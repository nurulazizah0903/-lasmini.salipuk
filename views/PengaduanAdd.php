<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$PengaduanAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pengaduan: currentTable } });
var currentForm, currentPageID;
var fpengaduanadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpengaduanadd = new ew.Form("fpengaduanadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fpengaduanadd;

    // Add fields
    var fields = currentTable.fields;
    fpengaduanadd.addFields([
        ["pelapor_id", [fields.pelapor_id.visible && fields.pelapor_id.required ? ew.Validators.required(fields.pelapor_id.caption) : null], fields.pelapor_id.isInvalid],
        ["jalan_id", [fields.jalan_id.visible && fields.jalan_id.required ? ew.Validators.required(fields.jalan_id.caption) : null], fields.jalan_id.isInvalid],
        ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.required(fields.foto.caption) : null], fields.foto.isInvalid],
        ["kordinat", [fields.kordinat.visible && fields.kordinat.required ? ew.Validators.required(fields.kordinat.caption) : null], fields.kordinat.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["_token", [fields._token.visible && fields._token.required ? ew.Validators.required(fields._token.caption) : null], fields._token.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["waktu", [fields.waktu.visible && fields.waktu.required ? ew.Validators.required(fields.waktu.caption) : null, ew.Validators.datetime(fields.waktu.clientFormatPattern)], fields.waktu.isInvalid]
    ]);

    // Form_CustomValidate
    fpengaduanadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpengaduanadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fpengaduanadd.lists.pelapor_id = <?= $Page->pelapor_id->toClientList($Page) ?>;
    fpengaduanadd.lists.jalan_id = <?= $Page->jalan_id->toClientList($Page) ?>;
    fpengaduanadd.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("fpengaduanadd");
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
<form name="fpengaduanadd" id="fpengaduanadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pengaduan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->pelapor_id->Visible) { // pelapor_id ?>
    <div id="r_pelapor_id"<?= $Page->pelapor_id->rowAttributes() ?>>
        <label id="elh_pengaduan_pelapor_id" for="x_pelapor_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pelapor_id->caption() ?><?= $Page->pelapor_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pelapor_id->cellAttributes() ?>>
<span id="el_pengaduan_pelapor_id">
    <select
        id="x_pelapor_id"
        name="x_pelapor_id"
        class="form-select ew-select<?= $Page->pelapor_id->isInvalidClass() ?>"
        data-select2-id="fpengaduanadd_x_pelapor_id"
        data-table="pengaduan"
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
loadjs.ready("fpengaduanadd", function() {
    var options = { name: "x_pelapor_id", selectId: "fpengaduanadd_x_pelapor_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fpengaduanadd.lists.pelapor_id.lookupOptions.length) {
        options.data = { id: "x_pelapor_id", form: "fpengaduanadd" };
    } else {
        options.ajax = { id: "x_pelapor_id", form: "fpengaduanadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.pengaduan.fields.pelapor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jalan_id->Visible) { // jalan_id ?>
    <div id="r_jalan_id"<?= $Page->jalan_id->rowAttributes() ?>>
        <label id="elh_pengaduan_jalan_id" for="x_jalan_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jalan_id->caption() ?><?= $Page->jalan_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->jalan_id->cellAttributes() ?>>
<span id="el_pengaduan_jalan_id">
    <select
        id="x_jalan_id"
        name="x_jalan_id"
        class="form-select ew-select<?= $Page->jalan_id->isInvalidClass() ?>"
        data-select2-id="fpengaduanadd_x_jalan_id"
        data-table="pengaduan"
        data-field="x_jalan_id"
        data-value-separator="<?= $Page->jalan_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->jalan_id->getPlaceHolder()) ?>"
        <?= $Page->jalan_id->editAttributes() ?>>
        <?= $Page->jalan_id->selectOptionListHtml("x_jalan_id") ?>
    </select>
    <?= $Page->jalan_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->jalan_id->getErrorMessage() ?></div>
<?= $Page->jalan_id->Lookup->getParamTag($Page, "p_x_jalan_id") ?>
<script>
loadjs.ready("fpengaduanadd", function() {
    var options = { name: "x_jalan_id", selectId: "fpengaduanadd_x_jalan_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fpengaduanadd.lists.jalan_id.lookupOptions.length) {
        options.data = { id: "x_jalan_id", form: "fpengaduanadd" };
    } else {
        options.ajax = { id: "x_jalan_id", form: "fpengaduanadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.pengaduan.fields.jalan_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto"<?= $Page->foto->rowAttributes() ?>>
        <label id="elh_pengaduan_foto" for="x_foto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->foto->caption() ?><?= $Page->foto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->foto->cellAttributes() ?>>
<span id="el_pengaduan_foto">
<textarea data-table="pengaduan" data-field="x_foto" name="x_foto" id="x_foto" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->foto->getPlaceHolder()) ?>"<?= $Page->foto->editAttributes() ?> aria-describedby="x_foto_help"><?= $Page->foto->EditValue ?></textarea>
<?= $Page->foto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->foto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kordinat->Visible) { // kordinat ?>
    <div id="r_kordinat"<?= $Page->kordinat->rowAttributes() ?>>
        <label id="elh_pengaduan_kordinat" for="x_kordinat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kordinat->caption() ?><?= $Page->kordinat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->kordinat->cellAttributes() ?>>
<span id="el_pengaduan_kordinat">
<textarea data-table="pengaduan" data-field="x_kordinat" name="x_kordinat" id="x_kordinat" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->kordinat->getPlaceHolder()) ?>"<?= $Page->kordinat->editAttributes() ?> aria-describedby="x_kordinat_help"><?= $Page->kordinat->EditValue ?></textarea>
<?= $Page->kordinat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kordinat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan"<?= $Page->keterangan->rowAttributes() ?>>
        <label id="elh_pengaduan_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->keterangan->cellAttributes() ?>>
<span id="el_pengaduan_keterangan">
<textarea data-table="pengaduan" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_token->Visible) { // token ?>
    <div id="r__token"<?= $Page->_token->rowAttributes() ?>>
        <label id="elh_pengaduan__token" for="x__token" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_token->caption() ?><?= $Page->_token->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_token->cellAttributes() ?>>
<span id="el_pengaduan__token">
<textarea data-table="pengaduan" data-field="x__token" name="x__token" id="x__token" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->_token->getPlaceHolder()) ?>"<?= $Page->_token->editAttributes() ?> aria-describedby="x__token_help"><?= $Page->_token->EditValue ?></textarea>
<?= $Page->_token->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_token->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_pengaduan_status" for="x_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<span id="el_pengaduan_status">
    <select
        id="x_status"
        name="x_status"
        class="form-select ew-select<?= $Page->status->isInvalidClass() ?>"
        data-select2-id="fpengaduanadd_x_status"
        data-table="pengaduan"
        data-field="x_status"
        data-value-separator="<?= $Page->status->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->status->getPlaceHolder()) ?>"
        <?= $Page->status->editAttributes() ?>>
        <?= $Page->status->selectOptionListHtml("x_status") ?>
    </select>
    <?= $Page->status->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->status->getErrorMessage() ?></div>
<script>
loadjs.ready("fpengaduanadd", function() {
    var options = { name: "x_status", selectId: "fpengaduanadd_x_status" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fpengaduanadd.lists.status.lookupOptions.length) {
        options.data = { id: "x_status", form: "fpengaduanadd" };
    } else {
        options.ajax = { id: "x_status", form: "fpengaduanadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.pengaduan.fields.status.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->waktu->Visible) { // waktu ?>
    <div id="r_waktu"<?= $Page->waktu->rowAttributes() ?>>
        <label id="elh_pengaduan_waktu" for="x_waktu" class="<?= $Page->LeftColumnClass ?>"><?= $Page->waktu->caption() ?><?= $Page->waktu->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->waktu->cellAttributes() ?>>
<span id="el_pengaduan_waktu">
<input type="<?= $Page->waktu->getInputTextType() ?>" name="x_waktu" id="x_waktu" data-table="pengaduan" data-field="x_waktu" value="<?= $Page->waktu->EditValue ?>" placeholder="<?= HtmlEncode($Page->waktu->getPlaceHolder()) ?>"<?= $Page->waktu->editAttributes() ?> aria-describedby="x_waktu_help">
<?= $Page->waktu->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->waktu->getErrorMessage() ?></div>
<?php if (!$Page->waktu->ReadOnly && !$Page->waktu->Disabled && !isset($Page->waktu->EditAttrs["readonly"]) && !isset($Page->waktu->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpengaduanadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(1) ?>",
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
    ew.createDateTimePicker("fpengaduanadd", "x_waktu", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
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
    ew.addEventHandlers("pengaduan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
