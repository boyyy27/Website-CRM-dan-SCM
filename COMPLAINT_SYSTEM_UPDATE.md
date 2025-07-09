# Complaint System Update - Customer Integration

## Overview
This update modifies the complaint/suggestion system to integrate with the customer database, allowing logged-in customers to submit feedback using their account information automatically.

## Changes Made

### 1. Database Changes
- Added `customer_id` column to `complaints_suggestions` table
- SQL file: `add_customer_id_column.sql`

```sql
ALTER TABLE complaints_suggestions ADD COLUMN customer_id INT NULL AFTER id;
```

### 2. Model Changes (`Complaint_model.php`)
- Modified `get_all()` method to join with `customers` table
- Added `get_by_customer_id()` method for customer-specific queries
- Now returns customer information along with complaints

### 3. Controller Changes (`Complaint.php`)
- Modified `submit()` method to:
  - Allow both customer and admin access
  - Automatically use customer data when logged in
  - Store `customer_id` in complaints table
- Added proper access control for admin methods

### 4. Welcome Controller Changes (`Welcome.php`)
- Updated complaints data fetching to use `Complaint_model`
- Now displays customer information in feedback section

### 5. View Changes (`landing_page.php`)
- Enhanced feedback display to show "Verified Customer" badge
- Added informational message for logged-in customers
- Improved customer name display using joined data

## Features

### For Logged-in Customers:
- Name and email automatically filled from customer account
- Fields are read-only when logged in
- Feedback marked as "Verified Customer"
- Customer information used for submission

### For Non-logged-in Users:
- Manual input required for name and email
- Standard feedback submission process

### For Admins:
- Can view all complaints with customer information
- Can delete complaints
- Access to admin dashboard for complaint management

## Database Structure

### complaints_suggestions table:
```sql
CREATE TABLE complaints_suggestions (
  id int(11) NOT NULL AUTO_INCREMENT,
  customer_id int(11) NULL,  -- NEW: Links to customers table
  name varchar(100) DEFAULT NULL,
  email varchar(100) DEFAULT NULL,
  subject varchar(200) DEFAULT NULL,
  rating tinyint(1) UNSIGNED DEFAULT NULL,
  message text DEFAULT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp()
);
```

## Usage

### Customer Submission:
1. Customer logs in to their account
2. Navigates to contact section
3. Form automatically fills with customer data
4. Customer only needs to enter subject, message, and rating
5. Submission is marked as verified customer

### Admin Management:
1. Admin logs in to admin panel
2. Navigates to complaints section
3. Can view all complaints with customer details
4. Can delete complaints as needed

## Benefits

1. **Data Integrity**: Customer information is automatically verified
2. **User Experience**: Logged-in customers have streamlined submission
3. **Trust Indicators**: "Verified Customer" badge increases credibility
4. **Admin Insights**: Better tracking of customer feedback
5. **Data Consistency**: Customer data is always up-to-date

## Installation

1. Run the SQL command in `add_customer_id_column.sql`
2. Deploy the updated PHP files
3. Test the system with both logged-in and non-logged-in users

## Testing

### Test Cases:
1. **Logged-in Customer**: Submit feedback and verify customer data is used
2. **Non-logged-in User**: Submit feedback and verify manual input works
3. **Admin Access**: Verify admin can view and manage complaints
4. **Data Display**: Verify customer information shows correctly in feedback section

## Notes

- Existing complaints without `customer_id` will still display normally
- The system is backward compatible with existing data
- Customer verification badge only shows for complaints with valid `customer_id` 