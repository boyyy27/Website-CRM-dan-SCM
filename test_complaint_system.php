<?php
/**
 * Test file for Complaint System
 * This file can be used to test the complaint system functionality
 * Place this file in your project root and access via browser
 */

// Include CodeIgniter bootstrap
require_once 'index.php';

// Test the complaint system
class ComplaintSystemTest {
    
    public function testCustomerSubmission() {
        echo "<h2>Testing Customer Complaint Submission</h2>";
        
        // Simulate customer login
        $CI =& get_instance();
        $CI->load->library('session');
        
        // Test with a sample customer ID (you may need to adjust this)
        $customer_id = 9; // HanSohee customer from your database
        
        // Set session data
        $CI->session->set_userdata('customer_id', $customer_id);
        $CI->session->set_userdata('logged_in', true);
        
        echo "<p>✅ Customer session set with ID: $customer_id</p>";
        
        // Test complaint submission
        $complaint_data = [
            'name' => 'Test Customer',
            'email' => 'test@example.com',
            'subject' => 'Test Suggestion',
            'rating' => 5,
            'message' => 'This is a test complaint from a logged-in customer.',
            'customer_id' => $customer_id
        ];
        
        $CI->load->model('Complaint_model');
        $result = $CI->Complaint_model->submit($complaint_data);
        
        if ($result) {
            echo "<p>✅ Complaint submitted successfully</p>";
        } else {
            echo "<p>❌ Failed to submit complaint</p>";
        }
        
        // Test retrieving complaints
        $complaints = $CI->Complaint_model->get_all();
        echo "<p>✅ Retrieved " . count($complaints) . " complaints</p>";
        
        // Show latest complaint
        if (!empty($complaints)) {
            $latest = $complaints[0];
            echo "<h3>Latest Complaint:</h3>";
            echo "<ul>";
            echo "<li><strong>Name:</strong> " . htmlspecialchars($latest->name) . "</li>";
            echo "<li><strong>Email:</strong> " . htmlspecialchars($latest->email) . "</li>";
            echo "<li><strong>Subject:</strong> " . htmlspecialchars($latest->subject) . "</li>";
            echo "<li><strong>Rating:</strong> " . $latest->rating . "</li>";
            echo "<li><strong>Customer ID:</strong> " . ($latest->customer_id ?? 'None') . "</li>";
            if (isset($latest->customer_name)) {
                echo "<li><strong>Customer Name:</strong> " . htmlspecialchars($latest->customer_name) . "</li>";
            }
            echo "</ul>";
        }
        
        // Clear session
        $CI->session->sess_destroy();
        echo "<p>✅ Session cleared</p>";
    }
    
    public function testNonCustomerSubmission() {
        echo "<h2>Testing Non-Customer Complaint Submission</h2>";
        
        $CI =& get_instance();
        $CI->load->library('session');
        
        // Ensure no customer session
        $CI->session->sess_destroy();
        
        echo "<p>✅ No customer session (simulating non-logged in user)</p>";
        
        // Test complaint submission without customer_id
        $complaint_data = [
            'name' => 'Anonymous User',
            'email' => 'anonymous@example.com',
            'subject' => 'Test Complaint',
            'rating' => 3,
            'message' => 'This is a test complaint from a non-logged in user.',
            'customer_id' => null
        ];
        
        $CI->load->model('Complaint_model');
        $result = $CI->Complaint_model->submit($complaint_data);
        
        if ($result) {
            echo "<p>✅ Anonymous complaint submitted successfully</p>";
        } else {
            echo "<p>❌ Failed to submit anonymous complaint</p>";
        }
    }
    
    public function runAllTests() {
        echo "<h1>Complaint System Test Results</h1>";
        echo "<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            h1, h2, h3 { color: #333; }
            p { margin: 10px 0; }
            ul { margin: 10px 0; padding-left: 20px; }
            li { margin: 5px 0; }
        </style>";
        
        $this->testCustomerSubmission();
        echo "<hr>";
        $this->testNonCustomerSubmission();
        
        echo "<h2>Test Summary</h2>";
        echo "<p>✅ All tests completed. Check the results above.</p>";
        echo "<p><strong>Next Steps:</strong></p>";
        echo "<ul>";
        echo "<li>Run the SQL commands in add_customer_id_column.sql</li>";
        echo "<li>Test the actual form submission on the landing page</li>";
        echo "<li>Verify customer data is automatically filled when logged in</li>";
        echo "<li>Check that 'Verified Customer' badge appears for logged-in users</li>";
        echo "</ul>";
    }
}

// Run tests if accessed directly
if (basename(__FILE__) == basename($_SERVER['SCRIPT_NAME'])) {
    $test = new ComplaintSystemTest();
    $test->runAllTests();
}
?> 