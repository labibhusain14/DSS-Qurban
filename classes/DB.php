<?php

class DB
{
    private $hostname; // Variabel untuk menyimpan nama host database
    private $username; // Variabel untuk menyimpan username database
    private $password; // Variabel untuk menyimpan password database
    private $dbname;   // Variabel untuk menyimpan nama database
    private $conn;     // Variabel untuk menyimpan koneksi ke database
    private $result;   // Variabel untuk menyimpan hasil query

    function __construct($hostname, $username, $password, $dbname)
    {
        $this->hostname = $hostname;     // Menginisialisasi variabel hostname dengan nilai dari parameter konstruktor
        $this->username = $username;     // Menginisialisasi variabel username dengan nilai dari parameter konstruktor
        $this->password = $password;     // Menginisialisasi variabel password dengan nilai dari parameter konstruktor
        $this->dbname = $dbname;         // Menginisialisasi variabel dbname dengan nilai dari parameter konstruktor
    }

    function open()
    {
        $this->conn = mysqli_connect($this->hostname, $this->username, $this->password, $this->dbname);
        // Membuka koneksi ke database menggunakan nilai-nilai yang disimpan dalam variabel hostname, username, password, dan dbname
    }

    function execute($query)
    {
        $this->result = mysqli_query($this->conn, $query);
        // Mengeksekusi query database dan menyimpan hasilnya dalam variabel result
    }

    function getResult()
    {
        return mysqli_fetch_array($this->result);
        // Mengembalikan hasil query sebagai array menggunakan fungsi mysqli_fetch_array()
    }

    function executeAffected($query = "")
    {
        mysqli_query($this->conn, $query);
        // Mengeksekusi query database tanpa menyimpan hasilnya
        return mysqli_affected_rows($this->conn);
        // Mengembalikan jumlah baris yang terpengaruh oleh operasi query terakhir
    }

    function close()
    {
        mysqli_close($this->conn);
        // Menutup koneksi ke database
    }
}
