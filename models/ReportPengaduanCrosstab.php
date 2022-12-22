<?php

namespace PHPMaker2022\pubinamarga;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class ReportPengaduanCrosstab extends ReportPengaduan
{
    use MessagesTrait;

    // Page ID
    public $PageID = "crosstab";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'Report Pengaduan';

    // Page object name
    public $PageObjName = "ReportPengaduanCrosstab";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS
    public $ReportTableClass = "";
    public $ReportTableStyle = "";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = $route->getArguments();
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        $url = rtrim(UrlFor($route->getName(), $args), "/") . "?";
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (ReportPengaduan)
        if (!isset($GLOBALS["ReportPengaduan"]) || get_class($GLOBALS["ReportPengaduan"]) == PROJECT_NAMESPACE . "ReportPengaduan") {
            $GLOBALS["ReportPengaduan"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'Report Pengaduan');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // Export options
        $this->ExportOptions = new ListOptions(["TagClassName" => "ew-export-option"]);

        // Filter options
        $this->FilterOptions = new ListOptions(["TagClassName" => "ew-filter-option"]);
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->isExport() && !$this->isExport("print")) {
            $class = PROJECT_NAMESPACE . Config("REPORT_EXPORT_CLASSES." . $this->Export);
            if (class_exists($class)) {
                $content = $this->getContents();
                $doc = new $class();
                $doc($this, $content);
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection if not in dashboard
        if (!$DashboardReport) {
            CloseConnections();
        }

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Lookup data
    public function lookup($ar = null)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $ar["field"] ?? Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;
        if (in_array($lookup->LinkTable, [$this->ReportSourceTable, $this->TableVar])) {
            $lookup->RenderViewFunc = "renderLookup"; // Set up view renderer
        }
        $lookup->RenderEditFunc = ""; // Set up edit renderer

        // Get lookup parameters
        $lookupType = $ar["ajax"] ?? Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $ar["q"] ?? Param("q") ?? $ar["sv"] ?? Post("sv", "");
            $pageSize = $ar["n"] ?? Param("n") ?? $ar["recperpage"] ?? Post("recperpage", 10);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $ar["q"] ?? Param("q", "");
            $pageSize = $ar["n"] ?? Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $ar["start"] ?? Param("start", -1);
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $ar["page"] ?? Param("page", -1);
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($ar["s"] ?? Post("s", ""));
        $userFilter = Decrypt($ar["f"] ?? Post("f", ""));
        $userOrderBy = Decrypt($ar["o"] ?? Post("o", ""));
        $keys = $ar["keys"] ?? Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $ar["v0"] ?? $ar["lookupValue"] ?? Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $ar["v" . $i] ?? Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, !is_array($ar)); // Use settings from current page
    }

    // Options
    public $HideOptions = false;
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $FilterOptions; // Filter options

    // Records
    public $GroupRecords = [];
    public $DetailRecords = [];
    public $DetailRecordCount = 0;

