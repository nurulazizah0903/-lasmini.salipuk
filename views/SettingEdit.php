<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$SettingEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { setting: currentTable } });
var currentForm, currentPageID;
var fsettingedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsettingedit = new ew.Form("fsettingedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fsettingedit;

    // Add fields
    var fields = currentTable.fields;
    fsettingedit.addFields([
        ["_key", [fields._key.visible && fields._key.required ? ew.Validators.required(fields._key.caption) : null], fields._key.isInvalid],
        ["value", [fields.value.visible && fields.value.required ? ew.Validators.required(fields.value.caption) : null], fields.value.isInvalid]
    ]);

    // Form_CustomValidate
    fsettingedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsettingedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fsettingedit");
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
<form name="fsettingedit" id="fsettingedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="setting">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->_key->Visible) { // key ?>
    <div id="r__key"<?= $Page->_key->rowAttributes() ?>>
        <label id="elh_setting__key" for="x__key" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_key->caption() ?><?= $Page->_key->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_key->cellAttributes() ?>>
<span id="el_setting__key">
<input type="<?= $Page->_key->getInputTextType() ?>" name="x__key" id="x__key" data-table="setting" data-field="x__key" value="<?= $Page->_key->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_key->getPlaceHolder()) ?>"<?= $Page->_key->editAttributes() ?> aria-describedby="x__key_help">
<?= $Page->_key->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_key->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <div id="r_value"<?= $Page->value->rowAttributes() ?>>
        <label id="elh_setting_value" for="x_value" class="<?= $Page->LeftColumnClass ?>"><?= $Page->value->caption() ?><?= $Page->value->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->value->cellAttributes() ?>>
<span id="el_setting_value">
<textarea data-table="setting" data-field="x_value" name="x_value" id="x_value" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->value->getPlaceHolder()) ?>"<?= $Page->value->editAttributes() ?> aria-describedby="x_value_help"><?= $Page->value->EditValue ?></textarea>
<?= $Page->value->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->value->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="setting" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("setting");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
