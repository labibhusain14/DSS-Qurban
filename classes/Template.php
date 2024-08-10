<?php

class Template
{
    var $filename = ''; // Variabel untuk menyimpan nama berkas template
    var $content = ''; // Variabel untuk menyimpan isi konten template

    function __construct($filename = '')
    {
        $this->filename = $filename; // Menginisialisasi variabel filename dengan nilai yang diberikan sebagai parameter

        $this->content = implode('', @file($filename)); // Membaca isi konten berkas template dan menyimpannya dalam variabel content
    }

    function clear()
    {
        $this->content = preg_replace("/DATA_[A-Z|_|0-9]+/", "", $this->content);
        // Menghapus semua data yang memiliki format DATA_XXX dari isi konten template menggunakan fungsi preg_replace()
    }

    function write()
    {
        $this->clear();
        print $this->content;
        // Menghapus data yang memiliki format DATA_XXX dari isi konten template dan mencetak konten yang telah diubah
    }

    function getContent()
    {
        $this->clear();
        return $this->content;
        // Mengembalikan isi konten template setelah menghapus data yang memiliki format DATA_XXX
    }

    function replace($old = '', $new = '')
    {
        if (is_int($new)) {
            $value = sprintf("%d", $new); // Mengubah nilai baru menjadi format integer menggunakan fungsi sprintf()
        } elseif (is_float($new)) {
            $value = sprintf("%f", $new); // Mengubah nilai baru menjadi format float menggunakan fungsi sprintf()
        } elseif (is_array($new)) {
            $value = '';

            foreach ($new as $item) {
                $value .= $item . ' '; // Menggabungkan setiap elemen array menjadi sebuah string yang dipisahkan oleh spasi
            }
        } else {
            $value = $new;
        }
        $this->content = preg_replace("/$old/", $value, $this->content);
        // Menggantikan semua kemunculan string $old dalam isi konten template dengan string $value menggunakan fungsi preg_replace()
    }
}
