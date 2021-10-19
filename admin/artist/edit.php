
<?php
    $id_artist=$_POST["id_artist"];
    // mengambil data barang dengan kode paling besar
    include '../../config/database.php';
    $query = mysqli_query($kon, "SELECT * FROM artist where id_artist=$id_artist");
    $data = mysqli_fetch_array($query); 

    $nama_artist=$data['nama_artist'];
    $about=$data['about'];

?>
    <form action="artist/edit.php" method="post">
    <div class="form-group">
            <input name="id_artist" value="<?php echo $id_artist; ?>" type="hidden" class="form-control">
        </div>
        <div class="form-group">
            <label>Nama Artist:</label>
            <input name="nama_artist" value="<?php echo $nama_artist; ?>" type="text" class="form-control">
        </div>
   
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>About:</label>
                    <textarea name="about" class="form-control" rows="5"><?php echo $about; ?></textarea>
                </div>
            </div>
        </div>
        

        <button type="submit" name="simpan_edit" class="btn btn-dark">Update Artist</button>
    </form>

<?php
    if (isset($_POST['simpan_edit'])) {
        //Include file koneksi, untuk koneksikan ke database
        include '../../config/database.php';
        
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $id_artist=input($_POST["id_artist"]);
        $nama_artist=input($_POST["nama_artist"]);
        $about=input($_POST["about"]);


        //Query input menginput data kedalam tabel anggota
        $sql="update artist set
        nama_artist='$nama_artist',
        about='$about'
        where id_artist=$id_artist";

        //Mengeksekusi/menjalankan query 
        $hasil=mysqli_query($kon,$sql);


        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:../index.php?halaman=artist&edit=berhasil");
        }
        else {
            header("Location:../index.php?halaman=artist&edit=gagal");;

        }
        
    }
    ?>