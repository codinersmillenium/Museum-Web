
<div class="card mb-4">
    <div class="card-header">
        <button type="button" id="btn-tambah-koleksi" class="btn btn-primary"><span class="text"><i class="fas fa-car fa-sm"></i> Tambah Koleksi</span></button>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Artist</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // include database
                include '../config/database.php';
                // perintah sql untuk menampilkan daftar koleksi
                $id_kategori=$_GET['kategori'];
                $sql="SELECT * FROM koleksi INNER JOIN kategori ON koleksi.id_kategori = kategori.id_kategori INNER JOIN artist ON koleksi.id_artist = artist.id_artist";
                $hasil=mysqli_query($kon,$sql);
                $no=0;
                //Menampilkan data dengan perulangan while
                while ($data = mysqli_fetch_array($hasil)):
                $no++;
            ?>
            
            
            <tr>
                <td><?php echo $no; ?></td>
                <td><img  src="koleksi/gambar/<?php echo $data['gambar'];?>" alt="Card image cap" width="80px"></td>
                <td><?php echo $data['judul_koleksi']; ?></td>
                <td><?php echo  $data['nama_artist'];  ?></td>
                <td><?php echo  $data['nama_kategori'];  ?></td>
                <td><?php echo date("d-m-Y",strtotime($data['tanggal'])); ?></td>
                <td><?php echo $data['status'] == 1 ? "<span class='text-success'>Publish</span>" : "<span class='text-warning'>Konsep</span>"; ?> </td>
                <td>   
                    <button class="btn-edit-koleksi btn btn-warning btn-circle" id_koleksi="<?php echo $data['id_koleksi']; ?>" kode_koleksi="<?php echo $data['kode_koleksi']; ?>" data-toggle="tooltip" title="Edit koleksi" data-placement="top">Edit</button> 
                    <button class="btn-hapus-koleksi btn btn-danger btn-circle"  id_koleksi="<?php echo $data['id_koleksi']; ?>"  gambar="<?php echo $data['gambar']; ?>"  data-toggle="tooltip" title="Hapus koleksi" data-placement="top">Hapus</button>
                </td>
            </tr>
            <!-- bagian akhir (penutup) while -->
            <?php endwhile; ?>
            </tbody>
        </table>
     
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

<input type="hidden" name="kategori" id="kategori" value="<?php echo $_GET['kategori'];?>" />

<script>

    $('#btn-tambah-koleksi').on('click',function(){
        var kategori = $('#kategori').val();
        $.ajax({
            url: 'koleksi/tambah-koleksi.php',
            data: {kategori:kategori},
            method: 'post',
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Tambah Koleksi';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });

        // fungsi edit koleksi
    $('.btn-edit-koleksi').on('click',function(){
    
        var id_koleksi = $(this).attr("id_koleksi");
        var kode_koleksi = $(this).attr("kode_koleksi");
     
        $.ajax({
            url: 'koleksi/edit-koleksi.php',
            method: 'post',
            data: {id_koleksi:id_koleksi,kode_koleksi:kode_koleksi},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit Koleksi #'+kode_koleksi;
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });


    // fungsi hapus koleksi
    $('.btn-hapus-koleksi').on('click',function(){

        var id_koleksi = $(this).attr("id_koleksi");
        var gambar = $(this).attr("gambar");
        var kategori = $('#kategori').val();
        konfirmasi=confirm("Yakin ingin menghapus?")
        
        if (konfirmasi){
            $.ajax({
                url: 'koleksi/hapus-koleksi.php',
                method: 'post',
                data: {id_koleksi:id_koleksi,gambar:gambar},
                success:function(data){
                    window.location.href = 'index.php?halaman=koleksi&kategori='+kategori+'&hapus=berhasil';
                }
            });
        }

     
    });

</script>