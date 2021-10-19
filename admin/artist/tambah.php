
<form action="artist/tambah.php" method="post">
        <div class="form-group">
            <label>Nama Artist:</label>
            <input name="nama_artist" type="text" class="form-control" placeholder="Masukan nama artist" required>
        </div>

        <div class="row">
            <div class="col-sm-6">
            <div class="form-group">
                    <label>About:</label>
                    <textarea name="about" class="form-control"  rows="5" required></textarea>
            </div>
            </div>
        </div>
        
        <button type="submit" name="simpan_tambah" class="btn btn-dark">Tambah</button>
      
    </form>
    <?php
    if (isset($_POST['simpan_tambah'])) {
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
        
        //Query input menginput data kedalam tabel 
        $sql="insert into artist (id_artist,nama_artist,about) values
        ('$id_artist','$nama_artist','$about')";
        //Mengeksekusi/menjalankan query 
        $hasil=mysqli_query($kon,$sql);
     

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:../index.php?halaman=artist&tambah=berhasil");
        }
        else {
            header("Location:../index.php?halaman=artist&tambah=gagal");

        }
        
    }
?>