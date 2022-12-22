<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$ReportLogUserChatCodeSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { ReportLogUserChatCode: currentTable } });
var currentForm, currentPageID;
var fReportLogUserChatCodesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fReportLogUserChatCodesrch = new ew.Form("fReportLogUserChatCodesrch", "summary");
    currentSearchForm = fReportLogUserChatCodesrch;
    currentPageID = ew.PAGE_ID = "summary";

    // Add fields
    var fields = currentTable.fields;
    fReportLogUserChatCodesrch.addFields([
        ["pelapor_id", [], fields.pelapor_id.isInvalid],
        ["pesan", [], fields.pesan.isInvalid]
    ]);

    // Validate form
    fReportLogUserChatCodesrch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm();

        // Validate fields
        if (!this.validateFields())
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fReportLogUserChatCodesrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fReportLogUserChatCodesrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fReportLogUserChatCodesrch.lists.id = <?= $Page->id->toClientList($Page) ?>;
    fReportLogUserChatCodesrch.lists.pelapor_id = <?= $Page->pelapor_id->toClientList($Page) ?>;
    fReportLogUserChatCodesrch.lists.pesan = <?= $Page->pesan->toClientList($Page) ?>;
    fReportLogUserChatCodesrch.lists.tanggal = <?= $Page->tanggal->toClientList($Page) ?>;
    fReportLogUserChatCodesrch.lists.code = <?= $Page->code->toClientList($Page) ?>;

    // Filters
    fReportLogUserChatCodesrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fReportLogUserChatCodesrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<a id="top"></a>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Content Container -->
