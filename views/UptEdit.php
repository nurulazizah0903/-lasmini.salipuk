<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$UptEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { upt: currentTable } });
var currentForm, currentPageID;
var fuptedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuptedit = new ew.Form("fuptedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fuptedit;

    // Add fields
    var fields = currentTable.fields;
    fuptedit.addFields([
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["nama_pic", [fields.nama_pic.visible && fields.nama_pic.required ? ew.Validators.required(fields.nama_pic.caption) : null], fields.nama_pic.isInvalid],
        ["nip_pic", [fields.nip_pic.visible && fields.nip_pic.required ? ew.Validators.required(fields.nip_pic.caption) : null], fields.nip_pic.isInvalid],
        ["jabatan_pic", [fields.jabatan_pic.visible && fields.jabatan_pic.required ? ew.Validators.required(fields.jabatan_pic.caption) : null], fields.jabatan_pic.isInvalid],
        ["no_hp_pic", [fields.no_hp_pic.visible && fields.no_hp_pic.required ? ew.Validators.required(fields.no_hp_pic.caption) : null], fields.no_hp_pic.isInvalid],
        ["email_pic", [fields.email_pic.visible && fields.email_pic.required ? ew.Validators.required(fields.email_pic.caption) : null], fields.email_pic.isInvalid],
        ["file", [fields.file.visible && fields.file.required ? ew.Validators.fileRequired(fields.file.caption) : null], fields.file.isInvalid]
    ]);

    // Form_CustomValidate
    fuptedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fuptedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fuptedit");
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
<form name="fuptedit" id="fuptedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="upt">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama"<?= $Page->nama->rowAttributes() ?>>
        <label id="elh_upt_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nama->cellAttributes() ?>>
<span id="el_upt_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" name="x_nama" id="x_nama" data-table="upt" data-field="x_nama" value="<?= $Page->nama->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama_pic->Visible) { // nama_pic ?>
    <div id="r_nama_pic"<?= $Page->nama_pic->rowAttributes() ?>>
        <label id="elh_upt_nama_pic" for="x_nama_pic" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_pic->caption() ?><?= $Page->nama_pic->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nama_pic->cellAttributes() ?>>
<span id="el_upt_nama_pic">
<input type="<?= $Page->nama_pic->getInputTextType() ?>" name="x_nama_pic" id="x_nama_pic" data-table="upt" data-field="x_nama_pic" value="<?= $Page->nama_pic->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nama_pic->getPlaceHolder()) ?>"<?= $Page->nama_pic->editAttributes() ?> aria-describedby="x_nama_pic_help">
<?= $Page->nama_pic->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_pic->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nip_pic->Visible) { // nip_pic ?>
    <div id="r_nip_pic"<?= $Page->nip_pic->rowAttributes() ?>>
        <label id="elh_upt_nip_pic" for="x_nip_pic" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nip_pic->caption() ?><?= $Page->nip_pic->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nip_pic->cellAttributes() ?>>
<span id="el_upt_nip_pic">
<input type="<?= $Page->nip_pic->getInputTextType() ?>" name="x_nip_pic" id="x_nip_pic" data-table="upt" data-field="x_nip_pic" value="<?= $Page->nip_pic->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nip_pic->getPlaceHolder()) ?>"<?= $Page->nip_pic->editAttributes() ?> aria-describedby="x_nip_pic_help">
<?= $Page->nip_pic->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nip_pic->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jabatan_pic->Visible) { // jabatan_pic ?>
    <div id="r_jabatan_pic"<?= $Page->jabatan_pic->rowAttributes() ?>>
        <label id="elh_upt_jabatan_pic" for="x_jabatan_pic" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jabatan_pic->caption() ?><?= $Page->jabatan_pic->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->jabatan_pic->cellAttributes() ?>>
<span id="el_upt_jabatan_pic">
<input type="<?= $Page->jabatan_pic->getInputTextType() ?>" name="x_jabatan_pic" id="x_jabatan_pic" data-table="upt" data-field="x_jabatan_pic" value="<?= $Page->jabatan_pic->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->jabatan_pic->getPlaceHolder()) ?>"<?= $Page->jabatan_pic->editAttributes() ?> aria-describedby="x_jabatan_pic_help">
<?= $Page->jabatan_pic->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jabatan_pic->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_hp_pic->Visible) { // no_hp_pic ?>
    <div id="r_no_hp_pic"<?= $Page->no_hp_pic->rowAttributes() ?>>
        <label id="elh_upt_no_hp_pic" for="x_no_hp_pic" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no_hp_pic->caption() ?><?= $Page->no_hp_pic->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->no_hp_pic->cellAttributes() ?>>
<span id="el_upt_no_hp_pic">
<input type="<?= $Page->no_hp_pic->getInputTextType() ?>" name="x_no_hp_pic" id="x_no_hp_pic" data-table="upt" data-field="x_no_hp_pic" value="<?= $Page->no_hp_pic->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->no_hp_pic->getPlaceHolder()) ?>"<?= $Page->no_hp_pic->editAttributes() ?> aria-describedby="x_no_hp_pic_help">
<?= $Page->no_hp_pic->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_hp_pic->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->email_pic->Visible) { // email_pic ?>
    <div id="r_email_pic"<?= $Page->email_pic->rowAttributes() ?>>
        <label id="elh_upt_email_pic" for="x_email_pic" class="<?= $Page->LeftColumnClass ?>"><?= $Page->email_pic->caption() ?><?= $Page->email_pic->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->email_pic->cellAttributes() ?>>
<span id="el_upt_email_pic">
<input type="<?= $Page->email_pic->getInputTextType() ?>" name="x_email_pic" id="x_email_pic" data-table="upt" data-field="x_email_pic" value="<?= $Page->email_pic->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->email_pic->getPlaceHolder()) ?>"<?= $Page->email_pic->editAttributes() ?> aria-describedby="x_email_pic_help">
<?= $Page->email_pic->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->email_pic->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->file->Visible) { // file ?>
    <div id="r_file"<?= $Page->file->rowAttributes() ?>>
        <label id="elh_upt_file" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file->caption() ?><?= $Page->file->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file->cellAttributes() ?>>
<span id="el_upt_file">
<div id="fd_x_file" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file->title() ?>" data-table="upt" data-field="x_file" name="x_file" id="x_file" lang="<?= CurrentLanguageID() ?>"<?= $Page->file->editAttributes() ?> aria-describedby="x_file_help"<?= ($Page->file->ReadOnly || $Page->file->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->file->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->file->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_file" id= "fn_x_file" value="<?= $Page->file->Upload->FileName ?>">
<input type="hidden" name="fa_x_file" id= "fa_x_file" value="<?= (Post("fa_x_file") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_file" id= "fs_x_file" value="50">
<input type="hidden" name="fx_x_file" id= "fx_x_file" value="<?= $Page->file->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_file" id= "fm_x_file" value="<?= $Page->file->UploadMaxFileSize ?>">
<table id="ft_x_file" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="upt" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("upt");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
