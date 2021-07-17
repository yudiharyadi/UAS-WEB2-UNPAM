<?php

class Provinces extends MySqlDb{

    static function getAllProvicies() {
        return Provinces::getAllData('provinces');
    }

    static function getProvince($id) {
        return Provinces::getData('provinces', "id='".$id."'");
    }
}