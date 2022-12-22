<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$LogUserChatDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_user_chat: currentTable } });
var currentForm, currentPageID;
var flog_user_chatdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_user_chatdelete = new ew.Form("flog_user_chatdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = flog_user_chatdelete;
    loadjs.done("flog_user_chatdelete");
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
<form name="flog_user_chatdelete" id="flog_user_chatdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_user_chat">
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
<?php if ($Page->pelapor_id->Visible) { // pelapor_id ?>
        <th class="<?= $Page->pelapor_id->headerCellClass() ?>"><span id="elh_log_user_chat_pelapor_id" class="log_user_chat_pelapor_id"><?= $Page->pelapor_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pesan->Visible) { // pesan ?>
        <th class="<?= $Page->pesan->headerCellClass() ?>"><span id="elh_log_user_chat_pesan" class="log_user_chat_pesan"><?= $Page->pesan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
        <th class="<?= $Page->tanggal->headerCellClass() ?>"><span id="elh_log_user_chat_tanggal" class="log_user_chat_tanggal"><?= $Page->tanggal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
        <th class="<?= $Page->code->headerCellClass() ?>"><span id="elh_log_user_chat_code" class="log_user_chat_code"><?= $Page->code->caption() ?></span></th>
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
<?php if ($Page->pelapor_id->Visible) { // pelapor_id ?>
        <td<?= $Page->pelapor_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_user_chat_pelapor_id" class="el_log_user_chat_pelapor_id">
<span<?= $Page->pelapor_id->viewAttributes() ?>>
<?= $Page->pelapor_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pesan->Visible) { // pesan ?>
        <td<?= $Page->pesan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_user_chat_pesan" class="el_log_user_chat_pesan">
<span<?= $Page->pesan->viewAttributes() ?>>
<?= $Page->pesan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
        <td<?= $Page->tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_user_chat_tanggal" class="el_log_user_chat_tanggal">
<span<?= $Page->tanggal->viewAttributes() ?>>
<?= $Page->tanggal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
        <td<?= $Page->code->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_log_user_chat_code" class="el_log_user_chat_code">
<span<?= $Page->code->viewAttributes() ?>>
<?= $Page->code->getViewValue() ?></span>
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
