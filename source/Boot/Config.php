<?php

//Configurações do banco de dados
define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "sorridents",
    "username" => "root",
    "passwd" => "",
    "options" => [
         PDO :: MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
         PDO :: ATTR_ERRMODE => PDO :: ERRMODE_EXCEPTION ,
         PDO :: ATTR_DEFAULT_FETCH_MODE => PDO :: FETCH_OBJ ,
         PDO :: ATTR_CASE => PDO :: CASE_NATURAL
    ]
]);

//URLs
define('CONF_URL_BASE','http://localhost/sorridentsapi');
define('CONF_VIEW_PATH',__DIR__.'/../../views/');
define('CONF_VIEW_EXT','php');
define('CONF_URL_API','api.localhost/sorridentsapi');

//Senhas
define("CONF_PASSWD_MIN_LEN", 8);
define("CONF_PASSWD_MAX_LEN", 40);
define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
define("CONF_PASSWD_OPTION", ["const"=> 10]);

//Site
define("CONF_SITE_NAME", "Clinica Sorridents");
define("CONF_SITE_LANG", "pt_BR");
define("CONF_SITE_DOMAIN", "sorridents.com.br");
define("CONF_SITE_DESC", "Tratando sua saúde bucal com respeito, carinho e dedicação.");
define("CONF_SITE_TITLE", "Sorridents");

//Social
define("CONF_SOCIAL_TWITTER_CREATOR", "@renangabriel");
define("CONF_SOCIAL_TWITTER_PUBLISHER", "@renangabriel");
define("CONF_SOCIAL_FACEBOOK_APP", "626590460695980");
define("CONF_SOCIAL_FACEBOOK_PAGE", "renangabriel");
define("CONF_SOCIAL_FACEBOOK_AUTHOR", "renangabriel");
define("CONF_SOCIAL_GOOGLE_PAGE", "107305124528362639842");
define("CONF_SOCIAL_GOOGLE_AUTHOR", "103958419096641225872");
define("CONF_SOCIAL_LINKEDIN", "tiago-pereira-ramos-9b13b394");

//Dates
define("CONF_DATE_BR", "d/m/Y H:i:s");
define("CONF_DATE_APP", "Y-m-d H:i:s");

//Message
define("CONF_MESSAGE_CLASS", "trigger");
define("CONF_MESSAGE_INFO", "info");
define("CONF_MESSAGE_SUCCESS", "success");
define("CONF_MESSAGE_WARNING", "warning");
define("CONF_MESSAGE_ERROR", "error");

//Upload
define("CONF_UPLOAD_DIR", "../storage");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_FILE_DIR", "files");
define("CONF_UPLOAD_MEDIA_DIR", "medias");

//Images
define("CONF_IMAGE_CACHE", CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR . "/cache");
define("CONF_IMAGE_SIZE", 2000);
define("CONF_IMAGE_QUALITY", ["jpg" => 75, "png" => 5]);

//Mail
define("CONF_MAIL_HOST", "smtp.hostinger.net");
define("CONF_MAIL_PORT", "587");
define("CONF_MAIL_USER", "renan.gab153@gmail.com");
define("CONF_MAIL_PASS", "**************************");
define("CONF_MAIL_SENDER", ["name" => "Renan Gabriel", "address" => "renan.gab153@gmail.com"]);
define("CONF_MAIL_SUPPORT", "renan.gab153@gmail.com");
define("CONF_MAIL_OPTION_LANG", "br");
define("CONF_MAIL_OPTION_HTML", true);
define("CONF_MAIL_OPTION_AUTH", true);
define("CONF_MAIL_OPTION_SECURE", "tls");
define("CONF_MAIL_OPTION_CHARSET", "utf-8");