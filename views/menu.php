<?php

namespace PHPMaker2022\pubinamarga;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(27, "mi_Dashboard2", $MenuLanguage->MenuPhrase("27", "MenuText"), $MenuRelativePath . "Dashboard2", -1, "", AllowListMenu('{11A19D5D-FC84-4A0A-BEBD-97472F31DBAB}Dashboard'), false, false, "", "", false, true);
//$sideMenu->addMenuItem(23, "mi_upt", $MenuLanguage->MenuPhrase("23", "MenuText"), $MenuRelativePath . "UptList", -1, "", AllowListMenu('{11A19D5D-FC84-4A0A-BEBD-97472F31DBAB}upt'), false, false, "", "", false, true);
$sideMenu->addMenuItem(19, "mi_log_user_chat", $MenuLanguage->MenuPhrase("19", "MenuText"), $MenuRelativePath . "LogUserChatList", -1, "", AllowListMenu('{11A19D5D-FC84-4A0A-BEBD-97472F31DBAB}log_user_chat'), false, false, "", "", false, true);
//$sideMenu->addMenuItem(18, "mi_form_pengaduan", $MenuLanguage->MenuPhrase("18", "MenuText"), $MenuRelativePath . "FormPengaduan", -1, "", AllowListMenu('{11A19D5D-FC84-4A0A-BEBD-97472F31DBAB}form_pengaduan.php'), false, false, "", "", false, true);
//$sideMenu->addMenuItem(1, "mi_jalan", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "JalanList", -1, "", AllowListMenu('{11A19D5D-FC84-4A0A-BEBD-97472F31DBAB}jalan'), false, false, "", "", false, true);
$sideMenu->addMenuItem(3, "mi_pelapor", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "PelaporList", -1, "", AllowListMenu('{11A19D5D-FC84-4A0A-BEBD-97472F31DBAB}pelapor'), false, false, "", "", false, true);
//$sideMenu->addMenuItem(4, "mi_pengaduan", $MenuLanguage->MenuPhrase("4", "MenuText"), $MenuRelativePath . "PengaduanList", -1, "", AllowListMenu('{11A19D5D-FC84-4A0A-BEBD-97472F31DBAB}pengaduan'), false, false, "", "", false, true);
$sideMenu->addMenuItem(5, "mi_broadcast", $MenuLanguage->MenuPhrase("5", "MenuText"), $MenuRelativePath . "BroadcastList", -1, "", AllowListMenu('{11A19D5D-FC84-4A0A-BEBD-97472F31DBAB}broadcast'), false, false, "", "", false, true);
$sideMenu->addMenuItem(6, "mi_pertanyaan", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "PertanyaanList", -1, "", AllowListMenu('{11A19D5D-FC84-4A0A-BEBD-97472F31DBAB}pertanyaan'), false, false, "", "", false, true);
$sideMenu->addMenuItem(16, "mci_Setting", $MenuLanguage->MenuPhrase("16", "MenuText"), "", -1, "", true, false, true, "", "", false, true);
$sideMenu->addMenuItem(8, "mi_setting", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "SettingList", 16, "", AllowListMenu('{11A19D5D-FC84-4A0A-BEBD-97472F31DBAB}setting'), false, false, "", "", false, true);
$sideMenu->addMenuItem(7, "mi_setting_aplikasi", $MenuLanguage->MenuPhrase("7", "MenuText"), $MenuRelativePath . "SettingAplikasi", 16, "", AllowListMenu('{11A19D5D-FC84-4A0A-BEBD-97472F31DBAB}setting_aplikasi.php'), false, false, "", "", false, true);
//$sideMenu->addMenuItem(17, "mi_pengguna", $MenuLanguage->MenuPhrase("17", "MenuText"), $MenuRelativePath . "PenggunaList", 16, "", AllowListMenu('{11A19D5D-FC84-4A0A-BEBD-97472F31DBAB}pengguna'), false, false, "", "", false, true);
//$sideMenu->addMenuItem(25, "mi_userlevels", $MenuLanguage->MenuPhrase("25", "MenuText"), $MenuRelativePath . "UserlevelsList", 16, "", AllowListMenu('{11A19D5D-FC84-4A0A-BEBD-97472F31DBAB}userlevels'), false, false, "", "", false, true);
echo $sideMenu->toScript();
