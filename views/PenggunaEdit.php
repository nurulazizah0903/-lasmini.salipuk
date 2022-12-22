<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$PenggunaEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pengguna: currentTable } });
var currentForm, currentPageID;
var fpenggunaedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpenggunaedit = new ew.Form("fpenggunaedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fpenggunaedit;

    // Add fields
    var fields = currentTable.fields;
    fpenggunaedit.addFields([
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
        ["_password", [fields._password.visible && fields._password.required ? ew.Validators.required(fields._password.caption) : null], fields._password.isInvalid],
        ["upt_id", [fields.upt_id.visible && fields.upt_id.required ? ew.Validators.required(fields.upt_id.caption) : null], fields.upt_id.isInvalid],
        ["level", [fields.level.visible && fields.level.required ? ew.Validators.required(fields.level.caption) : null], fields.level.isInvalid]
    ]);

    // Form_CustomValidate
    fpenggunaedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpenggunaedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fpenggunaedit.lists.upt_id = <?= $Page->upt_id->toClientList($Page) ?>;
    fpenggunaedit.lists.level = <?= $Page->level->toClientList($Page) ?>;
    loadjs.done("fpenggunaedit");
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
<form name="fpenggunaedit" id="fpenggunaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pengguna">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama"<?= $Page->nama->rowAttributes() ?>>
        <label id="elh_pengguna_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nama->cellAttributes() ?>>
<span id="el_pengguna_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" name="x_nama" id="x_nama" data-table="pengguna" data-field="x_nama" value="<?= $Page->nama->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <div id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <label id="elh_pengguna__username" for="x__username" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_username->caption() ?><?= $Page->_username->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_username->cellAttributes() ?>>
<span id="el_pengguna__username">
<input type="<?= $Page->_username->getInputTextType() ?>" name="x__username" id="x__username" data-table="pengguna" data-field="x__username" value="<?= $Page->_username->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_username->getPlaceHolder()) ?>"<?= $Page->_username->editAttributes() ?> aria-describedby="x__username_help">
<?= $Page->_username->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_username->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r__password"<?= $Page->_password->rowAttributes() ?>>
        <label id="elh_pengguna__password" for="x__password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_password->caption() ?><?= $Page->_password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_password->cellAttributes() ?>>
<span id="el_pengguna__password">
<input type="<?= $Page->_password->getInputTextType() ?>" name="x__password" id="x__password" data-table="pengguna" data-field="x__password" value="<?= $Page->_password->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
<?= $Page->_password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->upt_id->Visible) { // upt_id ?>
    <div id="r_upt_id"<?= $Page->upt_id->rowAttributes() ?>>
        <label id="elh_pengguna_upt_id" for="x_upt_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->upt_id->caption() ?><?= $Page->upt_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->upt_id->cellAttributes() ?>>
<span id="el_pengguna_upt_id">
    <select
        id="x_upt_id"
        name="x_upt_id"
        class="form-select ew-select<?= $Page->upt_id->isInvalidClass() ?>"
        data-select2-id="fpenggunaedit_x_upt_id"
        data-table="pengguna"
        data-field="x_upt_id"
        data-value-separator="<?= $Page->upt_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->upt_id->getPlaceHolder()) ?>"
        <?= $Page->upt_id->editAttributes() ?>>
        <?= $Page->upt_id->selectOptionListHtml("x_upt_id") ?>
    </select>
    <?= $Page->upt_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->upt_id->getErrorMessage() ?></div>
<?= $Page->upt_id->Lookup->getParamTag($Page, "p_x_upt_id") ?>
<script>
loadjs.ready("fpenggunaedit", function() {
    var options = { name: "x_upt_id", selectId: "fpenggunaedit_x_upt_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fpenggunaedit.lists.upt_id.lookupOptions.length) {
        options.data = { id: "x_upt_id", form: "fpenggunaedit" };
    } else {
        options.ajax = { id: "x_upt_id", form: "fpenggunaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.pengguna.fields.upt_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->level->Visible) { // level ?>
    <div id="r_level"<?= $Page->level->rowAttributes() ?>>
        <label id="elh_pengguna_level" for="x_level" class="<?= $Page->LeftColumnClass ?>"><?= $Page->level->caption() ?><?= $Page->level->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->level->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_pengguna_level">
<span class="form-control-plaintext"><?= $Page->level->getDisplayValue($Page->level->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el_pengguna_level">
    <select
        id="x_level"
        name="x_level"
        class="form-select ew-select<?= $Page->level->isInvalidClass() ?>"
        data-select2-id="fpenggunaedit_x_level"
        data-table="pengguna"
        data-field="x_level"
        data-value-separator="<?= $Page->level->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->level->getPlaceHolder()) ?>"
        <?= $Page->level->editAttributes() ?>>
        <?= $Page->level->selectOptionListHtml("x_level") ?>
    </select>
    <?= $Page->level->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->level->getErrorMessage() ?></div>
<?= $Page->level->Lookup->getParamTag($Page, "p_x_level") ?>
<script>
loadjs.ready("fpenggunaedit", function() {
    var options = { name: "x_level", selectId: "fpenggunaedit_x_level" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fpenggunaedit.lists.level.lookupOptions.length) {
        options.data = { id: "x_level", form: "fpenggunaedit" };
    } else {
        options.ajax = { id: "x_level", form: "fpenggunaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.pengguna.fields.level.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="pengguna" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("pengguna");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
