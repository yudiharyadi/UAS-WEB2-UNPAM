function getProvinceIdFromDistrict(district_id) {
    return String(district_id).slice(0, 2);
}

function getRegencyIdFromDistrict(district_id) {
    return String(district_id).slice(0, 4);
}