<?php
// Simple test file untuk debug Vercel
echo "PHP Version: " . phpversion() . "<br>";
echo "Current Directory: " . __DIR__ . "<br>";
echo "Laravel Public Path: " . __DIR__ . '/../public/index.php' . "<br>";
echo "File Exists: " . (file_exists(__DIR__ . '/../public/index.php') ? 'YES' : 'NO') . "<br>";
echo "<br>Environment Variables:<br>";
echo "APP_ENV: " . getenv('APP_ENV') . "<br>";
echo "APP_DEBUG: " . getenv('APP_DEBUG') . "<br>";
echo "APP_KEY: " . (getenv('APP_KEY') ? 'SET' : 'NOT SET') . "<br>";
