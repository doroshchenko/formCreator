<?php

$configs = require_once '../config/configs.php';
try {
    $dsn = 'mysql:host=' . $configs['storage_settings']['host'];
    $user = $configs['storage_settings']['user'];
    $password = $configs['storage_settings']['password'];

    $connection = $connection = new PDO($dsn, $user, $password,
            array(PDO::ATTR_EMULATE_PREPARES => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            )
        );
    $sql = array(
        'CREATE DATABASE IF NOT EXISTS `' . $configs['storage_settings']['database'] . '`',
        'USE `' . $configs['storage_settings']['database'] . '`',
        'CREATE TABLE IF NOT EXISTS `form` (
            `id_form` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(100) COLLATE utf8_bin NOT NULL,
            `action` varchar(30) COLLATE utf8_bin DEFAULT NULL,
            `enctype` varchar(60) COLLATE utf8_bin default NULL,
            `method` varchar(30) COLLATE utf8_bin NOT NULL,
             PRIMARY KEY (`id_form`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1',
        ' CREATE TABLE IF NOT EXISTS `form_element` (
            `id_form_element` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `id_form` int(10) unsigned NOT NULL,
            `name` varchar(100) COLLATE utf8_bin NOT NULL,
            `label` varchar(100) COLLATE utf8_bin NOT NULL,
            `type` varchar(50) COLLATE utf8_bin NOT NULL,
            PRIMARY KEY (`id_form_element`),
            INDEX `id_form` (`id_form`),
            FOREIGN KEY (`id_form`)
            REFERENCES `form` (`id_form`)
            ON UPDATE CASCADE ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1',
        'CREATE TABLE IF NOT EXISTS `form_element_value` (
            `id_form_element` int(10) unsigned NOT NULL,
            `value` varchar(500) default NULL,
            INDEX `form_element_value` (`id_form_element`, `value`),
            FOREIGN KEY (`id_form_element`)
            REFERENCES `form_element` (`id_form_element`)
            ON UPDATE CASCADE ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
    );
    foreach ($sql as $query) {
        $connection->query($query);
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}

die('completed');

