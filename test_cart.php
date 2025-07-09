<?php
// test_cart.php - Simpan di root folder project
// Akses via: http://localhost/vapestore/test_cart.php

// Test koneksi database dan model
require_once 'application/config/database.php';

echo "<h2>Cart Debug Test</h2>";

// Test 1: Basic PHP
echo "<h3>1. PHP Test</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Current Time: " . date('Y-m-d H:i:s') . "<br>";

// Test 2: Session
echo "<h3>2. Session Test</h3>";
session_start();
$_SESSION['test'] = 'session_working';
echo "Session Test: " . (isset($_SESSION['test']) ? 'Working' : 'Not Working') . "<br>";

// Test 3: Simulate POST data
echo "<h3>3. POST Data Simulation</h3>";
$_POST['product_id'] = '1';
$_POST['quantity'] = '1';
echo "POST product_id: " . $_POST['product_id'] . "<br>";
echo "POST quantity: " . $_POST['quantity'] . "<br>";

// Test 4: Test simple JSON output
echo "<h3>4. JSON Output Test</h3>";
header('Content-Type: application/json');
$test_response = [
    'success' => true,
    'message' => 'Test response',
    'data' => ['test' => 'value']
];
echo "<pre>";
echo json_encode($test_response, JSON_PRETTY_PRINT);
echo "</pre>";
?>