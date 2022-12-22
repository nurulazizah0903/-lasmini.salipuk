<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$PertanyaanDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pertanyaan: currentTable } });
var currentForm, currentPageID;
var fpertanyaandelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpertanyaandelete = new ew.Form("fpertanyaandelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fpertanyaandelete;
    loadjs.done("fpertanyaandelete");
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
<form name="fpertanyaandelete" id="fpertanyaandelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pertanyaan">
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
<?php if ($Page->pid->Visible) { // pid ?>
        <th class="<?= $Page->pid->headerCellClass() ?>"><span id="elh_pertanyaan_pid" class="pertanyaan_pid"><?= $Page->pid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
        <th class="<?= $Page->code->headerCellClass() ?>"><span id="elh_pertanyaan_code" class="pertanyaan_code"><?= $Page->code->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_pertanyaan_nama" class="pertanyaan_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jawaban->Visible) { // jawaban ?>
        <th class="<?= $Page->jawaban->headerCellClass() ?>"><span id="elh_pertanyaan_jawaban" class="pertanyaan_jawaban"><?= $Page->jawaban->caption() ?></span></th>
<?php } ?>
<?php if ($Page->file->Visible) { // file ?>
        <th class="<?= $Page->file->headerCellClass() ?>"><span id="elh_pertanyaan_file" class="pertanyaan_file"><?= $Page->file->caption() ?></span></th>
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
<?php if ($Page->pid->Visible) { // pid ?>
        <td<?= $Page->pid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pertanyaan_pid" class="el_pertanyaan_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
        <td<?= $Page->code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pertanyaan_code" class="el_pertanyaan_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td<?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pertanyaan_nama" class="el_pertanyaan_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jawaban->Visible) { // jawaban ?>
        <td<?= $Page->jawaban->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pertanyaan_jawaban" class="el_pertanyaan_jawaban">
<span<?= $Page->jawaban->viewAttributes() ?>>
<?= $Page->jawaban->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->file->Visible) { // file ?>
        <td<?= $Page->file->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pertanyaan_file" class="el_pertanyaan_file">
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
