-- Add customer_id column to complaints_suggestions table
-- This allows linking complaints to customer accounts

ALTER TABLE complaints_suggestions ADD COLUMN customer_id INT NULL AFTER id;

-- Optional: Add foreign key constraint for data integrity
-- Uncomment the following lines if you want to enforce referential integrity
-- ALTER TABLE complaints_suggestions ADD CONSTRAINT fk_complaints_customer 
-- FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE SET NULL;

-- Update existing complaints to link with customers if possible
-- This will try to match existing complaints with customers based on email
UPDATE complaints_suggestions cs 
JOIN customers c ON cs.email = c.email 
SET cs.customer_id = c.customer_id 
WHERE cs.customer_id IS NULL AND cs.email IS NOT NULL;

-- Show the updated table structure
DESCRIBE complaints_suggestions; 