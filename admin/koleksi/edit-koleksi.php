
<?php
session_start();
    if (isset($_POST['update_koleksi'])) {
        //Include file koneksi, untuk koneksikan ke database
       
        
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        //Cek apakah ada kiriman form dari method post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

        
            $id_koleksi=input($_POST["id_koleksi"]);
            $judul_koleksi=input($_POST["judul_koleksi"]);
            $artist=input($_POST["artist"]);
            $kategori=input($_POST["kategori"]);
            $status=input($_POST["status"]);
            $deskripsi=input($_POST["deskripsi"]);
            $gambar_saat_ini=$_POST['gambar_saat_ini'];
            $gambar_baru = $_FILES['gambar_baru']['name'];
            $ekstensi_diperbolehkan	= array('png','jpg');
            $x = explode('.', $gambar_baru);
            $ekstensi = strtolower(end($x));
            $ukuran	= $_FILES['gambar_baru']['size'];
            $file_tmp = $_FILES['gambar_baru']['tmp_name'];
        
            $tanggal=date("Y-m-d H:i:s");

            include '../../config/database.php';

            if (!empty($gambar_baru)){
                if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                    //Mengupload gambar baru
                    move_uploaded_file($file_tmp, 'gambar/'.$gambar_baru);

                    //Menghapus gambar lama, gambar yang dihapus selain gambar default
                    if ($gambar_saat_ini!='gambar_default.png'){
                        unlink("gambar/".$gambar_saat_ini);
                    }
                    
                    $sql="update koleksi set
                    judul_koleksi='$judul_koleksi',
                    deskripsi='$deskripsi',
                    gambar='$gambar_baru',
                    id_kategori='$kategori',
                    id_artist='$artist',
                    status='$status',
                    tanggal='$tanggal'
                    where id_koleksi=$id_koleksi"; 
                }
            }else {
                    $sql="update koleksi set
                    judul_koleksi='$judul_koleksi',
                    deskripsi='$deskripsi',
                    id_kategori='$kategori',
                    id_artist='$artist',
                    status='$status',
                    tanggal='$tanggal'
                    where id_koleksi=$id_koleksi"; 
            }

            //Mengeksekusi/menjalankan query 
            $edit_koleksi=mysqli_query($kon,$sql);

            //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
            if ($edit_koleksi) {
                header("Location:../index.php?halaman=koleksi&kategori=$kategori&edit=berhasil");
            }
            else {
                header("Location:../index.php?halaman=koleksi&kategori=$kategori&edit=gagal");
                
            }  



        }

    }
    $id_koleksi=$_POST["id_koleksi"];
    // mengambil data barang dengan kode paling besar
    include '../../config/database.php';
    $query = mysqli_query($kon, "SELECT * FROM koleksi where id_koleksi=$id_koleksi");
    $data = mysqli_fetch_array($query); 

?>
<form action="koleksi/edit-koleksi.php" method="post" enctype="multipart/form-data">
    <!-- rows -->
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Kode:</label>
                <h3><?php echo $data['kode_koleksi']; ?></h3>
                <input name="kode_koleksi" value="<?php  echo $data['kode_koleksi']; ?>" type="hidden" class="form-control">
                <input name="id_koleksi" value="<?php  echo $data['id_koleksi']; ?>" type="hidden" class="form-control">
            </div>
        </div>
    </div>
    <!-- rows -->
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Judul Koleksi:</label>
                <input name="judul_koleksi" type="text" value="<?php  echo $data['judul_koleksi']; ?>" class="form-control" placeholder="Masukan nama koleksi" required>
            </div>
        </div>
    </div>
    <!-- rows --> 
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Artist/Maker:</label>
                    <select name="artist" class="form-control">
                        <!-- Menampilkan daftar artist produk di dalam select list -->
                        <?php
                        
                        $sql="select * from artist order by id_artist asc";
                        $hasil=mysqli_query($kon,$sql);
                        $no=0;
                        if ($data['id_artist']==0) echo "<option value='0'>-</option>";
                        while ($kt = mysqli_fetch_array($hasil)):
                        $no++;
                        ?>
                        <option  <?php if ($data['id_artist']==$kt['id_artist']) echo "selected"; ?> value="<?php echo $kt['id_artist']; ?>"><?php echo $kt['nama_artist']; ?></option>
                        <?php endwhile; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label>Isi Koleksi:</label>
            <textarea name="deskripsi" class="form-control"  rows="5" ><?php  echo $data['deskripsi']; ?></textarea>
        </div>
    </div>
    </div>

    <!-- rows -->                 
    <div class="row">
        <div class="col-sm-6">
        <label>Gambar Saat ini:</label>
            <img src="koleksi/gambar/<?php echo $data['gambar'];?>" class="rounded" width="90%" alt="Cinque Terre">
            <input type="text" name="gambar_saat_ini" value="<?php echo $data['gambar'];?>" class="form-control" />
        </div>
        <div class="col-sm-6">
            <div id="msg"></div>
            <label>Gambar Baru:</label>
            <input type="file" name="gambar_baru" class="file" >
                <div class="input-group my-3">
                    <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
                    <div class="input-group-append">
                            <button type="button" id="pilih_gambar" class="browse btn btn-dark">Pilih Gambar</button>
                    </div>
                </div>
            <img src="https://placehold.it/80x80" id="preview" class="img-thumbnail">
        </div>
    </div>

    <!-- rows -->
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Kategori:</label>
                    <select name="kategori" class="form-control">
                        <!-- Menampilkan daftar kategori produk di dalam select list -->
                        <?php
                        
                        $sql="select * from kategori order by id_kategori asc";
                        $hasil=mysqli_query($kon,$sql);
                        $no=0;
                        if ($data['id_kategori']==0) echo "<option value='0'>-</option>";
                        while ($kt = mysqli_fetch_array($hasil)):
                        $no++;
                        ?>
                        <option  <?php if ($data['id_kategori']==$kt['id_kategori']) echo "selected"; ?> value="<?php echo $kt['id_kategori']; ?>"><?php echo $kt['nama_kategori']; ?></option>
                        <?php endwhile; ?>
                </select>
            </div>
        </div>
    </div>
    <!-- rows -->
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
            <label>Status:</label>
                <div class="form-check-inline">
                    <label class="form-check-label">
                    <input type="radio" <?php if ($data['status']==1) echo "checked"; ?> class="form-check-input" name="status" value="1">Publish
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label">
                    <input type="radio" <?php if ($data['status']==0) echo "checked"; ?> class="form-check-input" name="status" value="0">Konsep
                    </label>
                </div>
            </div>
        </div>
    </div>
    <!-- rows -->   
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <button type="submit" name="update_koleksi" class="btn btn-success">Update Koleksi</button>
            </div>
        </div>   
    </div>    
</form>
<style>
    .file {
    visibility: hidden;
    position: absolute;
    }
</style>

<script>
    $(document).on("click", "#pilih_gambar", function() {
    var file = $(this).parents().find(".file");
    file.trigger("click");
    });
    $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#file").val(fileName);

    var reader = new FileReader();
    reader.onload = function(e) {
        // get loaded data and render thumbnail.
        document.getElementById("preview").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
    });
</script>
