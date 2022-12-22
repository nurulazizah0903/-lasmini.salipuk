<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$KordinatJalanView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { kordinat_jalan: currentTable } });
var currentForm, currentPageID;
var fkordinat_jalanview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fkordinat_jalanview = new ew.Form("fkordinat_jalanview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fkordinat_jalanview;
    loadjs.done("fkordinat_jalanview");
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
<form name="fkordinat_jalanview" id="fkordinat_jalanview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kordinat_jalan">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->jalan_id->Visible) { // jalan_id ?>
    <tr id="r_jalan_id"<?= $Page->jalan_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kordinat_jalan_jalan_id"><?= $Page->jalan_id->caption() ?></span></td>
        <td data-name="jalan_id"<?= $Page->jalan_id->cellAttributes() ?>>
<span id="el_kordinat_jalan_jalan_id">
<span<?= $Page->jalan_id->viewAttributes() ?>>
<?= $Page->jalan_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lat->Visible) { // lat ?>
    <tr id="r_lat"<?= $Page->lat->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kordinat_jalan_lat"><?= $Page->lat->caption() ?></span></td>
        <td data-name="lat"<?= $Page->lat->cellAttributes() ?>>
<span id="el_kordinat_jalan_lat">
<span<?= $Page->lat->viewAttributes() ?>>
<?= $Page->lat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->long->Visible) { // long ?>
    <tr id="r_long"<?= $Page->long->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kordinat_jalan_long"><?= $Page->long->caption() ?></span></td>
        <td data-name="long"<?= $Page->long->cellAttributes() ?>>
<span id="el_kordinat_jalan_long">
<span<?= $Page->long->viewAttributes() ?>>
<?= $Page->long->getViewValue() ?></span>
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
