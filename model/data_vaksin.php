<?php

class DataVaksin extends MySqlDb{

    static function getAllDataVaksin() {
        return DataVaksin::getAllData('data_vaksin');
    }

    static function getDataVaksin($id) {
        return DataVaksin::getData('data_vaksin', "id='".$id."'");
    }

    static function createDataVaksin($data) {
        return DataVaksin::createData(
            'data_vaksin', 
            "district, faskes_type, faskes_name, identity_number, name, gender, age, birthday, phone_number, addr",
            "
                '$data->district', 
                '$data->faskes_type', 
                '$data->faskes_name', 
                '$data->identity_number', 
                '$data->name', 
                '$data->gender', 
                '$data->age', 
                '$data->birthday', 
                '$data->phone_number', 
                '$data->addr'
            "
        );
    }

    static function updateDataVaksin($data) {
        return DataVaksin::updateData(
            'data_vaksin',
            "
                district='".$data->district."',
                faskes_type='".$data->faskes_type."',
                faskes_name='".$data->faskes_name."',
                identity_number='".$data->identity_number."',
                name='".$data->name."',
                gender='".$data->gender."',
                age='".$data->age."',
                birthday='".$data->birthday."',
                phone_number='".$data->phone_number."',
                addr='".$data->addr."'
            ",
            "id='".$data->id."'"
        );
    }

    static function deleteDataVaksin($id) {
        $response = DataVaksin::deleteData('data_vaksin', "WHERE id='".$id."'");
        $obj = new stdClass();
        if ($response === true) {
            $obj->status = 200;
            $obj->success = true;
        } else {
            $obj->status = 400;
        }
        return $obj;
    }
}