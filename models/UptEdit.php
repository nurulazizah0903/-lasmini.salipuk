<?php

namespace PHPMaker2022\pubinamarga;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class UptEdit extends Upt
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'upt';

    // Page object name
    public $PageObjName = "UptEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

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
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
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
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
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
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return $this->TableVar == $CurrentForm->getValue("t");
            }
            if (Get("t") !== null) {
                return $this->TableVar == Get("t");
            }
        }
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

        // Table object (upt)
        if (!isset($GLOBALS["upt"]) || get_class($GLOBALS["upt"]) == PROJECT_NAMESPACE . "upt") {
            $GLOBALS["upt"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'upt');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
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
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $tbl = Container("upt");
                $doc = new $class($tbl);
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "UptView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
		        $this->file->OldUploadPath = "upt";
		        $this->file->UploadPath = $this->file->OldUploadPath;
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }

    // Lookup data
    public function lookup($ar = null)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $ar["field"] ?? Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

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

    // Properties
    public $FormClassName = "ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->nama->setVisibility();
        $this->nama_pic->setVisibility();
        $this->nip_pic->setVisibility();
        $this->jabatan_pic->setVisibility();
        $this->no_hp_pic->setVisibility();
        $this->email_pic->setVisibility();
        $this->file->setVisibility();
        $this->hideFieldsForAddEdit();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                    // Load current record
                    $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("UptList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "UptList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->file->Upload->Index = $CurrentForm->Index;
        $this->file->Upload->uploadFile();
        $this->file->CurrentValue = $this->file->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'nama' first before field var 'x_nama'
        $val = $CurrentForm->hasValue("nama") ? $CurrentForm->getValue("nama") : $CurrentForm->getValue("x_nama");
        if (!$this->nama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama->Visible = false; // Disable update for API request
            } else {
                $this->nama->setFormValue($val);
            }
        }

        // Check field name 'nama_pic' first before field var 'x_nama_pic'
        $val = $CurrentForm->hasValue("nama_pic") ? $CurrentForm->getValue("nama_pic") : $CurrentForm->getValue("x_nama_pic");
        if (!$this->nama_pic->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama_pic->Visible = false; // Disable update for API request
            } else {
                $this->nama_pic->setFormValue($val);
            }
        }

        // Check field name 'nip_pic' first before field var 'x_nip_pic'
        $val = $CurrentForm->hasValue("nip_pic") ? $CurrentForm->getValue("nip_pic") : $CurrentForm->getValue("x_nip_pic");
        if (!$this->nip_pic->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nip_pic->Visible = false; // Disable update for API request
            } else {
                $this->nip_pic->setFormValue($val);
            }
        }

        // Check field name 'jabatan_pic' first before field var 'x_jabatan_pic'
        $val = $CurrentForm->hasValue("jabatan_pic") ? $CurrentForm->getValue("jabatan_pic") : $CurrentForm->getValue("x_jabatan_pic");
        if (!$this->jabatan_pic->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jabatan_pic->Visible = false; // Disable update for API request
            } else {
                $this->jabatan_pic->setFormValue($val);
            }
        }

        // Check field name 'no_hp_pic' first before field var 'x_no_hp_pic'
        $val = $CurrentForm->hasValue("no_hp_pic") ? $CurrentForm->getValue("no_hp_pic") : $CurrentForm->getValue("x_no_hp_pic");
        if (!$this->no_hp_pic->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->no_hp_pic->Visible = false; // Disable update for API request
            } else {
                $this->no_hp_pic->setFormValue($val);
            }
        }

        // Check field name 'email_pic' first before field var 'x_email_pic'
        $val = $CurrentForm->hasValue("email_pic") ? $CurrentForm->getValue("email_pic") : $CurrentForm->getValue("x_email_pic");
        if (!$this->email_pic->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->email_pic->Visible = false; // Disable update for API request
            } else {
                $this->email_pic->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }
		$this->file->OldUploadPath = "upt";
		$this->file->UploadPath = $this->file->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->nama_pic->CurrentValue = $this->nama_pic->FormValue;
        $this->nip_pic->CurrentValue = $this->nip_pic->FormValue;
        $this->jabatan_pic->CurrentValue = $this->jabatan_pic->FormValue;
        $this->no_hp_pic->CurrentValue = $this->no_hp_pic->FormValue;
        $this->email_pic->CurrentValue = $this->email_pic->FormValue;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }
        if (!$row) {
            return;
        }

        // Call Row Selected event
        $this->rowSelected($row);
        $this->id->setDbValue($row['id']);
        $this->nama->setDbValue($row['nama']);
        $this->nama_pic->setDbValue($row['nama_pic']);
        $this->nip_pic->setDbValue($row['nip_pic']);
        $this->jabatan_pic->setDbValue($row['jabatan_pic']);
        $this->no_hp_pic->setDbValue($row['no_hp_pic']);
        $this->email_pic->setDbValue($row['email_pic']);
        $this->file->Upload->DbValue = $row['file'];
        $this->file->setDbValue($this->file->Upload->DbValue);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['nama'] = $this->nama->DefaultValue;
        $row['nama_pic'] = $this->nama_pic->DefaultValue;
        $row['nip_pic'] = $this->nip_pic->DefaultValue;
        $row['jabatan_pic'] = $this->jabatan_pic->DefaultValue;
        $row['no_hp_pic'] = $this->no_hp_pic->DefaultValue;
        $row['email_pic'] = $this->email_pic->DefaultValue;
        $row['file'] = $this->file->DefaultValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id
        $this->id->RowCssClass = "row";

        // nama
        $this->nama->RowCssClass = "row";

        // nama_pic
        $this->nama_pic->RowCssClass = "row";

        // nip_pic
        $this->nip_pic->RowCssClass = "row";

        // jabatan_pic
        $this->jabatan_pic->RowCssClass = "row";

        // no_hp_pic
        $this->no_hp_pic->RowCssClass = "row";

        // email_pic
        $this->email_pic->RowCssClass = "row";

        // file
        $this->file->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // nama
            $this->nama->ViewValue = $this->nama->CurrentValue;
            $this->nama->ViewCustomAttributes = "";

            // nama_pic
            $this->nama_pic->ViewValue = $this->nama_pic->CurrentValue;
            $this->nama_pic->ViewCustomAttributes = "";

            // nip_pic
            $this->nip_pic->ViewValue = $this->nip_pic->CurrentValue;
            $this->nip_pic->ViewCustomAttributes = "";

            // jabatan_pic
            $this->jabatan_pic->ViewValue = $this->jabatan_pic->CurrentValue;
            $this->jabatan_pic->ViewCustomAttributes = "";

            // no_hp_pic
            $this->no_hp_pic->ViewValue = $this->no_hp_pic->CurrentValue;
            $this->no_hp_pic->ViewCustomAttributes = "";

            // email_pic
            $this->email_pic->ViewValue = $this->email_pic->CurrentValue;
            $this->email_pic->ViewCustomAttributes = "";

            // file
            $this->file->UploadPath = "upt";
            if (!EmptyValue($this->file->Upload->DbValue)) {
                $this->file->ViewValue = $this->file->Upload->DbValue;
            } else {
                $this->file->ViewValue = "";
            }
            $this->file->ViewCustomAttributes = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // nama_pic
            $this->nama_pic->LinkCustomAttributes = "";
            $this->nama_pic->HrefValue = "";

            // nip_pic
            $this->nip_pic->LinkCustomAttributes = "";
            $this->nip_pic->HrefValue = "";

            // jabatan_pic
            $this->jabatan_pic->LinkCustomAttributes = "";
            $this->jabatan_pic->HrefValue = "";

            // no_hp_pic
            $this->no_hp_pic->LinkCustomAttributes = "";
            $this->no_hp_pic->HrefValue = "";

            // email_pic
            $this->email_pic->LinkCustomAttributes = "";
            $this->email_pic->HrefValue = "";

            // file
            $this->file->LinkCustomAttributes = "";
            $this->file->HrefValue = "";
            $this->file->ExportHrefValue = $this->file->UploadPath . $this->file->Upload->DbValue;
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // nama
            $this->nama->setupEditAttributes();
            $this->nama->EditCustomAttributes = "";
            if (!$this->nama->Raw) {
                $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->CurrentValue);
            $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

            // nama_pic
            $this->nama_pic->setupEditAttributes();
            $this->nama_pic->EditCustomAttributes = "";
            if (!$this->nama_pic->Raw) {
                $this->nama_pic->CurrentValue = HtmlDecode($this->nama_pic->CurrentValue);
            }
            $this->nama_pic->EditValue = HtmlEncode($this->nama_pic->CurrentValue);
            $this->nama_pic->PlaceHolder = RemoveHtml($this->nama_pic->caption());

            // nip_pic
            $this->nip_pic->setupEditAttributes();
            $this->nip_pic->EditCustomAttributes = "";
            if (!$this->nip_pic->Raw) {
                $this->nip_pic->CurrentValue = HtmlDecode($this->nip_pic->CurrentValue);
            }
            $this->nip_pic->EditValue = HtmlEncode($this->nip_pic->CurrentValue);
            $this->nip_pic->PlaceHolder = RemoveHtml($this->nip_pic->caption());

            // jabatan_pic
            $this->jabatan_pic->setupEditAttributes();
            $this->jabatan_pic->EditCustomAttributes = "";
            if (!$this->jabatan_pic->Raw) {
                $this->jabatan_pic->CurrentValue = HtmlDecode($this->jabatan_pic->CurrentValue);
            }
            $this->jabatan_pic->EditValue = HtmlEncode($this->jabatan_pic->CurrentValue);
            $this->jabatan_pic->PlaceHolder = RemoveHtml($this->jabatan_pic->caption());

            // no_hp_pic
            $this->no_hp_pic->setupEditAttributes();
            $this->no_hp_pic->EditCustomAttributes = "";
            if (!$this->no_hp_pic->Raw) {
                $this->no_hp_pic->CurrentValue = HtmlDecode($this->no_hp_pic->CurrentValue);
            }
            $this->no_hp_pic->EditValue = HtmlEncode($this->no_hp_pic->CurrentValue);
            $this->no_hp_pic->PlaceHolder = RemoveHtml($this->no_hp_pic->caption());

            // email_pic
            $this->email_pic->setupEditAttributes();
            $this->email_pic->EditCustomAttributes = "";
            if (!$this->email_pic->Raw) {
                $this->email_pic->CurrentValue = HtmlDecode($this->email_pic->CurrentValue);
            }
            $this->email_pic->EditValue = HtmlEncode($this->email_pic->CurrentValue);
            $this->email_pic->PlaceHolder = RemoveHtml($this->email_pic->caption());

            // file
            $this->file->setupEditAttributes();
            $this->file->EditCustomAttributes = "";
            $this->file->UploadPath = "upt";
            if (!EmptyValue($this->file->Upload->DbValue)) {
                $this->file->EditValue = $this->file->Upload->DbValue;
            } else {
                $this->file->EditValue = "";
            }
            if (!EmptyValue($this->file->CurrentValue)) {
                $this->file->Upload->FileName = $this->file->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->file);
            }

            // Edit refer script

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // nama_pic
            $this->nama_pic->LinkCustomAttributes = "";
            $this->nama_pic->HrefValue = "";

            // nip_pic
            $this->nip_pic->LinkCustomAttributes = "";
            $this->nip_pic->HrefValue = "";

            // jabatan_pic
            $this->jabatan_pic->LinkCustomAttributes = "";
            $this->jabatan_pic->HrefValue = "";

            // no_hp_pic
            $this->no_hp_pic->LinkCustomAttributes = "";
            $this->no_hp_pic->HrefValue = "";

            // email_pic
            $this->email_pic->LinkCustomAttributes = "";
            $this->email_pic->HrefValue = "";

            // file
            $this->file->LinkCustomAttributes = "";
            $this->file->HrefValue = "";
            $this->file->ExportHrefValue = $this->file->UploadPath . $this->file->Upload->DbValue;
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
        if ($this->nama->Required) {
            if (!$this->nama->IsDetailKey && EmptyValue($this->nama->FormValue)) {
                $this->nama->addErrorMessage(str_replace("%s", $this->nama->caption(), $this->nama->RequiredErrorMessage));
            }
        }
        if ($this->nama_pic->Required) {
            if (!$this->nama_pic->IsDetailKey && EmptyValue($this->nama_pic->FormValue)) {
                $this->nama_pic->addErrorMessage(str_replace("%s", $this->nama_pic->caption(), $this->nama_pic->RequiredErrorMessage));
            }
        }
        if ($this->nip_pic->Required) {
            if (!$this->nip_pic->IsDetailKey && EmptyValue($this->nip_pic->FormValue)) {
                $this->nip_pic->addErrorMessage(str_replace("%s", $this->nip_pic->caption(), $this->nip_pic->RequiredErrorMessage));
            }
        }
        if ($this->jabatan_pic->Required) {
            if (!$this->jabatan_pic->IsDetailKey && EmptyValue($this->jabatan_pic->FormValue)) {
                $this->jabatan_pic->addErrorMessage(str_replace("%s", $this->jabatan_pic->caption(), $this->jabatan_pic->RequiredErrorMessage));
            }
        }
        if ($this->no_hp_pic->Required) {
            if (!$this->no_hp_pic->IsDetailKey && EmptyValue($this->no_hp_pic->FormValue)) {
                $this->no_hp_pic->addErrorMessage(str_replace("%s", $this->no_hp_pic->caption(), $this->no_hp_pic->RequiredErrorMessage));
            }
        }
        if ($this->email_pic->Required) {
            if (!$this->email_pic->IsDetailKey && EmptyValue($this->email_pic->FormValue)) {
                $this->email_pic->addErrorMessage(str_replace("%s", $this->email_pic->caption(), $this->email_pic->RequiredErrorMessage));
            }
        }
        if ($this->file->Required) {
            if ($this->file->Upload->FileName == "" && !$this->file->Upload->KeepFile) {
                $this->file->addErrorMessage(str_replace("%s", $this->file->caption(), $this->file->RequiredErrorMessage));
            }
        }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();

        // Load old row
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            return false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $this->file->OldUploadPath = "upt";
            $this->file->UploadPath = $this->file->OldUploadPath;
        }

        // Set new row
        $rsnew = [];

        // nama
        $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, null, $this->nama->ReadOnly);

        // nama_pic
        $this->nama_pic->setDbValueDef($rsnew, $this->nama_pic->CurrentValue, null, $this->nama_pic->ReadOnly);

        // nip_pic
        $this->nip_pic->setDbValueDef($rsnew, $this->nip_pic->CurrentValue, null, $this->nip_pic->ReadOnly);

        // jabatan_pic
        $this->jabatan_pic->setDbValueDef($rsnew, $this->jabatan_pic->CurrentValue, null, $this->jabatan_pic->ReadOnly);

        // no_hp_pic
        $this->no_hp_pic->setDbValueDef($rsnew, $this->no_hp_pic->CurrentValue, null, $this->no_hp_pic->ReadOnly);

        // email_pic
        $this->email_pic->setDbValueDef($rsnew, $this->email_pic->CurrentValue, null, $this->email_pic->ReadOnly);

        // file
        if ($this->file->Visible && !$this->file->ReadOnly && !$this->file->Upload->KeepFile) {
            $this->file->Upload->DbValue = $rsold['file']; // Get original value
            if ($this->file->Upload->FileName == "") {
                $rsnew['file'] = null;
            } else {
                $rsnew['file'] = $this->file->Upload->FileName;
            }
        }

        // Update current values
        $this->setCurrentValues($rsnew);
        if ($this->file->Visible && !$this->file->Upload->KeepFile) {
            $this->file->UploadPath = "upt";
            $oldFiles = EmptyValue($this->file->Upload->DbValue) ? [] : [$this->file->htmlDecode($this->file->Upload->DbValue)];
            if (!EmptyValue($this->file->Upload->FileName)) {
                $newFiles = [$this->file->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->file, $this->file->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->file->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->file->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->file->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->file->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->file->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->file->setDbValueDef($rsnew, $this->file->Upload->FileName, null, $this->file->ReadOnly);
            }
        }

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);
        if ($updateRow) {
            if (count($rsnew) > 0) {
                $this->CurrentFilter = $filter; // Set up current filter
                $editRow = $this->update($rsnew, "", $rsold);
            } else {
                $editRow = true; // No field to update
            }
            if ($editRow) {
                if ($this->file->Visible && !$this->file->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->file->Upload->DbValue) ? [] : [$this->file->htmlDecode($this->file->Upload->DbValue)];
                    if (!EmptyValue($this->file->Upload->FileName)) {
                        $newFiles = [$this->file->Upload->FileName];
                        $newFiles2 = [$this->file->htmlDecode($rsnew['file'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->file, $this->file->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->file->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->file->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("UpdateCancelled"));
            }
            $editRow = false;
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
            // file
            CleanUploadTempPath($this->file, $this->file->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("UptList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            if ($startRec !== null && is_numeric($startRec)) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
        }
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
