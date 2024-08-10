<?php
class Opsi extends DB
{
    // Fungsi untuk mendapatkan data opsi
    function getOpsi()
    {
        $query = "SELECT * FROM opsi_kriteria";
        return $this->execute($query);
    }

    // Fungsi untuk Mendapatkan opsi berdasarkan ID
    function getOpsiById($id)
    {
        $query = "SELECT * FROM opsi_kriteria WHERE opsi_id=$id";
        return $this->execute($query);
    }

    // Fungsi untuk mencari opsi berdasarkan nama
    function searchOpsi($keyword)
    {
        $query = "SELECT * FROM opsi_kriteria WHERE opsi_nama LIKE '%" . $keyword . "%'";
        return $this->execute($query);
    }

    // Fungsi untuk mendapatkan opsi berdasarkan ID kriteria
    function getOpsiByKriteriaId($kriteriaId)
    {
        $query = "SELECT * FROM opsi_kriteria WHERE kriteria_id=$kriteriaId";
        return $this->execute($query);
    }

    // Fungsi untuk menambahkan opsi
    function addOpsi($data)
    {
        $kode = $data['kode'];
        $nama = $data['nama'];
        $nilai = $data['nilai'];
        $kriteria = $data['kriteria'];
        $query = "INSERT INTO opsi_kriteria (opsi_kode, opsi_nama, nilai, kriteria_id) VALUES ('$kode', '$nama', $nilai, $kriteria)";
        return $this->executeAffected($query);
    }

    // Fungsi untuk mengubah opsi
    function updateOpsi($id, $data)
    {
        $kode = $data['kode'];
        $nama = $data['nama'];
        $nilai = $data['nilai'];
        $kriteria = $data['kriteria'];
        $query = "UPDATE opsi_kriteria SET opsi_kode='$kode', opsi_nama='$nama', nilai=$nilai, kriteria_id=$kriteria WHERE opsi_id=$id";
        return $this->executeAffected($query);
    }

    // Fungsi untuk menghapus opsi
    function deleteOpsi($id)
    {
        // Hapus baris terkait di tabel hewan
        $deleteHewanQuery = "DELETE FROM hewan WHERE opsi_id=$id";
        $this->executeAffected($deleteHewanQuery);

        // Hapus baris di tabel opsi
        $deleteOpsiQuery = "DELETE FROM opsi_kriteria WHERE opsi_id=$id";
        return $this->executeAffected($deleteOpsiQuery);
    }
}
