<?php 
include "conf.php";

if (isLoggedin() == false) {
	logout();
	die();
}

if (isset($_GET['logout'])) {
	logout();
	die();
}

$url = $model_url."?table=data_vaksin";
$json = file_get_contents($url);
$arr = json_decode($json);
$num = 1;

function generateGender($g) {
	if ($g == 'l') {
		return 'Laki-laki';
	} else if ($g == 'p') {
		return 'Perempuan';
	} else {
		return 'Tidak diketahui';
	}
}
?>
<html>
<head>
	<title>Vaksinasi Covid</title>
	<style>
    @media print {
        button.noPrint {
            display: none;
        }
        a.noPrint {
            display: none;
   		}
   		th.noPrint{
   			display: none;
   		}
	}
    </style>
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>
<body>
<noscript>You need to enable JavaScript to run this app.</noscript>
	<div class="container col-md-10 mt-2">
		<?php
		date_default_timezone_set('Asia/Jakarta');
		echo '<center><h3>Daftar Peserta Vaksinasi Covid19</h3>
			<h3>Per '.date('d F Y H:i:s').'</h3>
		</center>'
		?>
		<div class="card">
			<div class="card-header bg-success text-white ">
				Data Peserta
				<a href="#" class="noPrint btn btn-sm btn-success float-right" onclick="window.print()">Cetak</a>
				<a href="tambah.php" class="noPrint btn btn-sm btn-primary float-right">Tambah</a>
			</div>
			<div class="card-body">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Faskes</th>
							<th>Nama</th>
							<th>NIK</th>
							<th>Jenis Kelamin</th>
							<th>Umur</th>
							<th>No Hp</th>
							<th class="noPrint">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($arr)): ?>
						<?php foreach ($arr as $val): ?>
						<tr>
							<th><?=$num++;?></th>
							<th><?=$val->faskes_name;?></th>
							<th><?=$val->name;?></th>
							<th><?=$val->identity_number;?></th>
							<th><?=generateGender($val->gender);?></th>
							<th><?=$val->age;?></th>
							<th><?=$val->phone_number;?></th>
							<th class="noPrint">
								<a href="edit.php?id=<?=$val->id;?>" class="noPrint btn-warning btn">Ubah</a>
								<button class="noPrint btn-danger btn" onclick="deleteRow(<?=$num;?>, <?=$val->id;?>)">Hapus</button>
								<br>
							</th>
						</tr>
						<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
				<button type="button" class="noPrint btn btn-primary" onclick="onLogoutCLicked()">Logout</button>
			</div>
		</div>
	</div>
	<script type="text/javascript" language="javascript">
		const deleteUrl = '<?=$model_url;?>?action=delete_data&id=';
		const tableData = document.getElementById("dataTables-example");

		function onLogoutCLicked() {
			window.location.href = "index.php?logout=1";
		}

		function deleteRow(index, id) {
			let confirmUser = confirm("Apakah anda yakin ingin menghapus data ini?");
			if (confirmUser) {
				let xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = () => {
					console.log(xmlhttp);
					if (xmlhttp.readyState === 4) {
						const response = JSON.parse(xmlhttp.response);
						if (response.success) {
							tableData.deleteRow(index-1);
						}
					}
				}
				xmlhttp.open("GET", deleteUrl + id);
				xmlhttp.send();
			}
		}
	</script>
	<script src="assets/js/dataTables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/js/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>
