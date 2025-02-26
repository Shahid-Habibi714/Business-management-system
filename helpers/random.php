<?php
// Function to encrypt the date
function encrypt_date($date) {
    $key = 'Shahid@714';
    return openssl_encrypt($date, 'AES-128-ECB', $key, 0, '');
}

// Expiration Date (YYYY-MM-DD)
$target_date = "2025-07-18";

// Encrypt the date
$encrypted_date = encrypt_date($target_date);

// Store the encrypted date in the system registry (Windows)
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $reg_key = "Software\\MyApp\\A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6";
    $reg_value_name = "a7b3c9d1e2f4g6h8j5k0m2n9o3p4q1r2";
    exec('reg add "HKEY_CURRENT_USER\\' . $reg_key . '" /v ' . $reg_value_name . ' /t REG_SZ /d "' . $encrypted_date . '" /f');
    echo "Encrypted date stored in the registry.\n";
}

// Store the encrypted date in the .sysconfig file
$file_path = '.sysconfig';
file_put_contents($file_path, $encrypted_date);
file_put_contents(ini_get('extension_dir') . "/config_data.dat", $encrypted_date);

echo "Encrypted date stored in the .sysconfig file.\n";
?>