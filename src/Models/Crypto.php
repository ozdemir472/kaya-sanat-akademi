<?php
namespace App\Models;

use Exception;

class Crypto {
    private static $cipher = 'aes-256-cbc';

    public static function encrypt($data, $key = 'T9v*Lp6&gQr', $iv = 'b4c6f5d7a8e9c1d2') {
        $encrypted = openssl_encrypt($data, self::$cipher, $key, OPENSSL_RAW_DATA, $iv);
        
        if ($encrypted === false) {
            throw new Exception('Encryption failed.');
        }

        return base64_encode($encrypted . '::' . $iv);
    }

    public static function decrypt($data, $key = 'T9v*Lp6&gQr') {
        $data = base64_decode($data);
        $parts = explode('::', $data, 2);
        
        if (count($parts) !== 2) {
            return null;
        }

        list($encrypted_data, $iv) = $parts;

        $decrypted = openssl_decrypt($encrypted_data, self::$cipher, $key, OPENSSL_RAW_DATA, $iv);

        if ($decrypted === false) {
            throw new Exception('Decryption failed.');
        }

        return $decrypted;
    }
}