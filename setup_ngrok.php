<?php
/**
 * Ngrok Setup Script for Midtrans Webhook Testing
 * 
 * This script helps set up ngrok tunnel for local development
 * so Midtrans webhooks can reach your local server
 */

echo "=== Ngrok Setup for Midtrans Webhook Testing ===\n\n";

// Check if ngrok is installed
$ngrokCheck = shell_exec('ngrok version 2>&1');
if (strpos($ngrokCheck, 'ngrok') === false) {
    echo "❌ Ngrok is not installed or not in PATH.\n";
    echo "Please install ngrok first:\n";
    echo "1. Download from https://ngrok.com/download\n";
    echo "2. Extract and add to your system PATH\n";
    echo "3. Run 'ngrok authtoken YOUR_AUTH_TOKEN' to authenticate\n\n";
    exit(1);
}

echo "✅ Ngrok is installed: " . trim($ngrokCheck) . "\n\n";

// Get the current app URL from .env
$envContent = file_get_contents(__DIR__ . '/.env');
if (preg_match('/APP_URL=(.+)/', $envContent, $matches)) {
    $currentUrl = trim($matches[1]);
    echo "Current APP_URL: $currentUrl\n";
}

// Start ngrok tunnel
echo "\n🚀 Starting ngrok tunnel on port 8000...\n";
echo "Command: ngrok http 8000\n\n";

// Instructions for user
echo "=== INSTRUCTIONS ===\n\n";
echo "1. Keep this terminal running (ngrok will start)\n";
echo "2. Copy the HTTPS URL from ngrok output (e.g., https://abc123.ngrok.io)\n";
echo "3. Update your .env file with the new webhook URL:\n";
echo "   MIDTRANS_WEBHOOK_URL=https://abc123.ngrok.io/midtrans/notification\n\n";
echo "4. Update Midtrans Dashboard:\n";
echo "   - Go to https://dashboard.midtrans.com\n";
echo "   - Navigate to Settings > Configuration\n";
echo "   - Update Payment Notification URL to: https://abc123.ngrok.io/midtrans/notification\n\n";
echo "5. Test with a new payment\n\n";

// Start ngrok
echo "Starting ngrok...\n";
passthru('ngrok http 8000');