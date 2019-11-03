<?php

$dbconf = require __DIR__ . '/dbconf.php';
$deploy = require __DIR__ . '/deploy.php';
$envfile = __DIR__ . '/config-local.php';
$application = require __DIR__ . '/app.php';
$env = is_file($envfile) ? require $envfile : array();
$static = empty($deploy['static_url']) ? rtrim(dirname(__ROOT__), '/') : $deploy['static_url'];

$config = [
    'url_model' => '0',
    'url_pathinfo_depr' => '/',

    'url_router_on' => true,
    'url_route_rules' => require dirname(__DIR__) . '/routes/web.php',

    'curl_http_version' => CURL_HTTP_VERSION_1_1, // 设置curl的HTTP版本

    'session_auto_start' => false,
    'session_options' => require __DIR__ . '/session.php',

    'default_module' => 'index',
    'action_prefix' => 'action',
    'var_pathinfo' => 'r',

    'taglib_begin' => '{',
    'taglib_end' => '}',

    'tmpl_file_depr' => '.',
    'tmpl_parse_string' => [
        '__STATIC__' => rtrim(str_replace('\\', '/', $static), '/'),
        '__PUBLIC__' => __ROOT__ . '/public',
        '__TPL__' => __ROOT__ . '/public'
    ],

    'upload_path' => empty($deploy['upload_path']) ? dirname(dirname(__DIR__)) . '/' : rtrim($deploy['upload_path'], '/') . '/',

    'assets' => require __DIR__ . '/assets.php',

    'tmpl_action_error' => dirname(__DIR__) . '/resources/views/vendor/message.html', // 默认错误跳转对应的模板文件
    'tmpl_action_success' => dirname(__DIR__) . '/resources/views/vendor/message.html', // 默认成功跳转对应的模板文件
    'tmpl_exception_file' => dirname(__DIR__) . '/resources/views/errors/exception.html',// 异常页面的模板文件

    'check_app_dir' => false
];

return array_merge($application, $config, $dbconf, $deploy, $env);
