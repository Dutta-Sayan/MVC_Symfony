<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Exam;
use App\Entity\StudentProfile;
use Services\Student\NewProfile;
use Services\Student\ExamEligibility;
use Services\Student\StartExam;
use Services\Student\SubmitExam;
use Services\Student\ComputeResult;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller for all student related routes.
 */
class StudentController extends AbstractController
{
  /**
   * Route to student dashboard.
   *
   * @return Response
   *  Returns the dashboard page.
   */
  #[Route('/student', name: 'student')]
  public function index(): Response
  {
    $studentProfile = $this->getUser()->getStudentProfile();
    if (!$studentProfile) {
      return $this->render('student/student.html.twig', [
          'controller_name' => 'StudentController',
          'name' => $this->getUser()->getEmail(),
      ]);
    } else {
      return $this->render('student/student.html.twig', [
        'controller_name' => 'StudentController',
        'name' => $studentProfile->getName(),
      ]);
    }
  }

  /**
   * Route for Student profile option.
   *
   * @param EntityManagerInterface $em
   *  Object of EntityManagerInterface
   *
   * @return Response
   *  Returns the createProfile page for profile creation for first time.
   *  Returns the viewProfile page showing the profile details next time onwards.
   */
  #[Route('/student/profile', name: 'student_profile')]
  public function profile(EntityManagerInterface $em): Response
  {
    $studentProfile = $this->getUser()->getStudentProfile();
    if (!$studentProfile) {
      return $this->redirectToRoute('create_profile');
    } else {
      $name = $studentProfile->getStudentEmail()->getEmail();
      return $this->render('student/viewProfile.html.twig', array('user'=> $studentProfile));
    }
  }

  /**
   * Route for create profile page.
   *
   * @param EntityManagerInterface $em
   *  Object of EntityManagerInterface
   *
   * @return Response
   *  Returns the createProfile page.
   */
  #[Route('/student/profile/createProfile', name: 'create_profile')]
  public function createProfile(Request $request, EntityManagerInterface $entityManager): Response
  {
    $errors = "";
    $post = "";
    if (isset($_POST['submit'])) {
      $post = $request->request->all();
      $newProfile = new NewProfile($post);
      $email = $this->getUser()->getEmail();
      $name = $this->getUser()->getName();
      $errors = $newProfile->processForm($entityManager, $email, $name);
      if (empty($errors)) {
        $this->addFlash('success', 'Profile Set');
        return $this->redirectToRoute('student');
      } else {
        return $this->render('student/createProfile.html.twig', [
          'errors'=>$errors,
          'post'=>$post,
        ]);
      }
    }
    return $this->render('student/createProfile.html.twig', [
        'controller_name' => 'StudentController',
        'errors'=>$errors,
        'post'=>$post,
    ]);
  }

  /**
   * Route for available exams page.
   *
   * @param EntityManagerInterface $em
   *  Object of EntityManagerInterface
   *
   * @return Response
   *  Returns the availableExams page.
   */
  #[Route('/student/availableExams', name: 'availableExams')]
  public function availableExams(EntityManagerInterface $em): Response
  {
    $exam = $em->getRepository(Exam::class)->findAll();
    return $this->render('student/availableExams.html.twig', array('exam'=> $exam));
  }

  /**
   * Route for eligiblw exams page.
   *
   * @param EntityManagerInterface $em
   *  Object of EntityManagerInterface
   *
   * @return Response
   *  Returns the eligibleExams page.
   */
  #[Route('/student/eligibleExams', name: 'eligibleExams')]
  public function eligibleExams(EntityManagerInterface $em): Response
  {
    $user = $this->getUser();
    $studentProfile = $user->getStudentProfile();
    $examEligibility = new ExamEligibility($em, $studentProfile);
    $exam = $examEligibility->showExams();
    return $this->render('student/eligibleExams.html.twig', array('exam'=>$exam));
  }

  /**
   * Route for exam start page.
   *
   * @param EntityManagerInterface $em
   *  Object of EntityManagerInterface
   *
   * @param string $examNumber
   *  Contains the exam number of the exam.
   *
   * @return Response
   *  Returns the startExam page.
   */
  #[Route('/student/startExam/{examNumber}', name: 'startExam')]
  public function startExam(EntityManagerInterface $em, $examNumber): Response
  {
    $startExam = new StartExam($em, $examNumber, $this->getUser()->getStudentProfile());
    $checkResult = $startExam->checkResult();
    if ($checkResult == 0) {
      $examInfo = $startExam->getQuestions();
      $questions = $examInfo[1];
      $duration = $examInfo[0];
      return $this->render('student/startExam.html.twig', [
        'examNumber'=>$examNumber,
        'ques'=>$questions,
        'duration'=>$duration,
      ]);
    } else {
      return $this->render('student/examOver.html.twig');
    }
  }

  /**
   * Route for submit exam page.
   *
   * @param EntityManagerInterface $em
   *  Object of EntityManagerInterface
   *
   * @param string $examNumber
   *  Contains the exam number of the exam.
   *
   * @return Response
   *  Redirects route to student dashboard page.
   */
  #[Route('/student/examSubmit/{examNumber}', name: 'submitExam')]
  public function submitExam(Request $request, EntityManagerInterface $em, $examNumber) :Response
  {
      $user = $this->getUser();
      $studentRoll = $user->getStudentProfile()->getRollNo();
      $post = $request->request->all();
      $submitExam = new SubmitExam($em, $post, $examNumber, $studentRoll);
      $submitExam->processAnswers();
      $computeResult = new ComputeResult($em, $studentRoll);
      $computeResult->showResults();
      $this->addFlash('success', 'Exam Submitted');
      return $this->redirectToRoute('student');
  }

  /**
   * Route for results page.
   *
   * @param EntityManagerInterface $em
   *  Object of EntityManagerInterface
   *
   * @return Response
   *  Returns the yourResults page.
   */
  #[Route('/student/report', name: 'examResults')]
  public function examResults(EntityManagerInterface $em)
  {
      $user = $this->getUser();
      $studentRoll = $user->getStudentProfile()->getRollNo();
      $computeResult = new ComputeResult($em, $studentRoll);
      $results = $computeResult->showResults();
      return $this->render('student/yourResults.html.twig', [
        'results'=>$results,
      ]);
  }
}
