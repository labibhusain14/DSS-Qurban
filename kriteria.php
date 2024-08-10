<?php

include('config/db.php');
include('classes/DB.php');
include('classes/kriteria.php');
include('classes/Template.php');

$kriteria = new Kriteria($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); // Membuat objek kriteria
$kriteria->open(); // Membuka koneksi ke database untuk objek kriteria
$kriteria->getKriteria(); // Mendapatkan data kriteria dari database

if (isset($_POST['btn-search'])) { // Mengecek apakah tombol pencarian diklik
    $kriteria->searchKriteria($_POST['search']); // Mencari kriteria berdasarkan kata kunci yang diberikan
} else {
    $kriteria->getKriteria(); // Mendapatkan data kriteria jika tidak ada pencarian
}

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($kriteria->addKriteria($_POST) > 0) { // Menambahkan data kriteria baru menggunakan metode addkriteria()
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'kriteria.php';
            </script>"; // Menampilkan pesan sukses dan mengarahkan ke halaman kriteria
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'kriteria.php';
            </script>"; // Menampilkan pesan gagal dan mengarahkan ke halaman kriteria
        }
    }

    $btn = 'Tambah'; // Label tombol 'Tambah'
    $title = 'Tambah'; // Judul halaman 'Tambah'
}

$view = new Template('templates/skintabel_kriteria.html'); // Membuat objek Template
$mainTitle = 'kriteria'; // Judul utama halaman 'kriteria'
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Kode kriteria</th>
<th scope="row">Nama kriteria</th>
<th scope="row">Bobot</th>
<th scope="row">Status</th>
<th scope="row">Aksi</th>
</tr>'; // Header tabel kriteria
$data = null;
$no = 1;
$formLabel = 'kriteria'; // Label formulir 'kriteria'

while ($div = $kriteria->getResult()) { // Mengambil data kriteria satu per satu
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['kriteria_kode'] . '</td>
    <td>' . $div['kriteria_nama'] . '</td>
    <td>' . $div['bobot'] . '</td>
    <td>' . $div['status'] . '</td>
    <td style="font-size: 22px;">
        <a href="kriteria.php?id=' . $div['kriteria_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="kriteria.php?hapus=' . $div['kriteria_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
         <button type="" class="btn btn-info text-white" name="submit"
                                    id="submit">Kelola Opsi</button>
        </td>
    </tr>'; // Menambahkan baris data kriteria ke variabel $data
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($kriteria->updateKriteria($id, $_POST) > 0) { // Mengupdate data kriteria menggunakan metode updatekriteria()
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'kriteria.php';
            </script>"; // Menampilkan pesan sukses dan mengarahkan ke halaman kriteria
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'kriteria.php';
            </script>"; // Menampilkan pesan gagal dan mengarahkan ke halaman kriteria
            }
        }

        $kriteria->getKriteriaById($id); // Mendapatkan data kriteria berdasarkan id menggunakan metode getkriteriaById()
        $row = $kriteria->getResult();

        $btn = 'Update'; // Label tombol 'Update'
        $title = 'Ubah'; // Judul halaman 'Ubah'

        $view->replace('DATA_KODE', $row['kriteria_kode']); // Mengganti 'DATA_VAL_UPDATE' dengan data nama kriteria yang akan diubah
        $view->replace('DATA_NAMA', $row['kriteria_nama']); // Mengganti 'DATA_VAL_UPDATE' dengan data nama kriteria yang akan diubah
        $view->replace('DATA_BOBOT', $row['bobot']); // Mengganti 'DATA_VAL_UPDATE' dengan data nama kriteria yang akan diubah
        $view->replace('DATA_STATUS', $row['status']); // Mengganti 'DATA_VAL_UPDATE' dengan data nama kriteria yang akan diubah
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($kriteria->deleteKriteria($id) > 0) { // Menghapus data kriteria berdasarkan id menggunakan metode deletekriteria()
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'kriteria.php';
            </script>"; // Menampilkan pesan sukses dan mengarahkan ke halaman kriteria
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'kriteria.php';
            </script>"; // Menampilkan pesan gagal dan mengarahkan ke halaman kriteria
        }
    }
}

$kriteria->close(); // Menutup koneksi ke database untuk objek kriteria

$view->replace('DATA_MAIN_TITLE', $mainTitle); // Mengganti 'DATA_MAIN_TITLE' dengan judul utama halaman
$view->replace('DATA_TABEL_HEADER', $header); // Mengganti 'DATA_TABEL_HEADER' dengan header tabel kriteria
$view->replace('DATA_TITLE', $title); // Mengganti 'DATA_TITLE' dengan judul halaman
$view->replace('JUDUL', $mainTitle); // Mengganti 'NAMA' dengan judul utama halaman
$view->replace('SEARCH_TABLE', 'Kriteria.php'); // Mengganti 'SEARCH_TABLE' dengan URL halaman kriteria
$view->replace('DATA_BUTTON', $btn); // Mengganti 'DATA_BUTTON' dengan label tombol
$view->replace('DATA_FORM_LABEL', $formLabel); // Mengganti 'DATA_FORM_LABEL' dengan label formulir
$view->replace('DATA_TABEL', $data); // Mengganti 'DATA_TABEL' dengan data kriteria
$view->write(); // Menulis output template ke layar
