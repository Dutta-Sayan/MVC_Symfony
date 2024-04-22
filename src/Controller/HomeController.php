<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller for home page.
 */
class HomeController extends AbstractController
{
  /**
   * Route for home page.
   *
   * @return Response
   *  Redirects route to home page.
   */
  #[Route('/', name: 'app_home')]
  public function index(): Response
  {
      return $this->render('home/index.html.twig', [
          'controller_name' => 'HomeController',
      ]);
  }
}
