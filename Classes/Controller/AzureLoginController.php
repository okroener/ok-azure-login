<?php

namespace OliverKroener\OkAzureLogin\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use OliverKroener\OkAzureLogin\Service\AzureAuthService;

class AzureLoginController extends ActionController
{
    protected $azureAuthService;

    public function __construct()
    {
        // get typoscript configuration from configurationmanager
        $configuration = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'ok_azure_login'
        );
        $this->azureAuthService = new azureAuthService($configuration);;
    }

    public function loginAction()
    {
        $authCode = $this->request->getArgument('code');

        if ($authCode) {
            $accessToken = $this->azureAuthService->getAccessToken($authCode);
            $userData = $this->azureAuthService->getUserData($accessToken);

            // Register or login the backend user using $userData
        } else {
            // Redirect to Azure login page
        }
    }
}
