<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(
    function () {
        ExtensionManagementUtility::addPlugin(
            [
                'LLL:EXT:ok_azure_login/Resources/Private/Language/locallang_db.xlf:tx_okazurelogin.name',
                'ok_azure_login'
            ],
            'list_type',
            'ok_azure_login'
        );

        // Add static TypoScript
        ExtensionManagementUtility::addStaticFile('ok_azure_login', 'Configuration/TypoScript', 'Azure Login');
    }
);
