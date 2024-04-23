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
    // Shows the student dashboard only if the user is a student.
    if ($this->getUser()->getRole() == 'Student') {

      $studentProfile = $this->getUser()->getStudentProfile();
      // If student profile is not set, shows the email in welcome message.
      if (!$studentProfile) {
        return $this->render('student/student.html.twig', [
            'controller_name' => 'StudentController',
            'name' => $this->getUser()->getEmail(),
        ]);
      // If student profile is set, shows the name in welcome message.
      } else {
        return $this->render('student/student.html.twig', [
          'controller_name' => 'StudentController',
          'name' => $studentProfile->getName(),
        ]);
      }
    } else {
      throw $this->createNotFoundException('Page does not exist');
    }
  }

  /**
   * Route for Student profile option.
   *
   * @param EntityManagerInterface $em
   *  Object of EntityManagerInterface.
   *
   * @return Response
   *  Returns the createProfile page for profile creation for first time.
   *  Returns the viewProfile page showing the profile details next time onwards.
   */
  #[Route('/student/profile', name: 'student_profile')]
  public function profile(EntityManagerInterface $em): Response
  {
    $studentProfile = $this->getUser()->getStudentProfile();
    // Redirects to create profile page if profile is not set.
    if (!$studentProfile) {
      return $this->redirectToRoute('create_profile');
    // Displays the student details if profile is set.
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
    // Variable to store the validation errors.
    $errors = "";
    // Store the POST request values.
    $post = "";
    if (isset($_POST['submit'])) {
      $post = $request->request->all();
      // Creating a object of NewProfile class.
      $newProfile = new NewProfile($post);
      $email = $this->getUser()->getEmail();
      $name = $this->getUser()->getName();
      $errors = $newProfile->processForm($entityManager, $email, $name);
      // If no errors found, profile is set and redirects to dashboard.
      if (empty($errors)) {
        $this->addFlash('success', 'Profile Set');
        return $this->redirectToRoute('student');
      // Stays on same page and shows the errors, form is not sumitted.
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
    // Fetching all the records of Exam Entity.
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
    // Object of ExamEligibility class.
    $examEligibility = new ExamEligibility($em, $studentProfile);
    // Stores the eligible exams based on student's academic marks.
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
    // If result is not present already, then the exam will start.
    if ($checkResult == 0) {
      $examInfo = $startExam->getQuestions();
      // Stores the questions.
      $questions = $examInfo[1];
      // Stores the exam total duration.
      $duration = $examInfo[0];
      return $this->render('student/startExam.html.twig', [
        'examNumber'=>$examNumber,
        'ques'=>$questions,
        'duration'=>$duration,
      ]);
    // Renders the exam Over page if result is present for the particular exam.
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
      // Processes the answers and stores the results.
      $submitExam->processAnswers();
      $this->addFlash('success', 'Exam Submitted');
      // Redirects to dashboard.
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
      // Stores all the results for a particular student.
      $results = $computeResult->showResults();
      return $this->render('student/yourResults.html.twig', [
        'results'=>$results,
      ]);
  }
}
