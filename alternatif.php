<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Alternatif.php'); // Menggunakan kelas Alternatif
include('classes/Template.php');

$alternatif = new Alternatif($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); // Membuat objek Alternatif
$alternatif->open(); // Membuka koneksi ke database untuk objek Alternatif
$alternatif->getAlternatif(); // Mendapatkan data alternatif dari database

if (isset($_POST['btn-search'])) { // Mengecek apakah tombol pencarian diklik
    $alternatif->searchAlternatif($_POST['search']); // Mencari alternatif berdasarkan kata kunci yang diberikan
} else {
    $alternatif->getAlternatif(); // Mendapatkan data alternatif jika tidak ada pencarian
}

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($alternatif->addAlternatif($_POST) > 0) { // Menambahkan data alternatif baru menggunakan metode addAlternatif()
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'alternatif.php';
            </script>"; // Menampilkan pesan sukses dan mengarahkan ke halaman alternatif
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'alternatif.php';
            </script>"; // Menampilkan pesan gagal dan mengarahkan ke halaman alternatif
        }
    }

    $btn = 'Tambah'; // Label tombol 'Tambah'
    $title = 'Tambah'; // Judul halaman 'Tambah'
}

$view = new Template('templates/skintabel.html'); // Membuat objek Template
$mainTitle = 'Alternatif'; // Judul utama halaman 'Alternatif'
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Kode Alternatif</th>
<th scope="row">Nama Alternatif</th>
<th scope="row">Aksi</th>
</tr>'; // Header tabel alternatif
$data = null;
$no = 1;
$formLabel = 'Alternatif'; // Label formulir 'Alternatif'

while ($div = $alternatif->getResult()) { // Mengambil data alternatif satu per satu
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['alternatif_kode'] . '</td>
    <td>' . $div['alternatif_nama'] . '</td>
    <td style="font-size: 22px;">
        <a href="alternatif.php?id=' . $div['alternatif_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="alternatif.php?hapus=' . $div['alternatif_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>'; // Menambahkan baris data alternatif ke variabel $data
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id >= 0) {
        if (isset($_POST['submit'])) {
            if ($alternatif->updateAlternatif($id, $_POST) > 0) { // Mengubah data alternatif berdasarkan id menggunakan metode updateAlternatif()
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'alternatif.php';
            </script>"; // Menampilkan pesan sukses dan mengarahkan ke halaman alternatif
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'alternatif.php';
            </script>"; // Menampilkan pesan gagal dan mengarahkan ke halaman alternatif
            }
        }

        $alternatif->getAlternatifById($id); // Mendapatkan data alternatif berdasarkan id menggunakan metode getAlternatifById()
        $row = $alternatif->getResult();


        $btn = 'Update'; // Label tombol 'Update'
        $title = 'Ubah'; // Judul halaman 'Ubah'

        $view->replace('DATA_KODE', $row['alternatif_kode']); // Mengganti 'DATA_VAL_UPDATE' dengan data nama alternatif yang akan diubah
        $view->replace('DATA_NAMA', $row['alternatif_nama']); // Mengganti 'DATA_VAL_UPDATE' dengan data nama alternatif yang akan diubah
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id >= 0) {
        if ($alternatif->deleteAlternatif($id) > 0) { // Menghapus data alternatif berdasarkan id menggunakan metode deleteAlternatif()
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'alternatif.php';
            </script>"; // Menampilkan pesan sukses dan mengarahkan ke halaman alternatif
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'alternatif.php';
            </script>";
            // Menampilkan pesan gagal dan mengarahkan ke halaman alternatif
        }
    }
}

$alternatif->close(); // Menutup koneksi ke database untuk objek Alternatif

$view->replace('DATA_MAIN_TITLE', $mainTitle); // Mengganti 'DATA_MAIN_TITLE' dengan judul utama halaman
$view->replace('DATA_TABEL_HEADER', $header); // Mengganti 'DATA_TABEL_HEADER' dengan header tabel alternatif
$view->replace('DATA_TITLE', $title); // Mengganti 'DATA_TITLE' dengan judul halaman
$view->replace('JUDUL', $mainTitle); // Mengganti 'NAMA' dengan judul utama halaman
$view->replace('DATA_BUTTON', $btn); // Mengganti 'DATA_BUTTON' dengan label tombol
$view->replace('DATA_FORM_LABEL', $formLabel); // Mengganti 'DATA_FORM_LABEL' dengan label formulir
$view->replace('DATA_TABEL', $data); // Mengganti 'DATA_TABEL' dengan data alternatif
$view->write(); // Menulis output template ke layar
