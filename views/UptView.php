<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$UptView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { upt: currentTable } });
var currentForm, currentPageID;
var fuptview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuptview = new ew.Form("fuptview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fuptview;
    loadjs.done("fuptview");
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
<form name="fuptview" id="fuptview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="upt">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama"<?= $Page->nama->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_upt_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama"<?= $Page->nama->cellAttributes() ?>>
<span id="el_upt_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama_pic->Visible) { // nama_pic ?>
    <tr id="r_nama_pic"<?= $Page->nama_pic->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_upt_nama_pic"><?= $Page->nama_pic->caption() ?></span></td>
        <td data-name="nama_pic"<?= $Page->nama_pic->cellAttributes() ?>>
<span id="el_upt_nama_pic">
<span<?= $Page->nama_pic->viewAttributes() ?>>
<?= $Page->nama_pic->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nip_pic->Visible) { // nip_pic ?>
    <tr id="r_nip_pic"<?= $Page->nip_pic->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_upt_nip_pic"><?= $Page->nip_pic->caption() ?></span></td>
        <td data-name="nip_pic"<?= $Page->nip_pic->cellAttributes() ?>>
<span id="el_upt_nip_pic">
<span<?= $Page->nip_pic->viewAttributes() ?>>
<?= $Page->nip_pic->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jabatan_pic->Visible) { // jabatan_pic ?>
    <tr id="r_jabatan_pic"<?= $Page->jabatan_pic->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_upt_jabatan_pic"><?= $Page->jabatan_pic->caption() ?></span></td>
        <td data-name="jabatan_pic"<?= $Page->jabatan_pic->cellAttributes() ?>>
<span id="el_upt_jabatan_pic">
<span<?= $Page->jabatan_pic->viewAttributes() ?>>
<?= $Page->jabatan_pic->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->no_hp_pic->Visible) { // no_hp_pic ?>
    <tr id="r_no_hp_pic"<?= $Page->no_hp_pic->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_upt_no_hp_pic"><?= $Page->no_hp_pic->caption() ?></span></td>
        <td data-name="no_hp_pic"<?= $Page->no_hp_pic->cellAttributes() ?>>
<span id="el_upt_no_hp_pic">
<span<?= $Page->no_hp_pic->viewAttributes() ?>>
<?= $Page->no_hp_pic->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->email_pic->Visible) { // email_pic ?>
    <tr id="r_email_pic"<?= $Page->email_pic->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_upt_email_pic"><?= $Page->email_pic->caption() ?></span></td>
        <td data-name="email_pic"<?= $Page->email_pic->cellAttributes() ?>>
<span id="el_upt_email_pic">
<span<?= $Page->email_pic->viewAttributes() ?>>
<?= $Page->email_pic->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->file->Visible) { // file ?>
    <tr id="r_file"<?= $Page->file->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_upt_file"><?= $Page->file->caption() ?></span></td>
        <td data-name="file"<?= $Page->file->cellAttributes() ?>>
<span id="el_upt_file">
<span<?= $Page->file->viewAttributes() ?>>
<?= GetFileViewTag($Page->file, $Page->file->getViewValue(), false) ?>
</span>
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
