<?php

namespace PHPMaker2022\pubinamarga;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // jalan
    $app->map(["GET","POST","OPTIONS"], '/JalanList[/{id}]', JalanController::class . ':list')->add(PermissionMiddleware::class)->setName('JalanList-jalan-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/JalanAdd[/{id}]', JalanController::class . ':add')->add(PermissionMiddleware::class)->setName('JalanAdd-jalan-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/JalanView[/{id}]', JalanController::class . ':view')->add(PermissionMiddleware::class)->setName('JalanView-jalan-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/JalanEdit[/{id}]', JalanController::class . ':edit')->add(PermissionMiddleware::class)->setName('JalanEdit-jalan-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/JalanDelete[/{id}]', JalanController::class . ':delete')->add(PermissionMiddleware::class)->setName('JalanDelete-jalan-delete'); // delete
    $app->group(
        '/jalan',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', JalanController::class . ':list')->add(PermissionMiddleware::class)->setName('jalan/list-jalan-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', JalanController::class . ':add')->add(PermissionMiddleware::class)->setName('jalan/add-jalan-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', JalanController::class . ':view')->add(PermissionMiddleware::class)->setName('jalan/view-jalan-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', JalanController::class . ':edit')->add(PermissionMiddleware::class)->setName('jalan/edit-jalan-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', JalanController::class . ':delete')->add(PermissionMiddleware::class)->setName('jalan/delete-jalan-delete-2'); // delete
        }
    );

    // kordinat_jalan
    $app->map(["GET","POST","OPTIONS"], '/KordinatJalanList[/{id}]', KordinatJalanController::class . ':list')->add(PermissionMiddleware::class)->setName('KordinatJalanList-kordinat_jalan-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/KordinatJalanAdd[/{id}]', KordinatJalanController::class . ':add')->add(PermissionMiddleware::class)->setName('KordinatJalanAdd-kordinat_jalan-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/KordinatJalanView[/{id}]', KordinatJalanController::class . ':view')->add(PermissionMiddleware::class)->setName('KordinatJalanView-kordinat_jalan-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/KordinatJalanEdit[/{id}]', KordinatJalanController::class . ':edit')->add(PermissionMiddleware::class)->setName('KordinatJalanEdit-kordinat_jalan-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/KordinatJalanDelete[/{id}]', KordinatJalanController::class . ':delete')->add(PermissionMiddleware::class)->setName('KordinatJalanDelete-kordinat_jalan-delete'); // delete
    $app->group(
        '/kordinat_jalan',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', KordinatJalanController::class . ':list')->add(PermissionMiddleware::class)->setName('kordinat_jalan/list-kordinat_jalan-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', KordinatJalanController::class . ':add')->add(PermissionMiddleware::class)->setName('kordinat_jalan/add-kordinat_jalan-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', KordinatJalanController::class . ':view')->add(PermissionMiddleware::class)->setName('kordinat_jalan/view-kordinat_jalan-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', KordinatJalanController::class . ':edit')->add(PermissionMiddleware::class)->setName('kordinat_jalan/edit-kordinat_jalan-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', KordinatJalanController::class . ':delete')->add(PermissionMiddleware::class)->setName('kordinat_jalan/delete-kordinat_jalan-delete-2'); // delete
        }
    );

    // pelapor
    $app->map(["GET","POST","OPTIONS"], '/PelaporList[/{id}]', PelaporController::class . ':list')->add(PermissionMiddleware::class)->setName('PelaporList-pelapor-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/PelaporAdd[/{id}]', PelaporController::class . ':add')->add(PermissionMiddleware::class)->setName('PelaporAdd-pelapor-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/PelaporView[/{id}]', PelaporController::class . ':view')->add(PermissionMiddleware::class)->setName('PelaporView-pelapor-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/PelaporEdit[/{id}]', PelaporController::class . ':edit')->add(PermissionMiddleware::class)->setName('PelaporEdit-pelapor-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/PelaporDelete[/{id}]', PelaporController::class . ':delete')->add(PermissionMiddleware::class)->setName('PelaporDelete-pelapor-delete'); // delete
    $app->group(
        '/pelapor',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', PelaporController::class . ':list')->add(PermissionMiddleware::class)->setName('pelapor/list-pelapor-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', PelaporController::class . ':add')->add(PermissionMiddleware::class)->setName('pelapor/add-pelapor-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', PelaporController::class . ':view')->add(PermissionMiddleware::class)->setName('pelapor/view-pelapor-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', PelaporController::class . ':edit')->add(PermissionMiddleware::class)->setName('pelapor/edit-pelapor-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', PelaporController::class . ':delete')->add(PermissionMiddleware::class)->setName('pelapor/delete-pelapor-delete-2'); // delete
        }
    );

    // pengaduan
    $app->map(["GET","POST","OPTIONS"], '/PengaduanList[/{id}]', PengaduanController::class . ':list')->add(PermissionMiddleware::class)->setName('PengaduanList-pengaduan-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/PengaduanAdd[/{id}]', PengaduanController::class . ':add')->add(PermissionMiddleware::class)->setName('PengaduanAdd-pengaduan-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/PengaduanView[/{id}]', PengaduanController::class . ':view')->add(PermissionMiddleware::class)->setName('PengaduanView-pengaduan-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/PengaduanEdit[/{id}]', PengaduanController::class . ':edit')->add(PermissionMiddleware::class)->setName('PengaduanEdit-pengaduan-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/PengaduanDelete[/{id}]', PengaduanController::class . ':delete')->add(PermissionMiddleware::class)->setName('PengaduanDelete-pengaduan-delete'); // delete
    $app->group(
        '/pengaduan',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', PengaduanController::class . ':list')->add(PermissionMiddleware::class)->setName('pengaduan/list-pengaduan-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', PengaduanController::class . ':add')->add(PermissionMiddleware::class)->setName('pengaduan/add-pengaduan-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', PengaduanController::class . ':view')->add(PermissionMiddleware::class)->setName('pengaduan/view-pengaduan-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', PengaduanController::class . ':edit')->add(PermissionMiddleware::class)->setName('pengaduan/edit-pengaduan-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', PengaduanController::class . ':delete')->add(PermissionMiddleware::class)->setName('pengaduan/delete-pengaduan-delete-2'); // delete
        }
    );

    // broadcast
    $app->map(["GET","POST","OPTIONS"], '/BroadcastList[/{id}]', BroadcastController::class . ':list')->add(PermissionMiddleware::class)->setName('BroadcastList-broadcast-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/BroadcastAdd[/{id}]', BroadcastController::class . ':add')->add(PermissionMiddleware::class)->setName('BroadcastAdd-broadcast-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/BroadcastView[/{id}]', BroadcastController::class . ':view')->add(PermissionMiddleware::class)->setName('BroadcastView-broadcast-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/BroadcastEdit[/{id}]', BroadcastController::class . ':edit')->add(PermissionMiddleware::class)->setName('BroadcastEdit-broadcast-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/BroadcastDelete[/{id}]', BroadcastController::class . ':delete')->add(PermissionMiddleware::class)->setName('BroadcastDelete-broadcast-delete'); // delete
    $app->group(
        '/broadcast',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', BroadcastController::class . ':list')->add(PermissionMiddleware::class)->setName('broadcast/list-broadcast-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', BroadcastController::class . ':add')->add(PermissionMiddleware::class)->setName('broadcast/add-broadcast-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', BroadcastController::class . ':view')->add(PermissionMiddleware::class)->setName('broadcast/view-broadcast-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', BroadcastController::class . ':edit')->add(PermissionMiddleware::class)->setName('broadcast/edit-broadcast-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', BroadcastController::class . ':delete')->add(PermissionMiddleware::class)->setName('broadcast/delete-broadcast-delete-2'); // delete
        }
    );

    // pertanyaan
    $app->map(["GET","POST","OPTIONS"], '/PertanyaanList[/{id}]', PertanyaanController::class . ':list')->add(PermissionMiddleware::class)->setName('PertanyaanList-pertanyaan-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/PertanyaanAdd[/{id}]', PertanyaanController::class . ':add')->add(PermissionMiddleware::class)->setName('PertanyaanAdd-pertanyaan-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/PertanyaanView[/{id}]', PertanyaanController::class . ':view')->add(PermissionMiddleware::class)->setName('PertanyaanView-pertanyaan-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/PertanyaanEdit[/{id}]', PertanyaanController::class . ':edit')->add(PermissionMiddleware::class)->setName('PertanyaanEdit-pertanyaan-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/PertanyaanDelete[/{id}]', PertanyaanController::class . ':delete')->add(PermissionMiddleware::class)->setName('PertanyaanDelete-pertanyaan-delete'); // delete
    $app->group(
        '/pertanyaan',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', PertanyaanController::class . ':list')->add(PermissionMiddleware::class)->setName('pertanyaan/list-pertanyaan-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', PertanyaanController::class . ':add')->add(PermissionMiddleware::class)->setName('pertanyaan/add-pertanyaan-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', PertanyaanController::class . ':view')->add(PermissionMiddleware::class)->setName('pertanyaan/view-pertanyaan-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', PertanyaanController::class . ':edit')->add(PermissionMiddleware::class)->setName('pertanyaan/edit-pertanyaan-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', PertanyaanController::class . ':delete')->add(PermissionMiddleware::class)->setName('pertanyaan/delete-pertanyaan-delete-2'); // delete
        }
    );

    // setting_aplikasi
    $app->map(["GET", "POST", "OPTIONS"], '/SettingAplikasi[/{params:.*}]', SettingAplikasiController::class)->add(PermissionMiddleware::class)->setName('SettingAplikasi-setting_aplikasi-custom'); // custom

    // setting
    $app->map(["GET","POST","OPTIONS"], '/SettingList[/{id}]', SettingController::class . ':list')->add(PermissionMiddleware::class)->setName('SettingList-setting-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/SettingAdd[/{id}]', SettingController::class . ':add')->add(PermissionMiddleware::class)->setName('SettingAdd-setting-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/SettingView[/{id}]', SettingController::class . ':view')->add(PermissionMiddleware::class)->setName('SettingView-setting-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/SettingEdit[/{id}]', SettingController::class . ':edit')->add(PermissionMiddleware::class)->setName('SettingEdit-setting-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/SettingDelete[/{id}]', SettingController::class . ':delete')->add(PermissionMiddleware::class)->setName('SettingDelete-setting-delete'); // delete
    $app->group(
        '/setting',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', SettingController::class . ':list')->add(PermissionMiddleware::class)->setName('setting/list-setting-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', SettingController::class . ':add')->add(PermissionMiddleware::class)->setName('setting/add-setting-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', SettingController::class . ':view')->add(PermissionMiddleware::class)->setName('setting/view-setting-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', SettingController::class . ':edit')->add(PermissionMiddleware::class)->setName('setting/edit-setting-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', SettingController::class . ':delete')->add(PermissionMiddleware::class)->setName('setting/delete-setting-delete-2'); // delete
        }
    );

    // pengguna
    $app->map(["GET","POST","OPTIONS"], '/PenggunaList[/{id}]', PenggunaController::class . ':list')->add(PermissionMiddleware::class)->setName('PenggunaList-pengguna-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/PenggunaAdd[/{id}]', PenggunaController::class . ':add')->add(PermissionMiddleware::class)->setName('PenggunaAdd-pengguna-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/PenggunaView[/{id}]', PenggunaController::class . ':view')->add(PermissionMiddleware::class)->setName('PenggunaView-pengguna-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/PenggunaEdit[/{id}]', PenggunaController::class . ':edit')->add(PermissionMiddleware::class)->setName('PenggunaEdit-pengguna-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/PenggunaDelete[/{id}]', PenggunaController::class . ':delete')->add(PermissionMiddleware::class)->setName('PenggunaDelete-pengguna-delete'); // delete
    $app->group(
        '/pengguna',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', PenggunaController::class . ':list')->add(PermissionMiddleware::class)->setName('pengguna/list-pengguna-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', PenggunaController::class . ':add')->add(PermissionMiddleware::class)->setName('pengguna/add-pengguna-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', PenggunaController::class . ':view')->add(PermissionMiddleware::class)->setName('pengguna/view-pengguna-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', PenggunaController::class . ':edit')->add(PermissionMiddleware::class)->setName('pengguna/edit-pengguna-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', PenggunaController::class . ':delete')->add(PermissionMiddleware::class)->setName('pengguna/delete-pengguna-delete-2'); // delete
        }
    );

    // form_pengaduan
    $app->map(["GET", "POST", "OPTIONS"], '/FormPengaduan[/{params:.*}]', FormPengaduanController::class)->add(PermissionMiddleware::class)->setName('FormPengaduan-form_pengaduan-custom'); // custom

    // log_user_chat
    $app->map(["GET","POST","OPTIONS"], '/LogUserChatList[/{id}]', LogUserChatController::class . ':list')->add(PermissionMiddleware::class)->setName('LogUserChatList-log_user_chat-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/LogUserChatAdd[/{id}]', LogUserChatController::class . ':add')->add(PermissionMiddleware::class)->setName('LogUserChatAdd-log_user_chat-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/LogUserChatView[/{id}]', LogUserChatController::class . ':view')->add(PermissionMiddleware::class)->setName('LogUserChatView-log_user_chat-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/LogUserChatEdit[/{id}]', LogUserChatController::class . ':edit')->add(PermissionMiddleware::class)->setName('LogUserChatEdit-log_user_chat-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/LogUserChatDelete[/{id}]', LogUserChatController::class . ':delete')->add(PermissionMiddleware::class)->setName('LogUserChatDelete-log_user_chat-delete'); // delete
    $app->group(
        '/log_user_chat',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', LogUserChatController::class . ':list')->add(PermissionMiddleware::class)->setName('log_user_chat/list-log_user_chat-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', LogUserChatController::class . ':add')->add(PermissionMiddleware::class)->setName('log_user_chat/add-log_user_chat-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', LogUserChatController::class . ':view')->add(PermissionMiddleware::class)->setName('log_user_chat/view-log_user_chat-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', LogUserChatController::class . ':edit')->add(PermissionMiddleware::class)->setName('log_user_chat/edit-log_user_chat-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', LogUserChatController::class . ':delete')->add(PermissionMiddleware::class)->setName('log_user_chat/delete-log_user_chat-delete-2'); // delete
        }
    );

    // broadcast_tujuan
    $app->map(["GET","POST","OPTIONS"], '/BroadcastTujuanList[/{id}]', BroadcastTujuanController::class . ':list')->add(PermissionMiddleware::class)->setName('BroadcastTujuanList-broadcast_tujuan-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/BroadcastTujuanAdd[/{id}]', BroadcastTujuanController::class . ':add')->add(PermissionMiddleware::class)->setName('BroadcastTujuanAdd-broadcast_tujuan-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/BroadcastTujuanView[/{id}]', BroadcastTujuanController::class . ':view')->add(PermissionMiddleware::class)->setName('BroadcastTujuanView-broadcast_tujuan-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/BroadcastTujuanEdit[/{id}]', BroadcastTujuanController::class . ':edit')->add(PermissionMiddleware::class)->setName('BroadcastTujuanEdit-broadcast_tujuan-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/BroadcastTujuanDelete[/{id}]', BroadcastTujuanController::class . ':delete')->add(PermissionMiddleware::class)->setName('BroadcastTujuanDelete-broadcast_tujuan-delete'); // delete
    $app->group(
        '/broadcast_tujuan',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', BroadcastTujuanController::class . ':list')->add(PermissionMiddleware::class)->setName('broadcast_tujuan/list-broadcast_tujuan-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', BroadcastTujuanController::class . ':add')->add(PermissionMiddleware::class)->setName('broadcast_tujuan/add-broadcast_tujuan-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', BroadcastTujuanController::class . ':view')->add(PermissionMiddleware::class)->setName('broadcast_tujuan/view-broadcast_tujuan-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', BroadcastTujuanController::class . ':edit')->add(PermissionMiddleware::class)->setName('broadcast_tujuan/edit-broadcast_tujuan-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', BroadcastTujuanController::class . ':delete')->add(PermissionMiddleware::class)->setName('broadcast_tujuan/delete-broadcast_tujuan-delete-2'); // delete
        }
    );

    // ReportLogUserChat
    $app->map(["GET", "POST", "OPTIONS"], '/ReportLogUserChat', ReportLogUserChatController::class)->add(PermissionMiddleware::class)->setName('ReportLogUserChat-ReportLogUserChat-summary'); // summary

    // upt
    $app->map(["GET","POST","OPTIONS"], '/UptList[/{id}]', UptController::class . ':list')->add(PermissionMiddleware::class)->setName('UptList-upt-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/UptAdd[/{id}]', UptController::class . ':add')->add(PermissionMiddleware::class)->setName('UptAdd-upt-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/UptView[/{id}]', UptController::class . ':view')->add(PermissionMiddleware::class)->setName('UptView-upt-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/UptEdit[/{id}]', UptController::class . ':edit')->add(PermissionMiddleware::class)->setName('UptEdit-upt-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/UptDelete[/{id}]', UptController::class . ':delete')->add(PermissionMiddleware::class)->setName('UptDelete-upt-delete'); // delete
    $app->group(
        '/upt',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', UptController::class . ':list')->add(PermissionMiddleware::class)->setName('upt/list-upt-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', UptController::class . ':add')->add(PermissionMiddleware::class)->setName('upt/add-upt-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', UptController::class . ':view')->add(PermissionMiddleware::class)->setName('upt/view-upt-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', UptController::class . ':edit')->add(PermissionMiddleware::class)->setName('upt/edit-upt-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', UptController::class . ':delete')->add(PermissionMiddleware::class)->setName('upt/delete-upt-delete-2'); // delete
        }
    );

    // userlevelpermissions
    $app->map(["GET","POST","OPTIONS"], '/UserlevelpermissionsList[/{keys:.*}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsList-userlevelpermissions-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/UserlevelpermissionsAdd[/{keys:.*}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsAdd-userlevelpermissions-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/UserlevelpermissionsView[/{keys:.*}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsView-userlevelpermissions-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/UserlevelpermissionsEdit[/{keys:.*}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsEdit-userlevelpermissions-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/UserlevelpermissionsDelete[/{keys:.*}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsDelete-userlevelpermissions-delete'); // delete
    $app->group(
        '/userlevelpermissions',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermissions/list-userlevelpermissions-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelpermissions/add-userlevelpermissions-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevelpermissions/view-userlevelpermissions-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelpermissions/edit-userlevelpermissions-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelpermissions/delete-userlevelpermissions-delete-2'); // delete
        }
    );

    // userlevels
    $app->map(["GET","POST","OPTIONS"], '/UserlevelsList[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelsList-userlevels-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/UserlevelsAdd[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelsAdd-userlevels-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/UserlevelsView[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelsView-userlevels-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/UserlevelsEdit[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelsEdit-userlevels-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/UserlevelsDelete[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelsDelete-userlevels-delete'); // delete
    $app->group(
        '/userlevels',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevels/list-userlevels-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevels/add-userlevels-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevels/view-userlevels-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevels/edit-userlevels-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevels/delete-userlevels-delete-2'); // delete
        }
    );

    // ReportPengaduan
    $app->map(["GET", "POST", "OPTIONS"], '/ReportPengaduan', ReportPengaduanController::class)->add(PermissionMiddleware::class)->setName('ReportPengaduan-ReportPengaduan-summary'); // summary

    // Dashboard2
    $app->map(["GET", "POST", "OPTIONS"], '/Dashboard2', Dashboard2Controller::class)->add(PermissionMiddleware::class)->setName('Dashboard2-Dashboard2-dashboard'); // dashboard

    // error
    $app->map(["GET","POST","OPTIONS"], '/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // personal_data
    $app->map(["GET","POST","OPTIONS"], '/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->map(["GET","POST","OPTIONS"], '/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // userpriv
    $app->map(["GET","POST","OPTIONS"], '/userpriv', OthersController::class . ':userpriv')->add(PermissionMiddleware::class)->setName('userpriv');

    // logout
    $app->map(["GET","POST","OPTIONS"], '/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->get('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
