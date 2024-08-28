<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Azure Login',
    'description' => 'A TYPO3 extension to login using Microsoft Entra and MSGraph API.',
    'category' => 'plugin',
    'author' => 'Oliver Kroener',
    'author_email' => 'ok@oliver-kroener.de',
    'author_company' => 'Oliver Kroener',
    'state' => 'beta',
    'version' => '0.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-12.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'OliverKroener\\OkAzureLogin\\' => 'Classes/',
        ],
    ],
];
