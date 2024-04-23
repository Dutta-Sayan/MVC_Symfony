<?php

namespace App\Controller;

use App\Services\Admin;
use App\Services\Admin\NewExam;
use App\Services\Admin\Students;
use App\Services\Admin\CalculateQues;
use App\Entity\Exam;
use App\Entity\StudentProfile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
    // Shows the admin dashboard only if the user is a admin.
    if ($this->getUser()->getRole() == 'Admin') {
      return $this->render('admin/admin.html.twig', [
          'controller_name' => 'AdminController',
      ]);
    }

    else {
      throw $this->createNotFoundException('Page does not exist');
    }
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
      // Processes the new exam form.
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
      // Processes the question form.
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
    // Stores all the exams created by the user.
    $exam = $em->getRepository(Exam::class)->findBy(['CreatorEmail'=>$var]);
    $noOfQuestions = new CalculateQues();
    // Stores the number of questions for each exam.
    $noOfQues = $noOfQuestions->calNoOfQues($exam, $em);
    return $this->render('admin/ExistingExams.html.twig', [
      'exam'=> $exam,
      'noOfQues'=>$noOfQues,
    ]);
  }

  /**
   * Route for students list page.
   *
   * @param EntityManagerInterface $em
   *  Object of EntityManagerInterface.
   *
   * @param Request $request
   *  HTTP request parameter.
   *
   * @return Response
   *  Returns the students list page.
   */
  #[Route('/admin/allStudents', name: 'showStudents')]
  public function showStudents(Request $request, EntityManagerInterface $em): Response
  {
    if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
      $showStudents = new Students();
      // Stores all the student users.
      $jsonData = $showStudents->showStudents($em, $request);
      return new JsonResponse($jsonData);
    }
    return $this->render('admin/showStudents.html.twig');
  }
}
