# CRM Sidebar Guide: Har Tab Kya Karta Hai

This is a business-flow guide for the active CRM sidebar at `/demo/crm/index`.

## Data kahan se aa sakta hai?

- **CRM**: admin/staff manually create or update records from the CRM form.
- **Website / e-commerce**: customer order or payment creates the record automatically.
- **Mobile app / API**: customer, engineer, delivery person, or sales person action sends data through an API.
- **Automatic workflow**: a record is created as the next step of another module; for example a pickup after a service request.

## 1. Dashboard: `/demo/crm/index`

**Kya dikhata hai:** poore CRM ka summary: customers, staff, leads, quotations, AMC, service requests, pickups, field issues and spare-part requests.

**Data kab aata hai:** jab in individual modules mein new record create/update hota hai. Dashboard khud koi data create nahi karta; it reads data from those modules and refreshes from `/demo/crm/dashboard-data`.

---

## 2. Access Control

| Tab | Kyu bana hai / kya kar sakte hain | Data kahan se aata hai | Kab data aata hai |
|---|---|---|---|
| **Staff** | Engineer, delivery person, sales person, accounts/admin staff create, edit, activate/deactivate karna. | CRM → Staff → Create Staff; staff onboarding/API. Table: `staff`. | New employee/joining ke time. |
| **Roles** | Kis type ka user hai define karna: Engineer, Sales Person, Admin, etc. | CRM → Roles → Create Role. | Jab new role/department chahiye. |
| **Permission** | Role ko kya access milega decide karna, e.g. quote create, payment view. | CRM → Permission → Create Permission. | Role/permission setup ke time. |

---

## 3. Accounts

### Transactions: `/demo/crm/transactions`

**Ye tab accounting ka unified history screen hai.** Ismein user manually transaction create nahi karta. Ye alag-alag payment modules ke completed/recorded payment records ko ek jagah laata hai.

**Is tab mein kya kar sakte hain:**

- Transaction type, status, date range aur customer/vendor/reference ID se filter.
- Recent payment history dekhna.
- CSV export download karna.
- Order, AMC, service, cash collection aur vendor purchase ka payment ek common list mein reconcile karna.

**Exact flow:**

```text
Website order paid          → order_payments (only completed)       ┐
AMC payment captured        → remote_amc_payments (only captured)   │
Service payment completed   → service_request_payments (completed)  ├→ Transactions tab
Cash collector receives cash→ cash_received                          │
Vendor purchase order       → vendor_purchase_orders                 ┘
```

**Important:** Transactions tab reporting/monitoring ke liye hai. Payment yahan create nahi hota. Payment jis original workflow mein hua tha, wahi source record create karta hai.

| Tab | Kyu bana hai / kya kar sakte hain | Data source | Record kaise create hota hai |
|---|---|---|---|
| **Payment** | All payment logs dekhna, payment status/filter/search karna. | Payment log service; order, AMC, service payment sources. | Customer website/app payment ya payment workflow. |
| **Withdraw** | Staff payout request create, approve/reject, aur paid mark karna. UTR/reference compulsory before Paid. | `withdrawal_requests`. | CRM Accounts → Withdraw, ya staff app API `POST /api/v1/withdrawals`. |
| **Cash Received** | Cash-on-delivery/cash collection ko customer, collector aur order/service request ke against track karna. | `cash_received`. | Delivery Man/Engineer app calls `POST /api/v1/cash-received` after taking cash from customer. It stores customer, staff, order or service request and amount with `customer_paid` status. Accounts then opens the record and clicks **Mark Received**; status becomes `received` and linked order/service payment becomes completed. |
| **Re-Imbursement** | Staff ke company expense claim (fuel, travel, tools) ko review aur reimburse karna. | `staff_wallet`. | Staff reimbursement API or CRM reimbursement form. |
| **Invoice** | Ek screen par quotation invoices, website order invoices aur service invoices dekhna. | `quotation_invoices`, `orders`, `service_request_quotations`. | Quote invoice generate, website order checkout, or service quotation invoice. |
| **Payments to Vendor** | Vendor ko purchase order ke against kitna payable/paid hai dekhna. | `vendor_purchase_orders`. | Vendor purchase-order workflow. Vendor ko normal staff withdrawal mein add nahi karna. |
| **Expenses** | Admin ke through staff expense add/edit/review karna. | `staff_wallet`. | CRM → Expenses → Add Expense. List, filter, receipt view, edit, delete and status actions are connected to the same records. |
| **Stock Reports** | Warehouse/product stock, category, brand aur available inventory dekhna. | `products` + warehouse/category/brand relations. | Product/warehouse inventory updates. |
| **Low Stock Reports** | Jinka active stock 40 se neeche hai unko alert/list karna. | `products` filtered by `stock_quantity < 40`. | Stock sale, use, return, adjustment ke baad automatically visible. |
| **KYC Log** | Staff KYC submission aur approval/rejection track karna. | `kycs`. | Staff KYC app/API submission and admin review. |

---

## 4. Customers and Sales Person

