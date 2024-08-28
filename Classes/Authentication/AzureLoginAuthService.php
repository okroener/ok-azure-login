<?php

namespace OliverKroener\OkAzureLogin\Authentication;

use TYPO3\CMS\Core\Authentication\AbstractAuthenticationService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\ServerRequestFactory;

class AzureLoginAuthService extends AbstractAuthenticationService
{
    protected ?array $user;

    public function getUser()
    {
        // Retrieve the 'code' parameter from the global $_GET array
        $request = ServerRequestFactory::fromGlobals();
        $code = $GLOBALS['_REQUEST']['code'] ?? null;

        // Custom logic to fetch user based on the 'code' parameter
        // For example, use the 'code' to fetch user details from Azure
        if ($code) {
            $user = $this->fetchUserFromAzure($code);
            return $user;
        }

        return null;
    }

    public function authUser(array $user): int
    {
        // Custom logic to authenticate user
        // Return one of the predefined constants (200 for success, -1 for failure, etc.)
        return 200; // Example: authentication successful
    }

    private function fetchUserFromAzure($code)
    {
        // Implement your logic to fetch user details from Azure using the code
        // This is just a dummy implementation
        return [
            'uid' => 4,
            'username' => 'Oliver',
            'workspace_id' => '0',
        ];
    }
}
