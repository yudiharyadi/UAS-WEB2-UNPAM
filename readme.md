# Aplikasi Pendataan Vaksin

Tugas Akhir (UAS) Mata Kuliah Pemrograman Web 2 - Kelompok 6

## Composer

Project ini menggunkan Composer untuk beberapa modul terutama package `phpdotenv`.

Anda bisa menggunakan Composer secara global dengan menginstall dari https://getcomposer.org/download/ 

Atau anda bisa menggunakan `composer.phar` yang sudah kami sertakan pada project ini

### Instalasi Package Composer
Pastikan anda terkoneksi ke Internet lalu jalankan `composer install` atau `php composer.phar install` pada konsol/terminal anda.

## Configuration
### Database
Projek ini menggunakan MySQL sebagai database enginenya. 

Buatlah database pada MySQL lalu import file `.sql` yang berada di `./source/db_kopid.sql`.

### Setting Environment
Ubah nama file `.env.example` menjadi `.env`. File `.env` berisi konfigurasi database yang akan dihubungkan.

```
server=mysql
host=localhost
username=your_mysql_username
password=your_mysql_password
database=your_mysql_database
```
> ganti value `your_mysql_username` dan `your_mysql_password` dengan username dan password mysql anda, default username mysql adalah `root` dan passwordnya biarkan kosong.

> ganti value `your_mysql_database` dengan nama database anda yang akan digunakan.

## Project Structure
Berikut struktur direktori projek ini.
```
/
|-- assets/
    |-- css/
    |-- js/
|-- database/
    |-- mysql.php
|-- model/
    |-- auth.php
    |-- classes.php
    |-- data_vaksin.php
    |-- provinces.php
    |-- regencies.php
    |-- districts.php
    |-- faskes_type.php
    |-- index.php
|-- source/
    |-- db_kopid.sql
|-- index.php
|-- tambah.php
|-- edit.php
|-- login.php
|-- conf.php
|-- .env
|-- .env.example
|-- composer.phar
|-- composer.json
|-- readme.md

```

## Definisi Class
### MySqlDb `./database/mysql.php`
Class ini digunkan untuk mengkoneksikan projek ke database MySQL. Di dalam class ini sudah terdapat beberapa static method yang nantinya agar memudahkan proses crud kedepannya.

### Provinces `./model/provinces.php`
Class ini digunakan untuk mengolah operasi data yang berhubungan dengan provinsi di Indonesia. Terdapat 2 method pada class ini yaitu :
- `getAllProvicies` untuk mengambil semua data provinsi di Indonesia.
- `getProvince` untuk mengambil 1 data provinsi berdasarkan id Provinsi.

### Regencies `./model/regencies.php`
Class ini digunakan untuk mengolah operasi data yang berhubungan dengan Kota/Kabupaten di Indonesia. Terdapat 2 method pada class ini yaitu : 
- `getAllRegencies` untuk mengambil semua data Kota/Kabupaten berdasarkan Provinsi.
- `getRegency` untuk mengambil 1 data Kota/Kabupaten berdasarkan id Kota/Kabupaten.

### Districts `./model/districts.php`
Class ini digunakan untuk mengolah operasi data yang berhubungan dengan Kota/Kabupaten di Indonesia. Terdapat 2 method pada class ini yaitu:
- `getAllDistricts` untuk mengambil semua data Kecamatan berdasarkan Kota/Kabupaten.
- `getDistrict` untuk mengambil 1 data Kecamatan berdasarkan id Kecamatan.

### FaskesType `./model/faskes_types.php`
Class ini digunakan untuk mengolah operasi data yang berhubungan dengan Tipe Fakses. Terdapat 2 method pada class ini yaitu:
- `getAllFaskesTypes` untuk mengambil semua data Tipe Faskes yang tersedia.
- `getFaskesType` untuk mengambil data Tipe Faskes berdasarkan id Tipe Faskes.

### Auth `./model/auth.php`
Class ini digunakan untuk mengolah operasi autentikasi user. Untuk saat ini hanya ada 1 method yang terdapat pada class ini yaitu:
- `login` untuk mengecek username dan password user apakah cocok dengan yang ada di database.

