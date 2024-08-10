<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Kriteria.php');
include('classes/Alternatif.php');
include('classes/Hewan.php');
include('classes/Template.php');

$hewan = new Hewan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); // Membuat objek hewan
$kriteria = new Kriteria($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); // Membuat objek Kriteria
$alternatif = new Alternatif($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); // Membuat objek Alternatif

$hewan->open(); // Membuka koneksi ke database untuk objek hewan
$kriteria->open(); // Membuka koneksi ke database untuk objek Kriteria
$alternatif->open(); // Membuka koneksi ke database untuk objek Alternatif

if (isset($_POST['btn-add'])) { // Mengecek apakah tombol "btn-add" diklik
    $id = $_GET['id']; // Mendapatkan nilai 'id' dari parameter GET
    $hewan->getHewanById($id); // Mendapatkan data hewan berdasarkan 'id'
    $row = $hewan->getResult(); // Mengambil hasil data hewan

    if ($hewan->updateData($id, $_POST, $_FILES) > 0) { // Memperbarui data hewan dengan menggunakan metode updateData()
        echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
            </script>"; // Menampilkan pesan sukses dan mengarahkan ke halaman index
    } else {
        echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'index.php';
            </script>"; // Menampilkan pesan gagal dan mengarahkan ke halaman index
    }
}

if (isset($_GET['id'])) { // Mengecek apakah parameter GET 'id' tersedia
    $id = $_GET['id']; // Mendapatkan nilai 'id' dari parameter GET

    if ($id > 0) {
        $hewan->getHewanById($id); // Mendapatkan data hewan berdasarkan 'id'
        $row = $hewan->getResult(); // Mengambil hasil data hewan

        $kriteria->getKriteria(); // Mendapatkan data kriteria
        $alternatif->getAlternatif(); // Mendapatkan data alternatif

        $kriterias = [];
        while ($kri = $kriteria->getResult()) {
            $kriterias[] = $kri;
        } // Mengambil semua data kriteria

        $alternatifs = [];
        while ($alt = $alternatif->getResult()) {
            $alternatifs[] = $alt;
        } // Mengambil semua data alternatif

        $list_kriteria = '';
        foreach ($kriterias as $kri) {
            $selected = ($kri['kriteria_id'] == $row['kriteria_id']) ? 'selected' : '';
            $list_kriteria .= "<option value=\"{$kri['kriteria_id']}\" $selected>{$kri['kriteria_kode']}</option>";
        } // Membuat daftar pilihan kriteria dengan opsi yang dipilih berdasarkan data hewan

        $list_alternatif = '';
        foreach ($alternatifs as $alt) {
            $selected = ($alt['alternatif_id'] == $row['alternatif_id']) ? 'selected' : '';
            $list_alternatif .= "<option value=\"{$alt['alternatif_id']}\" $selected>{$alt['alternatif_kode']}</option>";
        } // Membuat daftar pilihan alternatif dengan opsi yang dipilih berdasarkan data hewan

        $title = 'Update'; // Judul halaman
        $btn = 'Simpan'; // Teks tombol

        $kriteria->close(); // Menutup koneksi ke database untuk objek Kriteria
        $alternatif->close(); // Menutup koneksi ke database untuk objek Alternatif

        $add = new Template('templates/skin_form_add.html'); // Membuat objek Template
        $add->replace('DATA_TITLE', $title); // Mengganti 'DATA_TITLE' dengan judul halaman
        $add->replace('BUTTON', $btn); // Mengganti 'BUTTON' dengan teks tombol
        $add->replace('DATA_KRITERIA', $list_kriteria); // Mengganti 'DATA_KRITERIA' dengan daftar kriteria
        $add->replace('DATA_ALTERNATIF', $list_alternatif); // Mengganti 'DATA_ALTERNATIF' dengan daftar alternatif
        $add->replace('DATA_FOTO', $row['hewan_foto']); // Mengganti 'DATA_FOTO' dengan foto hewan
        $add->replace('DATA_ALTERNATIF', $row['alternatif_id']); // Mengganti 'DATA_ALTERNATIF' dengan alternatif hewan        $add->replace('DATA_KRITERIA', $row['kriteria_id']); // Mengganti 'DATA_KRITERIA' dengan kriteria hewan
        $add->write(); // Menulis output template ke layar
        $hewan->close(); // Menutup koneksi ke database untuk objek hewan
    }
}
