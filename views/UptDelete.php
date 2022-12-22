<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$UptDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { upt: currentTable } });
var currentForm, currentPageID;
var fuptdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuptdelete = new ew.Form("fuptdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fuptdelete;
    loadjs.done("fuptdelete");
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
<form name="fuptdelete" id="fuptdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="upt">
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
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_upt_nama" class="upt_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama_pic->Visible) { // nama_pic ?>
        <th class="<?= $Page->nama_pic->headerCellClass() ?>"><span id="elh_upt_nama_pic" class="upt_nama_pic"><?= $Page->nama_pic->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nip_pic->Visible) { // nip_pic ?>
        <th class="<?= $Page->nip_pic->headerCellClass() ?>"><span id="elh_upt_nip_pic" class="upt_nip_pic"><?= $Page->nip_pic->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jabatan_pic->Visible) { // jabatan_pic ?>
        <th class="<?= $Page->jabatan_pic->headerCellClass() ?>"><span id="elh_upt_jabatan_pic" class="upt_jabatan_pic"><?= $Page->jabatan_pic->caption() ?></span></th>
<?php } ?>
<?php if ($Page->no_hp_pic->Visible) { // no_hp_pic ?>
        <th class="<?= $Page->no_hp_pic->headerCellClass() ?>"><span id="elh_upt_no_hp_pic" class="upt_no_hp_pic"><?= $Page->no_hp_pic->caption() ?></span></th>
<?php } ?>
<?php if ($Page->email_pic->Visible) { // email_pic ?>
        <th class="<?= $Page->email_pic->headerCellClass() ?>"><span id="elh_upt_email_pic" class="upt_email_pic"><?= $Page->email_pic->caption() ?></span></th>
<?php } ?>
<?php if ($Page->file->Visible) { // file ?>
        <th class="<?= $Page->file->headerCellClass() ?>"><span id="elh_upt_file" class="upt_file"><?= $Page->file->caption() ?></span></th>
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
<?php if ($Page->nama->Visible) { // nama ?>
        <td<?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_upt_nama" class="el_upt_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama_pic->Visible) { // nama_pic ?>
        <td<?= $Page->nama_pic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_upt_nama_pic" class="el_upt_nama_pic">
<span<?= $Page->nama_pic->viewAttributes() ?>>
<?= $Page->nama_pic->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nip_pic->Visible) { // nip_pic ?>
        <td<?= $Page->nip_pic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_upt_nip_pic" class="el_upt_nip_pic">
<span<?= $Page->nip_pic->viewAttributes() ?>>
<?= $Page->nip_pic->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jabatan_pic->Visible) { // jabatan_pic ?>
        <td<?= $Page->jabatan_pic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_upt_jabatan_pic" class="el_upt_jabatan_pic">
<span<?= $Page->jabatan_pic->viewAttributes() ?>>
<?= $Page->jabatan_pic->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->no_hp_pic->Visible) { // no_hp_pic ?>
        <td<?= $Page->no_hp_pic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_upt_no_hp_pic" class="el_upt_no_hp_pic">
<span<?= $Page->no_hp_pic->viewAttributes() ?>>
<?= $Page->no_hp_pic->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->email_pic->Visible) { // email_pic ?>
        <td<?= $Page->email_pic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_upt_email_pic" class="el_upt_email_pic">
<span<?= $Page->email_pic->viewAttributes() ?>>
<?= $Page->email_pic->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->file->Visible) { // file ?>
        <td<?= $Page->file->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_upt_file" class="el_upt_file">
<span<?= $Page->file->viewAttributes() ?>>
<?= GetFileViewTag($Page->file, $Page->file->getViewValue(), false) ?>
</span>
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
