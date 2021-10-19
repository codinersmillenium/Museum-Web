<?php
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    include 'config/database.php';
    $id_koleksi=input($_GET['id']);
    $query = mysqli_query ($kon,"select * from koleksi a inner join kategori k on k.id_kategori=a.id_kategori where id_koleksi='".$id_koleksi."' limit 1");
    $data = mysqli_fetch_assoc($query); 
?>
<div class="row">
    <div class="col-sm-8">
        <div class="thumbnail">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="index.php?halaman=home&kategori=<?php echo $data['id_kategori']; ?>"><?php echo $data["nama_kategori"];?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $data["judul_koleksi"];?></li>
                </ol>
            </nav>
            <img src="admin/koleksi/gambar/<?php echo $data['gambar'];?>" width="100%" alt="Cinque Terre">
            <div class="caption">
                <?php
                echo strip_tags(html_entity_decode($data["deskripsi"],ENT_QUOTES,"ISO-8859-1"));
                 ?>
                <hr>
            </div>
            <?php
                  if (isset($_GET['artist'])) {
                    //Mengecek nilai variabel add yang telah di enskripsi dengan method md5()
                    if ($_GET['artist']=='berhasil'){
                        echo"<div class='alert alert-success'>Artist telah terkirim, menunggu persetujuan dari admin</div>";
                    }else {
                        echo"<div class='alert alert-danger'>Artist gagal</div>";
                    }   
                }
        if (isset($_GET['komentar'])) {
        //Mengecek nilai variabel tambah 
        if ($_GET['komentar']=='berhasil'){
            echo"<div class='alert alert-success'><strong>Berhasil!</strong> komentar telah terkirim, menunggu persetujuan dari admin</div>";
        }else if ($_GET['komentar']=='gagal'){
            echo"<div class='alert alert-danger'><strong>Gagal!</strong> komentar gagal di tambahkan!</div>";
        }    
    }
         ?>
            <div class="row">
                <?php
                    include 'config/database.php';
                    $sql="select * from artist,koleksi where artist.id_artist=koleksi.id_artist and id_koleksi=".$id_koleksi." and status=1 order by artist.id_artist desc";
                    $hasil=mysqli_query($kon,$sql);
                    while ($artist = mysqli_fetch_array($hasil)):
                ?>
                <div class="col-sm-12">
                    <div class="caption">
                        <h5><?php echo $artist['nama_artist'];?></h5>
                        <div class="row">
                            <div class="col-sm-1">
                                <img src="gambar/user.png" width="100%" alt="Cinque Terre">
                            </div>
                            <div class="col-sm-11">
                                <?php echo $artist['about']; ?>
                            </div> 
                        </div>
                        <br>
                    </div>
                </div>
                <?php endwhile; ?>
                <h5>Daftar Komentar</h5>
                <div style="overflow: scroll;height: 200px;">
                 <?php
                    include 'config/database.php';
                    $sql="select * from komentar where id_koleksi=".$id_koleksi." and status_komentar=1 order by id_komentar desc";
                    $hasil=mysqli_query($kon,$sql);
                    $cek_komentar = mysqli_num_rows($hasil);
                    if ($cek_komentar==0) {
                      echo"<div class='row'><div class='alert alert-danger'>Tidak Ada Komentar</div></div>";  
                    }else{
                    while ($komentar = mysqli_fetch_array($hasil)):
                ?>
                         <div class="row">
                            <div class="col-sm-1">
                                <img src="gambar/user.png" width="100%" alt="Cinque Terre">
                            </div>
                            <div class="col-sm-11">
                                <h6> <?php echo $komentar['nama'] ?> </h6> <p><?php echo $komentar['isi_komentar'] ?></p>
                            </div> 
                        </div>
                    <?php endwhile;} ?>
            </div>
            </div>
            <br><br>


            <div class="komentar">
                <form method="post" action="simpan-komentar.php">
                    <label><h2>Tinggalkan Komentar</h2></label>
                    <div class="form-group">
                        <input type="hidden" name="id_koleksi" value="<?php echo $data['id_koleksi'];?>" class="form-control">
                        <input type="hidden" name="status" value="0" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama:</label>
                        <input type="text" name="nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Komentar:</label>
                        <textarea class="form-control" name="komentar" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit"  name="form_komentar" class="btn btn-info" value="Kirim Komentar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="row">
            <?php
                include 'config/database.php';
                $sql="select * from koleksi where status=1 order by id_koleksi desc";
                $hasil=mysqli_query($kon,$sql);
                while ($data = mysqli_fetch_array($hasil)):
            ?>
            <div class="col-sm-12">
                <div class="caption">
                    <h5><a class="text-dark" href="index.php?halaman=koleksi&id=<?php echo $data['id_koleksi'];?>"><?php echo $data['judul_koleksi'];?></a></h5>
                    <div class="row">
                        <div class="col-xl-3">
                            <img src="admin/koleksi/gambar/<?php echo $data['gambar'];?>" width="100%" alt="Cinque Terre">
                        </div>
                        <div class="col-sm-9">
                            <?php
                                $ambil=$data["deskripsi"];
                                $panjang = strip_tags(html_entity_decode($ambil,ENT_QUOTES,"ISO-8859-1"));
                            
                                echo substr($panjang, 0, 80);
                            ?>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
       
    </div>  
</div>