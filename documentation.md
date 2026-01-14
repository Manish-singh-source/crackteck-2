# Documentation

Laravel Packages:
"php": "^8.2",
"barryvdh/laravel-dompdf": "^3.1",
"laravel/framework": "^12.0",
"laravel/sanctum": "^4.2",
"laravel/tinker": "^2.10.1",
"laravel/ui": "^4.6",
"laravolt/avatar": "^6.2",
"php-flasher/flasher-laravel": "^2.1",
"spatie/laravel-activitylog": "^4.10",
"spatie/laravel-permission": "^6.21",
"tymon/jwt-auth": "^2.2"
,
Fast2sms sms service,
phone pe payment gateway,
social logins,
etc.

## Roles: (same sequence)

1. Field Executive
2. Delivery Man
3. Sales Person
4. Customer
5. Admin

========================================================================================

1. customer - primary address issue
2. products - serial products variations not changable
3. e-commerce product - add packaging charges
4. figma: engineer request dignose part: remote support request not added
5. AMC Plans - in edit page covered items not auto selected.

========================================================================================

## Websites & Apps:

1. Frontend (E-commerce)
2. Backend (CRM)
3. App (Customer, Sales Person, Field Executive, Delivery Man)

# Backend (CRM)

-   The backend panel is diveded into four parts such as e-commerce section, crm section, warehouse section and App settings

## Warehouse

### Modules:

1.  permissions
    - toggle status not working
2.  roles
    - toggle status not working
3.  staff
    - data need to check if properly effected or not
4.  customers
    - file uploaded preview in edit page not working
    - data need to check if properly effected or not
    - created by value not stored
5.  warehouses
    - softdelete need to be added
6.  warehouse rack

    - softdelete need to be added

    (CRM)

7.  Permissions:

    - List of permissions available in the system
    - Add Permission
    - Update Permission
    - Delete Permission
    - toggle status

8.  Roles: List of roles available in the system

    - List of roles available in the system
    - Add Role
    - Update Role
    - Delete Role
    - toggle status

9.  Staff: List of staff available in the system (admin, sales person, field executive, delivery man, engineer)

    - List of staff available in the system
    - Add Staff
    - View Staff
    - Update Staff
    - Delete Staff

    Table:
    `staff`: - staff_id (auto generated) - staff_role (engineer, sales_person, delivery_man, field_executive, admin) - first_name - last_name - phone - email - dob - gender

            - employment_type (full_time, part_time)
            - joining_date
            - assigned_area (for field executive)

            - otp (for engineer)
            - otp_expiry (for engineer)

            - status (active, inactive, resigned, terminated, blocked, suspended, pending)
            - created_at
            - updated_at
            - deleted_at

        `staff_address`:
            - staff_id
            - address1
            - address2
            - city
            - state
            - country
            - pincode

        `staff_aadhar_details`:
            - staff_id
            - aadhar_number (unique)
            - aadhar_front_path
            - aadhar_back_path

        `staff_pan_card_details`:
            - staff_id
            - pan_number (unique)
            - pan_card_front_path
            - pan_card_back_path

        `staff_bank_details`:
            - staff_id
            - bank_acc_holder_name
            - bank_acc_number
            - bank_name
            - ifsc_code
            - passbook_pic

        `staff_vehical_details`:
            - staff_id
            - vehicle_type
            - vehical_no
            - driving_license_no
            - driving_license

        `staff_police_verification`:
            - staff_id
            - police_verification
            - police_verification_status
            - police_certificate

        `staff_work_skills`:
            - staff_id
            - primary_skills
            - certifications
            - experience
            - languages_known
            - employment_history

10. Customers:

    - List of customers available in the system (e-commerce customers, crm customers, both)

    (E-commerce)

    - E-commerce Customers:
        - List of customers available in the system
        - View Customer
        - Add Customer
        - Update Customer
        - Delete Customer

    (CRM & App Customers)

    - CRM & App Customers:
        - List of customers available in the system
        - View Customer
        - Add Customer
        - Update Customer
        - Delete Customer

    Table:
    `customers`: - customer_id (auto generated) - created_by - default null - first_name - last_name - phone - email - dob - gender - customer_type (e-commerce, crm, both, offline)  
     - source_type (website, app, call, walkin, other) - password - status (active, inactive, blocked, suspended) - created_at - updated_at - deleted_at

        Note:
            - Created By: default null, only if admin creates customer, fill created by using login user id
            - phone: unique
            - email: unique
            - soft delete

        `customer_company_details`:
            - customer_id (foreign key)
            - company_name
            - address1
            - address2
            - city
            - state
            - country
            - pincode
            - gst_no

        Note:
            - Not mandatory table
            - Company name is unique
            - GST number is unique
            - Multiple addresses can be added
            - soft delete

        `customer_address_details`:
            - customer_id (foreign key)
            - branch_name
            - address1
            - address2
            - city
            - state
            - country
            - pincode
            - is_primary (1 - primary, 0 - secondary)
            - created_at
            - updated_at
            - deleted_at

        Note:
            - Customer can have multiple addresses
            - One address can be primary and rest can be secondary
            - Primary address is used for all communications
            - Secondary address is used for reference only
            - Primary address is mandatory
            - Soft delete

        `customer_aadhar_details`:
            - customer_id (foreign key)
            - aadhar_number (unique)
            - aadhar_front_path
            - aadhar_back_path
            - created_at
            - updated_at
            - deleted_at

        Note:
            - Not mandatory table
            - soft delete

        `customer_pan_card_details`:
            - customer_id (foreign key)
            - pan_number (unique)
            - pan_card_front_path
            - pan_card_back_path
            - created_at
            - updated_at
            - deleted_at

        Note:
            - Not mandatory table
            - soft delete

    (Warehouse)

11. Warehouses:

    - Warehouse List
    - Add Warehouse
    - View Warehouse
    - Edit Warehouse
    - Delete Warehouse

    `warehouses`:
    warehouse_id (auto generated),
    name,
    type,
    address1,
    address2,
    city,
    state,
    country,
    pincode,

        contact_person_name,
        phone_number,
        alternate_phone_number,
        email,

        working_hours,
        working_days,
        max_store_capacity,
        supported_operations,
        zone_conf,

        gst_no,
        licence_no,
        licence_doc,

        verification_status,
        default_warehouse,
        status,
        created_at,
        updated_at,
        deleted_at

        - add if something is missing

    Note:

    - verification_status: 0 - Pending, 1 - Verified, 2 - Rejected
    - default_warehouse: 0 - No, 1 - Yes
    - status: 0 - Inactive, 1 - Active
    - Only one warehouse is default.
    - Warehouse Id is auto generated.
    - Warehouse Id is unique.
    - Soft delete
    - Show Available Stock, low stock, total stock, etc. in the list view

    Defaults: - verification_status: 0 - default_warehouse: 0 - status: 1

    Model Relationships:

    1. Has Many Warehouse Rack
       warehousesRacks()

    2. Has Many Product

        - total products count
        - total available stock count
        - total low stock count
        - total scrap stock count
        - etc.

        products()

