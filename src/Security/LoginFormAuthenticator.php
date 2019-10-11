<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator {

  /**
   * @var \App\Repository\UserRepository
   */
  private $userRepository;

  /**
   * @var \Symfony\Component\Routing\RouterInterface
   */
  private $router;

  /**
   * @var CsrfTokenManagerInterface
   */
  private $csrfTokenManager;

  public function __construct(UserRepository $userRepository, RouterInterface $router, CsrfTokenManagerInterface $csrfTokenManager) {
    $this->userRepository = $userRepository;
    $this->router = $router;
    $this->csrfTokenManager = $csrfTokenManager;
  }

  public function supports(Request $request) {
    // Do work when we're POSTing to the login page.
    return $request->attributes->get('_route') === 'app_login'
      && $request->isMethod('POST');
  }

  public function getCredentials(Request $request) {
    $credentials = [
      'email' => $request->request->get('email'),
      'password' => $request->request->get('password'),
      'csrf_token' => $request->request->get('_csrf_token'),
    ];

    $request->getSession()->set(
      Security::LAST_USERNAME,
      $credentials['email']
    );

    return $credentials;
  }

  public function getUser($credentials, UserProviderInterface $userProvider) {
    $token = new CsrfToken('authenticate', $credentials['csrf_token']);
    if (!$this->csrfTokenManager->isTokenValid($token)) {
      throw new InvalidCsrfTokenException();
    }

    return $this->userRepository->findOneBy(['email' => $credentials['email']]);
  }

  public function checkCredentials($credentials, UserInterface $user) {
    // Check this when user using password.
    return TRUE;
  }

  public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) {
    // Login Successful.
    return new RedirectResponse($this->router->generate('homepage'));
  }

  protected function getLoginUrl() {
    return $this->router->generate('app_login');
  }
}