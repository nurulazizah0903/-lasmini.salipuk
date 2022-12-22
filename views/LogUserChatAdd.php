<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$LogUserChatAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { log_user_chat: currentTable } });
var currentForm, currentPageID;
var flog_user_chatadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flog_user_chatadd = new ew.Form("flog_user_chatadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = flog_user_chatadd;

    // Add fields
    var fields = currentTable.fields;
    flog_user_chatadd.addFields([
        ["pelapor_id", [fields.pelapor_id.visible && fields.pelapor_id.required ? ew.Validators.required(fields.pelapor_id.caption) : null], fields.pelapor_id.isInvalid],
        ["pesan", [fields.pesan.visible && fields.pesan.required ? ew.Validators.required(fields.pesan.caption) : null], fields.pesan.isInvalid],
        ["tanggal", [fields.tanggal.visible && fields.tanggal.required ? ew.Validators.required(fields.tanggal.caption) : null, ew.Validators.datetime(fields.tanggal.clientFormatPattern)], fields.tanggal.isInvalid],
        ["code", [fields.code.visible && fields.code.required ? ew.Validators.required(fields.code.caption) : null], fields.code.isInvalid]
    ]);

    // Form_CustomValidate
    flog_user_chatadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    flog_user_chatadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    flog_user_chatadd.lists.pelapor_id = <?= $Page->pelapor_id->toClientList($Page) ?>;
    flog_user_chatadd.lists.pesan = <?= $Page->pesan->toClientList($Page) ?>;
    loadjs.done("flog_user_chatadd");
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
<form name="flog_user_chatadd" id="flog_user_chatadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="log_user_chat">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->pelapor_id->Visible) { // pelapor_id ?>
    <div id="r_pelapor_id"<?= $Page->pelapor_id->rowAttributes() ?>>
        <label id="elh_log_user_chat_pelapor_id" for="x_pelapor_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pelapor_id->caption() ?><?= $Page->pelapor_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pelapor_id->cellAttributes() ?>>
<span id="el_log_user_chat_pelapor_id">
    <select
        id="x_pelapor_id"
        name="x_pelapor_id"
        class="form-select ew-select<?= $Page->pelapor_id->isInvalidClass() ?>"
        data-select2-id="flog_user_chatadd_x_pelapor_id"
        data-table="log_user_chat"
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
loadjs.ready("flog_user_chatadd", function() {
    var options = { name: "x_pelapor_id", selectId: "flog_user_chatadd_x_pelapor_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (flog_user_chatadd.lists.pelapor_id.lookupOptions.length) {
        options.data = { id: "x_pelapor_id", form: "flog_user_chatadd" };
    } else {
        options.ajax = { id: "x_pelapor_id", form: "flog_user_chatadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.log_user_chat.fields.pelapor_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pesan->Visible) { // pesan ?>
    <div id="r_pesan"<?= $Page->pesan->rowAttributes() ?>>
        <label id="elh_log_user_chat_pesan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pesan->caption() ?><?= $Page->pesan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pesan->cellAttributes() ?>>
<span id="el_log_user_chat_pesan">
<?php
$onchange = $Page->pesan->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->pesan->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->pesan->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_pesan" class="ew-auto-suggest">
    <input type="<?= $Page->pesan->getInputTextType() ?>" class="form-control" name="sv_x_pesan" id="sv_x_pesan" value="<?= RemoveHtml($Page->pesan->EditValue) ?>" placeholder="<?= HtmlEncode($Page->pesan->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->pesan->getPlaceHolder()) ?>"<?= $Page->pesan->editAttributes() ?> aria-describedby="x_pesan_help">
</span>
<selection-list hidden class="form-control" data-table="log_user_chat" data-field="x_pesan" data-input="sv_x_pesan" data-value-separator="<?= $Page->pesan->displayValueSeparatorAttribute() ?>" name="x_pesan" id="x_pesan" value="<?= HtmlEncode($Page->pesan->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<?= $Page->pesan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pesan->getErrorMessage() ?></div>
<script>
loadjs.ready("flog_user_chatadd", function() {
    flog_user_chatadd.createAutoSuggest(Object.assign({"id":"x_pesan","forceSelect":false}, ew.vars.tables.log_user_chat.fields.pesan.autoSuggestOptions));
});
</script>
<?= $Page->pesan->Lookup->getParamTag($Page, "p_x_pesan") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
    <div id="r_tanggal"<?= $Page->tanggal->rowAttributes() ?>>
        <label id="elh_log_user_chat_tanggal" for="x_tanggal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal->caption() ?><?= $Page->tanggal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tanggal->cellAttributes() ?>>
<span id="el_log_user_chat_tanggal">
<input type="<?= $Page->tanggal->getInputTextType() ?>" name="x_tanggal" id="x_tanggal" data-table="log_user_chat" data-field="x_tanggal" value="<?= $Page->tanggal->EditValue ?>" placeholder="<?= HtmlEncode($Page->tanggal->getPlaceHolder()) ?>"<?= $Page->tanggal->editAttributes() ?> aria-describedby="x_tanggal_help">
<?= $Page->tanggal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal->getErrorMessage() ?></div>
<?php if (!$Page->tanggal->ReadOnly && !$Page->tanggal->Disabled && !isset($Page->tanggal->EditAttrs["readonly"]) && !isset($Page->tanggal->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["flog_user_chatadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(11) ?>",
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
    ew.createDateTimePicker("flog_user_chatadd", "x_tanggal", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
    <div id="r_code"<?= $Page->code->rowAttributes() ?>>
        <label id="elh_log_user_chat_code" for="x_code" class="<?= $Page->LeftColumnClass ?>"><?= $Page->code->caption() ?><?= $Page->code->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->code->cellAttributes() ?>>
<span id="el_log_user_chat_code">
<input type="<?= $Page->code->getInputTextType() ?>" name="x_code" id="x_code" data-table="log_user_chat" data-field="x_code" value="<?= $Page->code->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->code->getPlaceHolder()) ?>"<?= $Page->code->editAttributes() ?> aria-describedby="x_code_help">
<?= $Page->code->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->code->getErrorMessage() ?></div>
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
    ew.addEventHandlers("log_user_chat");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