12. Warehouse Rack:

    - Rack List
    - Add Rack
    - Edit Rack
    - Delete Rack

    Table:
    id
    warehouse_id
    rack_name
    zone_area
    rack_no
    level_no
    position_no
    floor
    quantity
    filled_quantity
    created_at
    updated_at
    deleted_at

    Note:

    - filled_quantity <= quantity (constraint)
    - Soft delete

    Model Relationships:

    1. Belongs To Warehouse
       warehouse()

    (E-commerce)

13. Category:

    - Parent Category

        - List of categories available in the system
        - Add Category
        - View Category
        - Update Category
        - Delete Category
        - Sort Order

    - Sub Category
        - List of sub categories available in the system
        - Add Sub Category
        - View Sub Category
        - Update Sub Category
        - Delete Sub Category
        - Sort Order

    Table:
    `parent_categories`: - id (auto generated) - slug - name - image - sort_order - status_ecommerce - status - created_at - updated_at - deleted_at

        Note:
            - Slug is auto generated from name
            - Slug is unique
            - Sort order is auto incremented (for showing on website)
            - Soft delete
            - Status ecommerce: 0 - No, 1 - Yes (for showing on e-commerce website)
            - Status: 0 - Inactive, 1 - Active

        `sub_categories`:
            - id (auto generated)
            - parent_category_id (foreign key)
            - slug
            - name
            - image
            - icon_image
            - status_ecommerce (for showing on e-commerce website)
            - status
            - created_at
            - updated_at
            - deleted_at

        Note:
            - Slug is auto generated from name
            - Slug is unique
            - Soft delete
            - Status ecommerce: 0 - No, 1 - Yes (for showing on e-commerce website)
            - Status: 0 - Inactive, 1 - Active

14. Brand:

    - List of brands available in the system
    - Add Brand
    - Update Brand
    - Delete Brand

    Table:
    `brands`: - id (auto generated) - slug - name - image - status_ecommerce (for showing on e-commerce website) - status - created_at - updated_at - deleted_at

    Note: - Slug is auto generated from name - Slug is unique - Soft delete - Status ecommerce: 0 - No, 1 - Yes (for showing on e-commerce website) - Status: 0 - Inactive, 1 - Active

15. Variations:

    - Attributes:

        - List of attributes available in the system
        - Add Attribute
        - View Attribute
        - Update Attribute
        - Delete Attribute

    - Attribute Values:
        - List of attribute values available in the system
        - Add Attribute Value
        - View Attribute Value
        - Update Attribute Value
        - Delete Attribute Value

    Table:
    `product_variant_attributes`: - id (auto generated) - name - status - created_at - updated_at - deleted_at

        `product_variant_attribute_values`:
            - id (auto generated)
            - attribute_id (foreign key)
            - value
            - status
            - created_at
            - updated_at
            - deleted_at

    (Warehouse)

16. Vendor:

    - List of vendors available in the system
    - Add Vendor
    - View Vendor
    - Update Vendor
    - Delete Vendor

    Table:
    `vendors`: - vendor_id (auto generated) - created by - default null - name  
     - phone - email

            - address1
            - address2
            - city
            - state
            - country
            - pincode

            - pan_no
            - gst_no

            - status
            - created_at
            - updated_at
            - deleted_at

    Note: - Created by: default null, only if admin creates vendor, fill created by using login user id - Soft delete - Status: 0 - Inactive, 1 - Active - Create Own warehouse for currently available stock

17. Vendor Purchase Order:

    - List of vendor purchase orders available in the system
    - Add Vendor Purchase Order
    - View Vendor Purchase Order
    - Update Vendor Purchase Order
    - Delete Vendor Purchase Order

    Table:
    `vendor_purchase_orders`: - vendor_purchase_order_id (auto generated) - vendor_id (foreign key) - po_number (unique) - invoice_number (unique) - invoice_pdf - purchase_date - po_amount_due_date - po_amount - po_status (pending, approved, rejected, cancelled) - created_at - updated_at - deleted_at

    Note: - PO Number is unique - Invoice Number is unique - Soft delete - PO Status: 0 - Pending, 1 - Approved, 2 - Rejected, 3 - Cancelled - default: 1 - Approved

    (CRM)

18. Manage Pincode:

    - List of pincodes available in the system
    - Add Pincode
    - View Pincode
    - Update Pincode
    - Delete Pincode

    Table:
    `pincodes`: - id (auto generated) - pincode - delivery_status (active, inactive) - installation_status (active, inactive) - repair_status (active, inactive) - quick_service_status (active, inactive) - amc_status (active, inactive) - created_at - updated_at - deleted_at

    Note: - Pincode is unique - All status are active by default - Soft delete - Status: 0 - Inactive, 1 - Active

