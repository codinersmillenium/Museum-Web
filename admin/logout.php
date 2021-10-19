<?php
    session_start();
    $id_admin=$_SESSION['id_admin'];
    $_SESSION['id_admin']='';
    $_SESSION['kode_admin']='';
    $_SESSION['nama_admin']='';
    $_SESSION['username']='';
    $_SESSION['level']='';

   

    unset($_SESSION['id_admin']);
    unset($_SESSION['kode_admin']);
    unset($_SESSION['nama_admin']);
    unset($_SESSION['username']);
    unset($_SESSION['level']);

    session_unset();
    session_destroy();

    header('Location:../index.php?halaman=login');

?>