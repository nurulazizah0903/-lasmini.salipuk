<?php

namespace PHPMaker2022\pubinamarga;

// Base path
$basePath = BasePath(true);
?>
<!DOCTYPE html>
<html<?= IsRTL() ? ' lang="' . CurrentLanguageID() . '" dir="rtl"' : '' ?>>
<head>
<title><?= $Title ?? $Language->projectPhrase("BodyTitle") ?></title>
<meta charset="utf-8">
<?php if ($ReportExportType != "" && $ReportExportType != "print") { // Stylesheet for exporting reports ?>
<link rel="stylesheet" href="<?= $basePath ?><?= CssFile(Config("PROJECT_STYLESHEET_FILENAME")) ?>">
    <?php if ($ReportExportType == "pdf" && Config("PDF_STYLESHEET_FILENAME")) { ?>
<link rel="stylesheet" href="/<?= $basePath ?><?= CssFile(Config("PDF_STYLESHEET_FILENAME")) ?>"><!-- Absolute path with leading '/' -->
    <?php } ?>
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?= $basePath ?>css/select2.min.css">
<link rel="stylesheet" href="<?= $basePath ?>css/select2-bootstrap5.min.css">
<link rel="stylesheet" href="<?= $basePath ?>adminlte3/css/<?= CssFile("adminlte.css") ?>">
<link rel="stylesheet" href="<?= $basePath ?>css/sweetalert2.min.css">
<link rel="stylesheet" href="<?= $basePath ?>plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="<?= $basePath ?>css/OverlayScrollbars.min.css">
<link rel="stylesheet" href="<?= $basePath ?><?= CssFile(Config("PROJECT_STYLESHEET_FILENAME")) ?>">
<?php if ($CustomExportType == "pdf" && Config("PDF_STYLESHEET_FILENAME")) { ?>
<link rel="stylesheet" href="<?= $basePath ?><?= CssFile(Config("PDF_STYLESHEET_FILENAME")) ?>">
<?php } ?>
<script data-pace-options='<?= JsonEncode(Config("PACE_OPTIONS")) ?>' src="<?= $basePath ?>js/pace.js"></script><!-- Single quotes for data-pace-options -->
<script src="<?= $basePath ?>js/element-internals-polyfill.min.js"></script>
<script src="<?= $basePath ?>js/ewcore.min.js"></script>
<script>
var $rowindex$ = null;
Object.assign(ew, <?= JsonEncode(ConfigClientVars()) ?>, <?= JsonEncode(GlobalClientVars()) ?>);
loadjs(ew.PATH_BASE + "jquery/jquery-3.6.0.min.js", "jquery");
loadjs(ew.PATH_BASE + "js/popper.min.js", "popper");
loadjs(ew.PATH_BASE + "js/luxon.min.js", "luxon");
loadjs([
    ew.PATH_BASE + "js/mobile-detect.min.js",
    ew.PATH_BASE + "js/purify.min.js",
    ew.PATH_BASE + "jquery/load-image.all.min.js"
], "others");
loadjs(ew.PATH_BASE + "js/sweetalert2.min.js", "swal");
<?= $Language->toJson() ?>
ew.vars = <?= JsonEncode(GetClientVar()) ?>;
ew.ready(["wrapper", "jquery"], ew.PATH_BASE + "jquery/jsrender.min.js", "jsrender", ew.renderJsTemplates);
ew.ready("jsrender", ew.PATH_BASE + "jquery/jquery.overlayScrollbars.min.js", "scrollbars"); // Init sidebar scrollbars after rendering menu
ew.ready("jquery", ew.PATH_BASE + "jquery/jquery-ui.min.js", "widget");
</script>
<?php include_once $RELATIVE_PATH . "views/menu.php"; ?>
<script>
var cssfiles = [
    ew.PATH_BASE + "css/jquery.fileupload.css",
    ew.PATH_BASE + "css/jquery.fileupload-ui.css"
];
cssfiles.push(ew.PATH_BASE + "colorbox/colorbox.css");
loadjs(cssfiles, "css");
var cssjs = [];
<?php foreach (array_merge(Config("STYLESHEET_FILES"), Config("JAVASCRIPT_FILES")) as $file) { // External Stylesheets and JavaScripts ?>
cssjs.push("<?= (IsRemote($file) ? "" : BasePath(true)) . $file ?>");
<?php } ?>
var jqueryjs = [
    ew.PATH_BASE + "jquery/select2.full.min.js",
    ew.PATH_BASE + "jquery/jqueryfileupload.min.js",
    ew.PATH_BASE + "jquery/typeahead.jquery.min.js"
];
jqueryjs.push(ew.PATH_BASE + "colorbox/jquery.colorbox.min.js");
jqueryjs.push(ew.PATH_BASE + "js/pdfobject.min.js");
ew.ready(["jquery", "dom", "popper"], ew.PATH_BASE + "bootstrap5/js/bootstrap.min.js", "bootstrap"); // Bootstrap
ew.ready("bootstrap", ew.PATH_BASE + "adminlte3/js/adminlte.min.js", "adminlte"); // AdminLTE (After Bootstrap)
ew.ready(["jquery", "widget"], [jqueryjs], "jqueryjs");
ew.ready(["bootstrap", "adminlte", "jqueryjs", "scrollbars", "luxon", "others"], ew.PATH_BASE + "js/ew.min.js", "makerjs");
ew.ready("makerjs", [
    cssjs,
    ew.PATH_BASE + "js/userfn.js",
    ew.PATH_BASE + "js/userevent.js"
], "head");
</script>
<script>
loadjs(ew.PATH_BASE + "css/<?= CssFile("tempus-dominus.css", false) ?>");
ew.ready("head", [
    ew.PATH_BASE + "js/tempus-dominus.min.js",
    ew.PATH_BASE + "js/ewdatetimepicker.min.js"
], "datetimepicker");
</script>
<script>
// Load chart *.js
loadjs(ew.PATH_BASE + "js/chart.min.js", "chartjs");
ew.ready(["chartjs", "luxon"], [
    ew.PATH_BASE + "js/chartjs-adapter-luxon.min.js",
    ew.PATH_BASE + "js/chartjs-plugin-annotation.min.js",
    ew.PATH_BASE + "js/chartjs-plugin-datalabels.min.js"
], "chart");
// Create chart
ew.createChart = function (args) {
    loadjs.ready(["head", "chart"], function () {
        let $ = jQuery,
            canvas = document.getElementById(args.canvasId),
            config = args.chartJson,
            showPercentage = args.showPercentage,
            yFieldFormat = args.yFieldFormat,
            yAxisFormat = args.yAxisFormat;
        canvas.dir = "ltr"; // Keep it LTR so currency symbol position in the format pattern will not be changed
        let formatNumber = function (value, format) {
            if (format == "Currency")
                return ew.formatCurrency(value, ew.CURRENCY_FORMAT);
            else if (format == "Number")
                return ew.formatNumber(value, ew.NUMBER_FORMAT);
            else if (format == "Percent")
                return ew.formatPercent(value, ew.PERCENT_FORMAT);
            return value;
        };
        if (config.data && config.data.datasets.length > 0) {
            config.options.onHover = function (e) {
                let el = this.getElementsAtEventForMode(e.native, "nearest", { intersect: true }, false);
                e.native.target.style.cursor = (el.length) ? "pointer" : "default";
            };
            let axis = config.options.indexAxis == "y" ? "x" : "y";
            if (!["pie", "doughnut"].includes(config.type)) { // Format x/y axis for non pie/doughnut charts
                // Format Primary Axis (x/y)
                config.options.scales[axis] = $.extend(true, {}, config.options.scales[axis], {
                    ticks: {
                        callback: function (value, index, values) {
                            let format = yAxisFormat.length ? yAxisFormat[0] : "";
                            return formatNumber(value, format);
                        }
                    }
                });
                // Format Secondary Axis (y1)
                if (config.options.scales["y1"]) {
                    config = $.extend(true, {}, config, {
                        options: {
                            scales: {
                                y1: {
                                    ticks: {
                                        callback: function (value, index, values) {
                                            let format = yAxisFormat.length > 1 ? yAxisFormat[1] : "";
                                            return formatNumber(value, format);
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            }
            config = $.extend(true, {}, config, {
                plugins: [ChartDataLabels],
                options: {
                    plugins: {
                        datalabels: {
                            align: ["line", "area"].includes(config.type) ? "top" : ew.IS_RTL ? "right" : "center",
                            rotation: config.type == "bar" && config.options.indexAxis != "y" ? -90 : 0, // Rotate label -90 degrees for column chart
                            formatter: function (value, context) {
                                let format = yFieldFormat.length > context.datasetIndex ? yFieldFormat[context.datasetIndex] : (yFieldFormat.length > 0 ? yFieldFormat[0] : "");
                                if (["pie", "doughnut"].includes(config.type) && showPercentage) { // Show as percentage
                                    let sum = context.dataset.data.reduce((accum, val) => {
                                        return accum + val;
                                    });
                                    value = value / sum;
                                    format = "Percent";
                                }
                                return formatNumber(value, format);
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = ["pie", "doughnut"].includes(config.type) ? context.label || "" : "",
                                        value = context.raw,
                                        format = yFieldFormat.length > context.datasetIndex ? yFieldFormat[context.datasetIndex] : (yFieldFormat.length > 0 ? yFieldFormat[0] : "");
                                    if (label)
                                        label += ": ";
                                    if (["pie", "doughnut"].includes(config.type) && showPercentage) {
                                        let sum = context.dataset.data.reduce((accum, val) => {
                                            return accum + val;
                                        });
                                        value = value / sum;
                                        format = "Percent";
                                    }
                                    label += formatNumber(value, format);
                                    return label;
                                }
                            }
                        }
                    }
                }
            }, ew.chartConfig, ew.charts[args.id]); // Deep copy (chart config + global config + user chart config)
            let evtArgs = { id: args.id, ctx: canvas, config: config };
            $(document).trigger("chart", [evtArgs]);
            let chart = new Chart(evtArgs.ctx, evtArgs.config);
            if (ew.DEBUG)
                console.log(evtArgs.config);
            evtArgs.ctx.addEventListener("click", function (e) {
                let activePoints = chart.getElementsAtEventForMode(e, "index", { intersect: true }, false);
                if (activePoints[0]) {
                    let activePoint = activePoints[0],
                        links = chart.data.datasets[activePoint.datasetIndex].links,
                        link = Array.isArray(links) ? links[activePoint.index] : {};
                    if (args.useDrilldownPanel) {
                        ew.showDrillDown(null, canvas, link.url, link.id, link.hdr);
                    } else if (args.useDrilldownPanel === false) { // If null, no drilldown
                        return ew.redirect(link.url);
                    }
                }
            });
            window.exportCharts["chart_" + args.id] = chart; // Export chart
        } else {
            canvas.classList.add("d-none");
        }
    });
};
</script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD93B_SN3Phn9avToCSCDEQ81CrvJZIV6A&libraries=drawing"></script>
<!-- Navbar -->
<script type="text/html" id="navbar-menu-items" class="ew-js-template" data-name="navbar" data-seq="10" data-data="navbar" data-method="appendTo" data-target="#ew-navbar">
{{if items}}
    {{for items}}
        <li id="{{:id}}" data-name="{{:name}}" class="{{if parentId == -1}}nav-item ew-navbar-item{{/if}}{{if isHeader && parentId > -1}}dropdown-header{{/if}}{{if items}} dropdown{{/if}}{{if items && parentId != -1}} dropdown-submenu{{/if}}{{if items && level == 1}} dropdown-hover{{/if}} d-none d-md-block">
            {{if isHeader && parentId > -1}}
                {{if icon}}<i class="{{:icon}}"></i>{{/if}}
                <span>{{:text}}</span>
            {{else}}
            <a href="{{:href}}"{{if target}} target="{{:target}}"{{/if}}{{if items}} role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"{{/if}}{{if attrs}}{{:attrs}}{{/if}}>
                {{if icon}}<i class="{{:icon}}"></i>{{/if}}
                <span>{{:text}}</span>
            </a>
            {{/if}}
            {{if items}}
            <ul class="dropdown-menu">
                {{include tmpl="#navbar-menu-items"/}}
            </ul>
            {{/if}}
        </li>
    {{/for}}
{{/if}}
</script>
<!-- Sidebar -->
<script type="text/html" class="ew-js-template" data-name="menu" data-seq="10" data-data="menu" data-target="#ew-menu">
{{if items}}
    <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column{{if compact}} nav-compact{{/if}}" data-widget="treeview" role="menu" data-accordion="{{:accordion}}">
    {{include tmpl="#menu-items"/}}
    </ul>
{{/if}}
</script>
<script type="text/html" id="menu-items">
{{if items}}
    {{for items}}
        <li id="{{:id}}" data-name="{{:name}}" class="{{if isHeader}}nav-header{{else}}nav-item{{if items}} has-treeview{{/if}}{{if active}} active current{{/if}}{{if open}} menu-open{{/if}}{{/if}}{{if isNavbarItem}} d-block d-md-none{{/if}}">
            {{if isHeader}}
                {{if icon}}<i class="{{:icon}}"></i>{{/if}}
                <span>{{:text}}</span>
                {{if label}}
                <span class="right">
                    {{:label}}
                </span>
                {{/if}}
            {{else}}
            <a href="{{:href}}"{{if target}} target="{{:target}}"{{/if}}{{if attrs}}{{:attrs}}{{/if}}>
                {{if icon}}<i class="nav-icon {{:icon}}"></i>{{/if}}
                <p>{{:text}}
                    {{if items}}
                        <i class="right fas fa-angle-left"></i>
                        {{if label}}
                            <span class="right">
                                {{:label}}
                            </span>
                        {{/if}}
                    {{else}}
                        {{if label}}
                            <span class="right">
                                {{:label}}
                            </span>
                        {{/if}}
                    {{/if}}
                </p>
            </a>
            {{/if}}
            {{if items}}
            <ul class="nav nav-treeview"{{if open}} style="display: block;"{{/if}}>
                {{include tmpl="#menu-items"/}}
            </ul>
            {{/if}}
        </li>
    {{/for}}
{{/if}}
</script>
<script type="text/html" class="ew-js-template" data-name="languages" data-seq="10" data-data="languages" data-method="<?= $Language->Method ?>" data-target="<?= HtmlEncode($Language->Target) ?>">
<?= $Language->getTemplate() ?>
</script>
<script type="text/html" class="ew-js-template" data-name="login" data-seq="10" data-data="login" data-method="appendTo" data-target=".navbar-nav.ms-auto">
{{if canSubscribe}}
<li class="nav-item"><a id="subscribe-notification" class="nav-link disabled">{{:subscribeText}}</a></li>
{{/if}}
{{if isLoggedIn}}
<li class="nav-item dropdown text-body">
    <a id="ew-nav-link-user" class="nav-link ew-user" data-bs-toggle="dropdown" href="#">
        <i class="fas fa-user"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="ew-nav-link-user">
        <div class="dropdown-header">
            <i class="fas fa-user me-2"></i>{{:currentUserName}}
        </div>
        <div class="dropdown-divider"></div>
        {{if hasPersonalData}}
        <a class="dropdown-item" id="personal-data"{{props personalData}} data-{{:key}}="{{>prop}}"{{/props}}>{{:personalDataText}}</a>
        {{/if}}
        {{if canChangePassword}}
        <a class="dropdown-item" id="change-password"{{props changePassword}} data-{{:key}}="{{>prop}}"{{/props}}>{{:changePasswordText}}</a>
        {{/if}}
        {{if enable2FAText}}
        <a class="dropdown-item{{if !enable2FA}} d-none{{/if}}" id="enable-2fa" data-ew-action="enable-2fa">{{:enable2FAText}}</a>
        {{/if}}
        {{if backupCodes}}
        <a class="dropdown-item{{if !showBackupCodes}} d-none{{/if}}" id="backup-codes" data-ew-action="backup-codes">{{:backupCodes}}</a>
        {{/if}}
        {{if disable2FAText}}
        <a class="dropdown-item{{if !disable2FA}} d-none{{/if}}" id="disable-2fa" data-ew-action="disable-2fa">{{:disable2FAText}}</a>
        {{/if}}
        {{if canLogout}}
        <div class="dropdown-divider"></div>
        <div class="dropdown-footer text-end py-0">
            <a class="btn btn-default"{{props logout}} data-{{:key}}="{{>prop}}"{{/props}}>{{:logoutText}}</a>
        </div>
        {{/if}}
    </div>
</li>
{{else}}
    {{if canLogin}}
<li class="nav-item"><a class="nav-link ew-tooltip" title="{{:loginTitle}}"{{props login}} data-{{:key}}="{{>prop}}"{{/props}}>{{:loginText}}</a></li>
    {{/if}}
    {{if canLogout}}
<li class="nav-item"><a class="nav-link ew-tooltip"{{props logout}} data-{{:key}}="{{>prop}}"{{/props}}>{{:logoutText}}</a></li>
    {{/if}}
{{/if}}
</script>
<meta name="generator" content="PHPMaker 2022.11.0">
</head>
<body class="<?= Config("BODY_CLASS") ?>">
<style>
    .sidebar-dark-teal .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-teal .nav-sidebar>.nav-item>.nav-link.active, .pace .pace-progress{
        background-color: #ca8e1c !important;
    }
    .navbar-teal{
        background-color: #9f2017 !important;
    }

    .ew-grid .ew-table>thead>tr>td, .ew-grid .ew-table>thead>tr>th, .ew-grid .ew-table>thead>tr>td, .ew-grid .ew-table>thead>tr>th{
        border-color: #9f2017 !important;
    }

    .ew-grid .ew-table>thead>*, .ew-grid .ew-table>thead>*>* {
        border-bottom-color: #9f2017!important;
    }
    .ew-grid .ew-table .ew-rpt-col-header, .ew-grid .ew-table .ew-rpt-col-summary, .ew-grid .ew-table .ew-table-header{
        background-color: #9f2017 !important;
        color: white!important;
    }
</style>
<?php if (@!$SkipHeaderFooter) { ?>
<div class="wrapper ew-layout">
    <!-- Main Header -->
    <!-- Navbar -->
    <nav class="<?= Config("NAVBAR_CLASS") ?>">
        <div class="container-fluid">
            <!-- Left navbar links -->
            <ul id="ew-navbar" class="navbar-nav">
                <li class="nav-item d-block">
                    <a class="nav-link" data-widget="pushmenu" data-enable-remember="true" data-ew-action="none"><i class="fas fa-bars ew-icon"></i></a>
                </li>
                <a class="navbar-brand d-none" href="#" data-ew-action="none">
                    <span class="brand-text">Disdukcapil Chatbot</span>
                </a>
            </ul>
            <!-- Right navbar links -->
            <ul id="ew-navbar-end" class="navbar-nav ms-auto"></ul>
        </div>
    </nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="<?= Config("SIDEBAR_CLASS") ?>">
        <div class="brand-container">
            <!-- Brand Logo //** Note: Only licensed users are allowed to change the logo ** -->
            <a href="#" class="brand-link">
                <span class="brand-text">Disdukcapil Chatbot</span>
            </a>
            <?php if (preg_match('/\bsidebar-mini\b/', Config("BODY_CLASS"))) { ?>
            <a class="pushmenu mx-1" data-pushmenu="mini" role="button"><i class="fas fa-angle-double-left"></i></a>
            <?php } ?>
        </div>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel -->
            <?php if (IsLoggedIn()) { ?>
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <?php if (GetClientVar("login", "currentUserName")) { ?>
                <div class="info">
                    <a class="d-block"><?= GetClientVar("login", "currentUserName") ?></a>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
            <!-- Sidebar Menu -->
            <nav id="ew-menu" class="mt-2"></nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
    <?php if (Config("PAGE_TITLE_STYLE") != "None") { ?>
            <div class="container-fluid">
                <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?= CurrentPageHeading() ?> <small class="text-muted"><?= CurrentPageSubheading() ?></small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <?php Breadcrumb()->render() ?>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
    <?php } ?>
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
<?php } ?>
<?= $content ?>
<?php if (@!$SkipHeaderFooter) { ?>
<?php
if (isset($DebugTimer)) {
    $DebugTimer->stop();
}
?>
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- ** Note: Only licensed users are allowed to change the copyright statement. ** -->
        <div class="ew-footer-text"><?= $Language->projectPhrase("FooterText") ?></div>
        <div class="float-end d-none d-sm-inline"></div>
    </footer>
</div>
<!-- ./wrapper -->
<?php } ?>
<script>
loadjs.done("wrapper");
</script>
<!-- template upload (for file upload) -->
<script id="template-upload" type="text/html">
{{for files}}
    <tr class="template-upload">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{{:name}}</p>
            <p class="error"></p>
        </td>
        <td>
            <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar bg-success" style="width: 0%;"></div></div>
        </td>
        <td>
            {{if !#index && !~root.options.autoUpload}}
            <button type="button" class="btn btn-default btn-sm start" disabled><?= $Language->phrase("UploadStart") ?></button>
            {{/if}}
            {{if !#index}}
            <button type="button" class="btn btn-default btn-sm cancel"><?= $Language->phrase("UploadCancel") ?></button>
            {{/if}}
        </td>
    </tr>
{{/for}}
</script>
<!-- template download (for file upload) -->
<script id="template-download" type="text/html">
{{for files}}
    <tr class="template-download">
        <td>
            <span class="preview">
                {{if !exists}}
                <span class="error"><?= $Language->phrase("FileNotFound") ?></span>
                {{else url && extension == "pdf"}}
                <div class="ew-pdfobject" data-url="{{>url}}" style="width: <?= Config("UPLOAD_THUMBNAIL_WIDTH") ?>px;"></div>
                {{else url && extension == "mp3"}}
                <audio controls><source type="audio/mpeg" src="{{>url}}"></audio>
                {{else url && extension == "mp4"}}
                <video controls><source type="video/mp4" src="{{>url}}"></video>
                {{else thumbnailUrl}}
                <a href="{{>url}}" title="{{>name}}" download="{{>name}}" class="ew-lightbox"><img class="ew-lazy" loading="lazy" src="{{>thumbnailUrl}}"></a>
                {{/if}}
            </span>
        </td>
        <td>
            <p class="name">
                {{if !exists}}
                <span class="text-muted">{{:name}}</span>
                {{else url && (extension == "pdf" || thumbnailUrl) && extension != "mp3" && extension != "mp4"}}
                <a href="{{>url}}" title="{{>name}}" data-extension="{{>extension}}" target="_blank">{{:name}}</a>
                {{else url}}
                <a href="{{>url}}" title="{{>name}}" data-extension="{{>extension}}" download="{{>name}}">{{:name}}</a>
                {{else}}
                <span>{{:name}}</span>
                {{/if}}
            </p>
            {{if error}}
            <div><span class="error">{{:error}}</span></div>
            {{/if}}
        </td>
        <td>
            <span class="size">{{:~root.formatFileSize(size)}}</span>
        </td>
        <td>
            {{if !~root.options.readonly && deleteUrl}}
            <button type="button" class="btn btn-default btn-sm delete" data-type="{{>deleteType}}" data-url="{{>deleteUrl}}"><?= $Language->phrase("UploadDelete") ?></button>
            {{else !~root.options.readonly}}
            <button type="button" class="btn btn-default btn-sm cancel"><?= $Language->phrase("UploadCancel") ?></button>
            {{/if}}
        </td>
    </tr>
{{/for}}
</script>
<!-- modal dialog -->
<div id="ew-modal-dialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog modal-fullscreen-sm-down"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"></h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= $Language->phrase("CloseBtn") ?>"></div><div class="modal-body"></div><div class="modal-footer"></div></div></div></div>
<!-- table header filter dropdown footer -->
<div id="ew-filter-dropdown-footer" class="d-none"><div class="dropdown-divider my-0"></div><div class="dropdown-footer text-start p-2"><button type="button" class="btn btn-link ew-btn ew-filter-clear"><?= $Language->phrase("Clear") ?></button><button type="button" class="btn btn-default ew-btn ew-filter-btn ms-2 float-end" data-value="false"><?= $Language->phrase("CancelBtn") ?></button><button type="button" class="btn btn-primary ew-btn ew-filter-btn ms-1 float-end" data-value="true"><?= $Language->phrase("OKBtn") ?></button></div></div>
<!-- import dialog -->
<div id="ew-import-dialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog modal-fullscreen-sm-down"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"></h5></div>
<div class="modal-body">
    <div class="fileinput-button ew-file-drop-zone w-100">
        <input type="file" class="form-control ew-file-input" title="" id="importfiles" name="importfiles[]" multiple lang="<?= CurrentLanguageID() ?>">
        <div class="text-muted ew-file-text">Drop file here or click to upload</div>
    </div>
    <div class="message d-none mt-3"></div>
    <div class="progress d-none mt-3"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-default ew-close-btn" data-bs-dismiss="modal"><?= $Language->phrase("CloseBtn") ?></button></div></div></div></div>
<!-- tooltip -->
<div id="ew-tooltip"></div>
<!-- drill down -->
<div id="ew-drilldown-panel"></div>
<script>
loadjs.done("wrapper");
</script>
<script>
loadjs.ready(ew.bundleIds, function() {
    if (!loadjs.isDefined("foot"))
        loadjs.done("foot");
});
</script>
</body>
</html>