19. Product:
    (Warehouse)

    - Warehouse Product:
        - List of All products available in the system
        - Add Warehouse Product
        - View Warehouse Product
        - Update Warehouse Product
        - Delete Warehouse Product

    Table:
    `products`:
    <!-- foreign keys --> - product_id (auto generated) - vendor_id (foreign key) - vendor_purchase_order_id (foreign key)

            - brand_id (foreign key)
            - parent_category_id (foreign key)
            - sub_category_id (foreign key)

            <!-- rack details -->
            - warehouse_id (foreign key)

            <!-- product details -->
            - name
            - hsn_code
            - sku
            - model_no
            - short_description
            - full_description
            - technical_specification
            - brand_warranty
            - company_warranty

            - cost_price
            - selling_price
            - discount_price
            - tax
            - final_price

            - stock_quantity
            - stock_status (in stock, low stock, out of stock, scrap)

            - main_product_image
            - additional_product_images
            - datasheet_manual

            - variations (json)

            - status (active, inactive)
            - created_at
            - updated_at
            - deleted_at



            <!-- pending for future -->
            - warehouse_rack_id (foreign key)
            - rack_zone_area
            - rack_no
            - level_no
            - position_no
            - expiry_date
            - rack_status (available, blocked, reserved)


        Note:
            - Stock quantity is always greater than or equal to 0
            - Stock status is auto generated based on stock quantity
            - Soft delete
            - Status: 0 - Inactive, 1 - Active


        `product_serials`:
            - product_serial_id (auto generated)
            - product_id (foreign key)

            - auto_generated_serial
            - manual_serial

            - price ( Fetch from product table and if we want to change for specific serial, we can change )
            - cost_price
            - selling_price
            - discount_price
            - tax
            - final_price

            - Images ( Fetch from product table and if we want to change for specific serial, we can change )
            - main_product_image
            - additional_product_images

            - status (active, inactive, sold, scrap)

            - created_at
            - updated_at
            - deleted_at

    (E-commerce)

    -   E-commerce Product:

        - List of All products available in the system
        - Add E-commerce Product
        - View E-commerce Product
        - Update E-commerce Product
        - Delete E-commerce Product

        Table:
        `ecommerce_products`: - ecommerce_product_id (auto generated) - warehouse_product_id (foreign key) - sku

              - with_installation (json)

              <!-- optional fields repeated from warehouse product -->
              - company_warranty
              - short_description
              - full_description
              - technical_specification

              - min_order_qty - default 1
              - max_order_qty - default : stock quantity

              - shipping_charges
              - shipping_class (light, heavy, fragile)

              - is_featured
              - is_best_seller
              - is_suggested
              - is_todays_deal

              - product_tags (json)

              - status (active, inactive, draft)

              - meta_title
              - meta_description
              - meta_keywords
              - meta_product_url_slug

              - created_at
              - updated_at
              - deleted_at

        Note: - SKU is unique - Meta Product URL Slug is unique - Soft delete - Status: 0 - Inactive, 1 - Active, 2 - Draft - Meta Product URL Slug is auto generated from meta title - This product relates to the warehouse product - Warehouse product can be related to multiple product serials table

    (CRM)

20. Covered Items:

    - Add Covered Item
    - Edit Covered Item
    - Delete Covered Item
    - List of covered items lists with (service type, covered item name, no of diagonisis)

    Table:
    `covered_items`: - id (auto generated)  
     - service_type (amc, quick_service, installation, repair) - service_name - service_charge ( if service type is amc then not required ) - status

            - diagonisis_list (json)

            - created_at
            - updated_at
            - deleted_at

    Note: - Soft delete - Status: 0 - Inactive, 1 - Active - Diagonisis List: json array of diagonisis list - If service type is amc then not required to add service charge

21. AMC Plans: List of AMC plans like Yearly, Monthly, etc. with covered items

    - Add AMC Plan
    - View AMC Plan
    - Update AMC Plan
    - Delete AMC Plan

    Table:
    `amc_plans`: - id (auto generated) - plan_name - plan_code

            - description
            - duration  ( If custom, then we will ask for duration as number of years ) - number in months
            - total_visits

            - plan_cost
            - tax
            - total_cost
            - pay_terms

            - support_type
            - covered_items (json) ( List of covered items only for AMC include diagnosis )

            - brochure
            - tandc
            - replacement_policy

            - status
            - created_at
            - updated_at
            - deleted_at

    Note: - Plan Code is unique - Duration: 1 - 6 Months, 2 - 12 months, 3 - 24 months, 4 - 36 months, 5 - Custom - Soft delete - Status: 0 - Inactive, 1 - Active

22. Quick Services Plans: List of quick services like Quick Repair, Full Cleaning, etc. with price and covered items

    - List of quick services available in the system
    - No of Diagnosis available for each quick service
    - Price for each quick service
    - View Quick Service

23. Installation Services Plans: List of installation services like Home Installation, Office Installation, etc. with price and covered items
    - List of installation services available in the system
    - No of Diagnosis available for each installation service
    - Price for each installation service
    - View Installation Service
24. Repairing Services Plans: List of repairing services like Battery Replacement, Screen Repair, etc. with price and covered items

    - List of repairing services available in the system
    - No of Diagnosis available for each repairing service
    - Price for each repairing service
    - View Repairing Service

