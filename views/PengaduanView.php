<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$PengaduanView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pengaduan: currentTable } });
var currentForm, currentPageID;
var fpengaduanview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpengaduanview = new ew.Form("fpengaduanview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fpengaduanview;
    loadjs.done("fpengaduanview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpengaduanview" id="fpengaduanview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pengaduan">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengaduan_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_pengaduan_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pelapor_id->Visible) { // pelapor_id ?>
    <tr id="r_pelapor_id"<?= $Page->pelapor_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengaduan_pelapor_id"><?= $Page->pelapor_id->caption() ?></span></td>
        <td data-name="pelapor_id"<?= $Page->pelapor_id->cellAttributes() ?>>
<span id="el_pengaduan_pelapor_id">
<span<?= $Page->pelapor_id->viewAttributes() ?>>
<?= $Page->pelapor_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jalan_id->Visible) { // jalan_id ?>
    <tr id="r_jalan_id"<?= $Page->jalan_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengaduan_jalan_id"><?= $Page->jalan_id->caption() ?></span></td>
        <td data-name="jalan_id"<?= $Page->jalan_id->cellAttributes() ?>>
<span id="el_pengaduan_jalan_id">
<span<?= $Page->jalan_id->viewAttributes() ?>>
<?= $Page->jalan_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <tr id="r_foto"<?= $Page->foto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengaduan_foto"><?= $Page->foto->caption() ?></span></td>
        <td data-name="foto"<?= $Page->foto->cellAttributes() ?>>
<span id="el_pengaduan_foto">
<span><img src="<?= CurrentPage()->foto->CurrentValue; ?>" />
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kordinat->Visible) { // kordinat ?>
    <tr id="r_kordinat"<?= $Page->kordinat->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengaduan_kordinat"><?= $Page->kordinat->caption() ?></span></td>
        <td data-name="kordinat"<?= $Page->kordinat->cellAttributes() ?>>
<span id="el_pengaduan_kordinat">
<span<?= $Page->kordinat->viewAttributes() ?>>
<?= $Page->kordinat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan"<?= $Page->keterangan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengaduan_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan"<?= $Page->keterangan->cellAttributes() ?>>
<span id="el_pengaduan_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_token->Visible) { // token ?>
    <tr id="r__token"<?= $Page->_token->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengaduan__token"><?= $Page->_token->caption() ?></span></td>
        <td data-name="_token"<?= $Page->_token->cellAttributes() ?>>
<span id="el_pengaduan__token">
<span<?= $Page->_token->viewAttributes() ?>>
<?= $Page->_token->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengaduan_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_pengaduan_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->waktu->Visible) { // waktu ?>
    <tr id="r_waktu"<?= $Page->waktu->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengaduan_waktu"><?= $Page->waktu->caption() ?></span></td>
        <td data-name="waktu"<?= $Page->waktu->cellAttributes() ?>>
<span id="el_pengaduan_waktu">
<span<?= $Page->waktu->viewAttributes() ?>>
<?= $Page->waktu->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
