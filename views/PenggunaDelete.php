<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$PenggunaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pengguna: currentTable } });
var currentForm, currentPageID;
var fpenggunadelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpenggunadelete = new ew.Form("fpenggunadelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fpenggunadelete;
    loadjs.done("fpenggunadelete");
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
<form name="fpenggunadelete" id="fpenggunadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pengguna">
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
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_pengguna_nama" class="pengguna_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><span id="elh_pengguna__username" class="pengguna__username"><?= $Page->_username->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <th class="<?= $Page->_password->headerCellClass() ?>"><span id="elh_pengguna__password" class="pengguna__password"><?= $Page->_password->caption() ?></span></th>
<?php } ?>
<?php if ($Page->upt_id->Visible) { // upt_id ?>
        <th class="<?= $Page->upt_id->headerCellClass() ?>"><span id="elh_pengguna_upt_id" class="pengguna_upt_id"><?= $Page->upt_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->level->Visible) { // level ?>
        <th class="<?= $Page->level->headerCellClass() ?>"><span id="elh_pengguna_level" class="pengguna_level"><?= $Page->level->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_pengguna_nama" class="el_pengguna_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <td<?= $Page->_username->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengguna__username" class="el_pengguna__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <td<?= $Page->_password->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengguna__password" class="el_pengguna__password">
<span<?= $Page->_password->viewAttributes() ?>>
<?= $Page->_password->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->upt_id->Visible) { // upt_id ?>
        <td<?= $Page->upt_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengguna_upt_id" class="el_pengguna_upt_id">
<span<?= $Page->upt_id->viewAttributes() ?>>
<?= $Page->upt_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->level->Visible) { // level ?>
        <td<?= $Page->level->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengguna_level" class="el_pengguna_level">
<span<?= $Page->level->viewAttributes() ?>>
<?= $Page->level->getViewValue() ?></span>
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
