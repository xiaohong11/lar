<?php

return [
    'app_init' => [],
    'app_begin' => [
        'app\behavior\SaaSServiceBehavior',
    ],
    'frontend_init' => [
        'app\behavior\ReplaceLangBehavior',
    ],
    'template_replace' => [
        'app\behavior\ParseTemplateBehavior',
    ],
    'view_filter' => [
        'Behavior\TokenBuildBehavior'
    ]
];
