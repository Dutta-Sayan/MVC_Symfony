<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;

/**
 * Controller for User Login.
 */
class SecurityController extends AbstractController
{
  /**
   * Route for User login page.
   *
   * @return Response
   *  Redirects route to student or admin dashboard page as per the user.
   */
  #[Route(path: '/Login', name: 'app_login')]
  public function login(AuthenticationUtils $authenticationUtils): Response
  {
    if ($this->getUser()) {
      $user = $this->getUser();
      if ($user->getRole() == 'Admin') {
          return $this->redirectToRoute('admin');
      } elseif ($user->getRole() == 'Student') {
        return $this->redirectToRoute('student');
      }
    }
    
      
      // get the login error if there is one
      $error = $authenticationUtils->getLastAuthenticationError();
      // last username entered by the user
      $lastUsername = $authenticationUtils->getLastUsername();

      return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
  }

  /**
   * Route for logout page.
   *
   * @return void
   */
  #[Route(path: '/logout', name: 'app_logout')]
  public function logout(): void
  {
    throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
  }
}
