<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$BroadcastAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { broadcast: currentTable } });
var currentForm, currentPageID;
var fbroadcastadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fbroadcastadd = new ew.Form("fbroadcastadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fbroadcastadd;

    // Add fields
    var fields = currentTable.fields;
    fbroadcastadd.addFields([
        ["start_date", [fields.start_date.visible && fields.start_date.required ? ew.Validators.required(fields.start_date.caption) : null, ew.Validators.datetime(fields.start_date.clientFormatPattern)], fields.start_date.isInvalid],
        ["text", [fields.text.visible && fields.text.required ? ew.Validators.required(fields.text.caption) : null], fields.text.isInvalid],
        ["file", [fields.file.visible && fields.file.required ? ew.Validators.fileRequired(fields.file.caption) : null], fields.file.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid]
    ]);

    // Form_CustomValidate
    fbroadcastadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fbroadcastadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fbroadcastadd");
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
<form name="fbroadcastadd" id="fbroadcastadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="broadcast">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->start_date->Visible) { // start_date ?>
    <div id="r_start_date"<?= $Page->start_date->rowAttributes() ?>>
        <label id="elh_broadcast_start_date" for="x_start_date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->start_date->caption() ?><?= $Page->start_date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->start_date->cellAttributes() ?>>
<span id="el_broadcast_start_date">
<input type="<?= $Page->start_date->getInputTextType() ?>" name="x_start_date" id="x_start_date" data-table="broadcast" data-field="x_start_date" value="<?= $Page->start_date->EditValue ?>" placeholder="<?= HtmlEncode($Page->start_date->getPlaceHolder()) ?>"<?= $Page->start_date->editAttributes() ?> aria-describedby="x_start_date_help">
<?= $Page->start_date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->start_date->getErrorMessage() ?></div>
<?php if (!$Page->start_date->ReadOnly && !$Page->start_date->Disabled && !isset($Page->start_date->EditAttrs["readonly"]) && !isset($Page->start_date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fbroadcastadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(9) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID
            },
            display: {
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                icons: {
                    previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                    next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
                }
            },
            meta: {
                format,
                numberingSystem: ew.getNumberingSystem()
            }
        };
    ew.createDateTimePicker("fbroadcastadd", "x_start_date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->text->Visible) { // text ?>
    <div id="r_text"<?= $Page->text->rowAttributes() ?>>
        <label id="elh_broadcast_text" for="x_text" class="<?= $Page->LeftColumnClass ?>"><?= $Page->text->caption() ?><?= $Page->text->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->text->cellAttributes() ?>>
<span id="el_broadcast_text">
<textarea data-table="broadcast" data-field="x_text" name="x_text" id="x_text" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->text->getPlaceHolder()) ?>"<?= $Page->text->editAttributes() ?> aria-describedby="x_text_help"><?= $Page->text->EditValue ?></textarea>
<?= $Page->text->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->text->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->file->Visible) { // file ?>
    <div id="r_file"<?= $Page->file->rowAttributes() ?>>
        <label id="elh_broadcast_file" class="<?= $Page->LeftColumnClass ?>"><?= $Page->file->caption() ?><?= $Page->file->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->file->cellAttributes() ?>>
<span id="el_broadcast_file">
<div id="fd_x_file" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->file->title() ?>" data-table="broadcast" data-field="x_file" name="x_file" id="x_file" lang="<?= CurrentLanguageID() ?>"<?= $Page->file->editAttributes() ?> aria-describedby="x_file_help"<?= ($Page->file->ReadOnly || $Page->file->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->file->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->file->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_file" id= "fn_x_file" value="<?= $Page->file->Upload->FileName ?>">
<input type="hidden" name="fa_x_file" id= "fa_x_file" value="0">
<input type="hidden" name="fs_x_file" id= "fs_x_file" value="-1">
<input type="hidden" name="fx_x_file" id= "fx_x_file" value="<?= $Page->file->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_file" id= "fm_x_file" value="<?= $Page->file->UploadMaxFileSize ?>">
<table id="ft_x_file" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_broadcast_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_broadcast_status">
<input type="<?= $Page->status->getInputTextType() ?>" name="x_status" id="x_status" data-table="broadcast" data-field="x_status" value="<?= $Page->status->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"<?= $Page->status->editAttributes() ?> aria-describedby="x_status_help">
<?= $Page->status->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("broadcast_tujuan", explode(",", $Page->getCurrentDetailTable())) && $broadcast_tujuan->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("broadcast_tujuan", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "BroadcastTujuanGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("broadcast");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
