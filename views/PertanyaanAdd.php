<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$PertanyaanAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pertanyaan: currentTable } });
var currentForm, currentPageID;
var fpertanyaanadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpertanyaanadd = new ew.Form("fpertanyaanadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fpertanyaanadd;

    // Add fields
    var fields = currentTable.fields;
    fpertanyaanadd.addFields([
        ["pid", [fields.pid.visible && fields.pid.required ? ew.Validators.required(fields.pid.caption) : null], fields.pid.isInvalid],
        ["code", [fields.code.visible && fields.code.required ? ew.Validators.required(fields.code.caption) : null], fields.code.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["jawaban", [fields.jawaban.visible && fields.jawaban.required ? ew.Validators.required(fields.jawaban.caption) : null], fields.jawaban.isInvalid],
        ["file", [fields.file.visible && fields.file.required ? ew.Validators.fileRequired(fields.file.caption) : null], fields.file.isInvalid]
    ]);

    // Form_CustomValidate
    fpertanyaanadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpertanyaanadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fpertanyaanadd.lists.pid = <?= $Page->pid->toClientList($Page) ?>;
    loadjs.done("fpertanyaanadd");
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
<form name="fpertanyaanadd" id="fpertanyaanadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pertanyaan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->pid->Visible) { // pid ?>
    <div id="r_pid"<?= $Page->pid->rowAttributes() ?>>
        <label id="elh_pertanyaan_pid" for="x_pid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pid->caption() ?><?= $Page->pid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pid->cellAttributes() ?>>
<span id="el_pertanyaan_pid">
    <select
        id="x_pid"
        name="x_pid"
        class="form-select ew-select<?= $Page->pid->isInvalidClass() ?>"
        data-select2-id="fpertanyaanadd_x_pid"
        data-table="pertanyaan"
        data-field="x_pid"
        data-value-separator="<?= $Page->pid->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->pid->getPlaceHolder()) ?>"
        <?= $Page->pid->editAttributes() ?>>
        <?= $Page->pid->selectOptionListHtml("x_pid") ?>
    </select>
    <?= $Page->pid->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->pid->getErrorMessage() ?></div>
<?= $Page->pid->Lookup->getParamTag($Page, "p_x_pid") ?>
<script>
loadjs.ready("fpertanyaanadd", function() {
    var options = { name: "x_pid", selectId: "fpertanyaanadd_x_pid" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fpertanyaanadd.lists.pid.lookupOptions.length) {
        options.data = { id: "x_pid", form: "fpertanyaanadd" };
    } else {
        options.ajax = { id: "x_pid", form: "fpertanyaanadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.pertanyaan.fields.pid.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
    <div id="r_code"<?= $Page->code->rowAttributes() ?>>
        <label id="elh_pertanyaan_code" for="x_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->code->caption() ?><?= $Page->code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->code->cellAttributes() ?>>
<span id="el_pertanyaan_code">
<input type="<?= $Page->code->getInputTextType() ?>" name="x_code" id="x_code" data-table="pertanyaan" data-field="x_code" value="<?= $Page->code->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->code->getPlaceHolder()) ?>"<?= $Page->code->editAttributes() ?> aria-describedby="x_code_help">
<?= $Page->code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->code->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama"<?= $Page->nama->rowAttributes() ?>>
        <label id="elh_pertanyaan_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nama->cellAttributes() ?>>
<span id="el_pertanyaan_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" name="x_nama" id="x_nama" data-table="pertanyaan" data-field="x_nama" value="<?= $Page->nama->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jawaban->Visible) { // jawaban ?>
    <div id="r_jawaban"<?= $Page->jawaban->rowAttributes() ?>>
        <label id="elh_pertanyaan_jawaban" for="x_jawaban" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jawaban->caption() ?><?= $Page->jawaban->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->jawaban->cellAttributes() ?>>
<span id="el_pertanyaan_jawaban">
<textarea data-table="pertanyaan" data-field="x_jawaban" name="x_jawaban" id="x_jawaban" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->jawaban->getPlaceHolder()) ?>"<?= $Page->jawaban->editAttributes() ?> aria-describedby="x_jawaban_help"><?= $Page->jawaban->EditValue ?></textarea>
<?= $Page->jawaban->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jawaban->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->file->Visible) { // file ?>
    <div id="r_file"<?= $Page->file->rowAttributes() ?>>
        <label id="elh_pertanyaan_file" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file->caption() ?><?= $Page->file->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file->cellAttributes() ?>>
<span id="el_pertanyaan_file">
<div id="fd_x_file" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file->title() ?>" data-table="pertanyaan" data-field="x_file" name="x_file" id="x_file" lang="<?= CurrentLanguageID() ?>"<?= $Page->file->editAttributes() ?> aria-describedby="x_file_help"<?= ($Page->file->ReadOnly || $Page->file->Disabled) ? " disabled" : "" ?>>
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
    ew.addEventHandlers("pertanyaan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
