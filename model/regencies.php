<?php

class Regencies extends MySqlDb{

    static function getAllRegencies($province_id) {
        return Regencies::getArrData('regencies', "province='".$province_id."'");
    }

    static function getRegency($id) {
        return Regencies::getData('regencies', "id='".$id."'");
    }
}