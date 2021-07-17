<?php

class Districts extends MySqlDb{

    static function getAllDistricts($regency_id) {
        return Districts::getArrData('districts', "regency='".$regency_id."'");
    }

    static function getDistrict($id) {
        return Districts::getData('districts', "id='".$id."'");
    }
}