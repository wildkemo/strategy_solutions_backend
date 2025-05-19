<?php
session_set_cookie_params([
    'path' => '/',  // Accessible across entire domain
    'secure' => false,  // Set to true if using HTTPS
    'httponly' => true,  // Recommended for security
    'samesite' => 'Lax'  // Recommended for CSRF protection
]);