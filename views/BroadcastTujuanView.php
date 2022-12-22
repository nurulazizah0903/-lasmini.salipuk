<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$BroadcastTujuanView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { broadcast_tujuan: currentTable } });
var currentForm, currentPageID;
var fbroadcast_tujuanview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbroadcast_tujuanview = new ew.Form("fbroadcast_tujuanview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fbroadcast_tujuanview;
    loadjs.done("fbroadcast_tujuanview");
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
<form name="fbroadcast_tujuanview" id="fbroadcast_tujuanview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="broadcast_tujuan">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->pelapor_id->Visible) { // pelapor_id ?>
    <tr id="r_pelapor_id"<?= $Page->pelapor_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_broadcast_tujuan_pelapor_id"><?= $Page->pelapor_id->caption() ?></span></td>
        <td data-name="pelapor_id"<?= $Page->pelapor_id->cellAttributes() ?>>
<span id="el_broadcast_tujuan_pelapor_id">
<span<?= $Page->pelapor_id->viewAttributes() ?>>
<?= $Page->pelapor_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->broadcast_id->Visible) { // broadcast_id ?>
    <tr id="r_broadcast_id"<?= $Page->broadcast_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_broadcast_tujuan_broadcast_id"><?= $Page->broadcast_id->caption() ?></span></td>
        <td data-name="broadcast_id"<?= $Page->broadcast_id->cellAttributes() ?>>
<span id="el_broadcast_tujuan_broadcast_id">
<span<?= $Page->broadcast_id->viewAttributes() ?>>
<?= $Page->broadcast_id->getViewValue() ?></span>
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
