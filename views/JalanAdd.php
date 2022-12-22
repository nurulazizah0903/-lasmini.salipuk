<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$JalanAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { jalan: currentTable } });
var currentForm, currentPageID;
var fjalanadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fjalanadd = new ew.Form("fjalanadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fjalanadd;

    // Add fields
    var fields = currentTable.fields;
    fjalanadd.addFields([
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["upt_id", [fields.upt_id.visible && fields.upt_id.required ? ew.Validators.required(fields.upt_id.caption) : null], fields.upt_id.isInvalid],
        ["file", [fields.file.visible && fields.file.required ? ew.Validators.fileRequired(fields.file.caption) : null], fields.file.isInvalid]
    ]);

    // Form_CustomValidate
    fjalanadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fjalanadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fjalanadd.lists.upt_id = <?= $Page->upt_id->toClientList($Page) ?>;
    loadjs.done("fjalanadd");
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
<form name="fjalanadd" id="fjalanadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="jalan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama"<?= $Page->nama->rowAttributes() ?>>
        <label id="elh_jalan_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nama->cellAttributes() ?>>
<span id="el_jalan_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" name="x_nama" id="x_nama" data-table="jalan" data-field="x_nama" value="<?= $Page->nama->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->upt_id->Visible) { // upt_id ?>
    <div id="r_upt_id"<?= $Page->upt_id->rowAttributes() ?>>
        <label id="elh_jalan_upt_id" for="x_upt_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->upt_id->caption() ?><?= $Page->upt_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->upt_id->cellAttributes() ?>>
<span id="el_jalan_upt_id">
    <select
        id="x_upt_id"
        name="x_upt_id"
        class="form-select ew-select<?= $Page->upt_id->isInvalidClass() ?>"
        data-select2-id="fjalanadd_x_upt_id"
        data-table="jalan"
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
loadjs.ready("fjalanadd", function() {
    var options = { name: "x_upt_id", selectId: "fjalanadd_x_upt_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fjalanadd.lists.upt_id.lookupOptions.length) {
        options.data = { id: "x_upt_id", form: "fjalanadd" };
    } else {
        options.ajax = { id: "x_upt_id", form: "fjalanadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.jalan.fields.upt_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->file->Visible) { // file ?>
    <div id="r_file"<?= $Page->file->rowAttributes() ?>>
        <label id="elh_jalan_file" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file->caption() ?><?= $Page->file->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file->cellAttributes() ?>>
<span id="el_jalan_file">
<div id="fd_x_file" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file->title() ?>" data-table="jalan" data-field="x_file" name="x_file" id="x_file" lang="<?= CurrentLanguageID() ?>"<?= $Page->file->editAttributes() ?> aria-describedby="x_file_help"<?= ($Page->file->ReadOnly || $Page->file->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->file->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->file->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_file" id= "fn_x_file" value="<?= $Page->file->Upload->FileName ?>">
<input type="hidden" name="fa_x_file" id= "fa_x_file" value="0">
<input type="hidden" name="fs_x_file" id= "fs_x_file" value="50">
<input type="hidden" name="fx_x_file" id= "fx_x_file" value="<?= $Page->file->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_file" id= "fm_x_file" value="<?= $Page->file->UploadMaxFileSize ?>">
<table id="ft_x_file" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
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
    ew.addEventHandlers("jalan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
