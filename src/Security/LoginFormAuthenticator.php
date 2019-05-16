<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator {

  /**
   * @var \App\Repository\UserRepository
   */
  private $userRepository;

  public function __construct(UserRepository $userRepository) {

    $this->userRepository = $userRepository;
  }

  public function supports(Request $request) {
    // Do work when we're POSTing to the login page.
    return $request->attributes->get('_route') === 'app_login'
      && $request->isMethod('POST');
  }

  public function getCredentials(Request $request) {
    return [
      'email' => $request->request->get('email'),
      'password' => $request->request->get('password'),
    ];
  }

  public function getUser($credentials, UserProviderInterface $userProvider) {
    return $this->userRepository->findOneBy(['email' => $credentials['email']]);
  }

  public function checkCredentials($credentials, UserInterface $user) {
    // Check this when user using password.
    return TRUE;
  }

  public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) {
    // Login Successful.
  }

  protected function getLoginUrl() {
    // TODO: Implement getLoginUrl() method.
  }
}
