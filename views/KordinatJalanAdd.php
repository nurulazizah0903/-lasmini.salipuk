<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$KordinatJalanAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { kordinat_jalan: currentTable } });
var currentForm, currentPageID;
var fkordinat_jalanadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fkordinat_jalanadd = new ew.Form("fkordinat_jalanadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fkordinat_jalanadd;

    // Add fields
    var fields = currentTable.fields;
    fkordinat_jalanadd.addFields([
        ["jalan_id", [fields.jalan_id.visible && fields.jalan_id.required ? ew.Validators.required(fields.jalan_id.caption) : null, ew.Validators.integer], fields.jalan_id.isInvalid],
        ["lat", [fields.lat.visible && fields.lat.required ? ew.Validators.required(fields.lat.caption) : null], fields.lat.isInvalid],
        ["long", [fields.long.visible && fields.long.required ? ew.Validators.required(fields.long.caption) : null], fields.long.isInvalid]
    ]);

    // Form_CustomValidate
    fkordinat_jalanadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fkordinat_jalanadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fkordinat_jalanadd");
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
<form name="fkordinat_jalanadd" id="fkordinat_jalanadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kordinat_jalan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->jalan_id->Visible) { // jalan_id ?>
    <div id="r_jalan_id"<?= $Page->jalan_id->rowAttributes() ?>>
        <label id="elh_kordinat_jalan_jalan_id" for="x_jalan_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jalan_id->caption() ?><?= $Page->jalan_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->jalan_id->cellAttributes() ?>>
<span id="el_kordinat_jalan_jalan_id">
<input type="<?= $Page->jalan_id->getInputTextType() ?>" name="x_jalan_id" id="x_jalan_id" data-table="kordinat_jalan" data-field="x_jalan_id" value="<?= $Page->jalan_id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->jalan_id->getPlaceHolder()) ?>"<?= $Page->jalan_id->editAttributes() ?> aria-describedby="x_jalan_id_help">
<?= $Page->jalan_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jalan_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lat->Visible) { // lat ?>
    <div id="r_lat"<?= $Page->lat->rowAttributes() ?>>
        <label id="elh_kordinat_jalan_lat" for="x_lat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lat->caption() ?><?= $Page->lat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lat->cellAttributes() ?>>
<span id="el_kordinat_jalan_lat">
<input type="<?= $Page->lat->getInputTextType() ?>" name="x_lat" id="x_lat" data-table="kordinat_jalan" data-field="x_lat" value="<?= $Page->lat->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->lat->getPlaceHolder()) ?>"<?= $Page->lat->editAttributes() ?> aria-describedby="x_lat_help">
<?= $Page->lat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->long->Visible) { // long ?>
    <div id="r_long"<?= $Page->long->rowAttributes() ?>>
        <label id="elh_kordinat_jalan_long" for="x_long" class="<?= $Page->LeftColumnClass ?>"><?= $Page->long->caption() ?><?= $Page->long->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->long->cellAttributes() ?>>
<span id="el_kordinat_jalan_long">
<input type="<?= $Page->long->getInputTextType() ?>" name="x_long" id="x_long" data-table="kordinat_jalan" data-field="x_long" value="<?= $Page->long->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->long->getPlaceHolder()) ?>"<?= $Page->long->editAttributes() ?> aria-describedby="x_long_help">
<?= $Page->long->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->long->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
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
    ew.addEventHandlers("kordinat_jalan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
