<?php

/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * NOTE: This file is ignored from Git by default with the .gitignore included
 * in laminas-mvc-skeleton. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return [
    'db' => [
        'driver' => 'pdo_mysql',
        'host' => 'acsi-dev-mysql',
        'port' => '3306',
        'user' => 'root',
        'password' => 'b3unh44s',
        'dbname' => 'laminas',
        'charset' => 'utf8',
    ],
];
