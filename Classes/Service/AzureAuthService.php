<?php

namespace OliverKroener\OkAzureLogin\Service;

use Microsoft\Kiota\Authentication\Oauth\AuthorizationCodeContext;
use Microsoft\Graph\Core\Authentication\GraphPhpLeagueAuthenticationProvider;

class AzureAuthService
{
    /**
     * @var string $tenantId
     */
    protected $tenantId;
    /**
     * @var string $clientId
     */
    protected $clientId;
    /**
     * @var string $clientSecret
     */
    protected $clientSecret;
    /**
     * @var string $redirectUri
     */
    protected $redirectUri;

    /**
     * @var array $configuration
     */
    public function __construct(array $configuration)
    {
        $this->tenantId = $configuration['tenantId'];
        $this->clientId = $configuration['clientId'];
        $this->clientSecret = $configuration['clientSecret'];
        $this->redirectUri = $configuration['redirectUri'];
    }

    public function getAccessToken(string $authCode): string
    {
        $tokenRequestContext = new AuthorizationCodeContext(
            $this->tenantId,
            $this->clientId,
            $this->clientSecret,
            $authCode,
            $this->redirectUri
        );

        $authProvider = new GraphPhpLeagueAuthenticationProvider($tokenRequestContext);
        return 123; //$authProvider->getAuthorizationHeader();
    }

    public function getUserData(string $accessToken)
    {
        // Use the access token to get user data from Azure AD
        // For example, you can use GuzzleHttp to make a request to Microsoft Graph API
    }
}
