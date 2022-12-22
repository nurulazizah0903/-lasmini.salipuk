<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$FormPengaduan = &$Page;
?>
<?php
$Page->showMessage();
?>
<script>
  window.location.href = "<?= BasePath().'/login'; ?>";
</script>
<?php
$token = '';
$msg = '';
$status = true;
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $dataisExist = ExecuteRow(
        'SELECT * FROM pengaduan WHERE token = "' . $token . '"'
    );
    // var_dump($dataisExist);
    if (empty($dataisExist)) {
        $status = false;
        $msg = 'Token anda tidak valid atau tidak terdaftar di sistem kami!';
    } else {
        if ($dataisExist['status'] == 'pending') {
            $status = true; // $status = false; // $msg = "Pengaduan anda sedang kami proses";
        } elseif (
            $dataisExist['status'] == 'prosess' ||
            $dataisExist['status'] == 'diajukan'
        ) {
            $status = false;
            $msg =
                'Pengaduan anda sedang kami proses, mohon tunggu info selanjut nya';
        } elseif ($dataisExist['status'] == 'selesai') {
            $status = false;
            $msg = 'Pengaduan anda sudah kami prosess';
        } elseif ($dataisExist['status'] == 'tolak') {
            $status = false;
            $msg = 'Pengaduan anda kami tolak';
        }
    }
}
if (isset($_POST['x_token'])) {
    // var_dump($_POST);
    $token = $_POST['x_token'];
    $nama = $_POST['x_nama'];
    $nik = $_POST['x_nik'];
    $foto = $_POST['foto'];
    $lat = $_POST['lat'];
    $waktu = $_POST['waktu'];

    $long = $_POST['long'];
    $ket = $_POST['x_keterangan'];
    $kordinat = json_encode(['lat' => $lat, 'long' => $long]);
    ExecuteUpdate("UPDATE pengaduan SET status='Diajukan', foto = '$foto', kordinat= '$kordinat', keterangan='$ket', waktu='$waktu' WHERE token='$token';");
    $dataUser = ExecuteRow("SELECT * FROM pengaduan WHERE token='$token';");
    $userId = $dataUser['pelapor_id'];
    ExecuteUpdate("UPDATE pelapor SET nik='$nik', nama = '$nama' WHERE id=$userId;");
    $status = false;
    $msg =
        'Pengajuan anda akan segera kami proses, dan jika ada update akan segera kami informasi kan';
}
?>
<nav class="navbar navbar-light" style="
    background-color: #20c997 !important;
    color: white !important;
">
  <div class="container">
    <a class="navbar-brand text-white" href="#">Form Pengaduan</a>
  </div>
