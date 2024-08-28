<?php

namespace OliverKroener\OkAzureLogin\Controller;

use OliverKroener\OkAzureLogin\Authentication\AzureLoginAuthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Microsoft\Kiota\Abstractions\ApiException;
use Microsoft\Kiota\Authentication\Oauth\AuthorizationCodeContext;
use Microsoft\Graph\GraphServiceClient;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Http\Response;

class LoginController extends ActionController
{
    /**
     * Constructor injection for LoggerInterface
     * 
     * @param LoggerInterface $logger
     */
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    /**
     * Show the login page with the necessary configuration settings
     * 
     * @return ResponseInterface The rendered HTML response
     */
    public function showAction(): ResponseInterface
    {
        // Assign necessary settings to the view
        $this->view->assignMultiple([
            'tenantId' => $this->settings['tenantId'], // Azure tenant ID
            'clientId' => $this->settings['clientId'], // Azure client ID
            'redirectUri' => $this->settings['redirectUri'], // Redirect URI for Azure login
        ]);

        // Return the HTML response for the login page
        return $this->htmlResponse();
    }

    /**
     * Handle the login action using Microsoft Entra and MSGraph API
     * 
     * @return ResponseInterface The response after processing the login
     */
    public function loginAction(): ResponseInterface
    {
        // Get the 'code' parameter from the query string
        $queryParams = $this->request->getQueryParams();
        $code = $queryParams['code'] ?? null;

        // Create the context for the authorization code flow
        $tokenRequestContext = new AuthorizationCodeContext(
            $this->settings['tenantId'],
            $this->settings['clientId'],
            $this->settings['clientSecret'],
            $code,
            $this->settings['redirectUri']
        );

        // Define the scopes required
        $scopes = ['User.Read'];

        // Create a new GraphServiceClient with the token request context and scopes
        $graphServiceClient = new GraphServiceClient($tokenRequestContext, $scopes);

        try {
            // Request the user information from Microsoft Graph
            $user = $graphServiceClient->me()->get()->wait();

            // Get the user's email
            $mail = $user->getMail();

            // Find the backend user by email
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('be_users');
            $backendUserRecord = $queryBuilder
                ->select('*')
                ->from('be_users')
                ->where(
                    $queryBuilder->expr()->eq('email', $queryBuilder->createNamedParameter($mail))
                )
                ->executeQuery()
                ->fetchAllAssociative();

            if (count($backendUserRecord) === 1) {

                $backendUser = GeneralUtility::makeInstance(BackendUserAuthentication::class);
                $request = ServerRequestFactory::fromGlobals();
                $backendUser->start($this->request);
                $backendUser->setBeUserByUid($backendUserRecord[0]['uid']);
                $GLOBALS['BE_USER'] = $backendUser;                
                // Start the session
                // $backendUser->start();

                // Set session cookie
                $cookieName = 'be_typo_user';
                setcookie($cookieName, (string)$backendUserRecord[0]['uid'], 0, '/', '', false, true);
                // Set the session cookie

                
                // Redirect to backend
                // Redirect to the backend
                return $this->redirectToUri('/typo3');
            } else {
                // Handle case when user is not found
                $this->logger->debug("Backend user with email {$mail} not found.");
                return $this->htmlResponse("Backend user with email {$mail} not found.");
            }
        } catch (ApiException $ex) {
            // Log any API exceptions
            $this->logger->debug($ex->getMessage());
        }

        // Return an appropriate response (adjust as needed)
        $this->view->assign('BE_USER', $GLOBALS['BE_USER']);

        return $this->htmlResponse();
    }

    private function redirectToBackend()
    {
        // Logic to redirect to TYPO3 backend
        header('Location: /typo3/');
        exit();
    }

    private function redirectToLoginPage()
    {
        // Logic to redirect to login page
        header('Location: /typo3/login');
        exit();
    }
}
