<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$BroadcastView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { broadcast: currentTable } });
var currentForm, currentPageID;
var fbroadcastview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbroadcastview = new ew.Form("fbroadcastview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fbroadcastview;
    loadjs.done("fbroadcastview");
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
<form name="fbroadcastview" id="fbroadcastview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="broadcast">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->start_date->Visible) { // start_date ?>
    <tr id="r_start_date"<?= $Page->start_date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_broadcast_start_date"><?= $Page->start_date->caption() ?></span></td>
        <td data-name="start_date"<?= $Page->start_date->cellAttributes() ?>>
<span id="el_broadcast_start_date">
<span<?= $Page->start_date->viewAttributes() ?>>
<?= $Page->start_date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->text->Visible) { // text ?>
    <tr id="r_text"<?= $Page->text->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_broadcast_text"><?= $Page->text->caption() ?></span></td>
        <td data-name="text"<?= $Page->text->cellAttributes() ?>>
<span id="el_broadcast_text">
<span<?= $Page->text->viewAttributes() ?>>
<?= $Page->text->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->file->Visible) { // file ?>
    <tr id="r_file"<?= $Page->file->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_broadcast_file"><?= $Page->file->caption() ?></span></td>
        <td data-name="file"<?= $Page->file->cellAttributes() ?>>
<span id="el_broadcast_file">
<span<?= $Page->file->viewAttributes() ?>>
<?= GetFileViewTag($Page->file, $Page->file->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_broadcast_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_broadcast_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("broadcast_tujuan", explode(",", $Page->getCurrentDetailTable())) && $broadcast_tujuan->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("broadcast_tujuan", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "BroadcastTujuanGrid.php" ?>
<?php } ?>
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
