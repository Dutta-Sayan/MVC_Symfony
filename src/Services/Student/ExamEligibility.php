<?php

namespace App\Services\Student;

use App\Entity\Exam;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Shows a student the list of exams for which he is eligible based on marks.
 */
class ExamEligibility
{
  /**
   * @var object
   *  Object of StudentProfile class.
   */
  private $studentProfile;

  /**
   * @var string $em
   *  Stores the object of EntityManagerInterface.
   */
  private $em;

  /**
   * Initializes the class variables.
   *
   * @param EntityManagerInterface
   *  Object of EntityManagerInterface.
   *
   * @param object
   *  Object of StudentProfile class.
   *
   * @return void
   */
  public function __construct(EntityManagerInterface $em, object $studentProfile)
  {
    $this->studentProfile = $studentProfile;
    $this->em = $em;
  }

  /**
   * Function to show exams to a student based on the academic marks.
   *
   * @return array
   */
  public function showExams(): array
  {
    $exam = $this->em->getRepository(Exam::class)->findByEligibleMarks($this->studentProfile->getAcademicMarks());
    // Returns the list of eligible exams.
    return $exam;
  }
}
