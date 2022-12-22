<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$LogUserChatView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_user_chat: currentTable } });
var currentForm, currentPageID;
var flog_user_chatview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_user_chatview = new ew.Form("flog_user_chatview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = flog_user_chatview;
    loadjs.done("flog_user_chatview");
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
<form name="flog_user_chatview" id="flog_user_chatview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_user_chat">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->pelapor_id->Visible) { // pelapor_id ?>
    <tr id="r_pelapor_id"<?= $Page->pelapor_id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_user_chat_pelapor_id"><?= $Page->pelapor_id->caption() ?></span></td>
        <td data-name="pelapor_id"<?= $Page->pelapor_id->cellAttributes() ?>>
<span id="el_log_user_chat_pelapor_id">
<span<?= $Page->pelapor_id->viewAttributes() ?>>
<?= $Page->pelapor_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pesan->Visible) { // pesan ?>
    <tr id="r_pesan"<?= $Page->pesan->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_user_chat_pesan"><?= $Page->pesan->caption() ?></span></td>
        <td data-name="pesan"<?= $Page->pesan->cellAttributes() ?>>
<span id="el_log_user_chat_pesan">
<span<?= $Page->pesan->viewAttributes() ?>>
<?= $Page->pesan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <tr id="r_tanggal"<?= $Page->tanggal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_user_chat_tanggal"><?= $Page->tanggal->caption() ?></span></td>
        <td data-name="tanggal"<?= $Page->tanggal->cellAttributes() ?>>
<span id="el_log_user_chat_tanggal">
<span<?= $Page->tanggal->viewAttributes() ?>>
<?= $Page->tanggal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
    <tr id="r_code"<?= $Page->code->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_log_user_chat_code"><?= $Page->code->caption() ?></span></td>
        <td data-name="code"<?= $Page->code->cellAttributes() ?>>
<span id="el_log_user_chat_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
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
