<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(
    function () {
        ExtensionManagementUtility::addTCAcolumns('tt_content', [
            'tx_okazurelogin_login_type' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:ok_azure_login/Resources/Private/Language/locallang_db.xlf:tt_content.login_type',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['LLL:EXT:ok_azure_login/Resources/Private/Language/locallang_db.xlf:tt_content.login_type.frontend', 'frontend'],
                        ['LLL:EXT:ok_azure_login/Resources/Private/Language/locallang_db.xlf:tt_content.login_type.backend', 'backend'],
                    ],
                    'default' => 'frontend'
                ]
            ],
        ]);

        ExtensionManagementUtility::addToAllTCAtypes(
            'tt_content',
            'tx_okazurelogin_login_type',
            '',
            'after:header'
        );

        // Exclude storage page and recursive options for the plugin
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['ok_azure_login'] = 'pages,recursive';
    }
);
