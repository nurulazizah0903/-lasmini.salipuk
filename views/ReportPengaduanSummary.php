<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$ReportPengaduanSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { ReportPengaduan: currentTable } });
var currentForm, currentPageID;
var fReportPengaduansrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fReportPengaduansrch = new ew.Form("fReportPengaduansrch", "summary");
    currentSearchForm = fReportPengaduansrch;
    currentPageID = ew.PAGE_ID = "summary";

    // Add fields
    var fields = currentTable.fields;
    fReportPengaduansrch.addFields([
        ["pelapor_id", [], fields.pelapor_id.isInvalid],
        ["jalan_id", [], fields.jalan_id.isInvalid],
        ["waktu", [], fields.waktu.isInvalid]
    ]);

    // Validate form
    fReportPengaduansrch.validate = function () {
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
    fReportPengaduansrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fReportPengaduansrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fReportPengaduansrch.lists.jalan_id = <?= $Page->jalan_id->toClientList($Page) ?>;

    // Filters
    fReportPengaduansrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fReportPengaduansrch");
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
<form name="fReportPengaduansrch" id="fReportPengaduansrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fReportPengaduansrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="ReportPengaduan">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->jalan_id->Visible) { // jalan_id ?>
<?php
if (!$Page->jalan_id->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_jalan_id" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->jalan_id->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_jalan_id"
            name="x_jalan_id[]"
            class="form-control ew-select<?= $Page->jalan_id->isInvalidClass() ?>"
            data-select2-id="fReportPengaduansrch_x_jalan_id"
            data-table="ReportPengaduan"
            data-field="x_jalan_id"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->jalan_id->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->jalan_id->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->jalan_id->getPlaceHolder()) ?>"
            <?= $Page->jalan_id->editAttributes() ?>>
            <?= $Page->jalan_id->selectOptionListHtml("x_jalan_id", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->jalan_id->getErrorMessage() ?></div>
        <?= $Page->jalan_id->Lookup->getParamTag($Page, "p_x_jalan_id") ?>
        <script>
        loadjs.ready("fReportPengaduansrch", function() {
            var options = {
                name: "x_jalan_id",
                selectId: "fReportPengaduansrch_x_jalan_id",
                ajax: { id: "x_jalan_id", form: "fReportPengaduansrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.ReportPengaduan.fields.jalan_id.filterOptions);
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
        $Page->ChartJumlahPengaduanHarian->PageBreakType = ""; // Page break type
        $Page->ChartJumlahPengaduanHarian->PageBreak = $Page->ExportChartPageBreak;
        $Page->ChartJumlahPengaduanHarian->PageBreakContent = $Page->PageBreakContent;
    }

    // Set up chart drilldown
    $Page->ChartJumlahPengaduanHarian->DrillDownInPanel = $Page->DrillDownInPanel;
    $Page->ChartJumlahPengaduanHarian->render("ew-chart-top");
}
?>
<?php if (!$DashboardReport && !$Page->isExport("email") && !$Page->DrillDown && $Page->ChartJumlahPengaduanHarian->hasData()) { ?>
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
        $Page->ChartJumlahJalanPengaduan->PageBreakType = "before"; // Page break type
        $Page->ChartJumlahJalanPengaduan->PageBreak = $Page->ExportChartPageBreak;
        $Page->ChartJumlahJalanPengaduan->PageBreakContent = $Page->PageBreakContent;
    }

    // Set up chart drilldown
    $Page->ChartJumlahJalanPengaduan->DrillDownInPanel = $Page->DrillDownInPanel;
    $Page->ChartJumlahJalanPengaduan->render("ew-chart-bottom");
}
?>
<?php if (!$DashboardReport && !$Page->isExport("email") && !$Page->DrillDown && $Page->ChartJumlahJalanPengaduan->hasData()) { ?>
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