25. Service Request:

    1. Non-AMC Service: - Installation Services - Repairing Services: List of non amc services requested by customers
    2. AMC Services: List of AMC services requested by customers
    3. Quick Service Requests: List of quick service requests requested by customers

    Table:
    For This we need 8 different tables - service_requests: - products_list: - assigned-engineer: - assigned_group_engineers: - engineer_diagnosis_details: - request_products: - assigned_delivery_man: - quotation:

        `service_requests`:
            - request_id (auto generated)
            - service_type - (0 - AMC, 1 - Quick Service, 2 - Installation, 3 - Repairing)
            - customer_id (foreign key)
            - request_date
            - request_status (pending, approved, rejected, processing, processed, picking, picked, completed)
            - request_source (customer, system)
            - created_by (if created by system, then show admin)
            - is_engineer_assigned - (0 - Not Assigned, 1 - Assigned)
            - created_at
            - updated_at
            - deleted_at

        Note:
            - Request Source: If customer, then store source as customer and id in created_by, if system, then store source as system and id in created_by

        `products_list`:
            - product_list_id (auto generated)
            - service_requests_id (foreign key)
            - name
            - type
            - model_no
            - sku - (optional)
            - hsn
            - purchase_date
            - brand
            - image
            - description
            - item_code_id - (for all service types from covered items table, if AMC then plan id) (1 or more)
            - service charge
            - status (pending, approved, rejected, processing, in_progress, on_hold, diagnosis_completed, processed, picking, picked, completed)
            - created_at
            - updated_at
            - deleted_at


        Note:
            - Statuses:
                - Pending: When request is created
                - Approved: When request is approved by customer
                - Rejected: When request is rejected by customer

                - Processing: When request is assigned to engineer
                - In Progress: When engineer starts working on the request
                - on Hold: When request is on hold
                - diagnosis_completed: When engineer has completed the diagnosis
                - Processed: When engineer has completed the diagnosis and completed the request

                - Picking: When engineer is picking the product from customer
                - Picked: When engineer has picked the product from customer

                - Completed: When request is completed


        `assigned_engineer`:
            - request_id (foreign key)
            - engineer_id (foreign key)

            <!-- assignment details -->
            - assignment_type (individual, group)
            - assigned_at

            <!-- transfer details  -->
            - transferred_to (to whom request transferred)
            - transferred_at (when request is transferred)
            - notes  - (reason)

            - group_name (if group assignment)
            - is_supervisor (boolean)

            - status (active, inactive)
            - created_at
            - updated_at
            - deleted_at

        Note:
            - status: if active then only that engineer can work on the request. inactive means engineer is not working on the request or previous engineer has transferred the request to another engineer


        `engineer_diagnosis_details`:
            - id (auto generated)
            - service_request_id (foreign key)
            - service_request_product_id (foreign key)
            - assigned_engineer_id (foreign key)

            - covered_items_id - from service request product table (only 1 from that json)
            <!--
                Request types:
                    1. working
                    2. not working
                        - add to pickup
                        - request part
                            - stock in hand
                            - part request
                        - request remote diagnosis
                        - save and continue
                    3. not checked
            -->

            - diagnosis_list (json)
                {
                    "OS": "working",
                    "OS": "not working",
                    .
                    .
                    .
                    .
                    "Software": "add to pickup",
                    "Software": "part requested",
                    "Batter": "not checked",
                }
            - diagnosis_photos (json)
                {
                    "OS": ["photo1.jpg", "photo2.jpg"],
                    "Software": ["photo3.jpg", "photo4.jpg"],
                    "Batter": ["photo5.jpg", "photo6.jpg"],
                }
            - diagnosis_videos (json)
                {
                    "OS": ["video1.mp4", "video2.mp4"],
                    "Software": ["video3.mp4", "video4.mp4"],
                    "Batter": ["video5.mp4", "video6.mp4"],
                }
            - diagnosis_notes (json)
                {
                    "OS": "OS is working",
                    "Software": "Software is not working",
                    "Batter": "Batter is not checked",
                }
            - diagnosis_report

            - after_service_photos (json)
            - before_service_photos (json)

            - completed_at
            - created_at
            - updated_at
            - deleted_at


        `service_request_product_pickup`:
            - id (auto generated)
            - service_request_id (foreign key)
            - service_request_product_id (foreign key)
            - assigned_engineer_id (engineer who sent pickup request)
            - reason - textarea (optional)

            - assigned_person_type (delivery man , engineer)
            - assigned_person_id (if assigned_person_type is engineer then assigned_person_id is equal to assigned engineer id)

            - status (pending, assigned, approved, picked, received, cancelled, returned)
            - otp
            - otp_expiry

            - assigned_at
            - picked_at
            - received_at
            - returned_at

            - created_at
            - updated_at
            - deleted_at



        `service_request_product_request_part`:
            - id (auto generated)
            - service_request_id (foreign key)
            - service_request_product_id (foreign key)
            - assigned_engineer_id (engineer who sent request part)
            - requested_part_id (foreign key)  - (product id)
            - request_type - (stock_in_hand, part_request) - (already in db stock in hand)

            - assigned_person_type (delivery man , engineer)
            - assigned_person_id (if assigned_person_type is engineer then assigned_person_id is equal to assigned engineer id)

            - status (pending, approved, rejected, customer_approved, customer_rejected, picked, in_transit, delivered, used)

            - otp
            - otp_expiry

            - assigned_at
            - approved_at
            - delivered_at
            - used_at
            - cancelled_at

            - created_at
            - updated_at
            - deleted_at



        `requested_part_delivery`:
            - id (auto generated)
            - service_request_id (foreign key)
            - service_request_product_id (foreign key)
            - service_request_product_request_part_id (foreign key)
            - product_serial_id (foreign key)
            - quantity
            - unit_price
            - total_price
            - notes
            - otp
            - otp_expiry
            - delivered_at
            - created_at
            - updated_at
            - deleted_at


        `service_request_quotation`:
            - id (auto generated)
            - service_request_id (foreign key) -
            - requested_part_id (foreign key)  - service_request_product_request_part
            - product_price - from product table
            - service_charge - from covered items table
            - delivery_charge - from delivery man table
            - total_amount
            - discount
            - quotation_file
            - quotation_status (pending, approved, rejected)
            - quotation_date

            - created_at
            - updated_at
            - deleted_at



        `service_request_payment`:
            - id (auto generated)
            - service_request_id (foreign key)

            - transaction_id
            - total_amount
            - payment_gateway
            - payment_method
            - payment_date
            - payment_status (paid, unpaid, partially_paid)

            - created_at
            - updated_at
            - deleted_at

26. Track Request: No need of table.

    - Search by service request id

27. Case Transfer: List of case transfer requests from engineer

    - List of case transfer requests
    - View Case Transfer Request
    - Approve/Reject Case Transfer Request
    - Re-assign Engineer
    - Assigned Engineer History
    - Case Transfer History

    Table:
    `case_transfer_requests`:

        Schema::create('case_transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_id')->unique();
            $table->foreignId('service_request_id')->constrained('service_requests')->onDelete('cascade');
            $table->foreignId('requesting_engineer_id')->constrained('staff')->onDelete('cascade');
            $table->foreignId('new_engineer_id')->nullable()->constrained('staff')->onDelete('setNull');
            $table->string('engineer_reason');
            $table->text('admin_reason')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['service_request_id', 'status']);
        });



    Note: - Service Request Type: 1 - AMC, 2 - Non-AMC, 3 - Quick Service - Service Request Id: foreign key from respective service request table - Status: pending -> approved -> rejected - Soft delete - Show Diagnosis details when view - When transferred, update the service request table with new engineer id

    Model Relationships: 1. Belongs To Service Request (Polymorphic) 2. Belongs To Requested By (Engineer) 3. Belongs To Re-assigned Engineer (Engineer)

28. Chats Logs:

    - List of all chats
    - View Chat
    - Add Chat
    - Update Chat
    - Delete Chat

    Table:
    `chats`:

29. Activity Log: List of all activities performed in the system

