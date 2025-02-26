<?php

namespace App\Controllers;

use App\Extensions\Json;
use App\Models\DB;

class LogController {
    protected $db;

    public function __construct() {
        $this->db = new DB('logs');
    }

    public function createLog($message = "Mesaj belirtilmedi", $status = "false", $userId = null, $type = null) {
        $ip_address   = $_SERVER['REMOTE_ADDR'] ?? 'Bilinmiyor';
        $user_agent   = $_SERVER['HTTP_USER_AGENT'] ?? 'Bilinmiyor';
        $os           = $this->getOS($user_agent);
        $browser      = $this->getBrowser($user_agent);
        $device_type  = $this->getDeviceType($user_agent);
        $current_page = $_SERVER['REQUEST_URI'] ?? 'Bilinmiyor';
        $referrer     = $_SERVER['HTTP_REFERER'] ?? 'Doğrudan giriş';

        $data = [
            'ip_address'   => $ip_address,
            'userId'       => $userId,
            'user_agent'   => $user_agent,
            'os'           => $os,
            'browser'      => $browser,
            'device_type'  => $device_type,
            'current_page' => $current_page,
            'referrer'     => $referrer,
            'last_visit'   => date("Y-m-d H:i:s"),
            'type'         => $type,
            'message'      => $message,
            'status'       => $status
        ];
        
        return $this->db->insert($data);
    }

    private function getOS($user_agent) {
        $os_array = [
            '/windows nt 10/i'     => 'Windows 10',
            '/windows nt 6.3/i'    => 'Windows 8.1',
            '/windows nt 6.2/i'    => 'Windows 8',
            '/windows nt 6.1/i'    => 'Windows 7',
            '/macintosh|mac os x/i'=> 'Mac OS',
            '/linux/i'             => 'Linux',
            '/android/i'           => 'Android',
            '/iphone/i'            => 'iOS'
        ];
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                return $value;
            }
        }
        return 'Bilinmiyor';
    }

    private function getBrowser($user_agent) {
        $browser_array = [
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Chrome',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/mobile/i'    => 'Mobil Tarayıcı'
        ];
        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                return $value;
            }
        }
        return 'Bilinmiyor';
    }

    private function getDeviceType($user_agent) {
        if (preg_match('/mobile/i', $user_agent)) {
            return 'Mobil';
        } elseif (preg_match('/tablet/i', $user_agent)) {
            return 'Tablet';
        } else {
            return 'PC';
        }
    }

    public function getLogs(){
        echo Json::data($this->db->get());
    }
}
