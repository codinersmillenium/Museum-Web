<?php
session_start();
    include '../../config/database.php';

    $id_koleksi=$_POST["id_koleksi"];
    $gambar=$_POST["gambar"];

    $sql="delete from koleksi where id_koleksi=$id_koleksi";
    $hapus_koleksi=mysqli_query($kon,$sql);

    //Menghapus gambar, gambar yang dihapus jika selain gambar default
    if ($gambar!='gambar_default.png'){
        unlink("gambar/".$gambar);
    }
 

?>