30. Pickup Request: List of pickup requests from engineers for customer product

    - List of pickup requests
    - View Pickup Request
        - List of products
        - Show Diagnosis details
        - Update Status (pending, approved, rejected)
        - Delivery/Engineer Man Assignment

    Table:
    `pickup_requests`:

        Schema::create('pickup_requests', function (Blueprint $table) {
            $table->id();
            $table->string('pickup_request_id')->unique();
            $table->foreignId('service_request_id')->constrained('service_requests')->onDelete('cascade');
            $table->foreignId('engineer_id')->constrained('staff')->onDelete('cascade'); // Requested by
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');

            // Pickup Assignment
            $table->foreignId('pickup_person_id')->nullable()->constrained('staff')->onDelete('setNull'); // Delivery Man or Engineer
            $table->timestamp('pickup_assigned_at')->nullable();
            $table->timestamp('pickup_completed_at')->nullable();

            // Delivery Assignment
            $table->foreignId('delivery_person_id')->nullable()->constrained('staff')->onDelete('setNull'); // Delivery Man
            $table->timestamp('delivery_assigned_at')->nullable();
            $table->timestamp('delivery_completed_at')->nullable();

            // Status
            $table->string('status')->default('pending'); // pending, assigned, in_transit, completed, cancelled, failed
            $table->text('cancellation_reason')->nullable();

            // Photos
            $table->text('before_photos')->nullable();
            $table->text('after_photos')->nullable();

            // OTP Verification
            $table->string('otp')->nullable();
            $table->timestamp('otp_verified_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['service_request_id', 'status']);
            $table->index('customer_id');
        });

    Note: - Status: pending -> approved -> rejected - Either delivery man will be assigned or engineer will pick the product - Soft delete - Change status to picked for service request when engineer picks the product - Change status to completed/cancelled for service request when delivery man delivers the product - When product delivered verify customer using otp verification

31. Remote Jobs: visible to admin, team head

    - List of requests coming from field executive for remote diagnosis
    - List of remote jobs
    - View Remote Job
        - Assign Remote Engineer
    - Update Remote Job
    - Delete Remote Job
    - Add Remote Job
        - Assign Remote Engineer

    Table:
    `remote_jobs`:

        // Remote Jobs (For remote engineers)
        Schema::create('remote_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_id')->unique();
            $table->foreignId('service_request_id')->constrained('service_requests')->onDelete('cascade');
            $table->foreignId('field_executive_id')->nullable()->constrained('staff')->onDelete('setNull'); // Created by
            $table->foreignId('assigned_engineer_id')->nullable()->constrained('staff')->onDelete('setNull');
            $table->string('job_type')->default('remote_diagnosis'); // remote_diagnosis, troubleshooting, guidance
            $table->text('job_description');
            $table->text('remote_access_details')->nullable();
            $table->string('status')->default('pending'); // pending, assigned, in_progress, completed, escalated
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->string('escalation_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
        });

32. Assigned Jobs: No need of table.

    - visible to remote engineers
    - List of jobs assigned to engineers
    - View Assigned Job
        - Start Job
        - Diagnosis
        - Take Action
        - Escalate to Onsite
        - Complete Job

    Note: - Display Escalate button only if job is not escalated and for every step

33. Field Issues: visible to admin, team head

    - List of field issues
    - View Field Issue
        - Assign Remote Engineer
    - Add Field Issue
    - Update Field Issue

    Note: - Tab switching: All issues, Pending, In Progress, Completed

    Table:
    `field_issues`:

        // Field Issues
        Schema::create('field_issues', function (Blueprint $table) {
            $table->id();
            $table->string('issue_id')->unique();
            $table->foreignId('field_executive_id')->constrained('staff')->onDelete('cascade');
            $table->string('issue_type');
            $table->text('issue_description');
            $table->string('severity')->default('medium'); // low, medium, high, critical
            $table->string('status')->default('pending'); // pending, in_progress, resolved, closed
            $table->foreignId('assigned_remote_engineer_id')->nullable()->constrained('staff')->onDelete('setNull');
            $table->timestamp('resolved_at')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->text('attachments')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
        });

34. Stock In Hand: engineer get stock from warehouse and use it for field service

    - List of stock in hand
        - All, Available, Used
    - View Stock In Hand
    - Add Stock In Hand
    - Update Stock In Hand
    - Delete Stock In Hand
    - Transfer Stock In Hand return to warehouse

    Table:
    `stock_in_hand`: - stock_in_hand_id (auto generated)
    <!-- - Product Id  --> - Product Serial Id - Requested By (Engineer) - Requested Quantity - Delivered Quantity - Status (pending, approved, rejected, picked, used, returned, cancelled)

        `stock_in_hand_products`:
            - stock_in_hand_product_id (auto generated)
            - stock_in_hand_id (foreign key)
            - product_id (foreign key)
            - product_serial_id (foreign key)
            - quantity (requested quantity)
            - delivered_quantity
            - status (pending, approved, rejected, picked, used, returned, cancelled)


        // Stock In Hand (Engineer field inventory)
        Schema::create('stock_in_hand', function (Blueprint $table) {
            $table->id();
            $table->string('stock_request_id')->unique();
            $table->foreignId('engineer_id')->constrained('staff')->onDelete('cascade'); // Requested by
            $table->date('requested_date');
            $table->integer('requested_quantity');
            $table->integer('delivered_quantity')->default(0);
            $table->string('status')->default('pending'); // pending, approved, rejected, picked, used, returned, cancelled
            $table->text('request_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['engineer_id', 'status']);
        });

        // Stock In Hand Products
        Schema::create('stock_in_hand_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_in_hand_id')->constrained('stock_in_hand')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('product_serial_id')->nullable()->constrained('product_serials')->onDelete('setNull');
            $table->integer('requested_quantity');
            $table->integer('delivered_quantity')->default(0);
            $table->decimal('unit_price', 15, 2);
            $table->string('status')->default('pending'); // pending, approved, rejected, picked, used, returned, cancelled
            $table->text('notes')->nullable();
            $table->timestamp('picked_at')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    Note: - Requested By is foreign key from Engineers table - Status: pending -> approved -> picked -> used -> returned -> cancelled - Soft delete

35. Spare Parts Request: List of spare parts request sent by engineers after going to customer site

    - List of spare parts request
        - All, Pending, Approved, Rejected, Cancelled
    - View Spare Parts Request
    - Add Extra Product
    - Remove Product
    - Update Product
    - Update Status (pending, approved, rejected)

    Tables:
    `spare_part_requests`: - request_id (auto generated) - Requested By (Engineer) - Requested For (Customer) - Requested At - Assigned Delivery Man - Assigned At - Delivered At - Status (pending, in progress, delivered, cancelled) - etc.

        `stock_in_hand_pivot`:
        	id	product_id	requested_by	delivery_man_id	request_date	urgency_level	quantity	reason	approval_status	service_request_id	created_at	updated_at


        // Spare Parts Requests
        Schema::create('spare_part_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->unique();
            $table->foreignId('service_request_id')->constrained('service_requests')->onDelete('cascade');
            $table->foreignId('engineer_id')->constrained('staff')->onDelete('cascade'); // Requested by
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); // Requested for
            $table->timestamp('requested_at');
            $table->foreignId('assigned_delivery_man_id')->nullable()->constrained('staff')->onDelete('setNull');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->string('status')->default('pending'); // pending, in_progress, delivered, cancelled
            $table->text('request_notes')->nullable();
            $table->text('delivery_photos')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
        });

        // Spare Part Request Items
        Schema::create('spare_part_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spare_part_request_id')->constrained('spare_part_requests')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('product_serial_id')->nullable()->constrained('product_serials')->onDelete('setNull');
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('total_price', 15, 2);
            $table->string('status')->default('pending'); // pending, approved, rejected, delivered, cancelled
            $table->timestamps();
            $table->softDeletes();
        });

    Note: - Product Id is foreign key from Products table - Product Serial Id is foreign key from Product Serials table - Requested By is foreign key from Engineers table - Requested For is foreign key from Customers table - Assigned Delivery Man is foreign key from Delivery Men table - Soft delete - etc.

