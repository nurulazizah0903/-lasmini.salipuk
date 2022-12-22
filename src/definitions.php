<?php

namespace PHPMaker2022\pubinamarga;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;

return [
    "cache" => function (ContainerInterface $c) {
        return new \Slim\HttpCache\CacheProvider();
    },
    "view" => function (ContainerInterface $c) {
        return new PhpRenderer("views/");
    },
    "flash" => function (ContainerInterface $c) {
        return new \Slim\Flash\Messages();
    },
    "audit" => function (ContainerInterface $c) {
        $logger = new Logger("audit"); // For audit trail
        $logger->pushHandler(new AuditTrailHandler("audit.log"));
        return $logger;
    },
    "log" => function (ContainerInterface $c) {
        global $RELATIVE_PATH;
        $logger = new Logger("log");
        $logger->pushHandler(new RotatingFileHandler($RELATIVE_PATH . "log.log"));
        return $logger;
    },
    "sqllogger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debugstack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "csrf" => function (ContainerInterface $c) {
        global $ResponseFactory;
        return new Guard($ResponseFactory, Config("CSRF_PREFIX"));
    },
    "debugstack" => \DI\create(DebugStack::class),
    "debugsqllogger" => \DI\create(DebugSqlLogger::class),
    "security" => \DI\create(AdvancedSecurity::class),
    "profile" => \DI\create(UserProfile::class),
    "language" => \DI\create(Language::class),
    "timer" => \DI\create(Timer::class),
    "session" => \DI\create(HttpSession::class),

    // Tables
    "jalan" => \DI\create(Jalan::class),
    "kordinat_jalan" => \DI\create(KordinatJalan::class),
    "pelapor" => \DI\create(Pelapor::class),
    "pengaduan" => \DI\create(Pengaduan::class),
    "broadcast" => \DI\create(Broadcast::class),
    "pertanyaan" => \DI\create(Pertanyaan::class),
    "setting_aplikasi" => \DI\create(SettingAplikasi::class),
    "setting" => \DI\create(Setting::class),
    "pengguna" => \DI\create(Pengguna::class),
    "form_pengaduan" => \DI\create(FormPengaduan::class),
    "log_user_chat" => \DI\create(LogUserChat::class),
    "broadcast_tujuan" => \DI\create(BroadcastTujuan::class),
    "ReportLogUserChat" => \DI\create(ReportLogUserChat::class),
    "upt" => \DI\create(Upt::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "userlevels" => \DI\create(Userlevels::class),
    "ReportPengaduan" => \DI\create(ReportPengaduan::class),
    "Dashboard2" => \DI\create(Dashboard2::class),

    // User table
    "usertable" => \DI\get("pengguna"),
];
