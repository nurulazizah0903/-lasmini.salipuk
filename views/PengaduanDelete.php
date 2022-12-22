<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$PengaduanDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pengaduan: currentTable } });
var currentForm, currentPageID;
var fpengaduandelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpengaduandelete = new ew.Form("fpengaduandelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fpengaduandelete;
    loadjs.done("fpengaduandelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpengaduandelete" id="fpengaduandelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pengaduan">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table table-bordered table-hover table-sm ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->pelapor_id->Visible) { // pelapor_id ?>
        <th class="<?= $Page->pelapor_id->headerCellClass() ?>"><span id="elh_pengaduan_pelapor_id" class="pengaduan_pelapor_id"><?= $Page->pelapor_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jalan_id->Visible) { // jalan_id ?>
        <th class="<?= $Page->jalan_id->headerCellClass() ?>"><span id="elh_pengaduan_jalan_id" class="pengaduan_jalan_id"><?= $Page->jalan_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <th class="<?= $Page->foto->headerCellClass() ?>"><span id="elh_pengaduan_foto" class="pengaduan_foto"><?= $Page->foto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><span id="elh_pengaduan_keterangan" class="pengaduan_keterangan"><?= $Page->keterangan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_token->Visible) { // token ?>
        <th class="<?= $Page->_token->headerCellClass() ?>"><span id="elh_pengaduan__token" class="pengaduan__token"><?= $Page->_token->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_pengaduan_status" class="pengaduan_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->waktu->Visible) { // waktu ?>
        <th class="<?= $Page->waktu->headerCellClass() ?>"><span id="elh_pengaduan_waktu" class="pengaduan_waktu"><?= $Page->waktu->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->pelapor_id->Visible) { // pelapor_id ?>
        <td<?= $Page->pelapor_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengaduan_pelapor_id" class="el_pengaduan_pelapor_id">
<span<?= $Page->pelapor_id->viewAttributes() ?>>
<?= $Page->pelapor_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jalan_id->Visible) { // jalan_id ?>
        <td<?= $Page->jalan_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengaduan_jalan_id" class="el_pengaduan_jalan_id">
<span<?= $Page->jalan_id->viewAttributes() ?>>
<?= $Page->jalan_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <td<?= $Page->foto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengaduan_foto" class="el_pengaduan_foto">
<span><img src="<?= CurrentPage()->foto->CurrentValue; ?>" />
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td<?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengaduan_keterangan" class="el_pengaduan_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_token->Visible) { // token ?>
        <td<?= $Page->_token->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengaduan__token" class="el_pengaduan__token">
<span<?= $Page->_token->viewAttributes() ?>>
<?= $Page->_token->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengaduan_status" class="el_pengaduan_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->waktu->Visible) { // waktu ?>
        <td<?= $Page->waktu->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengaduan_waktu" class="el_pengaduan_waktu">
<span<?= $Page->waktu->viewAttributes() ?>>
<?= $Page->waktu->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