36. Leads:

    - List of leads
    - View Lead
    - Add Lead
    - Update Lead
    - Delete Lead

    Table:
    `leads`:

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            <!-- user_id -->
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade'); // Sales Person
            $table->string('lead_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('company_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('industry_type')->nullable();
            $table->string('source')->default('website'); // website, referral, call, event, etc.
            $table->string('requirement_type')->nullable();
            $table->string('budget_range')->nullable(); // <1L, 1-5L, 5-10L, 10-20L, 20L+
            $table->string('urgency')->default('medium'); // low, medium, high, critical
            $table->string('status')->default('new'); // new, contacted, qualified, proposal, won, lost, nurture

            $table->decimal('estimated_value', 15, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
            $table->index(['staff_id', 'status']);
            $table->index('created_at');
            $table->index('urgency');
        });

37. Follow Up:

    - List of follow up
    - View Follow Up
    - Add Follow Up
    - Update Follow Up
    - Delete Follow Up

    Table:
    `follow_ups`:

        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            <!-- user_id -->
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade'); // Sales Person
            $table->date('followup_date');
            $table->time('followup_time')->nullable();
            $table->string('followup_type')->default('call'); // call, email, meeting, sms
            $table->string('status')->default('pending'); // pending, completed, rescheduled, cancelled
            $table->text('remarks')->nullable();
            $table->string('next_action')->nullable();
            $table->timestamp('next_followup_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['lead_id', 'status']);
            $table->index('followup_date');
        });

38. Meets:

    - List of meets
    - View Meet
    - Add Meet
    - Update Meet
    - Delete Meet

    Table:
    `meets`:

        // Meetings
        Schema::create('meets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            <!-- user_id -->
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade'); // Sales Person
            $table->string('meet_title');
            $table->string('meeting_type')->default('in_person'); // in_person, virtual, phone
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->string('meeting_link')->nullable(); // For virtual meetings
            $table->text('attendees')->nullable();
            $table->string('attachment')->nullable();
            $table->text('meet_agenda')->nullable();
            $table->text('meeting_notes')->nullable();
            $table->text('follow_up_action')->nullable();
            $table->string('status')->default('scheduled'); // scheduled, completed, cancelled, rescheduled
            $table->timestamps();
            $table->softDeletes();

            $table->index(['lead_id', 'status']);
        });

39. Quotations:

    - List of quotations
    - View Quotation
    - Add Quotation
    - Update Quotation
    - Delete Quotation

    Table:
    `quotations`:

        // Quotations
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            <!-- user_id -->
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade'); // Sales Person
            $table->string('quote_id')->unique();
            $table->string('quote_number')->unique();
            $table->date('quote_date');
            $table->date('expiry_date');

            $table->integer('total_items')->default(0);

            $table->string('currency')->default('INR');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2);

            $table->string('status')->default('draft'); // draft, sent, accepted, rejected, expired, converted
            $table->text('terms_conditions')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->string('quote_document_path')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['lead_id', 'status']);
        });

    Table:
    `quotation_products`:

         // Quotation Products
        Schema::create('quotation_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quotations')->onDelete('cascade');
            $table->string('product_name');
            $table->string('hsn_code')->nullable();
            $table->string('sku')->nullable();
            $table->text('product_description')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('discount_per_unit', 15, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('line_total', 15, 2);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

    (Warehouse)

40. Scrap Items:

    - List of scrap items
    - View Scrap Item
    - Add Scrap Item
    - Update Scrap Item
    - Delete Scrap Item

    Table:
    `scrap_items`:

        // Scrap Items
        Schema::create('scrap_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('product_serial_id')->nullable()->constrained('product_serials')->onDelete('setNull');
            $table->integer('quantity_scrapped');
            $table->string('reason_for_scrap');
            $table->text('scrap_notes')->nullable();
            $table->text('photos')->nullable();
            $table->foreignId('scrapped_by')->nullable()->constrained('users')->onDelete('setNull');
            $table->timestamp('scrapped_at');
            $table->timestamps();
            $table->softDeletes();

            $table->index('product_id');
        });

41. Track Product: No need of table.

    - Search Product by SKU or Serial Number
    - View Product Details
    - View Serial Numbers
    - View Warehouse Details
    - View Rack Details
    - View Stock Details
    - View Product History
    - View Product Images
    - View Product Documents
    - View Product Videos
    - View Product Audits
    - View Product Actions

42. Stock Reports: No need of table.

    - List of stock reports
    - View Stock Report
    - Add Stock Report
    - Update Stock Report
    - Delete Stock Report
    - Export Stock Report
    - Import Stock Report

43. Low Stock Report: No need of table.

    - List of low stock report
    - View Low Stock Report
    - Add Low Stock Report
    - Update Low Stock Report
    - Delete Low Stock Report
    - Export Low Stock Report
    - Import Low Stock Report

    (E-commerce)