    // Paging variables
    public $RecordIndex = 0; // Record index
    public $RecordCount = 0; // Record count (start from 1 for each group)
    public $StartGroup = 0; // Start group
    public $StopGroup = 0; // Stop group
    public $TotalGroups = 0; // Total groups
    public $GroupCount = 0; // Group count
    public $DisplayGroups = 3; // Groups per page
    public $GroupRange = 10;
    public $PageSizes = "1,2,3,5,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = "";
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $PageFirstGroupFilter = "";
    public $UserIDFilter = "";
    public $DrillDownList = "";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $SearchCommand = false;
    public $ShowHeader;
    public $GroupColumnCount = 0;
    public $ColumnSpan;
    public $TopContentClass = "col-sm-12 ew-top";
    public $LeftContentClass = "ew-left";
    public $CenterContentClass = "col-sm-12 ew-center";
    public $RightContentClass = "ew-right";
    public $BottomContentClass = "col-sm-12 ew-bottom";

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $ExportFileName, $Language, $Security, $UserProfile,
            $Security, $DrillDownInPanel, $Breadcrumb,
            $DashboardReport, $CustomExportType, $ReportExportType;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));
        $this->CurrentAction = Param("action"); // Set up current action

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up table class
        if ($this->isExport("word") || $this->isExport("excel") || $this->isExport("pdf")) {
            $this->ReportTableClass = "ew-table table-bordered table-sm";
        } else {
            $this->ReportTableClass = "table ew-table table-bordered table-sm";
        }

        // Set up groups per page dynamically
        $this->setupDisplayGroups();

        // Set up Breadcrumb
        if (!$this->isExport() && !$DashboardReport) {
            $this->setupBreadcrumb();
        }

        // Get sort
        $this->Sort = $this->getSort();

        // Load custom filters
        $this->pageFilterLoad();

        // Extended filter
        $extendedFilter = "";

        // No filter
        $this->FilterOptions["savecurrentfilter"]->Visible = false;
        $this->FilterOptions["deletefilter"]->Visible = false;

        // Call Page Selecting event
        $this->pageSelecting($this->SearchWhere);

        // Load columns to array
        $this->getColumns();

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Update filter
        AddFilter($this->Filter, $this->SearchWhere);

        // Get total group count
        $sql = $this->buildReportSql($this->getSqlSelectGroup(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), "", "", $this->Filter, "");
        $this->TotalGroups = $this->getRecordCount($sql);
        if ($this->DisplayGroups <= 0 || $this->DrillDown || $DashboardReport) { // Display all groups
            $this->DisplayGroups = $this->TotalGroups;
        }
        $this->StartGroup = 1;

        // Show header
        $this->ShowHeader = ($this->TotalGroups > 0);

        // Set up start position if not export all
        if ($this->ExportAll && $this->isExport()) {
            $this->DisplayGroups = $this->TotalGroups;
        } else {
            $this->setupStartGroup();
        }

        // Set no record found message
        if ($this->TotalGroups == 0) {
            if ($Security->canList()) {
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            } else {
                $this->setWarningMessage(DeniedMessage());
            }
        }

        // Hide export options if export/dashboard report/hide options
        if ($this->isExport() || $DashboardReport || $this->HideOptions) {
            $this->ExportOptions->hideAllOptions();
        }

        // Hide search/filter options if export/drilldown/dashboard report/hide options
        if ($this->isExport() || $this->DrillDown || $DashboardReport || $this->HideOptions) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }

        // Get group records
        if ($this->TotalGroups > 0) {
            $grpSort = UpdateSortFields($this->getSqlOrderByGroup(), $this->Sort, 2); // Get grouping field only
            $sql = $this->buildReportSql($this->getSqlSelectGroup(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), "", $this->getSqlOrderByGroup(), $this->Filter, $grpSort);
            $grpRs = $sql->setFirstResult($this->StartGroup - 1)->setMaxResults($this->DisplayGroups)->execute();
            $this->GroupRecords = $grpRs->fetchAll(); // Get records of first groups
            $this->loadGroupRowValues();
            $this->GroupCount = 1;
        }

        // Init detail records
        $this->DetailRecords = [];

        // Set up column attributes
        $this->_token->CssClass = "";
        $this->_token->CellCssStyle = "";
        $this->setupFieldCount();

        // Set the last group to display if not export all
        if ($this->ExportAll && $this->isExport()) {
            $this->StopGroup = $this->TotalGroups;
        } else {
            $this->StopGroup = $this->StartGroup + $this->DisplayGroups - 1;
        }

        // Stop group <= total number of groups
        if (intval($this->StopGroup) > intval($this->TotalGroups)) {
            $this->StopGroup = $this->TotalGroups;
        }

        // Navigate
        $this->RecordCount = 0;
        $this->RecordIndex = 0;

        // Set up pager
        $this->Pager = new PrevNextPager($this->TableVar, $this->StartGroup, $this->DisplayGroups, $this->TotalGroups, $this->PageSizes, $this->GroupRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Load group row values
    public function loadGroupRowValues()
    {
        $cnt = count($this->GroupRecords); // Get record count
        if ($this->GroupCount < $cnt) {
            $this->pelapor_id->setGroupValue(reset($this->GroupRecords[$this->GroupCount]));
        } else {
            $this->pelapor_id->setGroupValue("");
        }
    }

    // Load row values
    public function loadRowValues($record)
    {
        $this->pelapor_id->setDbValue($record['pelapor_id']);
        $this->jalan_id->setDbValue($record['jalan_id']);
        $this->status->setDbValue($record['status']);
        $cntbase = 3;
        $cnt = count($this->SummaryFields);
        $record = array_values($record);
        for ($is = 0; $is < $cnt; $is++) {
            $smry = &$this->SummaryFields[$is];
            $cntval = count($smry->SummaryValues);
            for ($ix = 1; $ix < $cntval; $ix++) {
                if ($smry->SummaryType == "AVG") {
                    $smry->SummaryValues[$ix] = $record[$ix * 2 + $cntbase - 2];
                    $smry->SummaryValueCounts[$ix] = $record[$ix * 2 + $cntbase - 1];
                } else {
                    $smry->SummaryValues[$ix] = $record[$ix + $cntbase - 1];
                }
            }
            $cntbase += ($smry->SummaryType == "AVG") ? 2 * ($cntval - 1) : ($cntval - 1);
        }
    }

    // Get summary values from records
    public function getSummaryValues($records)
    {
        $colcnt = $this->ColumnCount;
        $cnt = count($this->SummaryFields);
        for ($is = 0; $is < $cnt; $is++) {
            $smry = &$this->SummaryFields[$is];
            $smry->SummaryGroupValues = InitArray($colcnt, null);
            $smry->SummaryGroupValueCounts = InitArray($colcnt, null);
        }
        foreach ($records as $record) {
            $record = array_values($record);
            $cntbase = 3;
            for ($is = 0; $is < $cnt; $is++) {
                $smry = &$this->SummaryFields[$is];
                $cntval = count($smry->SummaryValues);
                for ($ix = 1; $ix < $cntval; $ix++) {
                    if ($smry->SummaryType == "AVG") {
                        $thisval = $record[$ix * 2 + $cntbase - 2];
                        $thiscnt = $record[$ix * 2 + $cntbase - 1];
                    } else {
                        $thisval = $record[$ix + $cntbase - 1];
                    }
                    $smry->SummaryGroupValues[$ix - 1] = SummaryValue($smry->SummaryGroupValues[$ix - 1], $thisval, $smry->SummaryType);
                    if ($smry->SummaryType == "AVG") {
                        $smry->SummaryGroupValueCounts[$ix - 1] += $thiscnt;
                    }
                }
                $cntbase += ($smry->SummaryType == "AVG") ? 2 * ($cntval - 1) : ($cntval - 1);
            }
        }
    }

    // Render row
    public function renderRow()
    {
        global $Security, $Language;
        $conn = $this->getConnection();

        // Set up summary values
        if ($this->RowType != ROWTYPE_SEARCH) { // Skip for search row
            $colcnt = $this->ColumnCount;
            $this->SummaryCellAttrs = InitArray($colcnt, null);
            $this->SummaryViewAttrs = InitArray($colcnt, null);
            $this->SummaryLinkAttrs = InitArray($colcnt, null);
            $this->SummaryCurrentValues = InitArray($colcnt, null);
            $this->SummaryViewValues = InitArray($colcnt, null);
            $cnt = count($this->SummaryFields);
            for ($is = 0; $is < $cnt; $is++) {
                $smry = &$this->SummaryFields[$is];
                $smry->SummaryViewAttrs = InitArray($colcnt, null);
                $smry->SummaryLinkAttrs = InitArray($colcnt, null);
                $smry->SummaryCurrentValues = InitArray($colcnt, null);
                $smry->SummaryViewValues = InitArray($colcnt, null);
            }
        }
        if ($this->RowTotalType == ROWTOTAL_PAGE) {
            // Aggregate SQL (filter by group values)
            $firstGrpFld = &$this->pelapor_id;
            $firstGrpFld->getDistinctValues($this->GroupRecords);
            $where = DetailFilterSql($firstGrpFld, $this->getSqlFirstGroupField(), $firstGrpFld->DistinctValues, $this->Dbid);
            if ($this->Filter != "") {
                $where = "($this->Filter) AND ($where)";
            }
            $qb = $this->buildReportSql($this->getSqlSelectAggregate()->addSelect($this->DistinctColumnFields), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupByAggregate(), "", "", $where, "");
            $rsagg = $qb->execute()->fetchNumeric();
        } else if ($this->RowTotalType == ROWTOTAL_GRAND) {
            // Aggregate SQL
            $qb = $this->buildReportSql($this->getSqlSelectAggregate()->addSelect($this->DistinctColumnFields), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupByAggregate(), "", "", $this->Filter, "");
            $rsagg = $qb->execute()->fetchNumeric();
        }
        if ($this->RowType != ROWTYPE_SEARCH) { // Skip for search row
            for ($i = 1; $i <= $this->ColumnCount; $i++) {
                if ($this->Columns[$i]->Visible) {
                    $cntbaseagg = 0;
                    $cnt = count($this->SummaryFields);
                    for ($is = 0; $is < $cnt; $is++) {
                        $smry = &$this->SummaryFields[$is];
                        if ($this->RowType == ROWTYPE_DETAIL) { // Detail row
                            $thisval = $smry->SummaryValues[$i];
                            if ($smry->SummaryType == "AVG") {
                                $thiscnt = $smry->SummaryValueCounts[$i];
                            }
                        } elseif ($this->RowTotalType == ROWTOTAL_GROUP) { // Group total
                            $thisval = $smry->SummaryGroupValues[$i - 1];
                            if ($smry->SummaryType == "AVG") {
                                $thiscnt = $smry->SummaryGroupValueCounts[$i - 1];
                            }
                        } elseif ($this->RowTotalType == ROWTOTAL_PAGE || $this->RowTotalType == ROWTOTAL_GRAND) { // Page Total / Grand total
                            if ($smry->SummaryType == "AVG") {
                                $thisval = $rsagg[$i * 2 + $cntbaseagg - 2] ?? 0;
                                $thiscnt = $rsagg[$i * 2 + $cntbaseagg - 1] ?? 0;
                                $cntbaseagg += $this->ColumnCount * 2;
                            } else {
                                $thisval = $rsagg[$i + $cntbaseagg - 1] ?? 0;
                                $cntbaseagg += $this->ColumnCount;
                            }
                        }
                        if ($smry->SummaryType == "AVG") {
                            $smry->SummaryCurrentValues[$i - 1] = ($thiscnt > 0) ? $thisval / $thiscnt : 0;
                        } else {
                            $smry->SummaryCurrentValues[$i - 1] = $thisval;
                        }
                    }
                }
            }
        }

        // Call Row_Rendering event
        $this->rowRendering();
        if ($this->RowType == ROWTYPE_SEARCH) { // Search row
        } elseif ($this->RowType == ROWTYPE_TOTAL) {
            // pelapor_id
            if ($this->pelapor_id->VirtualValue != "") {
                $this->pelapor_id->GroupViewValue = $this->pelapor_id->VirtualValue;
            } else {
                $curVal = strval($this->pelapor_id->groupValue());
                if ($curVal != "") {
                    $this->pelapor_id->GroupViewValue = $this->pelapor_id->lookupCacheOption($curVal);
                    if ($this->pelapor_id->GroupViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->pelapor_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->pelapor_id->Lookup->renderViewRow($rswrk[0]);
                            $this->pelapor_id->GroupViewValue = $this->pelapor_id->displayValue($arwrk);
                        } else {
                            $this->pelapor_id->GroupViewValue = FormatNumber($this->pelapor_id->groupValue(), $this->pelapor_id->formatPattern());
                        }
                    }
                } else {
                    $this->pelapor_id->GroupViewValue = null;
                }
            }
            $this->pelapor_id->CellCssClass = ($this->RowGroupLevel == 1 ? "ew-rpt-grp-summary-1" : "ew-rpt-grp-field-1");
            $this->pelapor_id->ViewCustomAttributes = "";

            // jalan_id
            $curVal = strval($this->jalan_id->groupValue());
            if ($curVal != "") {
                $this->jalan_id->GroupViewValue = $this->jalan_id->lookupCacheOption($curVal);
                if ($this->jalan_id->GroupViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->jalan_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->jalan_id->Lookup->renderViewRow($rswrk[0]);
                        $this->jalan_id->GroupViewValue = $this->jalan_id->displayValue($arwrk);
                    } else {
                        $this->jalan_id->GroupViewValue = FormatNumber($this->jalan_id->groupValue(), $this->jalan_id->formatPattern());
                    }
                }
            } else {
                $this->jalan_id->GroupViewValue = null;
            }
            $this->jalan_id->CellCssClass = ($this->RowGroupLevel == 2 ? "ew-rpt-grp-summary-2" : "ew-rpt-grp-field-2");
            $this->jalan_id->ViewCustomAttributes = "";

            // status
            $this->status->GroupViewValue = $this->status->groupValue();
            $this->status->CellCssClass = ($this->RowGroupLevel == 3 ? "ew-rpt-grp-summary-3" : "ew-rpt-grp-field-3");
            $this->status->ViewCustomAttributes = "";

            // Set up summary values
            $smry = &$this->SummaryFields[0];
            $scvcnt = count($smry->SummaryCurrentValues);
            for ($i = 0; $i < $scvcnt; $i++) {
                $smry->SummaryViewValues[$i] = $smry->SummaryCurrentValues[$i];
                $smry->SummaryViewAttrs[$i]["class"] = "";
                $this->SummaryCellAttrs[$i]["class"] = ($this->RowTotalType == ROWTOTAL_GROUP) ? "ew-rpt-grp-summary-" . $this->RowGroupLevel : "";
            }

            // pelapor_id
            $this->pelapor_id->HrefValue = "";

            // jalan_id
            $this->jalan_id->HrefValue = "";

            // status
            $this->status->HrefValue = "";
        } else {
            // pelapor_id
            if ($this->pelapor_id->VirtualValue != "") {
                $this->pelapor_id->GroupViewValue = $this->pelapor_id->VirtualValue;
            } else {
                $curVal = strval($this->pelapor_id->groupValue());
                if ($curVal != "") {
                    $this->pelapor_id->GroupViewValue = $this->pelapor_id->lookupCacheOption($curVal);
                    if ($this->pelapor_id->GroupViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->pelapor_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->pelapor_id->Lookup->renderViewRow($rswrk[0]);
                            $this->pelapor_id->GroupViewValue = $this->pelapor_id->displayValue($arwrk);
                        } else {
                            $this->pelapor_id->GroupViewValue = FormatNumber($this->pelapor_id->groupValue(), $this->pelapor_id->formatPattern());
                        }
                    }
                } else {
                    $this->pelapor_id->GroupViewValue = null;
                }
            }
            $this->pelapor_id->CellCssClass = "ew-rpt-grp-field-1";
            $this->pelapor_id->ViewCustomAttributes = "";
            if (!$this->pelapor_id->LevelBreak) {
                $this->pelapor_id->GroupViewValue = "";
            } else {
                $this->pelapor_id->LevelBreak = false;
            }

            // jalan_id
            $curVal = strval($this->jalan_id->groupValue());
            if ($curVal != "") {
                $this->jalan_id->GroupViewValue = $this->jalan_id->lookupCacheOption($curVal);
                if ($this->jalan_id->GroupViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->jalan_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->jalan_id->Lookup->renderViewRow($rswrk[0]);
                        $this->jalan_id->GroupViewValue = $this->jalan_id->displayValue($arwrk);
                    } else {
                        $this->jalan_id->GroupViewValue = FormatNumber($this->jalan_id->groupValue(), $this->jalan_id->formatPattern());
                    }
                }
            } else {
                $this->jalan_id->GroupViewValue = null;
            }
            $this->jalan_id->CellCssClass = "ew-rpt-grp-field-2";
            $this->jalan_id->ViewCustomAttributes = "";
            if (!$this->jalan_id->LevelBreak) {
                $this->jalan_id->GroupViewValue = "";
            } else {
                $this->jalan_id->LevelBreak = false;
            }

            // status
            $this->status->GroupViewValue = $this->status->groupValue();
            $this->status->CellCssClass = "ew-rpt-grp-field-3";
            $this->status->ViewCustomAttributes = "";
            if (!$this->status->LevelBreak) {
                $this->status->GroupViewValue = "";
            } else {
                $this->status->LevelBreak = false;
            }

            // Set up summary values
            $smry = &$this->SummaryFields[0];
            $scvcnt = count($smry->SummaryCurrentValues);
            for ($i = 0; $i < $scvcnt; $i++) {
                $smry->SummaryViewValues[$i] = $smry->SummaryCurrentValues[$i];
                $smry->SummaryViewAttrs[$i]["class"] = "";
                $this->SummaryCellAttrs[$i]["class"] = ($this->RecordCount % 2 != 1) ? "ew-table-alt-row" : "";
            }

            // pelapor_id
            $this->pelapor_id->LinkCustomAttributes = "";
            $this->pelapor_id->HrefValue = "";
            $this->pelapor_id->TooltipValue = "";

            // jalan_id
            $this->jalan_id->LinkCustomAttributes = "";
            $this->jalan_id->HrefValue = "";
            $this->jalan_id->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";
        }

        // Call Cell_Rendered event
        if ($this->RowType == ROWTYPE_TOTAL) {
            // pelapor_id
            $this->CurrentIndex = 0; // Current index
            $currentValue = $this->pelapor_id->groupValue();
            $viewValue = &$this->pelapor_id->GroupViewValue;
            $viewAttrs = &$this->pelapor_id->ViewAttrs;
            $cellAttrs = &$this->pelapor_id->CellAttrs;
            $hrefValue = &$this->pelapor_id->HrefValue;
            $linkAttrs = &$this->pelapor_id->LinkAttrs;
            $this->cellRendered($this->pelapor_id, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // jalan_id
            $this->CurrentIndex = 1; // Current index
            $currentValue = $this->jalan_id->groupValue();
            $viewValue = &$this->jalan_id->GroupViewValue;
            $viewAttrs = &$this->jalan_id->ViewAttrs;
            $cellAttrs = &$this->jalan_id->CellAttrs;
            $hrefValue = &$this->jalan_id->HrefValue;
            $linkAttrs = &$this->jalan_id->LinkAttrs;
            $this->cellRendered($this->jalan_id, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // status
            $this->CurrentIndex = 2; // Current index
            $currentValue = $this->status->groupValue();
            $viewValue = &$this->status->GroupViewValue;
            $viewAttrs = &$this->status->ViewAttrs;
            $cellAttrs = &$this->status->CellAttrs;
            $hrefValue = &$this->status->HrefValue;
            $linkAttrs = &$this->status->LinkAttrs;
            $this->cellRendered($this->status, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // Call Cell_Rendered for Summary fields
            $cnt = count($this->SummaryFields);
            for ($is = 0; $is < $cnt; $is++) {
                $smry = &$this->SummaryFields[$is];
                $scvcnt = count($smry->SummaryCurrentValues);
                for ($i = 0; $i < $scvcnt; $i++) {
                    $this->CurrentIndex = $i;
                    $currentValue = $smry->SummaryCurrentValues[$i];
                    $viewValue = &$smry->SummaryViewValues[$i];
                    $viewAttrs = &$smry->SummaryViewAttrs[$i];
                    $cellAttrs = &$this->SummaryCellAttrs[$i];
                    $hrefValue = "";
                    $linkAttrs = &$smry->SummaryLinkAttrs[$i];
                    $this->cellRendered($smry, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
                }
            }
        } elseif ($this->RowType == ROWTYPE_DETAIL) {
            // pelapor_id
            $this->CurrentIndex = 0; // Group index
            $currentValue = $this->pelapor_id->groupValue();
            $viewValue = &$this->pelapor_id->GroupViewValue;
            $viewAttrs = &$this->pelapor_id->ViewAttrs;
            $cellAttrs = &$this->pelapor_id->CellAttrs;
            $hrefValue = &$this->pelapor_id->HrefValue;
            $linkAttrs = &$this->pelapor_id->LinkAttrs;
            $this->cellRendered($this->pelapor_id, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // jalan_id
            $this->CurrentIndex = 1; // Group index
            $currentValue = $this->jalan_id->groupValue();
            $viewValue = &$this->jalan_id->GroupViewValue;
            $viewAttrs = &$this->jalan_id->ViewAttrs;
            $cellAttrs = &$this->jalan_id->CellAttrs;
            $hrefValue = &$this->jalan_id->HrefValue;
            $linkAttrs = &$this->jalan_id->LinkAttrs;
            $this->cellRendered($this->jalan_id, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // status
            $this->CurrentIndex = 2; // Group index
            $currentValue = $this->status->groupValue();
            $viewValue = &$this->status->GroupViewValue;
            $viewAttrs = &$this->status->ViewAttrs;
            $cellAttrs = &$this->status->CellAttrs;
            $hrefValue = &$this->status->HrefValue;
            $linkAttrs = &$this->status->LinkAttrs;
            $this->cellRendered($this->status, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
            $cnt = count($this->SummaryFields);
            for ($is = 0; $is < $cnt; $is++) {
                $smry = &$this->SummaryFields[$is];
                $scvcnt = count($smry->SummaryCurrentValues);
                for ($i = 0; $i < $scvcnt; $i++) {
                    $this->CurrentIndex = $i;
                    $currentValue = $smry->SummaryCurrentValues[$i];
                    $viewValue = &$smry->SummaryViewValues[$i];
                    $viewAttrs = &$smry->SummaryViewAttrs[$i];
                    $cellAttrs = &$this->SummaryCellAttrs[$i];
                    $hrefValue = "";
                    $linkAttrs = &$smry->SummaryLinkAttrs[$i];
                    $this->cellRendered($smry, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
                }
            }
        }

        // Call Row_Rendered event
        $this->rowRendered();
        $this->setupFieldCount();
    }

    // Setup field count
    protected function setupFieldCount()
    {
        $this->GroupColumnCount = 0;
        if ($this->pelapor_id->Visible) {
            $this->GroupColumnCount += 1;
        }
        if ($this->jalan_id->Visible) {
            $this->GroupColumnCount += 1;
        }
        if ($this->status->Visible) {
            $this->GroupColumnCount += 1;
        }
    }

    // Get column values
    protected function getColumns()
    {
        global $Language;

        // Load column values
        $filter = "";
        AddFilter($filter, $this->Filter);
        AddFilter($filter, $this->SearchWhere);
        $this->loadColumnValues($filter);

        // Get active columns
        $this->ColumnSpan = $this->ColumnCount;
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        if (SameText($type, "excel")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-excel" title="' . HtmlEncode($Language->phrase("ExportToExcel", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToExcel", true)) . '" data-ew-action="export-charts" data-url="' . $exportUrl . '" data-exportid="' . session_id() . '">' . $Language->phrase("ExportToExcel") . '</button>';
        } elseif (SameText($type, "word")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-word" title="' . HtmlEncode($Language->phrase("ExportToWord", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToWord", true)) . '" data-ew-action="export-charts" data-url="' . $exportUrl . '" data-exportid="' . session_id() . '">' . $Language->phrase("ExportToWord") . '</button>';
        } elseif (SameText($type, "pdf")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-pdf" title="' . HtmlEncode($Language->phrase("ExportToPdf", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToPdf", true)) . '" data-ew-action="export-charts" data-url="' . $exportUrl . '" data-exportid="' . session_id() . '">' . $Language->phrase("ExportToPdf") . '</button>';
        } elseif (SameText($type, "email")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-ew-action="email" data-hdr="' . HtmlEncode($Language->phrase("ExportToEmailText")) . '" data-url="' . $exportUrl . '" data-exportid="' . session_id() . '">' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("ExportToPrintText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPrintText")) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = false;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = false;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = false;

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = false;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = false;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide options for export
        if ($this->isExport()) {
            $this->ExportOptions->hideAllOptions();
        }
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl();
        $this->SearchOptions = new ListOptions(["TagClassName" => "ew-search-option"]);

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction) {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Check if any search fields
    public function hasSearchFields()
    {
        return false;
    }

    // Render search options
    protected function renderSearchOptions()
    {
        if (!$this->hasSearchFields() && $this->SearchOptions["searchtoggle"]) {
            $this->SearchOptions["searchtoggle"]->Visible = false;
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("crosstab", $this->TableVar, $url, "", $this->TableVar, true);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_pelapor_id":
                    break;
                case "x_jalan_id":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $ar[strval($row["lf"])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fReportPengaduansrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = false;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fReportPengaduansrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = false;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
    }

    // Set up starting group
    protected function setupStartGroup()
    {
        // Exit if no groups
        if ($this->DisplayGroups == 0) {
            return;
        }
        $startGrp = Param(Config("TABLE_START_GROUP"));
        $pageNo = Param(Config("TABLE_PAGE_NO"));

        // Check for a 'start' parameter
        if ($startGrp !== null) {
            $this->StartGroup = $startGrp;
            $this->setStartGroup($this->StartGroup);
        } elseif ($pageNo !== null) {
            $pageNo = ParseInteger($pageNo);
            if (is_numeric($pageNo)) {
                $this->StartGroup = ($pageNo - 1) * $this->DisplayGroups + 1;
                if ($this->StartGroup <= 0) {
                    $this->StartGroup = 1;
                } elseif ($this->StartGroup >= intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1) {
                    $this->StartGroup = intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1;
                }
                $this->setStartGroup($this->StartGroup);
            } else {
                $this->StartGroup = $this->getStartGroup();
            }
        } else {
            $this->StartGroup = $this->getStartGroup();
        }

        // Check if correct start group counter
        if (!is_numeric($this->StartGroup) || $this->StartGroup == "") { // Avoid invalid start group counter
            $this->StartGroup = 1; // Reset start group counter
            $this->setStartGroup($this->StartGroup);
        } elseif (intval($this->StartGroup) > intval($this->TotalGroups)) { // Avoid starting group > total groups
            $this->StartGroup = intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1; // Point to last page first group
            $this->setStartGroup($this->StartGroup);
        } elseif (($this->StartGroup - 1) % $this->DisplayGroups != 0) {
            $this->StartGroup = intval(($this->StartGroup - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1; // Point to page boundary
            $this->setStartGroup($this->StartGroup);
        }
    }

    // Reset pager
    protected function resetPager()
    {
        // Reset start position (reset command)
        $this->StartGroup = 1;
        $this->setStartGroup($this->StartGroup);
    }

    // Set up number of groups displayed per page
    protected function setupDisplayGroups()
    {
        if (Param(Config("TABLE_GROUP_PER_PAGE")) !== null) {
            $wrk = Param(Config("TABLE_GROUP_PER_PAGE"));
            if (is_numeric($wrk)) {
                $this->DisplayGroups = intval($wrk);
            } else {
                if (strtoupper($wrk) == "ALL") { // Display all groups
                    $this->DisplayGroups = -1;
                } else {
                    $this->DisplayGroups = 3; // Non-numeric, load default
                }
            }
            $this->setGroupPerPage($this->DisplayGroups); // Save to session

            // Reset start position (reset command)
            $this->StartGroup = 1;
            $this->setStartGroup($this->StartGroup);
        } else {
            if ($this->getGroupPerPage() != "") {
                $this->DisplayGroups = $this->getGroupPerPage(); // Restore from session
            } else {
                $this->DisplayGroups = 3; // Load default
            }
        }
    }

    // Get sort parameters based on sort links clicked
    protected function getSort()
    {
        if ($this->DrillDown) {
            return "";
        }
        $resetSort = Param("cmd") === "resetsort";
        $orderBy = Param("order", "");
        $orderType = Param("ordertype", "");

        // Check for a resetsort command
        if ($resetSort) {
            $this->setOrderBy("");
            $this->setStartGroup(1);
            $this->pelapor_id->setSort("");
            $this->jalan_id->setSort("");
            $this->status->setSort("");

        // Check for an Order parameter
        } elseif ($orderBy != "") {
            $this->CurrentOrder = $orderBy;
            $this->CurrentOrderType = $orderType;
            $this->updateSort($this->pelapor_id); // pelapor_id
            $this->updateSort($this->jalan_id); // jalan_id
            $this->updateSort($this->status); // status
            $sortSql = $this->sortSql();
            $this->setOrderBy($sortSql);
            $this->setStartGroup(1);
        }
        return $this->getOrderBy();
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Page Breaking event
    public function pageBreaking(&$break, &$content)
    {
        // Example:
        //$break = false; // Skip page break, or
        //$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content
    }

    // Load Filters event
    public function pageFilterLoad()
    {
        // Enter your code here
        // Example: Register/Unregister Custom Extended Filter
        //RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
        //RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
        //UnregisterFilter($this-><Field>, 'StartsWithA');
    }

    // Page Selecting event
    public function pageSelecting(&$filter)
    {
        // Enter your code here
    }

    // Page Filter Validated event
    public function pageFilterValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Page Filtering event
    public function pageFiltering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "")
    {
        // Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
        //if ($typ == "dropdown" && $fld->Name == "MyField") // Dropdown filter
        //    $filter = "..."; // Modify the filter
        //if ($typ == "extended" && $fld->Name == "MyField") // Extended filter
        //    $filter = "..."; // Modify the filter
        //if ($typ == "custom" && $opr == "..." && $fld->Name == "MyField") // Custom filter, $opr is the custom filter ID
        //    $filter = "..."; // Modify the filter
    }

    // Cell Rendered event
    public function cellRendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs)
    {
        //$ViewValue = "xxx";
        //$ViewAttrs["class"] = "xxx";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
