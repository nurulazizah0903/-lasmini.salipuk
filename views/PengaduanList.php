<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$PengaduanList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { pengaduan: currentTable } });
var currentForm, currentPageID;
var fpengaduanlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fpengaduanlist = new ew.Form("fpengaduanlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fpengaduanlist;
    fpengaduanlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fpengaduanlist");
});
var fpengaduansrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fpengaduansrch = new ew.Form("fpengaduansrch", "list");
    currentSearchForm = fpengaduansrch;

    // Dynamic selection lists

    // Filters
    fpengaduansrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fpengaduansrch");
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
<form name="fpengaduansrch" id="fpengaduansrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fpengaduansrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pengaduan">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fpengaduansrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fpengaduansrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fpengaduansrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fpengaduansrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> pengaduan">
<form name="fpengaduanlist" id="fpengaduanlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pengaduan">
<div id="gmp_pengaduan" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_pengaduanlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->pelapor_id->Visible) { // pelapor_id ?>
        <th data-name="pelapor_id" class="<?= $Page->pelapor_id->headerCellClass() ?>"><div id="elh_pengaduan_pelapor_id" class="pengaduan_pelapor_id"><?= $Page->renderFieldHeader($Page->pelapor_id) ?></div></th>
<?php } ?>
<?php if ($Page->jalan_id->Visible) { // jalan_id ?>
        <th data-name="jalan_id" class="<?= $Page->jalan_id->headerCellClass() ?>"><div id="elh_pengaduan_jalan_id" class="pengaduan_jalan_id"><?= $Page->renderFieldHeader($Page->jalan_id) ?></div></th>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <th data-name="foto" class="<?= $Page->foto->headerCellClass() ?>"><div id="elh_pengaduan_foto" class="pengaduan_foto"><?= $Page->renderFieldHeader($Page->foto) ?></div></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th data-name="keterangan" class="<?= $Page->keterangan->headerCellClass() ?>"><div id="elh_pengaduan_keterangan" class="pengaduan_keterangan"><?= $Page->renderFieldHeader($Page->keterangan) ?></div></th>
<?php } ?>
<?php if ($Page->_token->Visible) { // token ?>
        <th data-name="_token" class="<?= $Page->_token->headerCellClass() ?>"><div id="elh_pengaduan__token" class="pengaduan__token"><?= $Page->renderFieldHeader($Page->_token) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_pengaduan_status" class="pengaduan_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->waktu->Visible) { // waktu ?>
        <th data-name="waktu" class="<?= $Page->waktu->headerCellClass() ?>"><div id="elh_pengaduan_waktu" class="pengaduan_waktu"><?= $Page->renderFieldHeader($Page->waktu) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_pengaduan",
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
    <?php if ($Page->pelapor_id->Visible) { // pelapor_id ?>
        <td data-name="pelapor_id"<?= $Page->pelapor_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengaduan_pelapor_id" class="el_pengaduan_pelapor_id">
<span<?= $Page->pelapor_id->viewAttributes() ?>>
<?= $Page->pelapor_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jalan_id->Visible) { // jalan_id ?>
        <td data-name="jalan_id"<?= $Page->jalan_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengaduan_jalan_id" class="el_pengaduan_jalan_id">
<span<?= $Page->jalan_id->viewAttributes() ?>>
<?= $Page->jalan_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->foto->Visible) { // foto ?>
        <td data-name="foto"<?= $Page->foto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengaduan_foto" class="el_pengaduan_foto">
<span><img src="<?= CurrentPage()->foto->CurrentValue; ?>" />
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan"<?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengaduan_keterangan" class="el_pengaduan_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_token->Visible) { // token ?>
        <td data-name="_token"<?= $Page->_token->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengaduan__token" class="el_pengaduan__token">
<span<?= $Page->_token->viewAttributes() ?>>
<?= $Page->_token->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengaduan_status" class="el_pengaduan_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->waktu->Visible) { // waktu ?>
        <td data-name="waktu"<?= $Page->waktu->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengaduan_waktu" class="el_pengaduan_waktu">
<span<?= $Page->waktu->viewAttributes() ?>>
<?= $Page->waktu->getViewValue() ?></span>
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
    ew.addEventHandlers("pengaduan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