44. Orders:

    - List of orders
    - View Order
    - Add Order
    - Update Order
    - Delete Order
    - Print Invoice
    - Download Invoice
    - Send Invoice Email
    - Print Delivery Challan
    - Download Delivery Challan
    - Send Delivery Challan Email
    - Update Order Status
    - Update Payment Status
    - Update Delivery Status
    - Update Delivery Man
    - Update Delivery Date
    - Update Delivery Time
    - Update Delivery Address
    - Update Delivery Instructions

    Table:
    Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('customer_id')->constrained('customers')->onDelete('restrict');
    $table->string('order_number')->unique();
    $table->string('order_type')->default('retail'); // retail, wholesale, b2b

            // Items & Pricing
            $table->integer('total_items')->default(0);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->string('coupon_code')->nullable();
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('shipping_charges', 15, 2)->default(0);
            $table->decimal('packaging_charges', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2);

            // Address
            $table->foreignId('billing_address_id')->nullable()->constrained('customer_address_details')->onDelete('setNull');
            $table->foreignId('shipping_address_id')->nullable()->constrained('customer_address_details')->onDelete('setNull');
            $table->boolean('billing_same_as_shipping')->default(true);

            // Status
            $table->string('order_status')->default('pending'); // pending, confirmed, processing, shipped, delivered, cancelled, returned
            $table->string('payment_status')->default('pending'); // pending, partial, completed, failed, refunded
            $table->string('delivery_status')->default('pending'); // pending, in_transit, delivered, failed, returned

            // Dates
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->date('expected_delivery_date')->nullable();

            // OTP Verification
            $table->string('otp')->nullable();
            $table->timestamp('otp_expiry')->nullable();
            $table->timestamp('otp_verified_at')->nullable();

            // Additional Info
            $table->text('customer_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('source_platform')->default('website'); // website, mobile_app, admin_panel
            $table->string('tracking_number')->nullable();
            $table->string('tracking_url')->nullable();

            // Return Info
            $table->boolean('is_returnable')->default(true);
            $table->integer('return_days')->default(30);
            $table->string('return_status')->nullable();
            $table->decimal('refund_amount', 15, 2)->nullable();
            $table->string('refund_status')->nullable(); // pending, processed, cancelled

            // Metrics
            $table->boolean('is_priority')->default(false);
            $table->boolean('requires_signature')->default(false);
            $table->boolean('is_gift')->default(false);

            // Assigned Person
            $table->string('assigned_person_type')->nullable();
            $table->foreignId('assigned_person_id')->nullable()->constrained('staffs')->onDelete('setNull');

            // Created & Updated By
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('setNull');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('setNull');

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            $table->index(['customer_id', 'order_status']);
            $table->index('order_number');
            $table->index('created_at');
            $table->index('delivery_status');
        });


        // Order Items
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->foreignId('product_serial_id')->nullable()->constrained('product_serials')->onDelete('setNull');
            $table->string('product_name');
            $table->string('product_sku');
            $table->string('hsn_code')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('discount_per_unit', 15, 2)->default(0);
            $table->decimal('tax_per_unit', 15, 2)->default(0);
            $table->decimal('line_total', 15, 2);
            $table->text('variant_details')->nullable();
            $table->text('custom_options')->nullable();
            $table->string('item_status')->default('pending'); // pending, shipped, delivered, cancelled, returned
            $table->timestamps();
            $table->softDeletes();

            $table->index(['order_id', 'item_status']);
        });


        // Order Payments
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('payment_id')->unique();
            $table->string('transaction_id')->nullable()->unique();
            $table->string('payment_method')->default('online'); // online, cod, cheque, bank_transfer
            $table->string('payment_gateway')->nullable(); // phonepe, razorpay, etc.
            $table->decimal('amount', 15, 2);
            $table->string('currency')->default('INR');
            $table->string('status')->default('pending'); // pending, processing, completed, failed, refunded
            $table->text('response_data')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['order_id', 'status']);
            $table->index('payment_id');
        });

45. Coupons:

    - List of coupons
    - View Coupon
    - Add Coupon
    - Update Coupon
    - Delete Coupon

    Table:
    `coupons`:

        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type')->default('percentage'); // percentage, fixed, buy_x_get_y
            $table->decimal('discount_value', 10, 2);
            $table->decimal('max_discount', 15, 2)->nullable();
            $table->decimal('min_purchase_amount', 15, 2)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);
            $table->integer('usage_per_customer')->default(1);
            $table->boolean('is_active')->default(true);
            $table->text('applicable_categories')->nullable();
            $table->text('applicable_brands')->nullable();
            $table->text('excluded_products')->nullable();
            $table->boolean('stackable')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
            $table->index('is_active');
        });

    Table:
    `coupon_usage`:
    // Coupons Usage History
    Schema::create('coupon_usage', function (Blueprint $table) {
    $table->id();
    $table->foreignId('coupon_id')->constrained('coupons')->onDelete('cascade');
    $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
    $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
    $table->decimal('discount_amount', 15, 2);
    $table->timestamps();

            $table->index(['coupon_id', 'customer_id']);
        });

46. Subscribers:

    - List of subscribers
    - Send Mail to all subscribers
    - Delete Subscriber

    Table:
    `subscribers`:

        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamps();
        });

47. Contacts:

    - List of contacts
    - View Contact
    - Add Contact
    - Update Contact
    - Delete Contact

    Table:
    `contacts`:

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('subject');
            $table->text('description');
            $table->timestamps();
        });

48. Banner:

    -   Website Banner

        - List of website banners
        - View Website Banner
        - Add Website Banner
        - Update Website Banner
        - Delete Website Banner

        Table:
        `website_banners`:

              return new class extends Migration {
                  public function up(): void
                  {
                      Schema::create('banners', function (Blueprint $table) {
                          $table->id();

                          // Core Info
                          $table->string('title');
                          $table->string('slug')->unique();
                          $table->text('description')->nullable();
                          $table->string('image_url');

                          // Banner Classification
                          $table->string('type')->default('website');
                          // website, promotional

                          $table->string('channel')->default('website');
                          // website, mobile, email

                          // Promotion-Specific Fields
                          $table->string('promotion_type')->nullable();
                          // discount, coupon, flash_sale, event

                          $table->decimal('discount_value', 8, 2)->nullable();
                          $table->string('discount_type')->nullable();
                          // percentage, fixed

                          $table->string('promo_code')->nullable();

                          // Link & Display
                          $table->string('link_url')->nullable();
                          $table->string('link_target')->default('_self');
                          // _self, _blank

                          $table->string('position')->default('homepage');
                          // homepage, category, product, slider, checkout, cart

                          $table->integer('display_order')->default(0);

                          // Scheduling
                          $table->dateTime('start_at');
                          $table->dateTime('end_at');

                          // Status & Analytics
                          $table->boolean('is_active')->default(true);
                          $table->integer('click_count')->default(0);
                          $table->integer('view_count')->default(0);

                          // Extensibility
                          $table->text('metadata')->nullable();

                          $table->timestamps();
                          $table->softDeletes();

                          // Indexes
                          $table->index('type');
                          $table->index('channel');
                          $table->index('position');
                          $table->index('is_active');
                          $table->index('promotion_type');
                      });
                  }

                  public function down(): void
                  {
                      Schema::dropIfExists('banners');
                  }
              };

