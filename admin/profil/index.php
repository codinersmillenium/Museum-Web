
<div class="card mb-4">
    <div class="card-header">
     <form method="post" action="profil/ubah.php">
        <style type="text/css">
            .display{
                display: none;
            }
        </style>
    <input type="button" value="Update Profil" id="btn-update-profil" class="btn btn-primary text" onclick="active()" />
    <button type="submit" class="btn btn-success text display" id="btn-submit">Kirim</button>
    </div>
    <div class="card-body">
    <?php

    include '../config/database.php';
    $ambil_kategori = mysqli_query ($kon,"select * from profil");
    $row = mysqli_fetch_assoc($ambil_kategori); 
    $nama_website = $row['nama_website'];
    $about_web = $row['about_web'];
    if (isset($_GET['tambah'])) {
            echo"<div class='alert alert-success'><strong>Berhasil!</strong> profil telah di update</div>";
    }
    ?>
            <div class="form-group">
                <label for="usr">Nama Website:</label>
                <input type="text" id="nama_website" class="form-control" name="nama_website" readonly="readonly" value="<?php echo $nama_website; ?>">
            </div>
            <div class="form-group">
                <label for="usr">Profil Website:</label>
                <textarea name="about_web" id="about_web" class="form-control"  rows="5" readonly="readonly"><?php  echo $about_web; ?></textarea>
            </div>
            
    </div>
</div>
</form>   
<script type="text/javascript">
    var btn_update= document.getElementById('btn-update-profil');
    var btn_submit= document.getElementById('btn-submit');
    var nama_website= document.getElementById('nama_website');
    var about= document.getElementById('about_web');
    function active(){
        nama_website.removeAttribute('readonly');
        about.removeAttribute('readonly');
        btn_update.classList.add("display");
        btn_submit.classList.remove("display");
    }
</script>


