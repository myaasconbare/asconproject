<?php
// Simple protection using a secret key
$secret = 'mystrongsecret123'; // Change this to any random string

// Read data sent from GitHub
$input = file_get_contents('php://input');

// Check GitHub signature for security
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
$expected = 'sha256=' . hash_hmac('sha256', $input, $secret);
if (!hash_equals($expected, $signature)) {
    http_response_code(403);
    exit('Invalid signature');
}

// Run the deploy script in background
exec('bash /home/asconunited/htdocs/asconunited.com/deploy.sh > /dev/null 2>&1 &');

echo "✅ Deploy triggered successfully.";

