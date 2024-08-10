<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Alternatif.php');
include('classes/Kriteria.php');
include('classes/Hewan.php');
include('classes/Template.php');

$hewan = new Hewan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$hewan->open();

$data = null;
$opsi = null;
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    if ($id > 0) {
        if ($hewan->deleteData($id) > 0) {
            echo "
                <script>
                    alert('Data berhasil dihapus!');
                    document.location.href = 'index.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Data gagal dihapus!');
                    document.location.href = 'index.php';
                </script>
            ";
        }
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($id > 0) {
        $hewan->getHewanById($id);
        $row = $hewan->getResult();

        $kode_alternatif = $row['alternatif_kode'];
        $hewan->getHewanByKodeAlternatif($kode_alternatif);

        $data = '<div class="card-header text-center">
            <h3 class="my-0">Detail ' . $row['alternatif_nama'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['hewan_foto'] . '" class="img-thumbnail" alt="' . $row['hewan_foto'] . '" width="60">
                    </div>
                </div>
                <div class="col-9">
                    <div class="card px-3">
                        <table border="0" class="text-start">
                            <tr>
                                <td>Kode Alternatif</td>
                                <td>:</td>
                                <td>' . $row['alternatif_kode'] . '</td>
                            </tr>
                            <tr>
                                <td>Hewan</td>
                                <td>:</td>
                                <td>' . $row['alternatif_nama'] . '</td>
                            </tr>
                            DATA_HEWAN
                        </table>
                    </div>
                </div>
            </div>
        </div>';

        $opsi .= '
                        <tr>
                            <th>Kriteria</th>
                        </tr>';

        while ($row = $hewan->getResult()) {
            $opsi .= '<tr>
                        <td>' . $row['kriteria_nama'] . '</td>
                                <td>:</td>
                        <td>' . $row['opsi_nama'] . '</td>
                      </tr>';
        }

        $data .= '</table></div>
        <div class="card-footer text-end">
            <a href="update.php?id=' . $id . '"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
            <a href="detail.php?hapus=' . $id . '"><button type="button" class="btn btn-danger">Hapus Data</button></a>
        </div>';
    }
}

$hewan->close();

$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_HEWAN', $data);
$detail->replace('DATA_HEWAN', $opsi);
$detail->write();
