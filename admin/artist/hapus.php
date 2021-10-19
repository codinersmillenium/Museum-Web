<?php
session_start();
    include '../../config/database.php';

    $id_artist=$_POST["id_artist"];

    $sql="delete from artist where id_artist=$id_artist";
    $hapus_artist=mysqli_query($kon,$sql);


?>