| Tab | Kyu bana hai / kya kar sakte hain | Data source | Record kaise / kab create hota hai |
|---|---|---|---|
| **Customers** | Retail/corporate/AMC customers, addresses aur branches manage karna. | `customers`, branches, address tables. | CRM → Customers → Create Customer; customer signup/API; order/service registration. |
| **Sales Report** | Sales pipeline ka real performance dekhna: leads, qualified/won leads, quotes, conversion %, invoice value, received revenue, salesperson performance. Date range filter available hai. | `leads`, `quotations`, `quotation_invoices`, `staff`. | Lead/quotation/invoice create/update hote hi report values change hoti hain. Report khud data create nahi karta. |
| **Leads** | Naya potential sale/customer requirement capture aur sales person assign karna. | `leads`. | CRM → Leads → Create Leads; sales API. Customer need/website enquiry/phone enquiry ke baad. |
| **Follow-Up** | Lead ke next call, reminder, response aur status manage karna. | `follow_ups` linked to lead/staff. | CRM → Follow-Up → Create Follow-Up. Lead create/contact ke baad. |
| **Meets** | Customer/lead meeting schedule, notes aur attachment save karna. | `meets` linked to lead/customer. | CRM → Meets → Create Meets. Meeting schedule/follow-up ke time. |
| **Quotations** | Customer requirement ke liye item/service/AMC quote banana, status manage karna aur invoice generate karna. | `quotations`, `quotation_products`, AMC quotation details. | CRM → Quotations → Create Quotation, generally lead qualify hone ke baad. |

**Sales flow:**

```text
Customer enquiry → Lead → Follow-up / Meet → Quotation → Accepted/Converted → Invoice → Payment → Sales Report + Transactions
```

---

## 5. Operation Managers

| Tab | Kyu bana hai / kya kar sakte hain | Data source | Record kaise create hota hai |
|---|---|---|---|
| **AMC Plans** | Annual maintenance plan ke price, duration, coverage aur service rules define karna. | `amc_plans`. | CRM → AMC Plans → Create. |
| **Covered Items** | AMC plan mein kaunse devices/services covered hain define karna. | `covered_items`. | CRM → Covered Items → Create. |
| **Device Specific Diagnosis** | Device type ke diagnosis checklist/possible issues manage karna. | `device_specific_diagnoses`. | CRM → Device Specific Diagnosis → Create. |

---

## 6. Services

| Tab | Kyu bana hai / kya kar sakte hain | Data source | Record kaise / kab create hota hai |
|---|---|---|---|
| **AMCs** | Customer ka active/pending/expired AMC contract, plan aur covered products manage karna. | `amcs`, `amc_products`. | AMC request, accepted AMC quotation, customer app/API. |
| **Service Requests** | Installation, repair, AMC, quick service requests receive, assign aur complete karna. | `service_requests`, `service_request_products`. | Customer website/app/API, CRM quick/AMC/non-AMC request forms. |
| **Track Request** | Ek known request ID search karke customer, devices, assigned engineer aur live status dekhna. | `service_requests` + customer, products, assigned engineers. | Opening page sirf search form hai; search submit karte hi database se actual request loads. |
| **Case Transfer** | Engineer ke liye case too difficult/other area ka ho to transfer request aur admin approval. | `case_transfer_requests`. | Engineer service-request app/API se transfer request; CRM se approval/rejection. |
| **Chat Logs** | Support conversation history dikhane ke liye intended screen. | Currently hardcoded Blade sample rows only. | **Abhi real chat API/table nahi hai; intentionally unchanged.** |
| **Activity Logs** | Kis user ne kya CRM action kiya audit ke liye dekhna. | `activity_log` (Spatie activity log). | Enabled models/app actions automatically log create karte hain. |
| **Manage Pincodes** | Kaunse pincode mein delivery/installation/repair/AMC available hai configure karna. | `pincodes`. | CRM → Manage Pincodes → Create. |
| **Pickup Request** | Repair/pickup ke liye product collect karne ka assignment aur pickup status track karna. | `service_request_product_pickups`. | Service-request product ke pickup flow se automatically/through admin assignment. |

**Service flow:**

```text
Customer website/app/CRM request → Service Request → Engineer assignment
→ Diagnosis / part request / pickup if required → Work completed → invoice/payment if applicable
```

---

## 7. Remote Support and Inventory

| Tab | Kyu bana hai / kya kar sakte hain | Data source | Record kaise create hota hai |
|---|---|---|---|
| **Assigned Jobs** | Remote engineer ko assigned support job dekhna, start/diagnose/escalate/complete karna. | `remote_support_jobs`. | Service request ko remote-support team ko assign karne par. |
| **Field Issues** | Engineer field mein jo issue solve nahi kar pa raha usko escalate/track karna. | `field_issues`. | Field engineer app/API or CRM issue workflow. |
| **Spare Parts Request** | Service request ke liye required spare part approve, issue, pick aur track karna. | `service_request_product_request_parts`. | Engineer diagnosis ke baad part request raise karta hai. |

---

## 8. Customer Care

