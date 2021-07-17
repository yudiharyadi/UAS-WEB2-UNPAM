<?php
require_once ('classes.php');

function getTable($table) {
    switch ($table) {
        case 'provinces':
            if (isset($_GET['id'])) {
                return Provinces::getProvince($_GET['id']);
            } else {
                return Provinces::getAllProvicies();
            }
            break;
        case 'regencies':
            if (isset($_GET['id'])) {
                return Regencies::getRegency($_GET['id']);
            } else if (isset($_GET['province_id'])) {
                return Regencies::getAllRegencies($_GET['province_id']);
            } else {
                return null;
            }
            break;
        case 'districts':
            if (isset($_GET['id'])) {
                return Districts::getDistrict($_GET['id']);
            } else if (isset($_GET['regency_id'])) {
                return Districts::getAllDistricts($_GET['regency_id']);
            }
            break;
        case 'faskes_types':
            if (isset($_GET['id'])) {
                return FaskesType::getFaskesType($_GET['id']);
            } else {
                return FaskesType::getAllFaskesTypes();
            }
            break;
        case 'data_vaksin':
            if (isset($_GET['id'])) {
                return DataVaksin::getDataVaksin($_GET['id']);
            } else {
                return DataVaksin::getAllDataVaksin();
            }
            break;
        default: 
            break;
    }
}

if(isset($_GET['table'])) {
    header('Content-Type: application/json');
    echo json_encode(getTable($_GET['table']));
}

if(isset($_POST['add_data'])) {
    unset($_POST['add_data']);
    $object = (object) $_POST;
    unset($_POST);
    echo DataVaksin::createDataVaksin($object);
}

if(isset($_POST['update_data'])) {
    unset($_POST['update_data']);
    $object = (object) $_POST;
    unset($_POST);
    echo DataVaksin::updateDataVaksin($object);
}

if(isset($_GET['action'])) {
    if ($_GET['action'] == 'delete_data') {
        $response = DataVaksin::deleteDataVaksin($_GET['id']);
        echo json_encode($response);
    }
}

if(isset($_POST['login'])) {
    unset($_POST['login']);
    $object = (object) $_POST;
    unset($_POST);
    $response = Auth::login($object);
    http_response_code($response->status);
    header('Content-Type: application/json');
    echo json_encode($response);
}