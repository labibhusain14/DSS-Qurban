<?php
class Hewan extends DB
{
    function getHewanJoin()
    {
        $query = "SELECT hewan.*, alternatif.alternatif_kode, alternatif.alternatif_nama 
                  FROM hewan 
                  JOIN alternatif ON hewan.alternatif_id = alternatif.alternatif_id 
                  JOIN kriteria ON hewan.kriteria_id = kriteria.kriteria_id 
                  JOIN opsi_kriteria ON hewan.opsi_id = opsi_kriteria.opsi_id 
                  WHERE hewan.hewan_id IN (
                      SELECT MIN(hewan_id) 
                      FROM hewan 
                      GROUP BY alternatif_id
                  )
                  ORDER BY hewan.hewan_id";
        return $this->execute($query);
    }



    function getHewan()
    {
        // Mendapatkan semua data hewan dari tabel hewan.
        $query = "SELECT * FROM hewan";
        return $this->execute($query);
    }

    function getHewanById($id)
    {
        $query = "SELECT DISTINCT alternatif.alternatif_kode, hewan.*, alternatif.*, kriteria.*, opsi_kriteria.*
                  FROM hewan 
                  JOIN alternatif ON hewan.alternatif_id = alternatif.alternatif_id 
                  JOIN kriteria ON hewan.kriteria_id = kriteria.kriteria_id 
                  JOIN opsi_kriteria ON hewan.opsi_id = opsi_kriteria.opsi_id 
                  WHERE hewan_id=$id";
        return $this->execute($query);
    }
    function getHewanByKodeAlternatif($kode_alternatif)
    {
        $query = "SELECT alternatif.alternatif_kode, alternatif.alternatif_nama, hewan.*, kriteria.kriteria_nama, opsi_kriteria.opsi_nama
                  FROM hewan 
                  JOIN alternatif ON hewan.alternatif_id = alternatif.alternatif_id 
                  JOIN kriteria ON hewan.kriteria_id = kriteria.kriteria_id 
                  JOIN opsi_kriteria ON hewan.opsi_id = opsi_kriteria.opsi_id 
                  WHERE alternatif.alternatif_kode = '$kode_alternatif'";
        return $this->execute($query);
    }


    function searchHewan($keyword)
    {
        // Mencari data hewan berdasarkan kata kunci yang cocok dengan nama hewan. Data diurutkan berdasarkan hewan_id.
        // $query = "SELECT * FROM hewan WHERE hewan_nama LIKE '%$keyword%' ORDER BY hewan_id";
        $query = "SELECT * FROM hewan JOIN alternatif ON hewan.alternatif_id=alternatif.alternatif_id JOIN kriteria ON hewan.kriteria_id=kriteria.kriteria_id WHERE alternatif_nama LIKE '%$keyword%' OR kriteria_nama LIKE '%$keyword%' ORDER BY hewan.hewan_id;";
        return $this->execute($query);
    }

    function sortingHewan()
    {
        // Mendapatkan data hewan dan mengurutkannya berdasarkan hewan_nama secara ascending (A-Z).
        $query = "SELECT * FROM hewan ORDER BY hewan_nama ASC";
        return $this->execute($query);
    }

    function addData($data, $file)
    {
        $foto = $file['foto']['name'];
        $temp_foto = $file['foto']['tmp_name'];
        move_uploaded_file($temp_foto, 'assets/images/' . $foto);
        $alternatif = $data['alternatif']; // Memastikan key 'alternatif'
        $kriteria = $data['kriteria']; // Memastikan key 'kriteria'
        $opsi = $data['opsi']; // Memastikan key 'opsi'
        // Menambahkan data hewan baru ke dalam tabel hewan dengan menggunakan nilai-nilai yang diberikan sebagai parameter.
        $query = "INSERT INTO hewan (hewan_foto, hewan_nama, kriteria_id, alternatif_id, opsi_id) VALUES ('$foto', '$alternatif', '$kriteria', '$opsi')";
        return $this->executeAffected($query);
    }

    function updateData($id, $data, $file)
    {
        $foto = $file['foto']['name'];
        $temp_foto = $file['foto']['tmp_name'];
        move_uploaded_file($temp_foto, 'assets/images/' . $foto);
        $alternatif = $data['alternatif']; // Memastikan key 'alternatif'
        $kriteria = $data['kriteria']; // Memastikan key 'kriteria'
        $opsi = $data['opsi']; // Memastikan key 'opsi'
        // Memperbarui data hewan berdasarkan hewan_id dengan menggunakan nilai-nilai yang diberikan sebagai parameter.
        $query = "UPDATE hewan SET hewan_foto='$foto', alternatif_id='$alternatif',  kriteria_id='$kriteria', opsi_id='$opsi' WHERE hewan_id=$id";
        return $this->executeAffected($query);
    }

    function deleteData($id)
    {
        // Menghapus data hewan dari tabel hewan berdasarkan hewan_id yang diberikan sebagai parameter.
        $query = "DELETE FROM hewan WHERE hewan_id=$id";
        return $this->executeAffected($query);
    }
}
