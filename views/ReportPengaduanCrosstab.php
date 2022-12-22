<?php namespace PHPMaker2022\pubinamarga; ?>
<?php

namespace PHPMaker2022\pubinamarga;

// Page object
$ReportPengaduanCrosstab = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { ReportPengaduan: currentTable } });
var currentForm, currentPageID;
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
<!-- Crosstab report (begin) -->
<div id="report_crosstab">
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<?php } ?>
<?php
while ($Page->GroupCount <= count($Page->GroupRecords) && $Page->GroupCount <= $Page->DisplayGroups) {
?>
<?php
    // Show header
    if ($Page->ShowHeader) {
?>
<?php if ($Page->GroupCount > 1) { ?>
</tbody>
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
<?= $Page->PageBreakContent ?>
<?php } ?>
<div class="<?php if (!$Page->isExport("word") && !$Page->isExport("excel")) { ?>card ew-card <?php } ?>ew-grid"<?= $Page->ReportTableStyle ?>>
<!-- Report grid (begin) -->
<div id="gmp_ReportPengaduan" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="<?= $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td class="ew-rpt-col-summary" colspan="<?= $Page->GroupColumnCount ?>"><div><?= $Page->renderSummaryCaptions() ?></div></td>
<?php } ?>
        <td class="ew-rpt-col-header" colspan="<?= @$Page->ColumnSpan ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->_token->caption() ?></span>
            </div>
        </td>
    </tr>
    <tr class="ew-table-header">
<?php if ($Page->pelapor_id->Visible) { ?>
    <td data-field="pelapor_id"><div><?= $Page->renderFieldHeader($Page->pelapor_id) ?></div></td>
<?php } ?>
<?php if ($Page->jalan_id->Visible) { ?>
    <td data-field="jalan_id"><div><?= $Page->renderFieldHeader($Page->jalan_id) ?></div></td>
<?php } ?>
<?php if ($Page->status->Visible) { ?>
    <td data-field="status"><div><?= $Page->renderFieldHeader($Page->status) ?></div></td>
<?php } ?>
<!-- Dynamic columns begin -->
<?php
    $cntval = count($Page->Columns);
    for ($iy = 1; $iy < $cntval; $iy++) {
        if ($Page->Columns[$iy]->Visible) {
            $Page->SummaryCurrentValues[$iy - 1] = $Page->Columns[$iy]->Caption;
            $Page->SummaryViewValues[$iy - 1] = $Page->SummaryCurrentValues[$iy - 1];
?>
        <td class="ew-table-header"<?= $Page->_token->cellAttributes() ?>><div<?= $Page->_token->viewAttributes() ?>><?= $Page->SummaryViewValues[$iy-1]; ?></div></td>
<?php
        }
    }
?>
<!-- Dynamic columns end -->
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

    // Build detail SQL
    $where = DetailFilterSql($Page->pelapor_id, $Page->getSqlFirstGroupField(), $Page->pelapor_id->groupValue(), $Page->Dbid);
    if ($Page->PageFirstGroupFilter != "") {
        $Page->PageFirstGroupFilter .= " OR ";
    }
    $Page->PageFirstGroupFilter .= $where;
    if ($Page->Filter != "") {
        $where = "($Page->Filter) AND ($where)";
    }
    $sql = $Page->buildReportSql($Page->getSqlSelect()->addSelect($Page->DistinctColumnFields), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), "", $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->execute();
    $Page->DetailRecords = $rs ? $rs->fetchAll() : [];
    $Page->DetailRecordCount = count($Page->DetailRecords);

    // Load detail records
    $Page->pelapor_id->Records = &$Page->DetailRecords;
    $Page->pelapor_id->LevelBreak = true; // Set field level break
    $Page->jalan_id->getDistinctValues($Page->pelapor_id->Records);
    foreach ($Page->jalan_id->DistinctValues as $jalan_id) { // Load records for this distinct value
        $Page->jalan_id->setGroupValue($jalan_id); // Set group value
        $Page->jalan_id->getDistinctRecords($Page->pelapor_id->Records, $Page->jalan_id->groupValue());
        $Page->jalan_id->LevelBreak = true; // Set field level break
    $Page->status->getDistinctValues($Page->jalan_id->Records);
    foreach ($Page->status->DistinctValues as $status) { // Load records for this distinct value
        $Page->status->setGroupValue($status); // Set group value
        $Page->status->getDistinctRecords($Page->jalan_id->Records, $Page->status->groupValue());
        $Page->status->LevelBreak = true; // Set field level break
        foreach ($Page->status->Records as $record) {
            $Page->RecordCount++;
            $Page->RecordIndex++;
            $Page->loadRowValues($record);

            // Render row
            $Page->resetAttributes();
            $Page->RowType = ROWTYPE_DETAIL;
            $Page->renderRow();
?>
	<tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->pelapor_id->Visible) { ?>
        <!-- pelapor_id -->
        <td data-field="pelapor_id"<?= $Page->pelapor_id->cellAttributes() ?>><span<?= $Page->pelapor_id->viewAttributes() ?>><?= $Page->pelapor_id->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->jalan_id->Visible) { ?>
        <!-- jalan_id -->
        <td data-field="jalan_id"<?= $Page->jalan_id->cellAttributes() ?>><span<?= $Page->jalan_id->viewAttributes() ?>><?= $Page->jalan_id->GroupViewValue ?></span></td>
<?php } ?>
<?php if ($Page->status->Visible) { ?>
        <!-- status -->
        <td data-field="status"<?= $Page->status->cellAttributes() ?>><span<?= $Page->status->viewAttributes() ?>><?= $Page->status->GroupViewValue ?></span></td>
<?php } ?>
<!-- Dynamic columns begin -->
<?php
        $cntcol = count($Page->SummaryViewValues);
        for ($iy = 1; $iy <= $cntcol; $iy++) {
            $colShow = ($iy <= $Page->ColumnCount) ? $Page->Columns[$iy]->Visible : true;
            $colDesc = ($iy <= $Page->ColumnCount) ? $Page->Columns[$iy]->Caption : $Language->phrase("Summary");
            if ($colShow) {
?>
        <!-- <?= $colDesc; ?> -->
        <td<?= $Page->summaryCellAttributes($iy-1) ?>><?= $Page->renderSummaryFields($iy-1) ?></td>
<?php
            }
        }
?>
<!-- Dynamic columns end -->
    </tr>
<?php
    }
    } // End group level 2
    } // End group level 1
?>
<?php

    // Next group
    $Page->loadGroupRowValues();

    // Show header if page break
    if ($Page->isExport()) {
        $Page->ShowHeader = ($Page->ExportPageBreakCount == 0) ? false : ($Page->GroupCount % $Page->ExportPageBreakCount == 0);
    }

    // Page_Breaking server event
    if ($Page->ShowHeader) {
        $Page->pageBreaking($Page->ShowHeader, $Page->PageBreakContent);
    }
    $Page->GroupCount++;
} // End while
?>
<?php if ($Page->TotalGroups > 0) { ?>
</tbody>
<tfoot>
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
<!-- /#report-crosstab -->
<!-- Crosstab report (end) -->
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /#ew-center -->
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /.row -->
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
