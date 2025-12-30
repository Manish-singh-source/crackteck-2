# Engineer Task Approval Feature

## Overview
This feature allows engineers to view and approve service tasks assigned to them through the staff view page. Tasks that are not approved within 48 hours are highlighted and can be tracked.

## Features Implemented

### 1. Database Changes
- **Migration**: `2025_12_29_150000_add_engineer_approval_to_assigned_engineers_table.php`
- Added fields to `assigned_engineers` table:
  - `is_approved_by_engineer` (boolean, default: false) - Tracks if engineer has approved the task
  - `engineer_approved_at` (timestamp, nullable) - Records when the engineer approved the task

### 2. Model Updates
- **AssignedEngineer Model** (`app/Models/AssignedEngineer.php`):
  - Added fillable fields: `is_approved_by_engineer`, `engineer_approved_at`
  - Added casts for datetime fields
  - Added scopes:
    - `scopePendingApproval()` - Get tasks pending approval
    - `scopeApproved()` - Get approved tasks
    - `scopeOverdue()` - Get tasks over 48 hours without approval
  - Added accessor: `getIsOverdueAttribute()` - Check if task is overdue

### 3. Controller Updates
- **StaffController** (`app/Http/Controllers/StaffController.php`):
  - Updated `view()` method to fetch assigned tasks for the engineer
  - Added `approveTask()` method to handle task approval via AJAX
  - Includes proper validation, transaction handling, and activity logging

- **ServiceRequestController** (`app/Http/Controllers/ServiceRequestController.php`):
  - Added `viewServiceRequest()` method to view individual service requests

### 4. Routes
- **web.php**:
  - Added route: `POST /crm/approve-task` → `staff.approve.task`
  - Added route: `GET /crm/view-service-request/{id}` → `service-request.view`

### 5. View Updates
- **staff/view.blade.php** (`resources/views/crm/access-control/staff/view.blade.php`):
  - Updated "Task Details" tab to display assigned tasks
  - Shows:
    - Service Request ID (clickable link)
    - Customer Name
    - Service Type (AMC, Quick Service, Installation, Repair)
    - Assigned Date
    - Assignment Type (Individual/Group)
    - Approval Status (Approved/Pending Approval)
    - Action buttons (View, Approve)
  - Highlights tasks over 48 hours with warning color
  - Added AJAX functionality for task approval
  - Shows success/error messages
  - Auto-dismisses alerts after 5 seconds

## Usage

### For Engineers
1. Navigate to `/crm/view-staff/{engineer_id}`
2. Click on "Task Details" tab
3. View all assigned tasks
4. Click "Approve" button to accept a task
5. Tasks over 48 hours without approval are highlighted in yellow

### For Administrators
- Can view which tasks have been approved by engineers
- Can track tasks that haven't been approved within 48 hours
- Tasks automatically appear in service request section if not approved within 48 hours

## Technical Details

### Task Approval Flow
1. Engineer views assigned tasks in "Task Details" tab
2. Engineer clicks "Approve" button
3. AJAX request sent to `/crm/approve-task`
4. Server validates and updates:
   - `is_approved_by_engineer` = true
   - `engineer_approved_at` = current timestamp
5. Activity log created
6. UI updates to show approved status
7. Approve button is removed

### 48-Hour Logic
- Tasks are considered overdue if:
  - `is_approved_by_engineer` = false
  - `assigned_at` + 48 hours < current time
- Overdue tasks are:
  - Highlighted with yellow background in the table
  - Marked with "Over 48 hours" badge
  - Can still be approved by the engineer

## Database Schema

```sql
-- assigned_engineers table additions
ALTER TABLE assigned_engineers 
ADD COLUMN is_approved_by_engineer BOOLEAN DEFAULT FALSE COMMENT 'Whether engineer has approved the task',
ADD COLUMN engineer_approved_at TIMESTAMP NULL COMMENT 'When engineer approved the task';
```

## API Endpoints

### Approve Task
- **URL**: `/crm/approve-task`
- **Method**: POST
- **Auth**: Required
- **Parameters**:
  - `assignment_id` (required) - ID of the assigned_engineers record
- **Response**:
  ```json
  {
    "success": true,
    "message": "Task approved successfully.",
    "approved_at": "29 Dec 2024, 03:00 PM"
  }
  ```

## Migration Instructions

1. Run the migration:
   ```bash
   php artisan migrate
   ```

2. Clear cache:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

3. Test the feature:
   - Assign a task to an engineer
   - View the engineer's profile
   - Check the "Task Details" tab
   - Approve a task
   - Verify the approval status updates

## Notes
- No reject option is provided as per requirements
- Tasks remain visible even after approval
- Approval is a one-time action (cannot be undone)
- Activity logs are created for all approvals
- CSRF protection is enabled for all AJAX requests

