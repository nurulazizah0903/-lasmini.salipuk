<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$KordinatJalanDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { kordinat_jalan: currentTable } });
var currentForm, currentPageID;
var fkordinat_jalandelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fkordinat_jalandelete = new ew.Form("fkordinat_jalandelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fkordinat_jalandelete;
    loadjs.done("fkordinat_jalandelete");
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
<form name="fkordinat_jalandelete" id="fkordinat_jalandelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kordinat_jalan">
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
<?php if ($Page->jalan_id->Visible) { // jalan_id ?>
        <th class="<?= $Page->jalan_id->headerCellClass() ?>"><span id="elh_kordinat_jalan_jalan_id" class="kordinat_jalan_jalan_id"><?= $Page->jalan_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lat->Visible) { // lat ?>
        <th class="<?= $Page->lat->headerCellClass() ?>"><span id="elh_kordinat_jalan_lat" class="kordinat_jalan_lat"><?= $Page->lat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->long->Visible) { // long ?>
        <th class="<?= $Page->long->headerCellClass() ?>"><span id="elh_kordinat_jalan_long" class="kordinat_jalan_long"><?= $Page->long->caption() ?></span></th>
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
<?php if ($Page->jalan_id->Visible) { // jalan_id ?>
        <td<?= $Page->jalan_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_kordinat_jalan_jalan_id" class="el_kordinat_jalan_jalan_id">
<span<?= $Page->jalan_id->viewAttributes() ?>>
<?= $Page->jalan_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lat->Visible) { // lat ?>
        <td<?= $Page->lat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_kordinat_jalan_lat" class="el_kordinat_jalan_lat">
<span<?= $Page->lat->viewAttributes() ?>>
<?= $Page->lat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->long->Visible) { // long ?>
        <td<?= $Page->long->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_kordinat_jalan_long" class="el_kordinat_jalan_long">
<span<?= $Page->long->viewAttributes() ?>>
<?= $Page->long->getViewValue() ?></span>
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
