<?php

class Kriteria extends DB
{
    //Fungsi untuk mendapatkan data kriteria
    function getKriteria()
    {
        $query = "SELECT * FROM kriteria";
        return $this->execute($query);
    }

    //Fungsi untuk Mendapatkan id dari kriteria
    function getKriteriaById($id)
    {
        $query = "SELECT * FROM kriteria WHERE kriteria_id=$id";
        return $this->execute($query);
    }

    //Fungsi untuk mencari kriteria berdasarkan kriteria_nama
    function searchKriteria($keyword)
    {
        $query = "SELECT * FROM kriteria WHERE kriteria_nama LIKE '%" . $keyword . "%'";
        return $this->execute($query);
    }

    //Fungsi untuk menambahkan kriteria
    function addKriteria($data)
    {
        $nama = $data['nama'];
        $kode = $data['kode'];
        $bobot = $data['bobot'];
        $status = $data['status'];
        $query = "INSERT INTO kriteria VALUES('',  '$kode','$nama', '$bobot', '$status')";
        return $this->executeAffected($query);
    }

    // Fungsi untuk ubah kriteria
    function updateKriteria($id, $data)
    {
        $nama = $data['nama'];
        $kode = $data['kode'];
        $bobot = $data['bobot'];
        $status = $data['status'];
        $query = "UPDATE kriteria SET kriteria_kode='$kode', kriteria_nama='$nama', bobot='$bobot', status ='$status' where kriteria_id=$id";
        return $this->executeAffected($query);
    }

    // fungsi untuk menghapus kriteria
    function deleteKriteria($id)
    {
        // Hapus baris terkait di tabel pemain
        $deletehewanQuery = "DELETE FROM hewan WHERE kriteria_id=$id";
        $this->executeAffected($deletehewanQuery);

        $deleteopsiQuery = "DELETE FROM opsi_kriteria WHERE kriteria_id=$id";
        $this->executeAffected($deleteopsiQuery);
        // Hapus baris di tabel kriteria
        $deletekriteriaQuery = "DELETE FROM kriteria WHERE kriteria_id=$id";
        return $this->executeAffected($deletekriteriaQuery);
    }
}