## Definisi Method/Function
### getTable `(./model/index.php)`
Function ini digunakan untuk mengecek table apa yang direquest oleh frontend untuk ditampilkan, lalu function ini akan memanggil salah satu method dari class yang sudah didefinisikan.

### getProvinceIdFromDistrict `(./assets/js/scripts.js)`
Function ini digunakan untuk mengekstrak id Provinsi yang ada di id Kecamatan.

### getRegencyIdFromDistrict `(./assets/js/scripts.js)`
Function ini digunakan untuk mengekstrak id Kota/Kabupaten yang ada di id Kecamatan.

### generateGender `(./index.php)`
Function ini digunakan untuk generate Jenis Kelamin dari data yang disimpan dalam Database. Bentuk data yang disimpan adalah `char(1)` .

### isLoggedin `(./conf.php)`
Function ini digunakan untuk mengecek apakah user sedang dalam keadaan session login atau tidak.

### logout `(./conf.php)`
Function ini digunakan untuk menghapus session user sehingga user akan logout.

## File Definition
### `composer.phar`
File ini adalah composer yang dikompresi dalam bentuk `.phar`

### `composer.json`
File ini adalah file inti dari composer. Berisi informasi dasar tentang projek direktori dan package apa saja yang digunakan pada projek ini.

### `composer.lock`
File ini berisi informasi tentang kondisi / state Composer pada projek ini. Berisi informasi package apa saja yang sudah terinstall dan versi berapa yang digunakan.

### `.env`
File ini berisi konfigurasi database aplikasi. File ini adalah file sensitif karena berisi kredensial penting database.

### `.env.example`
File ini berisi contoh konfigurasi database aplikasi. File `.env` tidak ada pada repositori (terdaftar di `.gitignore`) karena bersifat kredensial penting.

### `conf.php`
File ini berisi file konfigurasi url project ini dan beberapa function yang akan umum digunakan pada projek ini.

### `index.php`
File ini adalah halaman awal aplikasi yang berisi data-data vaksin. Bahasa program yang digunakan pada file ini ada 2, yaitu `PHP` dan `Javascript`.

### `tambah.php`
File ini adalah halaman tambah data vaksinasi. Bahasa program yang digunakan pada file ini ada 2, yaitu `PHP` dan `Javascript`.

### `edit.php`
File ini adalah halaman edit data vaksinasi. Bahasa program yang digunakan pada file ini ada 2, yaitu `PHP` dan `Javascript`.

### `login.php`
File ini adalah halaman login user. Umumnya jika user belum login maka user akan dialihkan ke halaman ini secara otomatis.

### `model/index.php`
File index pada direktori ini digunakan untuk menerima request untuk pengolahan data atau proses lainnya yang berhubungan langsung dengan database.

### `model/classes.php`
File ini berisi semua class yang digunakan untuk pengolahan data agar tidak terduplikasi saat pemanggilan.

### `source/db_kopid.sql`
File ini adalah file `.sql` yang berisi database dan tablenya.

## Tools yang digunakan
Berikut adalah tools yang digunakan selama proses pembuatan projek ini
- `Composer` sebagai package manager
- Package `phpdotenv` untuk membantu menggunakan file `.env`
- PHP Versi 8.0.3 & 7.4.21
- MySQL & MariaDB

## Contributor
Thank you to those who have contributed to this final project.
- [@teukuraja](https://github.com/teukuraja) as backend developer and javascript developer
- [@winnimaeylani](https://githib.com/winnimaeylani) as frontend developer
- and the other for encouragement and prayer support


## Anggota Kelompok 6 & Contributors
| NIM | Nama |
|---| --- |
| 181011401508 | TEUKU RAJA MUHAMMAD ZAKI |
| 181011401293	|	WINNI MAEYLANI |
| 181011402479	|	RAMA MAULANA |
|181011402401	|	VYKA SEPTIANI |
| 181011401068	|	SITI AISAH|
| 181011402378 | WILLY PUTRA LESMANA |
