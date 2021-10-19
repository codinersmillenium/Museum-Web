
<div class="card mb-4">
    <div class="card-header">
    <button type="button" id="btn-tambah-artist" class="btn btn-primary"><span class="text"><i class="fas fa-car fa-sm"></i> Tambah Artist</span></button>
    </div>
    <div class="card-body">
    <?php
    if (isset($_GET['tambah'])) {
        //Mengecek nilai variabel tambah 
        if ($_GET['tambah']=='berhasil'){
            echo"<div class='alert alert-success'><strong>Berhasil!</strong> artist telah di tambahkan!</div>";
        }else if ($_GET['tambah']=='gagal'){
            echo"<div class='alert alert-danger'><strong>Gagal!</strong> artist gagal di tambahkan!</div>";
        }    
    }
    if (isset($_GET['edit'])) {
        //Mengecek nilai variabel edit 
        if ($_GET['edit']=='berhasil'){
            echo"<div class='alert alert-success'><strong>Berhasil!</strong> artist telah di edit!</div>";
        }else if ($_GET['edit']=='gagal'){
            echo"<div class='alert alert-danger'><strong>Gagal!</strong> artist gagal di edit!</div>";
        }    
      }
    if (isset($_GET['hapus'])) {
        //Mengecek nilai variabel hapus 
        if ($_GET['hapus']=='berhasil'){
            echo"<div class='alert alert-success'><strong>Berhasil!</strong> artist telah di hapus!</div>";
        }else if ($_GET['hapus']=='gagal'){
            echo"<div class='alert alert-danger'><strong>Gagal!</strong> artist gagal di hapus!</div>";
        }    
    }
    ?>
       <!-- Tabel daftar artist -->
       <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Artist</th>
                    <th>About</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        // include database
                        include '../config/database.php';
                        // perintah sql untuk menampilkan daftar artist
                        $sql="select * from artist order by id_artist desc";
                        $hasil=mysqli_query($kon,$sql);
                        $no=0;
                        //Menampilkan data dengan perulangan while
                        while ($data = mysqli_fetch_array($hasil)):
                        $no++;
                    ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $data['nama_artist']; ?></td>
                        <td><?php echo $data['about']; ?></td>
                        <td>
                            <button class="btn-edit btn btn-warning btn-circle" id_artist="<?php echo $data['id_artist']; ?>"  >Edit</button>
                            <button class="btn-hapus btn btn-danger btn-circle"  id_artist="<?php echo $data['id_artist']; ?>" >Hapus</button>
                        </td>
                    </tr>
                    <!-- bagian akhir (penutup) while -->
                    <?php endwhile; ?>
                </tbody>
            </table>
            </div>
     
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <!-- Bagian header -->
        <div class="modal-header">
            <h4 class="modal-title" id="judul"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Bagian body -->
        <div class="modal-body">
            <div id="tampil_data">

            </div>  
        </div>
        <!-- Bagian footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>
<script>

    $('#btn-tambah-artist').on('click',function(){
        
        $.ajax({
            url: 'artist/tambah.php',
            method: 'post',
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Tambah Artist';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });
   
    // fungsi edit artist
    $('.btn-edit').on('click',function(){

        var id_artist = $(this).attr("id_artist");
    
        $.ajax({
            url: 'artist/edit.php',
            method: 'post',
            data: {id_artist:id_artist},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit artist #'+id_artist;
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });




    // fungsi hapus artist
    $('.btn-hapus').on('click',function(){

        var id_artist = $(this).attr("id_artist");

        konfirmasi=confirm("Yakin ingin menghapus?")

        if (konfirmasi){
            $.ajax({
                url: 'artist/hapus.php',
                method: 'post',
                data: {id_artist:id_artist},
                success:function(data){
                    window.location.href = 'index.php?halaman=artist&hapus=berhasil';
                }
            });
        }
});

</script>