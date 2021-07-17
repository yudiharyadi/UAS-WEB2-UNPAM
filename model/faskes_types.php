<?php

class FaskesType extends MySqlDb{

    static function getAllFaskesTypes() {
        return FaskesType::getAllData('faskes_types');
    }

    static function getFaskesType($id) {
        return FaskesType::getData('faskes_types', "id='".$id."'");
    }
}