<?php
    include '../../config/database.php';
    $nama_website=$_POST["nama_website"];
    $about=$_POST["about_web"];
    $sql="update profil set nama_website='$nama_website',about_web='$about'"; 
    mysqli_query($kon,$sql);
    header("Location:../index.php?halaman=profil&tambah=berhasil");
?>