<div id="ew-report" class="ew-report container-fluid">
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<div class="btn-toolbar ew-toolbar">
<?php
if (!$Page->DrillDownInPanel) {
    $Page->ExportOptions->render("body");
    $Page->SearchOptions->render("body");
    $Page->FilterOptions->render("body");
}
?>
</div>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<div class="row">
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Center Container -->
<div id="ew-center" class="<?= $Page->CenterContentClass ?>">
<?php } ?>
<!-- Summary report (begin) -->
<div id="report_summary">
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fReportLogUserChatCodesrch" id="fReportLogUserChatCodesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fReportLogUserChatCodesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="ReportLogUserChatCode">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->id->Visible) { // id ?>
<?php
if (!$Page->id->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_id" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->id->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_id"
            name="x_id[]"
            class="form-control ew-select<?= $Page->id->isInvalidClass() ?>"
            data-select2-id="fReportLogUserChatCodesrch_x_id"
            data-table="ReportLogUserChatCode"
            data-field="x_id"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->id->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->id->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>"
            <?= $Page->id->editAttributes() ?>>
            <?= $Page->id->selectOptionListHtml("x_id", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fReportLogUserChatCodesrch", function() {
            var options = {
                name: "x_id",
                selectId: "fReportLogUserChatCodesrch_x_id",
                ajax: { id: "x_id", form: "fReportLogUserChatCodesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.ReportLogUserChatCode.fields.id.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->pelapor_id->Visible) { // pelapor_id ?>
<?php
if (!$Page->pelapor_id->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_pelapor_id" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->pelapor_id->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_pelapor_id"
            name="x_pelapor_id[]"
            class="form-control ew-select<?= $Page->pelapor_id->isInvalidClass() ?>"
            data-select2-id="fReportLogUserChatCodesrch_x_pelapor_id"
            data-table="ReportLogUserChatCode"
            data-field="x_pelapor_id"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->pelapor_id->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->pelapor_id->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->pelapor_id->getPlaceHolder()) ?>"
            <?= $Page->pelapor_id->editAttributes() ?>>
            <?= $Page->pelapor_id->selectOptionListHtml("x_pelapor_id", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->pelapor_id->getErrorMessage() ?></div>
        <?= $Page->pelapor_id->Lookup->getParamTag($Page, "p_x_pelapor_id") ?>
        <script>
        loadjs.ready("fReportLogUserChatCodesrch", function() {
            var options = {
                name: "x_pelapor_id",
                selectId: "fReportLogUserChatCodesrch_x_pelapor_id",
                ajax: { id: "x_pelapor_id", form: "fReportLogUserChatCodesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.ReportLogUserChatCode.fields.pelapor_id.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->pesan->Visible) { // pesan ?>
<?php
if (!$Page->pesan->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_pesan" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->pesan->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_pesan"
            name="x_pesan[]"
            class="form-control ew-select<?= $Page->pesan->isInvalidClass() ?>"
            data-select2-id="fReportLogUserChatCodesrch_x_pesan"
            data-table="ReportLogUserChatCode"
            data-field="x_pesan"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->pesan->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->pesan->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->pesan->getPlaceHolder()) ?>"
            <?= $Page->pesan->editAttributes() ?>>
            <?= $Page->pesan->selectOptionListHtml("x_pesan", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->pesan->getErrorMessage() ?></div>
        <?= $Page->pesan->Lookup->getParamTag($Page, "p_x_pesan") ?>
        <script>
        loadjs.ready("fReportLogUserChatCodesrch", function() {
            var options = {
                name: "x_pesan",
                selectId: "fReportLogUserChatCodesrch_x_pesan",
                ajax: { id: "x_pesan", form: "fReportLogUserChatCodesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.ReportLogUserChatCode.fields.pesan.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->tanggal->Visible) { // tanggal ?>
<?php
if (!$Page->tanggal->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_tanggal" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->tanggal->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_tanggal"
            name="x_tanggal[]"
            class="form-control ew-select<?= $Page->tanggal->isInvalidClass() ?>"
            data-select2-id="fReportLogUserChatCodesrch_x_tanggal"
            data-table="ReportLogUserChatCode"
            data-field="x_tanggal"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->tanggal->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->tanggal->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->tanggal->getPlaceHolder()) ?>"
            <?= $Page->tanggal->editAttributes() ?>>
            <?= $Page->tanggal->selectOptionListHtml("x_tanggal", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->tanggal->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fReportLogUserChatCodesrch", function() {
            var options = {
                name: "x_tanggal",
                selectId: "fReportLogUserChatCodesrch_x_tanggal",
                ajax: { id: "x_tanggal", form: "fReportLogUserChatCodesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.ReportLogUserChatCode.fields.tanggal.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->code->Visible) { // code ?>
<?php
if (!$Page->code->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_code" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->code->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_code"
            name="x_code[]"
            class="form-control ew-select<?= $Page->code->isInvalidClass() ?>"
            data-select2-id="fReportLogUserChatCodesrch_x_code"
            data-table="ReportLogUserChatCode"
            data-field="x_code"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->code->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->code->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->code->getPlaceHolder()) ?>"
            <?= $Page->code->editAttributes() ?>>
            <?= $Page->code->selectOptionListHtml("x_code", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->code->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fReportLogUserChatCodesrch", function() {
            var options = {
                name: "x_code",
                selectId: "fReportLogUserChatCodesrch_x_code",
                ajax: { id: "x_code", form: "fReportLogUserChatCodesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.ReportLogUserChatCode.fields.code.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->SearchColumnCount > 0) { ?>
   <div class="col-sm-auto mb-3">
       <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
   </div>
<?php } ?>
</div><!-- /.row -->
</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php } ?>
<?php
while ($Page->RecordCount < count($Page->DetailRecords) && $Page->RecordCount < $Page->DisplayGroups) {
?>
<?php
    // Show header
    if ($Page->ShowHeader) {
?>
<div class="<?php if (!$Page->isExport("word") && !$Page->isExport("excel")) { ?>card ew-card <?php } ?>ew-grid"<?= $Page->ReportTableStyle ?>>
<!-- Report grid (begin) -->
<div id="gmp_ReportLogUserChatCode" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="<?= $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->pelapor_id->Visible) { ?>
    <th data-name="pelapor_id" class="<?= $Page->pelapor_id->headerCellClass() ?>"><div class="ReportLogUserChatCode_pelapor_id"><?= $Page->renderFieldHeader($Page->pelapor_id) ?></div></th>
<?php } ?>
<?php if ($Page->pesan->Visible) { ?>
    <th data-name="pesan" class="<?= $Page->pesan->headerCellClass() ?>"><div class="ReportLogUserChatCode_pesan"><?= $Page->renderFieldHeader($Page->pesan) ?></div></th>
<?php } ?>
    </tr>
</thead>
<tbody>
<?php
        if ($Page->TotalGroups == 0) {
            break; // Show header only
        }
        $Page->ShowHeader = false;
    } // End show header
?>
<?php
    $Page->loadRowValues($Page->DetailRecords[$Page->RecordCount]);
    $Page->RecordCount++;
    $Page->RecordIndex++;
?>
<?php
        // Render detail row
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_DETAIL;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->pelapor_id->Visible) { ?>
        <td data-field="pelapor_id"<?= $Page->pelapor_id->cellAttributes() ?>>
<span<?= $Page->pelapor_id->viewAttributes() ?>>
<?= $Page->pelapor_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->pesan->Visible) { ?>
        <td data-field="pesan"<?= $Page->pesan->cellAttributes() ?>>
<span<?= $Page->pesan->viewAttributes() ?>>
<?= $Page->pesan->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
} // End while
?>
<?php if ($Page->TotalGroups > 0) { ?>
</tbody>
<tfoot>
<?php
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_TOTAL;
    $Page->RowTotalType = ROWTOTAL_GRAND;
    $Page->RowTotalSubType = ROWTOTAL_FOOTER;
    $Page->RowAttrs["class"] = "ew-rpt-grand-summary";
    $Page->renderRow();
?>
<?php if ($Page->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span></td></tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
<?php } ?>
</tfoot>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0)) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
</div>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?php } ?>
</div>
<!-- /#report-summary -->
<!-- Summary report (end) -->
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /#ew-center -->
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /.row -->
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Bottom Container -->
<div class="row">
    <div id="ew-bottom" class="<?= $Page->BottomContentClass ?>">
<?php } ?>
<?php
if (!$DashboardReport) {
    // Set up page break
    if (($Page->isExport("print") || $Page->isExport("pdf") || $Page->isExport("email") || $Page->isExport("excel") && Config("USE_PHPEXCEL") || $Page->isExport("word") && Config("USE_PHPWORD")) && $Page->ExportChartPageBreak) {
        // Page_Breaking server event
        $Page->pageBreaking($Page->ExportChartPageBreak, $Page->PageBreakContent);

        // Set up chart page break
        $Page->ChartCatatanPertanyaan->PageBreakType = "before"; // Page break type
        $Page->ChartCatatanPertanyaan->PageBreak = $Page->ExportChartPageBreak;
        $Page->ChartCatatanPertanyaan->PageBreakContent = $Page->PageBreakContent;
    }

    // Set up chart drilldown
    $Page->ChartCatatanPertanyaan->DrillDownInPanel = $Page->DrillDownInPanel;
    $Page->ChartCatatanPertanyaan->render("ew-chart-bottom");
}
?>
<?php if (!$DashboardReport && !$Page->isExport("email") && !$Page->DrillDown && $Page->ChartCatatanPertanyaan->hasData()) { ?>
<?php if (!$Page->isExport()) { ?>
<div class="mb-3"><a class="ew-top-link" data-ew-action="scroll-top"><?= $Language->phrase("Top") ?></a></div>
<?php } ?>
<?php } ?>
<?php
if (!$DashboardReport) {
    // Set up page break
    if (($Page->isExport("print") || $Page->isExport("pdf") || $Page->isExport("email") || $Page->isExport("excel") && Config("USE_PHPEXCEL") || $Page->isExport("word") && Config("USE_PHPWORD")) && $Page->ExportChartPageBreak) {
        // Page_Breaking server event
        $Page->pageBreaking($Page->ExportChartPageBreak, $Page->PageBreakContent);

        // Set up chart page break
        $Page->Chart1->PageBreakType = "before"; // Page break type
        $Page->Chart1->PageBreak = $Page->ExportChartPageBreak;
        $Page->Chart1->PageBreakContent = $Page->PageBreakContent;
    }

    // Set up chart drilldown
    $Page->Chart1->DrillDownInPanel = $Page->DrillDownInPanel;
    $Page->Chart1->render("ew-chart-bottom");
}
?>
<?php if (!$DashboardReport && !$Page->isExport("email") && !$Page->DrillDown && $Page->Chart1->hasData()) { ?>
<?php if (!$Page->isExport()) { ?>
<div class="mb-3"><a class="ew-top-link" data-ew-action="scroll-top"><?= $Language->phrase("Top") ?></a></div>
<?php } ?>
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
    </div>
</div>
<!-- /#ew-bottom -->
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /.ew-report -->
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
