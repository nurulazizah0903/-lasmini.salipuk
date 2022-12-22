<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$SettingAplikasi = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
$dataQr = ExecuteRow('SELECT * FROM setting WHERE `key` = "qr_code"');
$dataStatus = ExecuteRow('SELECT * FROM setting WHERE `key` = "status_connection_app"');
$dataQr2 = ExecuteRow('SELECT * FROM setting WHERE `key` = "qr_listchatbot_code"');
$dataStatus2 = ExecuteRow('SELECT * FROM setting WHERE `key` = "status_connection_lustchatbot_app"');
$dataStatusApp = ExecuteRow('SELECT * FROM setting WHERE `key` = "status_app"');
?>
Status Chatbot : <span id="status"><?= $dataStatus['value'] == 'false'
    ? 'Tidak Tersambung'
    : 'Tersambung' ?></span>
<br>
<br>
<canvas id="canvas" style="width: 400px;height: 400px;"></canvas>
<script src="node_modules/qrcode/build/qrcode.js"></script>
<script>
  QRCode.toCanvas(document.getElementById('canvas'), "<?= $dataQr['value']; ?>", function (error) {
    if (error) console.error(error)
    console.log('success!');
  })
  QRCode.toCanvas(document.getElementById('canvas2'), "<?= $dataQr2['value']; ?>", function (error) {
    if (error) console.error(error)
    console.log('success!');
  })
</script>
<script>
    setInterval(() => {
        $.get("<?= BasePath(); ?>"+"/api/getQrCode", function(res) {
            QRCode.toCanvas(document.getElementById('canvas'), res.Qr.value, function (error) {
                if (error) console.error(error)
                console.log('success!');
            })
            // var srcQr = "https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl="+res.Qr.value+"&choe=UTF-8";
            var status = res.status.value;
            var statusLog = res.status_app.value;

            // $('#qrApp').attr('src', srcQr)                
            $('#status').html(status == 'true' ? 'Tersambung' : 'Tidak Tersambung')                
            $('#status_log').html(statusLog)                
        });
    }, 2000);

    setInterval(() => {
        $.get("<?= BasePath(); ?>"+"/api/getQrCode2", function(res) {
            QRCode.toCanvas(document.getElementById('canvas2'), res.Qr.value, function (error) {
                if (error) console.error(error)
                console.log('success!');
            })
            // var srcQr = "https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl="+res.Qr.value+"&choe=UTF-8";
            var status = res.status.value;
            var statusLog = res.status_app.value;

            // $('#qrApp').attr('src', srcQr)                
            $('#status2').html(status == 'true' ? 'Tersambung' : 'Tidak Tersambung')                
            $('#status_log').html(statusLog)                
        });
    }, 2000);
</script>
<?= GetDebugMessage() ?>

