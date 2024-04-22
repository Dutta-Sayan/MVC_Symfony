<?php

namespace App\Controller;

use Services\Admin;
use Services\Admin\NewExam;
use Services\Admin\CalculateQues;
use App\Entity\Exam;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller for all student related routes.
 */
class AdminController extends AbstractController
{

  /**
   * Route for admin dashboard page.
   *
   * @return Response
   *  Returns the admin dashboard page.
   */
  #[Route('/admin', name: 'admin')]
  public function index(): Response
  {
      return $this->render('admin/admin.html.twig', [
          'controller_name' => 'AdminController',
      ]);
  }

  /**
   * Route for new exam creation page.
   *
   * @param EntityManagerInterface $entityManager
   *  Object of EntityManagerInterface
   *
   * @return Response
   *  Returns the new exam page and on form submission
   *  redirects to eisting exams page.
   */
  #[Route('/admin/newExam', name: 'newExam')]
  public function newExam(EntityManagerInterface $entityManager) :Response
  {
    if (isset($_POST['submit'])) {
      $newExam = new NewExam($_POST);
      $newExam -> processForm($entityManager);
      return $this->redirectToRoute('existingExam');
    }
    return $this->render('admin/NewExam.html.twig');
  }

  /**
   * Route for create exam questions page.
   *
   * @param EntityManagerInterface $entityManager
   *  Object of EntityManagerInterface
   *
   * @return Response
   *  Returns the createExam page.
   *  On successfully submitting the questions, redirects to the dashboard.
   */
  #[Route('/admin/createExam', name: 'createExam')]
  public function createExam(EntityManagerInterface $entityManager): Response
  {
    if (isset($_POST['submit'])) {
      $adminService = new Admin\AdminServices($_POST);
      $adminService->processForm($entityManager);
      $this->addFlash('success', 'Questions Set');
      return $this->redirectToRoute('admin');
    }

    return $this->render('admin/CreateExam.html.twig', [
        'controller_name' => 'AdminController',
    ]);
  }

  /**
   * Route for existing exams page.
   *
   * @param EntityManagerInterface $em
   *  Object of EntityManagerInterface
   *
   * @return Response
   *  Returns the existingExams page.
   */
  #[Route('/admin/existingExams', name: 'existingExam')]
  public function existingExam(EntityManagerInterface $em): Response
  {
    $var = $this->getUser()->getEmail();
    $exam = $em->getRepository(Exam::class)->findBy(['CreatorEmail'=>$var]);
    $noOfQuestions = new CalculateQues();
    $noOfQues = $noOfQuestions->calNoOfQues($exam, $em);
    return $this->render('admin/ExistingExams.html.twig', [
      'exam'=> $exam,
      'noOfQues'=>$noOfQues,
    ]);
  }
}
