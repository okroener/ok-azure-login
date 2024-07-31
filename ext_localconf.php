<?php

// defined('TYPO3') or die();

call_user_func(function () {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'OkAzureLogin',
            'Pi1',
            [
                'AzureLoginController' => 'login'
            ],
            // non-cacheable actions
            [
                'AzureLoginController' => 'login'
            ]
        );
    }
);
