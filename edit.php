<?php
include "conf.php";

if (isLoggedin() == false) {
	logout();
	die();
}

if (!isset($_GET['id'])) {
	header('Location: index.php');
	die();
}

$url = $model_url."?table=data_vaksin&id=".$_GET['id'];
$json = file_get_contents($url);
$obj = json_decode($json);

if (isset($_POST['update_data'])) {
	$_POST['id'] = $_GET['id'];
	$curl = curl_init($model_url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($_POST));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
	if ($response) {
		header("Location: index.php");
		die();
	} else {
		echo '<script language="javascript">';
		echo 'alert("Edit data gagal")';
		echo '</script>';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Vaksinasi Covid</title>
</head>
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
<body onload="onLoad()">
<noscript>You need to enable JavaScript to run this app.</noscript>
	<div class="container col-md-6 mt-4">
		<center><h3>Form Edit Data Peserta</h3></center>
		<div class="card">
			<div class="card-header bg-success text-white">
				Edit Data Peserta
			</div>
			<div class="card-body">
				<form action="" method="post" role="form" id="addDataVaksinForm" name="addDataVaksinForm">
					<div class="form-group">
		              <label>Provinsi</label>
		                	<select name="province" id="province" class="form-control select2" style="width: 100%;" required onchange="getRegencies(this.value)">
			                  <option value="" selected>-- Pilih Provinsi --</option>
							  <?php foreach($provinces as $key => $val): ?>
			                  <option value="<?=$val->id;?>"><?=$val->name;?></option>
							  <?php endforeach; ?>
		                	</select>
		            </div>
					<div class="form-group">
		              <label>Kabupaten/Kota</label>
		                	<select name="regency" id="regency" class="form-control select2" style="width: 100%;" required onchange="getDistricts(this.value)">
			                  <option value="" selected>-- Pilih Kab/Kota --</option>
		                	</select>
		            </div>
					<div class="form-group">
		              <label>Kecamatan</label>
		                	<select name="district" id="district" class="form-control select2" style="width: 100%;" required>
			                  <option value="" selected>-- Pilih Kecamatan --</option>
		                	</select>
		            </div>
		            <div class="form-group">
		              <label>Jenis Faskes</label>
		                	<select name="faskes_type" id="faskes_type" class="form-control select2" style="width: 100%;" required>
			                  <option value="" selected="selected">-- Pilih Jenis Faskes --</option>
		                	</select>
		            </div>
		            <div class="form-group">
		              <label>Nama Faskes</label>
					  <input class="form-control" type="text" name="faskes_name" id="faskes_name" value="<?=$obj->faskes_name;?>" placeholder="Masukan Nama Fakses" required>

		            </div>
					<div class="form-group">
						<label>NIK</label>
						<input class="form-control" type="text" name="identity_number" id="identity_number" value="<?=$obj->identity_number;?>" placeholder="Masukan NIK" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
					</div>
					<div class="form-group">
						<label>Nama</label>
						<input class="form-control" type="text" name="name" id="name" value="<?=$obj->name;?>" placeholder="Masukan Nama" required>
					</div>
					<div class="form-group">
						<label>Jenis Kelamin</label><br>
						<input type="radio" name="gender" id="gender" value="l" required> Laki-laki
						<input type="radio" name="gender" id="gender" value="p"> Perempuan
					</div>
					<div class="form-group">
						<label>Umur</label>
						<input class="form-control" type="number" name="age" id="age" value="<?=$obj->age;?>" placeholder="Masukan Umur" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
					</div>
					<div class="form-group">
						<label>Tanggal Lahir</label>
						<input class="form-control" type="date" name="birthday" id="birthday" value="<?=$obj->birthday;?>" placeholder="Masukan Tanggal Lahir" required>
					</div>
					<div class="form-group">
						<label>No Hp</label>
						<input class="form-control" type="tel" name="phone_number" id="phone_number" value="<?=$obj->phone_number;?>" placeholder="Masukan No Hp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
					</div>
					<div class="form-group">
						<label>Alamat</label>
						<textarea class="form-control" type="text" name="addr" id="addr" placeholder="Masukan Alamat" required=""><?=$obj->addr;?></textarea>
					</div>
					<button type="submit" class="btn btn-primary" name="update_data" value="simpan">Simpan data</button>
					<button type="cancel" class="btn btn-cancel" name="cancel_update" value="cancel" onclick="cancelEdit()">Batal</button>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="assets/js/scripts.js"></script>
	<script>
		const thisForm = document.forms.namedItem('addDataVaksinForm');
		const provincesSelectOpt = document.querySelector('#province');
		const regenciesSelectOpt = document.querySelector('#regency');
		const districtsSelectOpt = document.querySelector('#district');
		const faskesTypesSelectOpt = document.querySelector('#faskes_type')
		const urlProvince = "<?=$model_url;?>?table=provinces";
		const urlRegency = "<?=$model_url;?>?table=regencies&province_id=";
		const urlDistrict = "<?=$model_url;?>?table=districts&regency_id=";
		const urlFaskesType = "<?=$model_url;?>?table=faskes_types";

		const districtValue = <?=$obj->district;?>;
		const provinceValue = getProvinceIdFromDistrict(districtValue);
		const regencyValue = getRegencyIdFromDistrict(districtValue)

		function onLoad() {
			getProvinces(provinceValue);
			getFaskesTypes(<?=$obj->faskes_type;?>);
			getRegencies(provinceValue, regencyValue);
			getDistricts(regencyValue, districtValue);

			document.querySelector('input[name="gender"][value="<?=$obj->gender;?>"]').checked = true;
		}

		function getProvinces(defaultValue) {
			let xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = () => {
				if (xmlhttp.readyState === 4) {
					generateOption(xmlhttp.response, provincesSelectOpt);
					if (defaultValue) {
						provincesSelectOpt.value = defaultValue;
					}
				}
			}
			xmlhttp.open("GET", urlProvince);
			xmlhttp.send();
		}

		function getRegencies(province_id, defaultValue) {
			removeOption(regenciesSelectOpt);
			removeOption(districtsSelectOpt);
			if (province_id) {
				let xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = () => {
					if (xmlhttp.readyState === 4) {
						console.log(JSON.parse(xmlhttp.response));
						generateOption(xmlhttp.response, regenciesSelectOpt);
						if (defaultValue) {
							regenciesSelectOpt.value = defaultValue;
						}
					}
				}
				xmlhttp.open("GET", urlRegency + province_id);
				xmlhttp.send();
			}
		}

		function getDistricts(regency_id, defaultValue) {
			removeOption(districtsSelectOpt);
			if (regency_id) {
				let xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = () => {
					if (xmlhttp.readyState === 4) {
						console.log(JSON.parse(xmlhttp.response));
						generateOption(xmlhttp.response, districtsSelectOpt);
						if (defaultValue) {
							districtsSelectOpt.value = defaultValue;
						}
					}
				}
				xmlhttp.open("GET", urlDistrict + regency_id);
				xmlhttp.send();

			}
		}

		function getFaskesTypes(defaultValue) {
			let xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = () => {
				if (xmlhttp.readyState === 4) {
					generateOption(xmlhttp.response, faskesTypesSelectOpt);
					if (defaultValue) {
						faskesTypesSelectOpt.value = defaultValue;
					}
				}
			}
			xmlhttp.open("GET", urlFaskesType);
			xmlhttp.send();

			faskesTypesSelectOpt.value = <?=$obj->faskes_type;?>;
		}

		function generateOption(response, selectOpt) {
			const arr = JSON.parse(response);
			console.log(arr);
			arr.forEach ((obj) => {
				selectOpt.add(new Option(obj.name, obj.id), undefined);
			})
		}

		function removeOption(selectOpt) {
			while (selectOpt.options.length > 1) {
				selectOpt.remove(1);
			}
		}

		function cancelEdit() {
			window.location.replace("index.php");
		}

	</script>
	<script type="text/javascript" src="assets/js/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>