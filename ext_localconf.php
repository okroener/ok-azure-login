<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(
    function () {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'OkAzureLogin',
            'Login',
            [
                \OliverKroener\OkAzureLogin\Controller\LoginController::class => 'show, login'
            ],
            // non-cacheable actions
            [
                \OliverKroener\OkAzureLogin\Controller\LoginController::class => 'login'
            ]
        );

        // Register the authentication service for backend users
        ExtensionManagementUtility::addService(
            'ok_azure_login',
            'auth',
            \OliverKroener\OkAzureLogin\Authentication\AzureLoginAuthService::class,
            [
                'title' => 'Azure Login Backend Authentication',
                'description' => 'Custom authentication service for backend users using Azure',
                'subtype' => 'getUserBE,authUserBE',
                'available' => true,
                'priority' => 50,
                'quality' => 50,
                'os' => '',
                'exec' => '',
                'className' => \OliverKroener\OkAzureLogin\Authentication\AzureLoginAuthService::class,
            ]
        );
    }
);
