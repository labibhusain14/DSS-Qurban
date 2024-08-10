<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Kriteria.php');
include('classes/Alternatif.php');
include('classes/Hewan.php');
include('classes/Template.php');

// buat instance Hewan
$listHewan = new Hewan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listHewan->open();
// tampilkan data Hewan
$listHewan->getHewanJoin();

// cari Hewan
if (isset($_POST['btn-cari'])) {
    // methode mencari data Hewan
    $listHewan->searchHewan($_POST['cari']);
} else if (isset($_POST['btn-sort'])) {
    // methode mengurutkan data Hewan
    $listHewan->sortingHewan();
} else {
    // method menampilkan data Hewan
    $listHewan->getHewanJoin();
}
$data = null;

while ($row = $listHewan->getResult()) {
    $data .=     " <div class='col-md-3'>
        <a href='detail.php?id=" . $row['hewan_id'] . "'>
            <div class='card p-2 py-3 text-center'>
                <div class='img mb-2'> 
                    <img src='assets/images/" . $row['hewan_foto'] . "' width='110' height='110' class='rounded-circle' alt='" . $row['hewan_foto'] . "' style='object-fit: cover;'>
                </div>
                <h5 class='mb-0'><strong> " . $row['alternatif_kode'] . " </strong></h5> 
                <small>" . $row['alternatif_nama'] . "</small>
                <div class='mt-4 apointment'> <button class='btn btn-info btn-opacity-50 text-uppercase'>Detail</button> </div>
            </div>
        </a>
    </div> ";
}

// tutup koneksi
$listHewan->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_HEWAN', $data);
$home->write();
