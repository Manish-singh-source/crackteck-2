@crackteck-backend/resources/views/warehouse/index.blade.php

You are an expert Laravel + UI/UX developer.

I want you to create a **modern CRM Admin Dashboard** with a **clean, card-based UI (NOT table-based)**. The dashboard should be visually appealing, responsive, and optimized for quick decision-making.

This dashboard must be built using **real database data**, and I want you to **use data from all relevant tables** in the project, not just limited dashboard metrics. The dashboard should intelligently combine and visualize data from all major crm entities.

---

## 🎯 Core Requirement

* DO NOT use traditional table layouts for the dashboard overview
* Use **cards, charts, widgets, graphs, progress bars, mini lists, and visual analytics blocks**
* Data should be presented in a **proper dashboard format**, not CRUD table format
* Focus on **analytics, summaries, trends, insights, and business performance**
* Dashboard must look like a **modern SaaS admin analytics panel**
* It must be **responsive for desktop, tablet, and mobile**
* Every important section should be visually organized and easy to scan

---

## 🧩 Important Instruction About Data Usage

I want the dashboard to use **all major project tables wherever relevant**, including aggregated data, counts, trends, comparisons, top records, low performance records, growth insights, and visual summaries.

### Use data from these tables:

* `leads` 
* `quotations` 
* `amc_plans` 
* `amcs`
* `service_requests`
* `service_request_products` 
* `case_transfer_requests` 
* `service_request_product_pickups` 
* `field_issues` 
* `service_request_product_request_parts` 

Check for any required tables that may be missing from the above list and include them if they can provide meaningful insights.

If there are relationships between these tables, use them properly through Eloquent relationships and optimized queries.

Do not leave these tables unused. Wherever possible, show meaningful dashboard insights using each table’s data.

---

## 🧩 Dashboard Sections (Must Include)

### 1. Top Summary Cards

Create responsive summary cards showing:

* Total Customers
* Total Staffs 
* Total Leads
* Total Quotations
* Total AMC Plans
* Total AMCs
* Total Service Requests
* Total Service Request Products
* Total Case Transfer Requests
* Total Service Request Product Pickups
* Total Field Issues
* Total Service Request Product Request Parts


Each card should include:

* Icon
* Count/value
* Percentage increase/decrease
* Positive/negative indicator colors
* Optional mini sparkline/trend line

---

### 2. Total Customers Insights

Use `customers` and related data to show:

* Total customers over time (line chart)
* Customer acquisition by source (donut/pie chart)
* Top 5 customer segments (bar chart)
* Customer lifetime value trends (area chart)

### Filters:

* customer_type filter
* date range filter

---

Use chart library like:

* ApexCharts OR Chart.js

---


### 3. Total Staffs Insights


Use `staffs` and related data to show:

* Total staffs over time (line chart)
* Staff acquisition by source (donut/pie chart)
* Top 5 staff segments (bar chart)
* Staff lifetime value trends (area chart)

### Filters:

* staff_role filter
* date range filter

---

Use chart library like:

* ApexCharts OR Chart.js

---

### 4. Leads Insights

Use `leads` and related data to show:

Relationship between `leads` and `staffs` can be used to show lead assignment and follow-up insights.

* Total leads over time (line chart)
* Lead source distribution (donut/pie chart)
* Top 5 lead sources (bar chart)
* Lead conversion rates trends (area chart)

### Filters:

* lead_source filter
* date range filter

---

Use chart library like:

* ApexCharts OR Chart.js

---


### 5. Quotations Insights

Use `quotations` and related data to show:

* Total quotations over time (line chart)
* Quotation source distribution (donut/pie chart)
* Top 5 quotation sources (bar chart)
* Quotation conversion rates trends (area chart)

### Filters:

* quotation_source filter
* date range filter

---

Use chart library like:

* ApexCharts OR Chart.js

---


### 6. AMC Plans Insights

Use `amc_plans` and related data to show:

* Total AMC plans over time (line chart)
* AMC plan type distribution (donut/pie chart)
* Top 5 AMC plan types (bar chart)
* AMC plan conversion rates trends (area chart)

### Filters:

* amc_plan_type filter
* date range filter

---

Use chart library like:

* ApexCharts OR Chart.js

---





### 7. AMCs Insights

Use `amcs` and related data to show:

* Total AMCs over time (line chart)
* AMC source distribution (donut/pie chart)
* Top 5 AMC sources (bar chart)
* AMC conversion rates trends (area chart)

### Filters:
* amc_source filter
* date range filter

---

Use chart library like:

* ApexCharts OR Chart.js

---

### 8. Service Requests Insights

Use `service_requests` and related data to show:

* Total service requests over time (line chart)
* Service request source distribution (donut/pie chart)
* Top 5 service request sources (bar chart)
* Service request conversion rates trends (area chart)

### Filters:

* service_request_source filter
* date range filter

---

Use chart library like:

* ApexCharts OR Chart.js

---

### 9. Service Request Products Insights

Use `service_request_products` and related data to show:

