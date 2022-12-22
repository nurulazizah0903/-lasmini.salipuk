<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$SettingView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { setting: currentTable } });
var currentForm, currentPageID;
var fsettingview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsettingview = new ew.Form("fsettingview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fsettingview;
    loadjs.done("fsettingview");
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
<form name="fsettingview" id="fsettingview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="setting">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->_key->Visible) { // key ?>
    <tr id="r__key"<?= $Page->_key->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_setting__key"><?= $Page->_key->caption() ?></span></td>
        <td data-name="_key"<?= $Page->_key->cellAttributes() ?>>
<span id="el_setting__key">
<span<?= $Page->_key->viewAttributes() ?>>
<?= $Page->_key->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <tr id="r_value"<?= $Page->value->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_setting_value"><?= $Page->value->caption() ?></span></td>
        <td data-name="value"<?= $Page->value->cellAttributes() ?>>
<span id="el_setting_value">
<span<?= $Page->value->viewAttributes() ?>>
<?= $Page->value->getViewValue() ?></span>
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
