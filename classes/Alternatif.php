<?php

class Alternatif extends DB
{
    //Fungsi untuk mendapatkan data alternatif
    function getAlternatif()
    {
        $query = "SELECT * FROM alternatif";
        return $this->execute($query);
    }

    //Fungsi untuk Mendapatkan id dari alternatif
    function getAlternatifById($id)
    {
        $query = "SELECT * FROM alternatif WHERE alternatif_id=$id";
        return $this->execute($query);
    }

    //Fungsi untuk mencari alternatif berdasarkan alternatif_nama
    function searchAlternatif($keyword)
    {
        $query = "SELECT * FROM alternatif WHERE alternatif_nama LIKE '%$keyword%'";
        return $this->execute($query);
    }

    //Fungsi Untuk Add alternatif
    function addAlternatif($data)
    {
        $nama = $data['nama'];
        $kode = $data['kode'];
        $query = "INSERT INTO alternatif VALUES('', '$kode','$nama')";
        return $this->executeAffected($query);
    }

    // Fungsi untuk ubah alternatif
    function updateAlternatif($id, $data)
    {
        $kode = $data['kode'];
        $nama = $data['nama'];
        $query = "UPDATE alternatif SET alternatif_kode='$kode', alternatif_nama='$nama' where alternatif_id=$id";
        return $this->executeAffected($query);
    }

    // fungsi untuk menghapus alternatif
    function deleteAlternatif($id)
    {
        // Hapus baris terkait di tabel hewan
        $deletePemainQuery = "DELETE FROM hewan WHERE alternatif_id=$id";
        $this->executeAffected($deletePemainQuery);

        $query = "DELETE from alternatif where alternatif_id=$id";
        return $this->executeAffected($query);
    }
}
