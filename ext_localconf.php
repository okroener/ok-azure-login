<?php

defined('TYPO3') or die();

call_user_func(function () {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'OliverKroener.ok_azure_login',
            'Pi1',
            [
                \OliverKroener\OkAzureLogin\Controller\AzureLoginController::class => 'login'
            ],
            // non-cacheable actions
            [
                \OliverKroener\OkAzureLogin\Controller\AzureLoginController::class => 'login'
            ]
        );
    }
);
