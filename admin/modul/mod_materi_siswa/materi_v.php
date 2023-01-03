<div class="row pad-botm">
  <div class="col-md-12">
    <h4 class="header-line">Materi Belajar Siswa</h4>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
       Materi Untuk Kelas <?php echo $nama_kelas; ?>
     </div>        

     <div class="panel-body">
      <?php
      if (isset($_GET['mp'])){
        $mapel=$_GET['mp'];
      } else {
        $mapel='all';
      }
      ?>
      <a href="?module=materi&mp=all" class="btn <?php echo $_GET['mp']=='all' ? "btn-default" : "btn-primary"; ?> btn-sm">Semua</a>

      <?php
      $qmapel=mysqli_query($connect,"SELECT mapel.kd_mapel, mapel.nama_mapel 
        FROM mapel, detail_kurikulum as dk, kurikulum
        WHERE dk.kd_kurikulum=kurikulum.kd_kurikulum AND kurikulum.aktif='Y' AND
        dk.kd_mapel=mapel.kd_mapel AND dk.kd_kelas='$kode_kelas'");
      while ($rmp=mysqli_fetch_array($qmapel)){
        $mapel==$rmp['kd_mapel'] ? $cbtn="btn-default" : $cbtn="btn-primary";
        echo "<a href='?module=materi&mp=$rmp[kd_mapel]' class='btn $cbtn btn-sm'>$rmp[nama_mapel]</a>  ";
      }
      ?>

    </div>
  </div>
</div>
</div>
<div class="row">
  <div class="col-md-9 col-sm-9 col-xs-12">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
          <tr>
            <th>Materi </th>
            <th>Mata Pelajaran </th>
            <th>Guru Pengampu </th>
            <th>File </th>
            <th>Aksi </th>
          </tr>
        </thead>
        <tbody>
          <?php

          if ($mapel=='all') {
            $qmat="SELECT materi.nama_materi, materi.ForL, materi.file, materi.pertemuan, materi.tgl_up, mapel.nama_mapel, materi.kd_materi, kelas.nama_kelas , guru.nama
                    FROM kurikulum, materi, detail_kurikulum as dk, mapel, kelas, guru 
                    WHERE kurikulum.kd_kurikulum=dk.kd_kurikulum AND kurikulum.aktif='Y' AND dk.kd_mapel=materi.kd_mapel AND materi.kd_mapel=mapel.kd_mapel AND kelas.kd_kelas=materi.kd_kelas AND kelas.kd_kelas=dk.kd_kelas AND materi.kd_guru=dk.kd_guru AND guru.kd_guru=dk.kd_guru AND materi.kd_kelas='$kode_kelas'";
            $mat=mysqli_query($connect,$qmat);
            while ($rmat=mysqli_fetch_array($mat)){
              echo "<tr class='odd gradeX'>
              <td>$rmat[nama_materi]</td>
              <td>$rmat[nama_mapel]</td>
              <td>$rmat[nama]</td>";
              if ($rmat['ForL']=='file') {
                echo "<td class='center'>$rmat[file]</td>
              <td class='center'><a href='modul/mod_materi_siswa/download.php?materi=$rmat[file]'>Download</a> | <a href='#'' class='pmateri' data-id='$rmat[file]' data-judul='$rmat[nama_materi]'>Preview</a></td>";  
              } else {
                echo "<td class='center'>$rmat[file]</td>
              <td class='center'><a href='$rmat[file]' target='_blank'>Lihat</a></td>";
              }
              echo "</tr>";
            }
          } else {
            $qmat="SELECT materi.nama_materi, materi.ForL, materi.file, materi.pertemuan, materi.tgl_up, mapel.nama_mapel, materi.kd_materi, kelas.nama_kelas , guru.nama
                    FROM kurikulum, materi, detail_kurikulum as dk, mapel, kelas, guru 
                    WHERE kurikulum.kd_kurikulum=dk.kd_kurikulum AND kurikulum.aktif='Y' AND dk.kd_mapel=materi.kd_mapel AND materi.kd_mapel=mapel.kd_mapel AND kelas.kd_kelas=materi.kd_kelas AND kelas.kd_kelas=dk.kd_kelas AND materi.kd_guru=dk.kd_guru AND guru.kd_guru=dk.kd_guru AND materi.kd_kelas='$kode_kelas' AND materi.kd_mapel='$mapel'";
            $mat=mysqli_query($connect,$qmat);
            while ($rmat=mysqli_fetch_array($mat)){
              echo "<tr class='odd gradeX'>
              <td>$rmat[nama_materi]</td>
              <td>$rmat[nama_mapel]</td>
              <td>$rmat[nama]</td>";
              if ($rmat['ForL']=='file') {
                echo "<td class='center'>$rmat[file]</td>
              <td class='center'><a href='modul/mod_materi_siswa/download.php?materi=$rmat[file]'>Download</a> | <a href='#'' class='pmateri' data-id='$rmat[file]' data-judul='$rmat[nama_materi]'>Preview</a></td>";  
              } else {
                echo "<td class='center'>$rmat[file]</td>
              <td class='center'><a href='$rmat[file]' target='_blank'>Lihat</a></td>";
              }
              
              echo "</tr>";
            }
          }

          ?>                               
        </tbody>
      </table>
    </div>

  </div>

  <div class="modal fade" id="previewmateri" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Judul Materi</h4>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-3 col-xs-12" >
    <div class="alert alert-info text-center">
      <?php

      switch ($mapel) {
        case 'kd_mapel1':
        ?>
        <h3> Mata Pelajaran 1 </h3> 
        <hr />
        <img src="assets/img/user2.png">
        <hr />
        <p>
         <h4>Nama Guru Mata Pelajaran 1</h4>
         <h4>Tahun Ajaran 2020/2021 Ganjil</h4>
       </p>
       <hr />
       <a href="#" class="btn btn-info">Lihat Detail</a>
       <?php
       break;

       case 'kd_mapel2':
       ?>
       <h3> Mata Pelajaran 2 </h3> 
       <hr />
       <img src="assets/img/user2.png">
       <hr />
       <p>
         <h4>Nama Guru Mata Pelajaran 2</h4>
         <h4>Tahun Ajaran 2020/2021 Ganjil</h4>
       </p>
       <hr />
       <a href="#" class="btn btn-info">Lihat Detail</a>
       <?php
       break;

       case 'kd_mapel3':
       ?>
       <h3> Mata Pelajaran 3 </h3> 
       <hr />
       <img src="assets/img/user2.png">
       <hr />
       <p>
         <h4>Nama Guru Mata Pelajaran 3</h4>
         <h4>Tahun Ajaran 2020/2021 Ganjil</h4>
       </p>
       <hr />
       <a href="#" class="btn btn-info">Lihat Detail</a>
       <?php
       break;

       default:
       ?>
       <h3> NAMA SISWA DISINI </h3> 
       <hr />
       <img src="assets/img/user2.png">
       <hr />
       <p>
         <h4>Kelas XII A</h4>
         <h4>Tahun Ajaran 2020/2021 Ganjil</h4>
       </p>
       <hr />
       <a href="#" class="btn btn-info">Ubah Data</a>
       <?php
       break;
     }
     ?> 
   </div>
 </div>
</div>