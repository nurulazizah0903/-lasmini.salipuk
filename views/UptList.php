<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$UptList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { upt: currentTable } });
var currentForm, currentPageID;
var fuptlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuptlist = new ew.Form("fuptlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fuptlist;
    fuptlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fuptlist");
});
var fuptsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fuptsrch = new ew.Form("fuptsrch", "list");
    currentSearchForm = fuptsrch;

    // Dynamic selection lists

    // Filters
    fuptsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fuptsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fuptsrch" id="fuptsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fuptsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="upt">
<div class="ew-extended-search container-fluid">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fuptsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fuptsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fuptsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fuptsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> upt">
<form name="fuptlist" id="fuptlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="upt">
<div id="gmp_upt" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_uptlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Page->nama->headerCellClass() ?>"><div id="elh_upt_nama" class="upt_nama"><?= $Page->renderFieldHeader($Page->nama) ?></div></th>
<?php } ?>
<?php if ($Page->nama_pic->Visible) { // nama_pic ?>
        <th data-name="nama_pic" class="<?= $Page->nama_pic->headerCellClass() ?>"><div id="elh_upt_nama_pic" class="upt_nama_pic"><?= $Page->renderFieldHeader($Page->nama_pic) ?></div></th>
<?php } ?>
<?php if ($Page->nip_pic->Visible) { // nip_pic ?>
        <th data-name="nip_pic" class="<?= $Page->nip_pic->headerCellClass() ?>"><div id="elh_upt_nip_pic" class="upt_nip_pic"><?= $Page->renderFieldHeader($Page->nip_pic) ?></div></th>
<?php } ?>
<?php if ($Page->jabatan_pic->Visible) { // jabatan_pic ?>
        <th data-name="jabatan_pic" class="<?= $Page->jabatan_pic->headerCellClass() ?>"><div id="elh_upt_jabatan_pic" class="upt_jabatan_pic"><?= $Page->renderFieldHeader($Page->jabatan_pic) ?></div></th>
<?php } ?>
<?php if ($Page->no_hp_pic->Visible) { // no_hp_pic ?>
        <th data-name="no_hp_pic" class="<?= $Page->no_hp_pic->headerCellClass() ?>"><div id="elh_upt_no_hp_pic" class="upt_no_hp_pic"><?= $Page->renderFieldHeader($Page->no_hp_pic) ?></div></th>
<?php } ?>
<?php if ($Page->email_pic->Visible) { // email_pic ?>
        <th data-name="email_pic" class="<?= $Page->email_pic->headerCellClass() ?>"><div id="elh_upt_email_pic" class="upt_email_pic"><?= $Page->renderFieldHeader($Page->email_pic) ?></div></th>
<?php } ?>
<?php if ($Page->file->Visible) { // file ?>
        <th data-name="file" class="<?= $Page->file->headerCellClass() ?>"><div id="elh_upt_file" class="upt_file"><?= $Page->renderFieldHeader($Page->file) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif ($Page->isGridAdd() && !$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row attributes
        $Page->RowAttrs->merge([
            "data-rowindex" => $Page->RowCount,
            "id" => "r" . $Page->RowCount . "_upt",
            "data-rowtype" => $Page->RowType,
            "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Page->isAdd() && $Page->RowType == ROWTYPE_ADD || $Page->isEdit() && $Page->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Page->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->nama->Visible) { // nama ?>
        <td data-name="nama"<?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_upt_nama" class="el_upt_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama_pic->Visible) { // nama_pic ?>
        <td data-name="nama_pic"<?= $Page->nama_pic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_upt_nama_pic" class="el_upt_nama_pic">
<span<?= $Page->nama_pic->viewAttributes() ?>>
<?= $Page->nama_pic->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nip_pic->Visible) { // nip_pic ?>
        <td data-name="nip_pic"<?= $Page->nip_pic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_upt_nip_pic" class="el_upt_nip_pic">
<span<?= $Page->nip_pic->viewAttributes() ?>>
<?= $Page->nip_pic->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jabatan_pic->Visible) { // jabatan_pic ?>
        <td data-name="jabatan_pic"<?= $Page->jabatan_pic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_upt_jabatan_pic" class="el_upt_jabatan_pic">
<span<?= $Page->jabatan_pic->viewAttributes() ?>>
<?= $Page->jabatan_pic->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->no_hp_pic->Visible) { // no_hp_pic ?>
        <td data-name="no_hp_pic"<?= $Page->no_hp_pic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_upt_no_hp_pic" class="el_upt_no_hp_pic">
<span<?= $Page->no_hp_pic->viewAttributes() ?>>
<?= $Page->no_hp_pic->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->email_pic->Visible) { // email_pic ?>
        <td data-name="email_pic"<?= $Page->email_pic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_upt_email_pic" class="el_upt_email_pic">
<span<?= $Page->email_pic->viewAttributes() ?>>
<?= $Page->email_pic->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->file->Visible) { // file ?>
        <td data-name="file"<?= $Page->file->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_upt_file" class="el_upt_file">
<span<?= $Page->file->viewAttributes() ?>>
<?= GetFileViewTag($Page->file, $Page->file->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
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
<?php } ?>
