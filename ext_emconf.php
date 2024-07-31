<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Azure Login',
    'description' => 'Login and register backend users using Azure AD',
    'category' => 'frontend',
    'author' => 'Oliver Kroener',
    'author_email' => 'ok@oliver-kroener.de',
    'state' => 'beta',
    'clearCacheOnLoad' => 0,
    'version' => '0.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-12.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
