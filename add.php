<?php

include('config/db.php'); // Memasukkan file db.php yang berisi konfigurasi database
include('classes/DB.php'); // Memasukkan file DB.php yang berisi definisi kelas DB
include('classes/Alternatif.php'); // Memasukkan file Alternatif.php yang berisi definisi kelas Alternatif
include('classes/Kriteria.php'); // Memasukkan file Kriteria.php yang berisi definisi kelas Kriteria
include('classes/Hewan.php'); // Memasukkan file Hewan.php yang berisi definisi kelas Hewan
include('classes/Template.php'); // Memasukkan file Template.php yang berisi definisi kelas Template
include('classes/Opsi.php'); // Memasukkan file Hewan.php yang berisi definisi kelas Hewan

// Inisialisasi objek kriteria
$kriteria = new Kriteria($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$kriteria->open(); // Buka koneksi database
$kriteria->getKriteria(); // Ambil data kriteria dari tabel kriteria

// Bangun opsi kriteria untuk formulir tambah
$list_kriteria = '';
while ($row = $kriteria->getResult()) {
    $list_kriteria .= '
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label mt-2">' . $row['kriteria_nama'] . '</label>
                <div class="input-group">
                    <select class="form-select" name="kriteria[]" required>
                        <option value="">Pilih Opsi</option>';

    // Ambil opsi kriteria
    $opsi_kriteria = new Opsi($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
    $opsi_kriteria->open();
    $opsi_kriteria->getOpsiByKriteriaId($row['kriteria_id']);
    while ($opsi_row = $opsi_kriteria->getResult()) {
        $list_kriteria .= '<option value="' . $opsi_row['opsi_id'] . '">' . $opsi_row['opsi_nama'] . '</option>';
    }
    $opsi_kriteria->close();
    $list_kriteria .= '
                    </select>
                </div>
            </div>
        </div>
    </div>';
}

$kriteria->close(); // Tutup koneksi database

// Inisialisasi objek alternatif
$alternatif = new Alternatif($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$alternatif->open(); // Buka koneksi database
$alternatif->getAlternatif(); // Ambil data alternatif dari tabel alternatif

// Bangun opsi alternatif untuk formulir tambah
$list_alternatif = '';
while ($row = $alternatif->getResult()) {
    $list_alternatif .= '<option value="' . $row['alternatif_id'] . '">' . $row['alternatif_kode'] . '</option>';
}
$alternatif->close(); // Tutup koneksi database

// Inisialisasi objek hewan
$hewan = new Hewan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$hewan->open(); // Buka koneksi database

// Memeriksa apakah formulir telah dikirimkan
if (isset($_POST['btn-add'])) {
    // Memanggil metode addData pada objek hewan
    if ($hewan->addData($_POST, $_FILES) > 0) {
        echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'index.php';
            </script>";
    } else {
        echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'index.php';
            </script>";
    }
}

$hewan->close(); // Tutup koneksi database

$title = 'Tambah'; // Judul halaman

// Membuat objek Template
$add = new Template('templates/skin_form_add.html');

// Mengganti placeholder dalam konten template dengan data yang sesuai
$add->replace('DATA_KRITERIA', $list_kriteria);
$add->replace('DATA_TITLE', $title);
$add->replace('BUTTON', $title);
$add->replace('DATA_ALTERNATIF', $list_alternatif);

// Menampilkan konten template setelah mengganti placeholder
$add->write();
