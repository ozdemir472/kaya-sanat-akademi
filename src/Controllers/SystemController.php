<?php

namespace App\Controllers;

use App\Models\DB;
use App\Extensions\Json;


class SystemController {
    public function getSystemOption(){
        $option = DB::filter($_GET['option']);
        $value = json_decode(DB::table("options")->where("option", $option)->first()['value'], true);

        echo Json::data(["option" => $value]);
    }

    public function saveWorkingHours() {
        // Ham JSON verisini al
        $rawData = $_POST['option'];
        $decodedData = json_decode($rawData, true);
    
        // JSON geçerli mi kontrol et
        if ($decodedData === null) {
            die("Geçersiz JSON formatı!");
        }
    
        // Veriyi veritabanına kaydet
        DB::table("options")->where("option", "workingHours")->update([
            'value' => json_encode($decodedData, JSON_UNESCAPED_UNICODE)
        ]);
    
        echo Json::message("Çalışma saatleri başarıyla kaydedildi.");
    }

    public function saveWorkingDays(){
        // Ham JSON verisini al
        $rawData = $_POST['option'];
        $decodedData = json_decode($rawData, true);
        
        // JSON geçerli mi kontrol et,
        if ($decodedData === null) {
            die("Geçersiz JSON formatı!");
        }
        
        // Veriyi veritabanına kaydet
        DB::table("options")->where("option", "workingDays")->update([
            'value' => json_encode($decodedData, JSON_UNESCAPED_UNICODE)
        ]);
        
        echo Json::message("Çalışma günleri başarıyla kaydedildi.");
    }
    
}