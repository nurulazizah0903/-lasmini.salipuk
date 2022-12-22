<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$BroadcastTujuanEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { broadcast_tujuan: currentTable } });
var currentForm, currentPageID;
var fbroadcast_tujuanedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbroadcast_tujuanedit = new ew.Form("fbroadcast_tujuanedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fbroadcast_tujuanedit;

    // Add fields
    var fields = currentTable.fields;
    fbroadcast_tujuanedit.addFields([
        ["pelapor_id", [fields.pelapor_id.visible && fields.pelapor_id.required ? ew.Validators.required(fields.pelapor_id.caption) : null], fields.pelapor_id.isInvalid],
        ["broadcast_id", [fields.broadcast_id.visible && fields.broadcast_id.required ? ew.Validators.required(fields.broadcast_id.caption) : null], fields.broadcast_id.isInvalid]
    ]);

    // Form_CustomValidate
    fbroadcast_tujuanedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbroadcast_tujuanedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fbroadcast_tujuanedit.lists.pelapor_id = <?= $Page->pelapor_id->toClientList($Page) ?>;
    fbroadcast_tujuanedit.lists.broadcast_id = <?= $Page->broadcast_id->toClientList($Page) ?>;
    loadjs.done("fbroadcast_tujuanedit");
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
<form name="fbroadcast_tujuanedit" id="fbroadcast_tujuanedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="broadcast_tujuan">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "broadcast") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="broadcast">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->broadcast_id->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->pelapor_id->Visible) { // pelapor_id ?>
    <div id="r_pelapor_id"<?= $Page->pelapor_id->rowAttributes() ?>>
        <label id="elh_broadcast_tujuan_pelapor_id" for="x_pelapor_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pelapor_id->caption() ?><?= $Page->pelapor_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pelapor_id->cellAttributes() ?>>
<span id="el_broadcast_tujuan_pelapor_id">
    <select
        id="x_pelapor_id"
        name="x_pelapor_id"
        class="form-select ew-select<?= $Page->pelapor_id->isInvalidClass() ?>"
        data-select2-id="fbroadcast_tujuanedit_x_pelapor_id"
        data-table="broadcast_tujuan"
        data-field="x_pelapor_id"
        data-value-separator="<?= $Page->pelapor_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->pelapor_id->getPlaceHolder()) ?>"
        <?= $Page->pelapor_id->editAttributes() ?>>
        <?= $Page->pelapor_id->selectOptionListHtml("x_pelapor_id") ?>
    </select>
    <?= $Page->pelapor_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->pelapor_id->getErrorMessage() ?></div>
<?= $Page->pelapor_id->Lookup->getParamTag($Page, "p_x_pelapor_id") ?>
<script>
loadjs.ready("fbroadcast_tujuanedit", function() {
    var options = { name: "x_pelapor_id", selectId: "fbroadcast_tujuanedit_x_pelapor_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbroadcast_tujuanedit.lists.pelapor_id.lookupOptions.length) {
        options.data = { id: "x_pelapor_id", form: "fbroadcast_tujuanedit" };
    } else {
        options.ajax = { id: "x_pelapor_id", form: "fbroadcast_tujuanedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.broadcast_tujuan.fields.pelapor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->broadcast_id->Visible) { // broadcast_id ?>
    <div id="r_broadcast_id"<?= $Page->broadcast_id->rowAttributes() ?>>
        <label id="elh_broadcast_tujuan_broadcast_id" for="x_broadcast_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->broadcast_id->caption() ?><?= $Page->broadcast_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->broadcast_id->cellAttributes() ?>>
<?php if ($Page->broadcast_id->getSessionValue() != "") { ?>
<span id="el_broadcast_tujuan_broadcast_id">
<span<?= $Page->broadcast_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->broadcast_id->getDisplayValue($Page->broadcast_id->ViewValue) ?></span></span>
</span>
<input type="hidden" id="x_broadcast_id" name="x_broadcast_id" value="<?= HtmlEncode(FormatNumber($Page->broadcast_id->CurrentValue, $Page->broadcast_id->formatPattern())) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_broadcast_tujuan_broadcast_id">
    <select
        id="x_broadcast_id"
        name="x_broadcast_id"
        class="form-select ew-select<?= $Page->broadcast_id->isInvalidClass() ?>"
        data-select2-id="fbroadcast_tujuanedit_x_broadcast_id"
        data-table="broadcast_tujuan"
        data-field="x_broadcast_id"
        data-value-separator="<?= $Page->broadcast_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->broadcast_id->getPlaceHolder()) ?>"
        <?= $Page->broadcast_id->editAttributes() ?>>
        <?= $Page->broadcast_id->selectOptionListHtml("x_broadcast_id") ?>
    </select>
    <?= $Page->broadcast_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->broadcast_id->getErrorMessage() ?></div>
<?= $Page->broadcast_id->Lookup->getParamTag($Page, "p_x_broadcast_id") ?>
<script>
loadjs.ready("fbroadcast_tujuanedit", function() {
    var options = { name: "x_broadcast_id", selectId: "fbroadcast_tujuanedit_x_broadcast_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fbroadcast_tujuanedit.lists.broadcast_id.lookupOptions.length) {
        options.data = { id: "x_broadcast_id", form: "fbroadcast_tujuanedit" };
    } else {
        options.ajax = { id: "x_broadcast_id", form: "fbroadcast_tujuanedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.broadcast_tujuan.fields.broadcast_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="broadcast_tujuan" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .row -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("broadcast_tujuan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