| Tab | Kyu bana hai / kya kar sakte hain | Data source | Record kaise create hota hai |
|---|---|---|---|
| **Tickets** | AMC customer support tickets, customer aur AMC reference ke saath manage karna. | `amc_tickets`. | AMC support/ticket workflow. |

---

## Current work status / important rules

1. **Dynamic and working:** All menu lists above except Chat Logs are database/API driven.
2. **Chat Logs:** Static by your instruction; no change required now.
3. **Expenses:** The list reads `staff_wallet` records. If no rows are shown, no expense has been submitted yet for the selected filters.
4. **Transactions is not a payment-entry page:** It is the single reporting screen for payments that were created elsewhere.
5. **Do not duplicate money records:** staff payout = Withdraw; vendor payment = Payments to Vendor; customer refund = order/return refund flow.

---

## Exact record-creation flows

Use this section when the question is: **"Is tab mein data exactly kis action se aayega?"**

### Accounts

- **Transactions:** Direct create button nahi hai. It reads five already-created sources: completed website order payment, captured AMC payment, completed service payment, `cash_received`, and vendor purchase order. A row appears automatically after the source record exists.
- **Payment:** Direct create button nahi hai. A row appears when an order/AMC/service payment provider or its payment workflow writes a payment log.
- **Withdraw:** CRM admin creates a request on Withdraw page, or staff app uses `POST /api/v1/withdrawals`. Admin then approves/rejects; Accounts marks it Paid after entering UTR/reference.
- **Cash Received:** Delivery Man/Engineer collects physical cash from the customer for one order or service request. Their app sends `POST /api/v1/cash-received`; the API derives missing customer/staff/amount from the linked order/service request. Accounts verifies physical cash and uses **Mark Received**. This is the only action that changes its status from `customer_paid` to `received`.
- **Re-Imbursement:** Engineer/Delivery Man submits a company-expense claim through staff reimbursement API; alternatively admin creates it from Re-Imbursement form. Admin approves/rejects/pays it.
- **Invoice:** A row comes from one of three different events: quotation invoice generated, customer e-commerce order generated, or service quotation invoice generated. It is a combined viewer, not an invoice entry form.
- **Payments to Vendor:** Purchase team creates vendor purchase order/bill. Its payable amount/status then appears here. Vendor payment should be recorded against that PO.
- **Expenses:** Admin submits an expense for Engineer/Delivery Man. It creates a `staff_wallet` row immediately; the Expenses list reads that row and supports filter, receipt, view/edit/delete and payment-status actions.
- **Stock / Low Stock:** Warehouse stock changes when products are received, sold, used on service, returned or manually adjusted. Low Stock is automatic; no record is separately created for it.
- **KYC Log:** Staff member submits KYC documents from app/API; staff/admin review changes the KYC status.

### Customers and sales

- **Customers:** Admin creates customer from CRM, customer signs up, or an order/service flow creates/uses customer data. Customer detail is the source for leads, orders, service and AMC.
- **Leads:** Sales/admin records a new enquiry in CRM or sales API. This is the first sales record; it should be created before follow-up, meeting and quotation.
- **Follow-Up:** Sales person adds a next-action/call follow-up against an existing lead.
- **Meets:** Sales person schedules or records a customer meeting against an existing lead.
- **Quotation:** Sales person creates quotation from an existing lead, adds products/services/AMC plan, then sends/updates its status.
- **Sales Report:** No entry is created here. It recalculates from lead, quotation and invoice records for selected dates.

### Service operations

- **AMC Plans / Covered Items / Device Diagnosis:** These are admin master-data screens. Operations Manager enters these before selling an AMC or doing diagnosis.
- **AMCs:** A customer buys/requests an AMC through customer flow, CRM, or accepted quotation. The resulting contract appears in AMCs.
- **Service Requests:** Customer submits from website/app, or CRM creates Quick/AMC/Non-AMC request. One request can have multiple requested products.
- **Track Request:** No record is created. User enters existing request ID; page only reads the corresponding service request, products, customer and engineer assignment.
- **Case Transfer:** Assigned engineer raises transfer request from service workflow when another engineer/team should handle it; manager approves/rejects.
- **Activity Logs:** No manual list entry. Records are created automatically whenever configured models/actions are changed.
- **Manage Pincodes:** Admin manually creates/updates serviceability configuration.
- **Pickup Request:** Service workflow/admin selects pickup for a service-request product and assigns a pickup person; then status changes as item is picked/received/delivered.

### Remote support and customer care

- **Assigned Jobs:** Operations assigns a service request/product to remote support; remote engineer then starts diagnosis, escalates or completes it.
- **Field Issues:** Field engineer raises an issue from app/API when job cannot be resolved normally; manager tracks it until resolved/closed.
- **Spare Parts Request:** Engineer diagnosis identifies needed part and raises request; inventory/warehouse approves, picks and issues the part.
- **Tickets:** AMC support workflow creates a ticket against the customer AMC; customer care manages its status.
- **Chat Logs:** No real creation flow exists yet. Existing rows are hardcoded demo data, so it must not be used as an audit/customer-chat record until a chat provider/table is added.