</nav>
<div class="container">
  <div class="row">
    <div class="col-lg-12 mt-5">
      <img src="https://upload.wikimedia.org/wikipedia/commons/a/a7/Logo_PU_%28RGB%29.jpg" style="width: 90px;margin-bottom: 30px;">
        <img src="https://binamarga.jatimprov.go.id/portal/images/sampledata/icetheme/logo.png" style="margin-bottom: 30px;">
      <?php if ($status): ?>
      <form class="ew-form ew-add-form" action="" method="post">  
      <?php if (Config('CHECK_TOKEN')) { ?>
        <input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
        <input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
      <?php } ?>
        <input type="hidden" name="lat">      
        <input type="hidden" name="long">      
        <input type="hidden" name="waktu" value="<?= date(
            'Y-m-d H:i:s'
        ) ?>">      
        <div class="ew-add-div">   

          <div class="alert alert-danger d-none" id="alertLocation">
            Lokasi harus Aktif, Mohon refresh halaman ini dan ijinkan lokasi
          </div>
          
          <div class="alert alert-danger d-none" id="alertCamera">
            Camera harus aktif, Mohon refresh halaman ini dan ijinkan camera
          </div>

          <div id="r_token" class="row">
            <label id="elh_pengaduan_token" for="x_token" class="col-sm-2 col-form-label ew-label">Token</label>
            <div class="col-sm-10">
              <div>
                <span id="el_pengaduan_token">
                  <input required type="text" value="<?= $token ?>" name="x_token" id="x_token" data-table="pengaduan" data-field="x_token"
                    size="30" maxlength="50" placeholder="Token" class="form-control" aria-describedby="x_token_help">                  
                  <div class="invalid-feedback"></div>
                </span>
              </div>
            </div>
          </div> 
          
          <div id="r_nama" class="row">
            <label id="elh_pengaduan_nama" for="x_nama" class="col-sm-2 col-form-label ew-label">Nama</label>
            <div class="col-sm-10">
              <div>
                <span id="el_pengaduan_nama">
                  <input required type="text" name="x_nama" id="x_nama" data-table="pengaduan" data-field="x_nama" value=""
                    size="30" maxlength="50" placeholder="Nama" class="form-control" aria-describedby="x_nama_help">                  
                  <div class="invalid-feedback"></div>
                </span>
              </div>
            </div>
          </div> 
          
          <div id="r_nik" class="row">
            <label id="elh_pengaduan_nik" for="x_nik" class="col-sm-2 col-form-label ew-label">NIK</label>
            <div class="col-sm-10">
              <div>
                <span id="el_pengaduan_nik">
                  <input required type="text" name="x_nik" id="x_nik" data-table="pengaduan" data-field="x_nik" value=""
                    size="30" maxlength="50" placeholder="NIK" class="form-control" aria-describedby="x_nik_help">                  
                  <div class="invalid-feedback"></div>
                </span>
              </div>
            </div>
          </div> 

          <div id="r_foto" class="row">
            <label id="elh_pengaduan_foto" class="col-sm-2 col-form-label ew-label">Foto</label>
            <div class="col-sm-10">
              <div>            
                <button class="d-block btn btn-info text-white" type="button" id="start-camera">Aktifkan Kamera</button>
                <video id="video" width="320" height="240" autoplay></video>
                <canvas id="canvas" width="320" height="240"></canvas>
                <input type="text" readonly class="form-control d-block mb-2" name="foto" required>      
                <button class="d-block btn btn-info text-white" type="button" id="click-photo">Ambil Gambar</button>
              </div>
            </div>
          </div>        

          <div id="r_keterangan" class="row">
            <label id="elh_pengaduan_keterangan" for="x_keterangan"
              class="col-sm-2 col-form-label ew-label">Keterangan</label>
            <div class="col-sm-10">
              <div>
                <span id="el_pengaduan_keterangan">
                  <textarea required data-table="pengaduan" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35"
                    rows="4" placeholder="Keterangan" class="form-control" aria-describedby="x_keterangan_help"></textarea>
                  <div class="invalid-feedback"></div>
                </span>
              </div>
            </div>
          </div>            

        </div>
        <div class="row">
          <div class="col-sm-10 offset-sm-2">
            <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" name="submit" type="submit">Kirim Pengaduan</button>
            <!-- <button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="http://localhost/PHP-Maker/pu-binamarga/PengaduanList">Cancel</button> -->
          </div>
        </div>
      </form>
      <script>      
        getLocation()
        openCamera()
        
        var x = document.getElementById("demo");

        function getLocation() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, errorPosition);
          } else { 
            x.innerHTML = "Geolocation is not supported by this browser.";
          }
        }

        function showPosition(position) {
          console.log(position)
          $("[name='lat']").val(position.coords.latitude);
          $("[name='long']").val(position.coords.longitude);
        }

        function errorPosition(err){
          $("#alertLocation").removeClass('d-none');
        }

        function openCamera(){
          let camera_button = document.querySelector("#start-camera");
          let video = document.querySelector("#video");
          let click_button = document.querySelector("#click-photo");
          let canvas = document.querySelector("#canvas");

          var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);          

          camera_button.addEventListener('click', async function() {
            try {
              let stream;
              if(isMobile){
                stream = await navigator.mediaDevices.getUserMedia({ 
                video: {
                  facingMode: { 
                    exact: "environment" 
                  } 
                }, 
                audio: false 
              });
            }else{
              stream = await navigator.mediaDevices.getUserMedia({ 
                video: true, 
                audio: false 
              });
            }
            video.srcObject = stream;
            } catch(err) {
              console.log(err)
              $("#alertCamera").removeClass('d-none');
            }
          });

          click_button.addEventListener('click', function() {
              canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
              let image_data_url = canvas.toDataURL('image/jpeg');
              $("[name='foto']").val(image_data_url);
          });
        }
      </script>
      <?php else: ?>
        <div class="card">
          <div class="card-body">
            <h1 align="center"><?= $msg ?></h1>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?= GetDebugMessage() ?>
