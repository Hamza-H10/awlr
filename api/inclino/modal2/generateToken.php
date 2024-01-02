<?php
function generateToken($length = 20)
{
    // Generate a random binary string
    $randomBytes = random_bytes($length);

    // Convert binary to hexadecimal representation
    $token = bin2hex($randomBytes);

    return $token;
}

// Example usage
$generatedToken = generateToken();
echo $generatedToken;
