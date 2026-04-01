<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrmDashboardController extends Controller
{
    public function index(Request $request)
    {
        $filters = $this->filters($request);

        return view('crm.index', [
            'filterOptions' => $this->options(),
            'initialFilters' => $filters,
            'dashboardData' => $this->buildData($filters),
            'dashboardDataUrl' => route('crm.dashboard.data'),
            'dashboardAssumptions' => $this->assumptions(),
            'sectionMeta' => $this->definitions(),
        ]);
    }

    public function data(Request $request): JsonResponse
    {
        $filters = $this->filters($request);

        return response()->json([
            'filters' => $filters,
            'data' => $this->buildData($filters),
            'generated_at' => now()->toIso8601String(),
        ]);
    }

    private function buildData(array $filters): array
    {
        [$from, $to, $previousFrom, $previousTo] = $this->periods($filters);
        $sections = [];
        $summary = [];

        foreach ($this->definitions() as $key => $definition) {
            $dataset = $this->dataset($key, $filters);
            [$sectionFrom, $sectionTo] = $this->sectionPeriods($filters, $key);

            $sections[$key] = [
                'headline' => (clone $dataset)->count(),
                'timeline_label' => $definition['timeline_label'],
                'distribution_label' => $definition['distribution_label'],
                'segments_label' => $definition['segments_label'],
                'value_label' => $definition['value_label'],
                'cards' => [
                    ['label' => 'Records in range', 'value' => $this->wrappedDatasetCount($dataset, $sectionFrom, $sectionTo), 'type' => 'number'],
                    ['label' => 'Top source', 'value' => $this->topBucket((clone $dataset), 'source_label'), 'type' => 'text'],
                    ['label' => 'Top segment', 'value' => $this->topBucket((clone $dataset), 'segment_label'), 'type' => 'text'],
                ],
                'charts' => [
                    'timeline' => $this->series((clone $dataset), $sectionFrom, $sectionTo, 'COUNT(DISTINCT id)', $definition['timeline_label']),
                    'distribution' => $this->donut((clone $dataset), 'source_label'),
                    'segments' => $this->bars((clone $dataset), 'segment_label', $definition['segments_label']),
                    'value' => $definition['value_mode'] === 'rate'
                        ? $this->series((clone $dataset), $sectionFrom, $sectionTo, 'ROUND(AVG(rate_flag), 1)', $definition['value_label'])
                        : $this->series((clone $dataset), $sectionFrom, $sectionTo, 'SUM(metric_value)', $definition['value_label']),
                ],
                'insights' => [
                    'primary_rate' => $this->wrappedDatasetAvg($dataset, 'rate_flag', 1),
                    'metric_total' => $this->wrappedDatasetSum($dataset, 'metric_value', 2),
                    'top_source' => $this->topBucket((clone $dataset), 'source_label'),
                ],
            ];

            $current = $this->wrappedDatasetCount($dataset, $from, $to);
            $previous = $this->wrappedDatasetCount($dataset, $previousFrom, $previousTo);

            $summary[] = [
                'key' => $key,
                'label' => $definition['summary_label'],
                'value' => (clone $dataset)->count(),
                'icon' => $definition['icon'],
                'tone' => $definition['tone'],
                'trend' => $this->trend($current, $previous),
                'sparkline' => [$previous, $current],
            ];
        }

        return [
            'meta' => [
                'range' => ['date_from' => $from->toDateString(), 'date_to' => $to->toDateString(), 'days' => $from->diffInDays($to) + 1],
                'last_updated' => now()->format('d M Y, h:i A'),
                'currency' => 'INR',
            ],
            'hero' => [
                'title' => 'CRM command center across acquisition, quotations, AMC flow and service execution.',
                'subtitle' => 'This card-first dashboard combines real data from customers, staff, leads, quotations, AMCs, service requests, pickups, field issues and part requests.',
                'highlights' => [
                    ['label' => 'Linked Revenue', 'value' => $this->currency($sections['customers']['insights']['metric_total'] ?? 0)],
                    ['label' => 'Lead Conversion', 'value' => ($sections['leads']['insights']['primary_rate'] ?? 0) . '%'],
                    ['label' => 'Request Completion', 'value' => ($sections['service_requests']['insights']['primary_rate'] ?? 0) . '%'],
                    ['label' => 'Issue Resolution', 'value' => ($sections['field_issues']['insights']['primary_rate'] ?? 0) . '%'],
                ],
            ],
            'summary_cards' => $summary,
            'sections' => $sections,
        ];
    }

    private function definitions(): array
    {
        return [
            'customers' => ['title' => 'Customers Insights', 'description' => 'Acquisition, source mix and lifetime value proxy.', 'summary_label' => 'Total Customers', 'filter_key' => 'customer_type', 'filter_label' => 'Customer type', 'options_key' => 'customer_types', 'icon' => 'las la-users', 'tone' => 'primary', 'timeline_label' => 'Customers', 'distribution_label' => 'Customer Source', 'segments_label' => 'Customer Segments', 'value_label' => 'Customer Lifetime Value', 'value_mode' => 'sum'],
            'staffs' => ['title' => 'Staffs Insights', 'description' => 'Team growth, role mix and revenue proxy.', 'summary_label' => 'Total Staffs', 'filter_key' => 'staff_role', 'filter_label' => 'Staff role', 'options_key' => 'staff_roles', 'icon' => 'las la-user-tie', 'tone' => 'info', 'timeline_label' => 'Staffs', 'distribution_label' => 'Staff Acquisition Mix', 'segments_label' => 'Staff Segments', 'value_label' => 'Staff Revenue Proxy', 'value_mode' => 'sum'],
            'leads' => ['title' => 'Leads Insights', 'description' => 'Lead creation, source mix and conversion movement.', 'summary_label' => 'Total Leads', 'filter_key' => 'lead_source', 'filter_label' => 'Lead source', 'options_key' => 'lead_sources', 'icon' => 'las la-funnel-dollar', 'tone' => 'warning', 'timeline_label' => 'Leads', 'distribution_label' => 'Lead Source', 'segments_label' => 'Lead Segments', 'value_label' => 'Lead Conversion Rate', 'value_mode' => 'rate'],
            'quotations' => ['title' => 'Quotations Insights', 'description' => 'Quotation volume, status mix and value trend.', 'summary_label' => 'Total Quotations', 'filter_key' => 'quotation_source', 'filter_label' => 'Quotation source', 'options_key' => 'quotation_sources', 'icon' => 'las la-file-invoice-dollar', 'tone' => 'success', 'timeline_label' => 'Quotations', 'distribution_label' => 'Quotation Source', 'segments_label' => 'Quotation Status', 'value_label' => 'Quotation Conversion Rate', 'value_mode' => 'rate'],
            'amc_plans' => ['title' => 'AMC Plans Insights', 'description' => 'Plan creation, plan-type split and adoption.', 'summary_label' => 'Total AMC Plans', 'filter_key' => 'amc_plan_type', 'filter_label' => 'AMC plan type', 'options_key' => 'amc_plan_types', 'icon' => 'las la-clipboard-list', 'tone' => 'secondary', 'timeline_label' => 'AMC Plans', 'distribution_label' => 'AMC Plan Type', 'segments_label' => 'Plan Durations', 'value_label' => 'Plan Utilisation Rate', 'value_mode' => 'rate'],
            'amcs' => ['title' => 'AMCs Insights', 'description' => 'AMC demand, source mix and completion pace.', 'summary_label' => 'Total AMCs', 'filter_key' => 'amc_source', 'filter_label' => 'AMC source', 'options_key' => 'amc_sources', 'icon' => 'las la-shield-alt', 'tone' => 'primary', 'timeline_label' => 'AMCs', 'distribution_label' => 'AMC Source', 'segments_label' => 'AMC Status', 'value_label' => 'AMC Revenue', 'value_mode' => 'sum'],
            'service_requests' => ['title' => 'Service Requests Insights', 'description' => 'Request volume, source mix and completion.', 'summary_label' => 'Total Service Requests', 'filter_key' => 'service_request_source', 'filter_label' => 'Request source', 'options_key' => 'service_request_sources', 'icon' => 'las la-tools', 'tone' => 'danger', 'timeline_label' => 'Requests', 'distribution_label' => 'Request Source', 'segments_label' => 'Service Types', 'value_label' => 'Request Completion Rate', 'value_mode' => 'rate'],
            'service_request_products' => ['title' => 'Service Request Products Insights', 'description' => 'Product intake, brand mix and product closures.', 'summary_label' => 'Total Service Request Products', 'filter_key' => 'service_request_product_source', 'filter_label' => 'Product source', 'options_key' => 'service_request_product_sources', 'icon' => 'las la-microchip', 'tone' => 'info', 'timeline_label' => 'Products', 'distribution_label' => 'Product Source', 'segments_label' => 'Brands', 'value_label' => 'Service Charge Trend', 'value_mode' => 'sum'],
            'case_transfer_requests' => ['title' => 'Case Transfer Requests Insights', 'description' => 'Escalation demand, source mix and approvals.', 'summary_label' => 'Total Case Transfer Requests', 'filter_key' => 'case_transfer_request_source', 'filter_label' => 'Transfer source', 'options_key' => 'case_transfer_request_sources', 'icon' => 'las la-random', 'tone' => 'warning', 'timeline_label' => 'Transfers', 'distribution_label' => 'Transfer Source', 'segments_label' => 'Transfer Status', 'value_label' => 'Approval Rate', 'value_mode' => 'rate'],
            'service_request_product_pickups' => ['title' => 'Product Pickups Insights', 'description' => 'Pickup flow, assignment mix and completion.', 'summary_label' => 'Total Product Pickups', 'filter_key' => 'service_request_product_pickup_source', 'filter_label' => 'Pickup source', 'options_key' => 'service_request_product_pickup_sources', 'icon' => 'las la-truck-loading', 'tone' => 'success', 'timeline_label' => 'Pickups', 'distribution_label' => 'Pickup Source', 'segments_label' => 'Assigned Types', 'value_label' => 'Pickup Completion Rate', 'value_mode' => 'rate'],
            'field_issues' => ['title' => 'Field Issues Insights', 'description' => 'Issue intake, issue type mix and resolution.', 'summary_label' => 'Total Field Issues', 'filter_key' => 'field_issue_source', 'filter_label' => 'Field issue source', 'options_key' => 'field_issue_sources', 'icon' => 'las la-exclamation-circle', 'tone' => 'danger', 'timeline_label' => 'Issues', 'distribution_label' => 'Field Issue Source', 'segments_label' => 'Issue Types', 'value_label' => 'Issue Resolution Rate', 'value_mode' => 'rate'],
            'service_request_product_request_parts' => ['title' => 'Part Requests Insights', 'description' => 'Part demand, request-type mix and fulfilment.', 'summary_label' => 'Total Product Request Parts', 'filter_key' => 'service_request_product_request_part_source', 'filter_label' => 'Part request source', 'options_key' => 'service_request_product_request_part_sources', 'icon' => 'las la-cubes', 'tone' => 'secondary', 'timeline_label' => 'Part Requests', 'distribution_label' => 'Part Request Source', 'segments_label' => 'Part Status', 'value_label' => 'Requested Quantity Trend', 'value_mode' => 'sum'],
        ];
    }
    private function dataset(string $key, array $filters): Builder
    {
        $sectionFilter = $this->sectionSource($filters, $key, $this->definitions()[$key]['filter_key']);

        return match ($key) {
            'customers' => $this->table('customers')
                ->leftJoinSub(DB::table('leads')->leftJoin('quotations', 'quotations.lead_id', '=', 'leads.id')->selectRaw('leads.customer_id, SUM(COALESCE(quotations.total_amount, 0)) as revenue')->groupBy('leads.customer_id'), 'customer_quote_revenue', 'customer_quote_revenue.customer_id', '=', 'customers.id')
                ->leftJoinSub($this->hasTable('amcs') ? DB::table('amcs')->selectRaw('customer_id, SUM(COALESCE(payment_amount, 0)) as amc_revenue')->groupBy('customer_id') : DB::table('customers')->selectRaw('id as customer_id, 0 as amc_revenue'), 'customer_amc_revenue', 'customer_amc_revenue.customer_id', '=', 'customers.id')
                ->selectRaw('customers.id, customers.created_at as event_date, COALESCE(customers.source_type, "Unknown") as source_label, COALESCE(customers.customer_type, "Unknown") as segment_label, COALESCE(customer_quote_revenue.revenue, 0) + COALESCE(customer_amc_revenue.amc_revenue, 0) as metric_value, 100 as rate_flag')
                ->when($filters['customer_type'] ?? null, fn ($q, $v) => $q->where('customers.customer_type', $v))
                ->when($sectionFilter, fn ($q, $v) => $q->where('customers.customer_type', $v)),
            'staffs' => $this->table('staff')
                ->leftJoinSub(DB::table('quotations')->selectRaw('staff_id, SUM(COALESCE(total_amount, 0)) as quotation_revenue')->groupBy('staff_id'), 'staff_quotation_revenue', 'staff_quotation_revenue.staff_id', '=', 'staff.id')
                ->selectRaw('staff.id, ' . $this->staffDateColumn() . ' as event_date, COALESCE(staff.employment_type, "Unknown") as source_label, COALESCE(staff.staff_role, "Unknown") as segment_label, COALESCE(staff_quotation_revenue.quotation_revenue, 0) as metric_value, 100 as rate_flag')
                ->when($filters['staff_role'] ?? null, fn ($q, $v) => $q->where('staff.staff_role', $v))
                ->when($sectionFilter, fn ($q, $v) => $q->where('staff.staff_role', $v)),
            'leads' => $this->table('leads')
                ->leftJoin('customers', 'customers.id', '=', 'leads.customer_id')
                ->leftJoin('quotations', 'quotations.lead_id', '=', 'leads.id')
                ->selectRaw('leads.id, leads.created_at as event_date, COALESCE(customers.source_type, "Unknown") as source_label, COALESCE(leads.requirement_type, "Unknown") as segment_label, COALESCE(leads.estimated_value, 0) as metric_value, CASE WHEN quotations.id IS NOT NULL OR leads.status IN ("won", "qualified", "proposal") THEN 100 ELSE 0 END as rate_flag')
                ->when($filters['customer_type'] ?? null, fn ($q, $v) => $q->where('customers.customer_type', $v))
                ->when($filters['lead_source'] ?? null, fn ($q, $v) => $q->where('customers.source_type', $v))
                ->when($sectionFilter, fn ($q, $v) => $q->where('customers.source_type', $v)),
            'quotations' => $this->table('quotations')
                ->leftJoin('leads', 'leads.id', '=', 'quotations.lead_id')
                ->leftJoin('customers', 'customers.id', '=', 'leads.customer_id')
                ->selectRaw('quotations.id, ' . $this->quotationDateColumn() . ' as event_date, COALESCE(customers.source_type, "Unknown") as source_label, COALESCE(quotations.status, "Unknown") as segment_label, COALESCE(quotations.total_amount, 0) as metric_value, CASE WHEN quotations.status IN ("accepted", "converted") THEN 100 ELSE 0 END as rate_flag')
                ->when($filters['customer_type'] ?? null, fn ($q, $v) => $q->where('customers.customer_type', $v))
                ->when($filters['quotation_source'] ?? null, fn ($q, $v) => $q->where('customers.source_type', $v))
                ->when($sectionFilter, fn ($q, $v) => $q->where('customers.source_type', $v)),
            'amc_plans' => $this->table('amc_plans')
                ->leftJoin('amcs', 'amcs.amc_plan_id', '=', 'amc_plans.id')
                ->selectRaw('amc_plans.id, amc_plans.created_at as event_date, COALESCE(amc_plans.support_type, "Unknown") as source_label, CONCAT(COALESCE(amc_plans.duration, 0), " months") as segment_label, COALESCE(amc_plans.total_cost, 0) as metric_value, CASE WHEN amcs.id IS NOT NULL THEN 100 ELSE 0 END as rate_flag')
                ->when($filters['amc_plan_type'] ?? null, fn ($q, $v) => $q->where('amc_plans.support_type', $v))
                ->when($sectionFilter, fn ($q, $v) => $q->where('amc_plans.support_type', $v)),
            'amcs' => $this->table('amcs')
                ->leftJoin('customers', 'customers.id', '=', 'amcs.customer_id')
                ->selectRaw('amcs.id, ' . $this->amcDateColumn() . ' as event_date, COALESCE(amcs.request_source, "Unknown") as source_label, COALESCE(amcs.status, "Unknown") as segment_label, COALESCE(' . $this->amcMetricColumn() . ', 0) as metric_value, CASE WHEN amcs.status IN ("active", "completed") THEN 100 ELSE 0 END as rate_flag')
                ->when($filters['customer_type'] ?? null, fn ($q, $v) => $q->where('customers.customer_type', $v))
                ->when($filters['amc_source'] ?? null, fn ($q, $v) => $q->where('amcs.request_source', $v))
                ->when($sectionFilter, fn ($q, $v) => $q->where('amcs.request_source', $v)),
            'service_requests' => $this->table('service_requests')
                ->leftJoin('customers', 'customers.id', '=', 'service_requests.customer_id')
                ->leftJoinSub(DB::table('service_request_products')->selectRaw('service_requests_id, COUNT(*) as products')->groupBy('service_requests_id'), 'request_products', 'request_products.service_requests_id', '=', 'service_requests.id')
                ->selectRaw('service_requests.id, ' . $this->serviceRequestDateColumn() . ' as event_date, COALESCE(service_requests.request_source, "Unknown") as source_label, COALESCE(' . $this->serviceTypeColumn() . ', "Unknown") as segment_label, COALESCE(request_products.products, 0) as metric_value, CASE WHEN ' . $this->serviceRequestStatusSql() . ' THEN 100 ELSE 0 END as rate_flag')
                ->when($filters['customer_type'] ?? null, fn ($q, $v) => $q->where('customers.customer_type', $v))
                ->when($filters['service_request_source'] ?? null, fn ($q, $v) => $q->where('service_requests.request_source', $v))
                ->when($sectionFilter, fn ($q, $v) => $q->where('service_requests.request_source', $v)),
            'service_request_products' => $this->table('service_request_products')
                ->leftJoin('service_requests', 'service_requests.id', '=', 'service_request_products.service_requests_id')
                ->leftJoin('customers', 'customers.id', '=', 'service_requests.customer_id')
                ->selectRaw('service_request_products.id, service_request_products.created_at as event_date, COALESCE(service_requests.request_source, "Unknown") as source_label, COALESCE(service_request_products.brand, "Unknown") as segment_label, COALESCE(' . $this->serviceChargeColumn() . ', 0) as metric_value, CASE WHEN service_request_products.status IN ("completed", "picked", "diagnosis_completed") THEN 100 ELSE 0 END as rate_flag')
                ->when($filters['customer_type'] ?? null, fn ($q, $v) => $q->where('customers.customer_type', $v))
                ->when($filters['service_request_product_source'] ?? null, fn ($q, $v) => $q->where('service_requests.request_source', $v))
                ->when($sectionFilter, fn ($q, $v) => $q->where('service_requests.request_source', $v)),
            'case_transfer_requests' => $this->table('case_transfer_requests')
                ->leftJoin('service_requests', 'service_requests.id', '=', 'case_transfer_requests.service_request_id')
                ->leftJoin('customers', 'customers.id', '=', 'service_requests.customer_id')
                ->selectRaw('case_transfer_requests.id, case_transfer_requests.created_at as event_date, COALESCE(service_requests.request_source, "Unknown") as source_label, COALESCE(case_transfer_requests.status, "Unknown") as segment_label, 1 as metric_value, CASE WHEN case_transfer_requests.status = "approved" THEN 100 ELSE 0 END as rate_flag')
                ->when($filters['customer_type'] ?? null, fn ($q, $v) => $q->where('customers.customer_type', $v))
                ->when($filters['case_transfer_request_source'] ?? null, fn ($q, $v) => $q->where('service_requests.request_source', $v))
                ->when($sectionFilter, fn ($q, $v) => $q->where('service_requests.request_source', $v)),
            'service_request_product_pickups' => $this->table('service_request_product_pickups')
                ->leftJoin('service_requests', 'service_requests.id', '=', 'service_request_product_pickups.request_id')
                ->leftJoin('customers', 'customers.id', '=', 'service_requests.customer_id')
                ->selectRaw('service_request_product_pickups.id, ' . $this->pickupDateColumn() . ' as event_date, COALESCE(service_requests.request_source, "Unknown") as source_label, COALESCE(service_request_product_pickups.assigned_person_type, "Unknown") as segment_label, 1 as metric_value, CASE WHEN service_request_product_pickups.status IN ("received", "completed", "returned") THEN 100 ELSE 0 END as rate_flag')
                ->when($filters['customer_type'] ?? null, fn ($q, $v) => $q->where('customers.customer_type', $v))
                ->when($filters['service_request_product_pickup_source'] ?? null, fn ($q, $v) => $q->where('service_requests.request_source', $v))
                ->when($sectionFilter, fn ($q, $v) => $q->where('service_requests.request_source', $v)),
            'field_issues' => $this->table('field_issues')
                ->when($this->hasColumn('field_issues', 'service_request_id'), fn ($q) => $q->leftJoin('service_requests', 'service_requests.id', '=', 'field_issues.service_request_id')->leftJoin('customers', 'customers.id', '=', 'service_requests.customer_id'))
                ->selectRaw('field_issues.id, field_issues.created_at as event_date, ' . $this->fieldIssueSourceSql() . ' as source_label, COALESCE(field_issues.issue_type, "Unknown") as segment_label, 1 as metric_value, CASE WHEN field_issues.status IN ("resolved", "closed") THEN 100 ELSE 0 END as rate_flag')
                ->when(($filters['customer_type'] ?? null) && $this->hasColumn('field_issues', 'service_request_id'), fn ($q, $v) => $q->where('customers.customer_type', $v))
                ->when($filters['field_issue_source'] ?? null, function ($q, $v) { if ($this->hasColumn('field_issues', 'service_request_id')) { $q->where('service_requests.request_source', $v); return; } $q->where('field_issues.issue_type', $v); })
                ->when($sectionFilter, function ($q, $v) { if ($this->hasColumn('field_issues', 'service_request_id')) { $q->where('service_requests.request_source', $v); return; } $q->where('field_issues.issue_type', $v); }),
            'service_request_product_request_parts' => $this->table('service_request_product_request_parts')
                ->leftJoin('service_requests', 'service_requests.id', '=', 'service_request_product_request_parts.request_id')
                ->leftJoin('customers', 'customers.id', '=', 'service_requests.customer_id')
                ->selectRaw('service_request_product_request_parts.id, ' . $this->requestPartDateColumn() . ' as event_date, COALESCE(service_request_product_request_parts.request_type, "Unknown") as source_label, COALESCE(service_request_product_request_parts.status, "Unknown") as segment_label, COALESCE(service_request_product_request_parts.requested_quantity, 0) as metric_value, CASE WHEN service_request_product_request_parts.status IN ("delivered", "used", "picked") THEN 100 ELSE 0 END as rate_flag')
                ->when($filters['customer_type'] ?? null, fn ($q, $v) => $q->where('customers.customer_type', $v))
                ->when($filters['service_request_product_request_part_source'] ?? null, fn ($q, $v) => $q->where('service_request_product_request_parts.request_type', $v))
                ->when($sectionFilter, fn ($q, $v) => $q->where('service_request_product_request_parts.request_type', $v)),
            default => $this->table('customers')->selectRaw('id, created_at as event_date, "Unknown" as source_label, "Unknown" as segment_label, 0 as metric_value, 0 as rate_flag'),
        };
    }

    private function filters(Request $request): array
    {
        $sectionFilters = [];
        foreach (array_keys($this->definitions()) as $key) {
            $section = (array) $request->input("section_filters.{$key}", []);
            $sectionFilters[$key] = [
                'preset' => $this->clean($section['preset'] ?? null),
                'date_from' => $this->clean($section['date_from'] ?? null),
                'date_to' => $this->clean($section['date_to'] ?? null),
                'source' => $this->clean($section['source'] ?? null),
            ];
        }

        return [
            'date_preset' => $this->clean($request->input('date_preset')) ?: 'last_30_days',
            'date_from' => $this->clean($request->input('date_from')),
            'date_to' => $this->clean($request->input('date_to')),
            'customer_type' => $this->clean($request->input('customer_type')),
            'staff_role' => $this->clean($request->input('staff_role')),
            'lead_source' => $this->clean($request->input('lead_source')),
            'quotation_source' => $this->clean($request->input('quotation_source')),
            'amc_plan_type' => $this->clean($request->input('amc_plan_type')),
            'amc_source' => $this->clean($request->input('amc_source')),
            'service_request_source' => $this->clean($request->input('service_request_source')),
            'service_request_product_source' => $this->clean($request->input('service_request_product_source')),
            'case_transfer_request_source' => $this->clean($request->input('case_transfer_request_source')),
            'service_request_product_pickup_source' => $this->clean($request->input('service_request_product_pickup_source')),
            'field_issue_source' => $this->clean($request->input('field_issue_source')),
            'service_request_product_request_part_source' => $this->clean($request->input('service_request_product_request_part_source')),
            'section_filters' => $sectionFilters,
        ];
    }

    private function periods(array $filters): array
    {
        [$from, $to] = $this->resolveRange($filters['date_preset'] ?? 'last_30_days', $filters['date_from'] ?? null, $filters['date_to'] ?? null);
        $days = $from->diffInDays($to) + 1;
        $previousTo = $from->copy()->subDay()->endOfDay();
        $previousFrom = $previousTo->copy()->subDays($days - 1)->startOfDay();
        return [$from, $to, $previousFrom, $previousTo];
    }

    private function sectionPeriods(array $filters, string $key): array
    {
        $section = $filters['section_filters'][$key] ?? [];
        return $this->resolveRange($section['preset'] ?? ($filters['date_preset'] ?? 'last_30_days'), $section['date_from'] ?? ($filters['date_from'] ?? null), $section['date_to'] ?? ($filters['date_to'] ?? null));
    }

    private function resolveRange(?string $preset, ?string $from, ?string $to): array
    {
        $today = now();
        $preset = $preset ?: 'last_30_days';
        if ($preset === 'last_7_days') return [$today->copy()->subDays(6)->startOfDay(), $today->copy()->endOfDay()];
        if ($preset === 'this_month') return [$today->copy()->startOfMonth(), $today->copy()->endOfDay()];
        if ($preset === 'last_month') { $last = $today->copy()->subMonthNoOverflow(); return [$last->copy()->startOfMonth(), $last->copy()->endOfMonth()]; }
        if ($preset === 'custom' && $from && $to) {
            $start = Carbon::parse($from)->startOfDay();
            $end = Carbon::parse($to)->endOfDay();
            if ($end->lt($start)) [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
            return [$start, $end];
        }
        return [$today->copy()->subDays(29)->startOfDay(), $today->copy()->endOfDay()];
    }

    private function options(): array
    {
        return [
            'date_presets' => ['last_7_days' => 'Last 7 days', 'last_30_days' => 'Last 30 days', 'this_month' => 'This month', 'last_month' => 'Last month', 'custom' => 'Custom range'],
            'customer_types' => $this->pluckTableOptions('customers', 'customer_type'),
            'staff_roles' => $this->pluckTableOptions('staff', 'staff_role'),
            'lead_sources' => $this->pluckQueryOptions($this->dataset('leads', $this->filters(new Request())), 'source_label'),
            'quotation_sources' => $this->pluckQueryOptions($this->dataset('quotations', $this->filters(new Request())), 'source_label'),
            'amc_plan_types' => $this->pluckTableOptions('amc_plans', 'support_type'),
            'amc_sources' => $this->pluckTableOptions('amcs', 'request_source'),
            'service_request_sources' => $this->pluckTableOptions('service_requests', 'request_source'),
            'service_request_product_sources' => $this->pluckQueryOptions($this->dataset('service_request_products', $this->filters(new Request())), 'source_label'),
            'case_transfer_request_sources' => $this->pluckQueryOptions($this->dataset('case_transfer_requests', $this->filters(new Request())), 'source_label'),
            'service_request_product_pickup_sources' => $this->pluckQueryOptions($this->dataset('service_request_product_pickups', $this->filters(new Request())), 'source_label'),
            'field_issue_sources' => $this->pluckQueryOptions($this->dataset('field_issues', $this->filters(new Request())), 'source_label'),
            'service_request_product_request_part_sources' => $this->pluckTableOptions('service_request_product_request_parts', 'request_type'),
        ];
    }
    private function wrappedDatasetCount(Builder $query, Carbon $from, Carbon $to): int
    {
        return (int) DB::query()
            ->fromSub((clone $query), 'crm_count_source')
            ->whereBetween(DB::raw('DATE(event_date)'), [$from->toDateString(), $to->toDateString()])
            ->count();
    }

    private function wrappedDatasetAvg(Builder $query, string $column, int $precision = 1): float
    {
        return round((float) (DB::query()
            ->fromSub((clone $query), 'crm_avg_source')
            ->avg($column) ?? 0), $precision);
    }

    private function wrappedDatasetSum(Builder $query, string $column, int $precision = 2): float
    {
        return round((float) (DB::query()
            ->fromSub((clone $query), 'crm_sum_source')
            ->sum($column) ?? 0), $precision);
    }
    private function series(Builder $query, Carbon $from, Carbon $to, string $aggregate, string $label): array
    {
        $rows = DB::query()->fromSub((clone $query), 'crm_series_source')->whereBetween(DB::raw('DATE(event_date)'), [$from->toDateString(), $to->toDateString()])->selectRaw("DATE(event_date) as bucket, {$aggregate} as aggregate")->groupBy('bucket')->orderBy('bucket')->get()->pluck('aggregate', 'bucket');
        $labels = [];
        $data = [];
        $cursor = $from->copy()->startOfDay();
        while ($cursor->lte($to)) {
            $labels[] = $cursor->format('d M');
            $data[] = round((float) ($rows[$cursor->toDateString()] ?? 0), 1);
            $cursor->addDay();
        }
        return ['labels' => $labels, 'series' => [['name' => $label, 'data' => $data]]];
    }

    private function donut(Builder $query, string $column): array
    {
        $rows = DB::query()
            ->fromSub((clone $query), 'crm_donut_source')
            ->selectRaw("{$column} as bucket, COUNT(DISTINCT id) as aggregate")
            ->groupBy('bucket')
            ->orderByDesc('aggregate')
            ->limit(6)
            ->get();

        return ['labels' => $rows->pluck('bucket')->map(fn ($value) => $this->label($value))->values()->all(), 'series' => $rows->pluck('aggregate')->map(fn ($value) => (int) $value)->values()->all()];
    }

    private function bars(Builder $query, string $column, string $label): array
    {
        $rows = DB::query()
            ->fromSub((clone $query), 'crm_bar_source')
            ->selectRaw("{$column} as bucket, COUNT(DISTINCT id) as aggregate")
            ->groupBy('bucket')
            ->orderByDesc('aggregate')
            ->limit(5)
            ->get();

        return ['labels' => $rows->pluck('bucket')->map(fn ($value) => $this->label($value))->values()->all(), 'series' => [['name' => $label, 'data' => $rows->pluck('aggregate')->map(fn ($value) => (int) $value)->values()->all()]]];
    }

    private function topBucket(Builder $query, string $column): string
    {
        $value = DB::query()
            ->fromSub((clone $query), 'crm_bucket_source')
            ->selectRaw("{$column} as bucket, COUNT(DISTINCT id) as aggregate")
            ->groupBy('bucket')
            ->orderByDesc('aggregate')
            ->value('bucket');

        return $this->label($value ?: 'Unknown');
    }

    private function trend($current, $previous): array
    {
        $current = (float) $current;
        $previous = (float) $previous;
        if ($previous == 0.0 && $current == 0.0) return ['percentage' => 0, 'direction' => 'neutral'];
        if ($previous == 0.0) return ['percentage' => 100, 'direction' => 'up'];
        $change = (($current - $previous) / abs($previous)) * 100;
        return ['percentage' => round(abs($change), 1), 'direction' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'neutral')];
    }

    private function pluckTableOptions(string $table, string $column): array
    {
        if (!$this->hasColumn($table, $column)) return [];
        return $this->table($table)->whereNotNull($column)->distinct()->orderBy($column)->pluck($column, $column)->mapWithKeys(fn ($value, $key) => [$key => $this->label($value)])->all();
    }
    private function pluckQueryOptions(Builder $query, string $column): array
    {
        $wrapped = DB::query()->fromSub((clone $query), 'crm_option_source');

        return $wrapped->whereNotNull($column)
            ->distinct()
            ->orderBy($column)
            ->pluck($column, $column)
            ->mapWithKeys(fn ($value, $key) => [$key => $this->label($value)])
            ->all();
    }

    private function sectionSource(array $filters, string $section, string $fallback): ?string
    {
        return $filters['section_filters'][$section]['source'] ?? ($filters[$fallback] ?? null);
    }

    private function serviceRequestStatusSql(): string
    {
        $column = $this->hasColumn('service_requests', 'status') ? 'service_requests.status' : 'service_requests.request_status';
        return "{$column} IN ('completed', 'picked', 'processed', 'active')";
    }

    private function amcMetricColumn(): string
    {
        return $this->hasColumn('amcs', 'payment_amount') ? 'amcs.payment_amount' : '0';
    }

    private function serviceTypeColumn(): string
    {
        return $this->hasColumn('service_requests', 'service_type') ? 'service_requests.service_type' : '"General"';
    }

    private function serviceChargeColumn(): string
    {
        return $this->hasColumn('service_request_products', 'service_charge') ? 'service_request_products.service_charge' : '0';
    }

    private function quotationDateColumn(): string { return $this->hasColumn('quotations', 'quote_date') ? 'quotations.quote_date' : 'quotations.created_at'; }
    private function staffDateColumn(): string { return $this->hasColumn('staff', 'joining_date') ? 'staff.joining_date' : 'staff.created_at'; }
    private function amcDateColumn(): string { return $this->hasColumn('amcs', 'request_date') ? 'amcs.request_date' : 'amcs.created_at'; }
    private function serviceRequestDateColumn(): string { return $this->hasColumn('service_requests', 'request_date') ? 'service_requests.request_date' : 'service_requests.created_at'; }
    private function pickupDateColumn(): string { foreach (['picked_at', 'assigned_at', 'created_at'] as $column) { if ($this->hasColumn('service_request_product_pickups', $column)) return "service_request_product_pickups.{$column}"; } return 'service_request_product_pickups.created_at'; }
    private function requestPartDateColumn(): string { foreach (['requested_at', 'assigned_at', 'created_at'] as $column) { if ($this->hasColumn('service_request_product_request_parts', $column)) return "service_request_product_request_parts.{$column}"; } return 'service_request_product_request_parts.created_at'; }
    private function fieldIssueSourceSql(): string { return $this->hasColumn('field_issues', 'service_request_id') ? 'COALESCE(service_requests.request_source, "Unknown")' : 'COALESCE(field_issues.issue_type, "Unknown")'; }

    private function table(string $table): Builder
    {
        $query = DB::table($table);
        if ($this->hasColumn($table, 'deleted_at')) $query->whereNull("{$table}.deleted_at");
        return $query;
    }

    private function currency($value): string
    {
        return 'Rs ' . number_format((float) $value, 0);
    }

    private function label(?string $value): string
    {
        return ucfirst(str_replace('_', ' ', strtolower((string) ($value ?: 'Unknown'))));
    }

    private function clean($value): ?string
    {
        $value = is_string($value) ? trim($value) : $value;
        return $value === '' || $value === null ? null : (string) $value;
    }

    private function hasTable(string $table): bool
    {
        static $cache = [];
        if (!array_key_exists($table, $cache)) $cache[$table] = Schema::hasTable($table);
        return $cache[$table];
    }

    private function hasColumn(string $table, string $column): bool
    {
        static $cache = [];
        $key = "{$table}.{$column}";
        if (!array_key_exists($key, $cache)) $cache[$key] = $this->hasTable($table) && Schema::hasColumn($table, $column);
        return $cache[$key];
    }

    private function assumptions(): array
    {
        return [
            'Staff acquisition uses employment type as the nearest available source proxy because the staff table does not store a dedicated source field.',
            'Lead and quotation source analytics are derived from the linked customer source because those records do not have their own source column.',
            'AMC plan type uses support type because the schema does not contain an explicit amc_plan_type field.',
            'Case transfer and pickup source charts use the parent service request source so operational origin still matches how the case entered the CRM.',
            'Field issue source uses the linked service request source when available and falls back to issue type when that relationship column is absent.',
        ];
    }
}


