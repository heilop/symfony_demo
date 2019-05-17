<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils) {
      // Get the login error if there is one.
      $error = $authenticationUtils->getLastAuthenticationError();
      // Last username entered by the .
      $lastUsername = $authenticationUtils->getLastUsername();

      return $this->render('security/login.html.twig', [
        'error' => $error,
        'last_username' =>$lastUsername,
      ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout() {
      throw new \Exception('Will be intercepted before getting here');

    }
}
