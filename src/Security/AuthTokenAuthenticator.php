<?php
namespace App\Security;


use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use App\Security\AuthTokenUserProvider;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthTokenAuthenticator implements AuthenticationFailureHandlerInterface
{

    const TOKEN_VALIDITY_DURATION = 6 * 3600;
    
    protected $httpUtils;
    
    public function __construct(HttpUtils $httpUtils) {
        $this->httpUtils = $httpUtils;
    }
    
    public function createToken(Request $request, $providerKey) {
        $targetUrl = "/auth-tokens";
        
        if ($request->getMethod() === "POST" && $this->httpUtils->checkRequestPath($request, $targetUrl)) {
            return;
        }
        
        $authTokenHeader = $request->headers->get("X-Auth-Token");
        
        if (!$authTokenHeader) {
            throw new BadCredentialsException("X-Auth-Token header is required");
        }
        
        return new PreAuthenticatedToken("anonymous", $authTokenHeader, $providerKey);
    }
    
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey) {
        if (!$userProvider instanceof AuthTokenUserProvider) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Une instance de AuthTokenUserProvider doit être passé (%s was given)",
                    get_class($userProvider)
                )
            );
        }
        
        // X-Auth-Token Bearer fmdskfqmsiyqsdfic nmjdktasism<jdfmq. dfmqsdkfjmqskjmkjfsd. dfjmqskfjqsmkfjsqd
        $authTokenHeader = $token->getCredentials();
        $authToken = $userProvider->getAuthToken($authTokenHeader);
        
        if (!$authToken || !$this->isTokenValid($authToken)) {
            throw new BadCredentialsException(("Token utilisateur est invalide"));
        }
        
        // Récupérer l'utilisateur
        $user = $authToken->getUser();
        $preAuthentication = new PreAuthenticatedToken($user, $authTokenHeader, $providerKey, $user->getRoles());
        
        return $preAuthentication;
    }
    
    public function supportsToken(TokenInterface $token, $providerKey) {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }
    
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        throw $exception;
    }
    
    private function isTokenValid($authToken) {
        return (time() - $authToken->getCreatedAt()->getTimestamp()) < self::TOKEN_VALIDITY_DURATION;
    }
}

