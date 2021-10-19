<?php 
  session_start();
  if (!$_SESSION["id_admin"]){
        header('Location:../index.php?halaman=login&pesan=login_dulu');
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>National Gallery of Art | Halaman Admin </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <?php
        include '../config/database.php';
        $ambil_kategori = mysqli_query ($kon,"select * from profil limit 1");
        $row = mysqli_fetch_assoc($ambil_kategori); 
        $nama_website = $row['nama_website'];
        $copy_right = $row['nama_website'];
    ?>
    <a class="navbar-brand" href="../index.php"><?php echo $nama_website; ?> </a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav  ml-auto">
        <li class="text-light">Login Sebagai :  <?php echo $_SESSION["nama_admin"]; ?> </li>
        </ul>
    </div>
   
</nav>
<div class="jumbotron text-center">
<?php 
if(isset($_GET['halaman']) && !isset($_GET['kategori'])){
    $halaman = $_GET['halaman'];
   echo "<h1>".ucwords($halaman)."</h1>";
}

if(isset($_GET['halaman']) &&  isset($_GET['kategori'])){

    include '../config/database.php';
    $ambil_kategori = mysqli_query ($kon,"select * from kategori where id_kategori='".$_GET['kategori']."' limit 1");
    $row = mysqli_fetch_assoc($ambil_kategori); 
    $kategori = $row['nama_kategori'];
    $halaman = $_GET['halaman'];
   echo "<h1>".ucwords($halaman)." ".ucwords($kategori)."</h1>";
}
?>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-2">
            <div class="list-group">
                <a href="index.php?halaman=kategori" class="list-group-item list-group-item-action">Koleksi</a>
                <a href="index.php?halaman=artist" class="list-group-item list-group-item-action">Artist</a>
                <a href="index.php?halaman=admin" class="list-group-item list-group-item-action">Admin</a>
                <a href="index.php?halaman=komentar" class="list-group-item list-group-item-action">Komentar</a>
                <a href="index.php?halaman=profil" class="list-group-item list-group-item-action">Profil</a>
                <a href="logout.php" class="list-group-item list-group-item-action">Logout</a>
            </div>
        </div> 
        <div class="col-sm-10">
        <?php 
            if(isset($_GET['halaman'])){
                $halaman = $_GET['halaman'];
                switch ($halaman) {
                    case 'kategori':
                        include "koleksi/kategori.php";
                        break;
                    case 'koleksi':
                        include "koleksi/index.php";
                        break;
                    case 'artist':
                        include "artist/index.php";
                        break;
                    case 'admin':
                        include "admin/index.php";
                        break;
                    case 'komentar':
                        include "komentar/index.php";
                        break;
                    case 'profil':
                        include "profil/index.php";
                        break;
                    default:
                    echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
                    break;
                }
            }else {
                include "dashboard.php";
            }
        ?>
        </div>
    </div>
    <br>
</div>


<!-- Bagian Footer-->
<footer class="footer">
            <div class="container2">
                <div class="row1">
                    <div class="footer-col">
                        <h4>National Gallery of Art</h4>
                        <ul>
                            <li>The National Gallery of Art serves the nation by welcoming</li>
                            <li>all people to explore and experience art, creativity,</li>
                            <li>and our shared humanity.</li>
                            <br>
                            <li>This website was created to fulfill the final project of a database system.</li>
                            <li>This website is inspired by:</li>
                            <li><a href="https://www.nga.gov/collection.html">National Gallery of Art </a>(Original Website)</li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>Address</h4>
                        <ul>
                            <li>West Building</li>
                            <li>6th St and Constitution Ave NW</li>
                            <li>10:00 a.m. to 5:00 p.m. daily</li>
                            <br>
                            <li>Sculpture Garden</li>
                            <li>7th St and Constitution Ave </li> 
                            <li>10:00 a.m. to 5:00 p.m. daily</li>
                            <br> 
                            <li>East Building</li>
                            <li>4th St and Constitution Ave NW</li>
                            <li>10:00 a.m. to 5:00 p.m. daily</li>
                        </ul>
                    </div>
                    <div class="footer-col">
                            <img src="../gambar/12.png">
                    </div>
                    <hr style="width:100%; color: white;">
                    <p style="color:white; text-align: center;">Copyright &copy; 2021 <b>. Kelompok 10 SBD .</b></p>
                </div>
            </div>
        </footer>
</body>
</html>