49. Testimonials:

    - List of testimonials
    - View Testimonial
    - Add Testimonial
    - Update Testimonial
    - Delete Testimonial

    Table:
    `testimonials`:

        // Testimonials
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_image')->nullable();
            $table->string('customer_designation')->nullable();
            $table->text('testimonial_text');
            $table->integer('rating')->default(5); // 1-5 stars
            $table->string('source')->nullable(); // website, app, email, etc.
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
        });

50. Product Deal Offers:

51. Collections:

    - List of collections
    - View Collection
    - Add Collection
    - Update Collection
    - Delete Collection

    Table:
    `collections`:

        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('products_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
        });

    Table:
    `collection_category`:

        // Collection Categories
        Schema::create('collection_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained('collections')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('parent_categories')->onDelete('cascade');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['collection_id', 'category_id']);
        });

52. Profile:

    (CRM)

53. Tickets:

    List of tickets
    View Ticket
    Add Ticket
    Update Ticket
    Delete Ticket

    Table:
    `tickets`:

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('ticket_number')->unique();
            $table->string('ticket_id')->unique();
            $table->string('title');
            $table->longText('description');
            $table->string('category')->default('general'); // product, service, billing, technical, other
            $table->string('subcategory')->nullable();
            $table->string('priority')->default('medium'); // low, medium, high, urgent
            $table->string('status')->default('open'); // open, in_progress, pending, resolved, closed, reopened
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->integer('response_time_minutes')->nullable(); // SLA
            $table->integer('resolution_time_minutes')->nullable(); // SLA
            $table->timestamp('first_response_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('assigned_to')->references('id')->on('staff')->onDelete('setNull');
            $table->index(['customer_id', 'status']);
            $table->index('priority');
        });

    Table:
    `ticket_comments`:

        Schema::create('ticket_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->text('comment');
            $table->text('attachments')->nullable();
            $table->boolean('is_internal')->default(false);
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('setNull');
            $table->index('ticket_id');
        });

54. Invoices:

    List of invoices
    View Invoice
    Add Invoice
    Update Invoice
    Delete Invoice
    Generate Invoice PDF
    Send Invoice Email
    Print Invoice

    Table:
    `invoices`:

        // Invoices
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('setNull');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('restrict');
            $table->string('invoice_number')->unique();
            $table->string('invoice_id')->unique();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('currency')->default('INR');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->string('status')->default('draft'); // draft, sent, viewed, partially_paid, paid, overdue, cancelled
            $table->text('notes')->nullable();
            $table->string('invoice_document_path')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['customer_id', 'status']);
            $table->index('due_date');
        });

    Table:
    `invoice_items`:

        // Invoice Items
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->string('item_description');
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('line_total', 15, 2);
            $table->timestamps();
        });

(Admin Panel & Website Setting) 46. Settings:

## CRM

## E-commerce

## App Settings

# Frontend (E-commerce)

# App (Customer, Sales Person, Field Executive, Delivery Man) - APIs

1. Staff seeder:

Common APIs:

Authentication:

/signup
/send-otp
/verify-otp
/refresh-token
/logout

/dashboard

/notifications

/profile
/profile/{role_id}

/attendance
/attendance/login
/attendance/logout

Sales Person App APIs:

API Endpoint

Dashboard:
/sales-overview
/task

/leads
/lead/{lead_id}
/lead
/lead/{lead_id}
/lead/{lead_id}

/follow-up
/follow-up/{follow_up_id}
/follow-up
/follow-up/{follow_up_id}
/follow-up/{follow_up_id}

/meets
/meet/{meet_id}
/meet
/meet/{meet_id}
/meet/{meet_id}

/quotation
/quotation
/quotation/{quotation_id}
/quotation/{quotation_id}
/quotation/{quotation_id}

/product
/product/{product_id}

Delivery Man App APIs:

/vehical-registration
/vehical-details
/vehical-details

/dashboard
/orders
/orders
/orders
/orders
/orders

/order/{order_id}

/accept-order/{order_id}
/order/profile/{order_id}
/order/{order_id}/otp
/order/{order_id}/verify-otp

/delivery/{order_id}

/driving-license
/driving-license

/aadhar-card
/aadhar-card

/pan-card
/pan-card

/track-work-details

Customer App APIs:

/products
/product/{product_id}
/buy-product/{product_id}

/quick-service
/quick-service{id}

/installation-request

/repair-request

/amc-plans
/create-amc-request

/orders
/order/{order_id}

/work-progress
/work-progress/{id}

/repairs
/repairs/{id}

/quotations
/quotation/{q_id}

/all-requests
/amc-request-details/{id}
/non-amc-request-details/{id}
/quick-service-request-details/{id}

/feedback

/feedbacks
/feedbacks/{feedback_id}

users

staffs - done
staff addresses - done
aadhar details - done
pan card details - done
bank details - done
vehical details - done
police verification details - done
work skills details - done

customers - done
customer address details - done
customers company details - done
customer aadhar details - done
customer pan card details - done

warehouses - done
warehouses racks - done

parent categories - done
sub categories - done

brands - done
product varient attributes - done
product varient attribute values - done

vendors - done
vendors purchase orders - done

pincodes - done

products - done
product serials - done
ecommerce products - done

covered items - done
amc plans - done
service requests - done
service request products - done

case transfer requests - done
pickup requests - done
remote jobs - done

field issues - done
stock in hands - done
stock in hand products - done

leads - done
follow ups - done
meets - done
quotations - done
quotation products - done

scrap items - done

orders - done
order items - done
order payments - done

coupons - done
coupon usages - done

subscribers - done

contacts - done

website banners - done

testimonials - done

collections - done
collection categories - done

tickets - done
ticket comments - done

invoices - done
invoice items - done

assigned engineers - done
engineer diagnosis details - done

service request product pickups - done
service request product request parts - done

requested part deliveries - done

service request quotations - done

service request payments - done
assigned engineer group - model not created

website banners - done

feedbacks - done

2. payment after service request completion


3. my orders - profile
4. my services
5. work progress tracker (selected service details)
