<?php

namespace PHPMaker2022\pubinamarga;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for Report Pengaduan
 */
class ReportPengaduan extends ReportTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";
    public $ShowGroupHeaderAsRow = false;
    public $ShowCompactSummaryFooter = false;

    // Export
    public $ExportDoc;
    public $ChartJumlahPengaduanHarian;
    public $ChartJumlahJalanPengaduan;

    // Fields
    public $id;
    public $pelapor_id;
    public $jalan_id;
    public $foto;
    public $kordinat;
    public $keterangan;
    public $_token;
    public $status;
    public $waktu;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'ReportPengaduan';
        $this->TableName = 'Report Pengaduan';
        $this->TableType = 'REPORT';

        // Update Table
        $this->UpdateTable = "`pengaduan`";
        $this->ReportSourceTable = 'pengaduan'; // Report source table
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (report only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordVersion = 12; // Word version (PHPWord only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = "A4"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions

        // id
        $this->id = new ReportField(
            'ReportPengaduan',
            'Report Pengaduan',
            'x_id',
            'id',
            '`id`',
            '`id`',
            3,
            11,
            -1,
            false,
            '`id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->id->InputTextType = "text";
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->SourceTableVar = 'pengaduan';
        $this->Fields['id'] = &$this->id;

        // pelapor_id
        $this->pelapor_id = new ReportField(
            'ReportPengaduan',
            'Report Pengaduan',
            'x_pelapor_id',
            'pelapor_id',
            '`pelapor_id`',
            '`pelapor_id`',
            3,
            11,
            -1,
            false,
            '`EV__pelapor_id`',
            true,
            true,
            true,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->pelapor_id->InputTextType = "text";
        $this->pelapor_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->pelapor_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->pelapor_id->Lookup = new Lookup('pelapor_id', 'pelapor', false, 'id', ["nama","","",""], [], [], [], [], [], [], '', '', "`nama`");
        $this->pelapor_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->pelapor_id->SourceTableVar = 'pengaduan';
        $this->Fields['pelapor_id'] = &$this->pelapor_id;

        // jalan_id
        $this->jalan_id = new ReportField(
            'ReportPengaduan',
            'Report Pengaduan',
            'x_jalan_id',
            'jalan_id',
            '`jalan_id`',
            '`jalan_id`',
            3,
            11,
            -1,
            false,
            '`jalan_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->jalan_id->InputTextType = "text";
        $this->jalan_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->jalan_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->jalan_id->UseFilter = true; // Table header filter
        $this->jalan_id->Lookup = new Lookup('jalan_id', 'jalan', true, 'id', ["nama","","",""], [], [], [], [], [], [], '', '', "`nama`");
        $this->jalan_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->jalan_id->AdvancedSearch->SearchValueDefault = Config("INIT_VALUE");
        $this->jalan_id->SourceTableVar = 'pengaduan';
        $this->Fields['jalan_id'] = &$this->jalan_id;

        // foto
        $this->foto = new ReportField(
            'ReportPengaduan',
            'Report Pengaduan',
            'x_foto',
            'foto',
            '`foto`',
            '`foto`',
            201,
            65535,
            -1,
            false,
            '`foto`',
            false,
            false,
            false,
            'IMAGE',
            'TEXTAREA'
        );
        $this->foto->InputTextType = "text";
        $this->foto->SourceTableVar = 'pengaduan';
        $this->Fields['foto'] = &$this->foto;

        // kordinat
        $this->kordinat = new ReportField(
            'ReportPengaduan',
            'Report Pengaduan',
            'x_kordinat',
            'kordinat',
            '`kordinat`',
            '`kordinat`',
            201,
            65535,
            -1,
            false,
            '`kordinat`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->kordinat->InputTextType = "text";
        $this->kordinat->SourceTableVar = 'pengaduan';
        $this->Fields['kordinat'] = &$this->kordinat;

        // keterangan
        $this->keterangan = new ReportField(
            'ReportPengaduan',
            'Report Pengaduan',
            'x_keterangan',
            'keterangan',
            '`keterangan`',
            '`keterangan`',
            201,
            65535,
            -1,
            false,
            '`keterangan`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->keterangan->InputTextType = "text";
        $this->keterangan->SourceTableVar = 'pengaduan';
        $this->Fields['keterangan'] = &$this->keterangan;

        // token
        $this->_token = new ReportField(
            'ReportPengaduan',
            'Report Pengaduan',
            'x__token',
            'token',
            '`token`',
            '`token`',
            201,
            65535,
            -1,
            false,
            '`token`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->_token->InputTextType = "text";
        $this->_token->SourceTableVar = 'pengaduan';
        $this->Fields['token'] = &$this->_token;

        // status
        $this->status = new ReportField(
            'ReportPengaduan',
            'Report Pengaduan',
            'x_status',
            'status',
            '`status`',
            '`status`',
            200,
            50,
            -1,
            false,
            '`status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->status->InputTextType = "text";
        $this->status->SourceTableVar = 'pengaduan';
        $this->Fields['status'] = &$this->status;

        // waktu
        $this->waktu = new ReportField(
            'ReportPengaduan',
            'Report Pengaduan',
            'x_waktu',
            'waktu',
            '`waktu`',
            CastDateFieldForLike("`waktu`", 7, "DB"),
            135,
            19,
            7,
            false,
            '`waktu`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->waktu->InputTextType = "text";
        $this->waktu->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->waktu->SourceTableVar = 'pengaduan';
        $this->Fields['waktu'] = &$this->waktu;

        // Chart Jumlah Pengaduan Harian
        $this->ChartJumlahPengaduanHarian = new DbChart($this, 'ChartJumlahPengaduanHarian', 'Chart Jumlah Pengaduan Harian', 'waktu', 'pelapor_id', 1001, '', 0, 'COUNT', 600, 500);
        $this->ChartJumlahPengaduanHarian->YAxisFormat = ["Number"];
        $this->ChartJumlahPengaduanHarian->YFieldFormat = ["Number"];
        $this->ChartJumlahPengaduanHarian->SortType = 4;
        $this->ChartJumlahPengaduanHarian->SortSequence = "";
        $this->ChartJumlahPengaduanHarian->SqlSelect = $this->getQueryBuilder()->select("`waktu`", "''", "COUNT(`pelapor_id`)");
        $this->ChartJumlahPengaduanHarian->SqlGroupBy = "`waktu`";
        $this->ChartJumlahPengaduanHarian->SqlOrderBy = "";
        $this->ChartJumlahPengaduanHarian->SeriesDateType = "";
        $this->ChartJumlahPengaduanHarian->XAxisDateFormat = 7;
        $this->ChartJumlahPengaduanHarian->ID = "ReportPengaduan_ChartJumlahPengaduanHarian"; // Chart ID
        $this->ChartJumlahPengaduanHarian->setParameters([
            ["type", "1001"],
            ["seriestype", "0"]
        ]); // Chart type / Chart series type
        $this->ChartJumlahPengaduanHarian->setParameters([
            ["caption", $this->ChartJumlahPengaduanHarian->caption()],
            ["xaxisname", $this->ChartJumlahPengaduanHarian->xAxisName()]
        ]); // Chart caption / X axis name
        $this->ChartJumlahPengaduanHarian->setParameter("yaxisname", $this->ChartJumlahPengaduanHarian->yAxisName()); // Y axis name
        $this->ChartJumlahPengaduanHarian->setParameters([
            ["shownames", "1"],
            ["showvalues", "1"],
            ["showhovercap", "1"]
        ]); // Show names / Show values / Show hover
        $this->ChartJumlahPengaduanHarian->setParameter("alpha", "50"); // Chart alpha
        $this->ChartJumlahPengaduanHarian->setParameter("colorpalette", "#5899DA,#E8743B,#19A979,#ED4A7B,#945ECF,#13A4B4,#525DF4,#BF399E,#6C8893,#EE6868,#2F6497"); // Chart color palette

        // Chart Jumlah Jalan Pengaduan
        $this->ChartJumlahJalanPengaduan = new DbChart($this, 'ChartJumlahJalanPengaduan', 'Chart Jumlah Jalan Pengaduan', 'jalan_id', 'pelapor_id', 1001, '', 0, 'COUNT', 600, 500);
        $this->ChartJumlahJalanPengaduan->YAxisFormat = ["Number"];
        $this->ChartJumlahJalanPengaduan->YFieldFormat = ["Number"];
        $this->ChartJumlahJalanPengaduan->SortType = 4;
        $this->ChartJumlahJalanPengaduan->SortSequence = "";
        $this->ChartJumlahJalanPengaduan->SqlSelect = $this->getQueryBuilder()->select("`jalan_id`", "''", "COUNT(`pelapor_id`)");
        $this->ChartJumlahJalanPengaduan->SqlGroupBy = "`jalan_id`";
        $this->ChartJumlahJalanPengaduan->SqlOrderBy = "";
        $this->ChartJumlahJalanPengaduan->SeriesDateType = "";
        $this->ChartJumlahJalanPengaduan->ID = "ReportPengaduan_ChartJumlahJalanPengaduan"; // Chart ID
        $this->ChartJumlahJalanPengaduan->setParameters([
            ["type", "1001"],
            ["seriestype", "0"]
        ]); // Chart type / Chart series type
        $this->ChartJumlahJalanPengaduan->setParameters([
            ["caption", $this->ChartJumlahJalanPengaduan->caption()],
            ["xaxisname", $this->ChartJumlahJalanPengaduan->xAxisName()]
        ]); // Chart caption / X axis name
        $this->ChartJumlahJalanPengaduan->setParameter("yaxisname", $this->ChartJumlahJalanPengaduan->yAxisName()); // Y axis name
        $this->ChartJumlahJalanPengaduan->setParameters([
            ["shownames", "1"],
            ["showvalues", "1"],
            ["showhovercap", "1"]
        ]); // Show names / Show values / Show hover
        $this->ChartJumlahJalanPengaduan->setParameter("alpha", "50"); // Chart alpha
        $this->ChartJumlahJalanPengaduan->setParameter("colorpalette", "#5899DA,#E8743B,#19A979,#ED4A7B,#945ECF,#13A4B4,#525DF4,#BF399E,#6C8893,#EE6868,#2F6497"); // Chart color palette

        // Add Doctrine Cache
        $this->Cache = new ArrayCache();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Single column sort
    protected function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortField . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            if ($fld->GroupingFieldId == 0) {
                $this->setDetailOrderBy($curOrderBy); // Save to Session
            }
        } else {
            if ($fld->GroupingFieldId == 0) {
                $fld->setSort("");
            }
        }
    }

    // Get Sort SQL
    protected function sortSql()
    {
        $dtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
        $argrps = [];
        foreach ($this->Fields as $fld) {
            if (in_array($fld->getSort(), ["ASC", "DESC"])) {
                $fldsql = $fld->Expression;
                if ($fld->GroupingFieldId > 0) {
                    if ($fld->GroupSql != "") {
                        $argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->GroupSql) . " " . $fld->getSort();
                    } else {
                        $argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
                    }
                }
            }
        }
        $sortSql = "";
        foreach ($argrps as $grp) {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $grp;
        }
        if ($dtlSortSql != "") {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $dtlSortSql;
        }
        return $sortSql;
    }

    // Summary properties
    private $sqlSelectAggregate = null;
    private $sqlAggregatePrefix = "";
    private $sqlAggregateSuffix = "";
    private $sqlSelectCount = null;

    // Select Aggregate
    public function getSqlSelectAggregate()
    {
        return $this->sqlSelectAggregate ?? $this->getQueryBuilder()->select("*");
    }

    public function setSqlSelectAggregate($v)
    {
        $this->sqlSelectAggregate = $v;
    }

    // Aggregate Prefix
    public function getSqlAggregatePrefix()
    {
        return ($this->sqlAggregatePrefix != "") ? $this->sqlAggregatePrefix : "";
    }

    public function setSqlAggregatePrefix($v)
    {
        $this->sqlAggregatePrefix = $v;
    }

    // Aggregate Suffix
    public function getSqlAggregateSuffix()
    {
        return ($this->sqlAggregateSuffix != "") ? $this->sqlAggregateSuffix : "";
    }

    public function setSqlAggregateSuffix($v)
    {
        $this->sqlAggregateSuffix = $v;
    }

    // Select Count
    public function getSqlSelectCount()
    {
        return $this->sqlSelectCount ?? $this->getQueryBuilder()->select("COUNT(*)");
    }

    public function setSqlSelectCount($v)
    {
        $this->sqlSelectCount = $v;
    }

    // Render for lookup
    public function renderLookup()
    {
        $this->jalan_id->ViewValue = GetDropDownDisplayValue($this->jalan_id->CurrentValue, "", 0);
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        if ($chartVar == "ChartJumlahJalanPengaduan") {
            $this->jalan_id->CurrentValue = $chartRow[0];
            $curVal = strval($this->jalan_id->CurrentValue);
            if ($curVal != "") {
                $this->jalan_id->ViewValue = $this->jalan_id->lookupCacheOption($curVal);
                if ($this->jalan_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->jalan_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->jalan_id->Lookup->renderViewRow($rswrk[0]);
                        $this->jalan_id->ViewValue = $this->jalan_id->displayValue($arwrk);
                    } else {
                        $this->jalan_id->ViewValue = FormatNumber($this->jalan_id->CurrentValue, $this->jalan_id->formatPattern());
                    }
                }
            } else {
                $this->jalan_id->ViewValue = null;
            }
            $this->jalan_id->ViewCustomAttributes = "";
            $chartRow[0] = is_object($this->jalan_id->ViewValue) ? $this->jalan_id->ViewValue->__toString() : $this->jalan_id->ViewValue;
        }
        return $chartRow;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`pengaduan`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        if ($this->SqlSelect) {
            return $this->SqlSelect;
        }
        $select = $this->getQueryBuilder()->select("*");
        return $select;
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlSelectList() // Select for List page
    {
        if ($this->SqlSelectList) {
            return $this->SqlSelectList;
        }
        $from = "(SELECT *, (SELECT `nama` FROM `pelapor` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `Report Pengaduan`.`pelapor_id` LIMIT 1) AS `EV__pelapor_id` FROM `pengaduan`)";
        return $from . " `TMP_TABLE`";
    }

    public function sqlSelectList() // For backward compatibility
    {
        return $this->getSqlSelectList();
    }

    public function setSqlSelectList($v)
    {
        $this->SqlSelectList = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter, $id = "")
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            case "lookup":
                return (($allow & 256) == 256);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlwrk);
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = $this->id->OldValue !== null ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "") {
            return $Language->phrase("View");
        } elseif ($pageName == "") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "";
            case Config("API_ADD_ACTION"):
                return "";
            case Config("API_EDIT_ACTION"):
                return "";
            case Config("API_DELETE_ACTION"):
                return "";
            case Config("API_LIST_ACTION"):
                return "";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "?" . $this->getUrlParm($parm);
        } else {
            $url = "";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"id\":" . JsonEncode($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language;
        $sortUrl = "";
        $attrs = "";
        if ($fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-sort-url="' . $sortUrl . '" data-sort-type="1"';
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") . '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        global $DashboardReport;
        if (
            $this->CurrentAction || $this->isExport() ||
            $this->DrillDown || $DashboardReport ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        global $DownloadFileName;

        // No binary fields
        return false;
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