* Total service request products over time (line chart)
* Service request product source distribution (donut/pie chart)
* Top 5 service request product sources (bar chart)
* Service request product conversion rates trends (area chart)

### Filters:

* service_request_product_source filter
* date range filter

---

Use chart library like:

* ApexCharts OR Chart.js

---

### 10. Case Transfer Requests Insights

Use `case_transfer_requests` and related data to show:

* Total case transfer requests over time (line chart)
* Case transfer request source distribution (donut/pie chart)
* Top 5 case transfer request sources (bar chart)
* Case transfer request conversion rates trends (area chart)

### Filters:

* case_transfer_request_source filter
* date range filter

---

Use chart library like:

* ApexCharts OR Chart.js

---

### 11. Service Request Product Pickups Insights

Use `service_request_product_pickups` and related data to show:

* Total service request product pickups over time (line chart)
* Service request product pickup source distribution (donut/pie chart)
* Top 5 service request product pickup sources (bar chart)
* Service request product pickup conversion rates trends (area chart)

### Filters:

* service_request_product_pickup_source filter
* date range filter

---

Use chart library like:

* ApexCharts OR Chart.js

---

### 12. Field Issues Insights

Use `field_issues` and related data to show:

* Total field issues over time (line chart)
* Field issue source distribution (donut/pie chart)
* Top 5 field issue sources (bar chart)
* Field issue conversion rates trends (area chart)

### Filters:

* field_issue_source filter
* date range filter

---

Use chart library like:

* ApexCharts OR Chart.js

---

### 13. Service Request Product Request Parts Insights

Use `service_request_product_request_parts` and related data to show:

* Total service request product request parts over time (line chart)
* Service request product request part source distribution (donut/pie chart)
* Top 5 service request product request part sources (bar chart)
* Service request product request part conversion rates trends (area chart)

### Filters:

* service_request_product_request_part_source filter
* date range filter

---

Use chart library like:

* ApexCharts OR Chart.js


---

## 🎛️ Filters (VERY IMPORTANT)

Implement proper dashboard filters to display crm data dynamically.

### Global Filters (Top of Dashboard)

Add:

* Date range filter (preset options: last 7 days, last 30 days, this month, last month, custom range)
* Customer type filter (dropdown with customer types)
* Staff role filter (dropdown with staff roles)
* Lead source filter (dropdown with lead sources)
* Quotation source filter (dropdown with quotation sources)
* AMC plan type filter (dropdown with AMC plan types)
* AMC source filter (dropdown with AMC sources)
* Service request source filter (dropdown with service request sources)
* Service request product source filter (dropdown with service request product sources)
* Case transfer request source filter (dropdown with case transfer request sources)
* Service request product pickup source filter (dropdown with service request product pickup sources)
* Field issue source filter (dropdown with field issue sources)
* Service request product request part source filter (dropdown with service request product request part sources)


### Section-Level Filters

Each section should also have its own filters relevant to that section’s data, such as:
* Date range filter
* Source/type filters specific to that section’s data


All filters should update data dynamically using:

* AJAX OR Livewire

---

## 🎨 UI/UX Requirements

Use same design system as the rest of the project, but create a **modern, clean, and visually appealing dashboard**. Use:

* Cards with shadows and rounded corners
* Consistent color scheme with positive/negative indicators
* Clear typography with hierarchy
* Responsive grid layout
* Icons for visual cues
* Charts with legends and tooltips
* Minimalistic design with focus on data

---

## ⚙️ Backend Requirements (Laravel)

Build complete Laravel implementation.

### Create:

* `CrmDashboardController`
* proper dashboard route
* filter endpoints if needed
* AJAX or Livewire-based filtering support

### Use optimized queries with:

* Eloquent relationships
* Aggregations using `SUM`, `COUNT`, `AVG`
* Grouping by date
* Grouping by order status
* Grouping by category / brand / rating / payment type
* Efficient eager loading
* Reusable query methods where needed

---

## 📊 Data Relationships to Use

Use proper relationships between tables to fetch and display data. For example:
* `staffs` may have a relationship with `leads` for lead assignment
* `customers` may have a relationship with `quotations` for customer quotations

If any relationship is missing, create assumptions and mention them before implementation.

---

## 🚀 Output Expected

Provide complete implementation with:

1. Dashboard Blade file
2. `CrmDashboardController`
3. Route definitions
4. Query logic for all sections
5. Chart integration code
6. AJAX/Livewire filter code
7. Reusable UI components/partials
8. Clean responsive design
9. Proper comments for understanding
10. Any assumptions clearly mentioned before code

---

## ❗ Important Notes

* DO NOT use tables in the dashboard UI
* Use tables only in CRUD pages if absolutely necessary, but not in dashboard overview
* Use **all major tables listed above**
* Each table should contribute some meaningful dashboard insight
* Keep code modular and maintainable
* Do not generate a basic dashboard; create a **professional, modern, analytics-rich crm admin dashboard**

If any column names differ from assumptions, mention assumptions first and then provide code accordingly.

Make the dashboard visually impressive, data-rich, fully responsive, and production-ready.