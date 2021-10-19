<?php
session_start();
    include '../../config/database.php';

    $id_admin=$_POST["id_admin"];
    $gambar=$_POST["gambar"];

    $sql="delete from admin where id_admin=$id_admin";
    $hapus_admin=mysqli_query($kon,$sql);


?>