<?php

namespace App\Services\Student;

use App\Entity\Exam;
use App\Entity\Questions;
use App\Entity\Results;
use App\Entity\StudentProfile;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class to get the questions and check whether exam
 * is already given during exam start.
 */
class StartExam
{
  /**
   * @var string
   *  Stores the exam number.
   */
  private $examNumber;

  /**
   * @var object
   *  Stores the object of EntityManagerInterface.
   */
  private $em;

  /**
   * @var object
   *  Stores the object of StudentProfile class.
   */
  private $studentProfile;

  /**
   * Initialises the class variables.
   *
   * @param object $em
   *  Object of EntityManagerInterface.
   *
   * @param string $examNumber
   *  Exam number variable.
   *
   * @param object $studentProfile
   *  Object of StudentProfile class.
   */
  public function __construct(EntityManagerInterface $em, string $examNumber, $studentProfile)
  {
    $this->examNumber = $examNumber;
    $this->em = $em;
    $this->studentProfile = $studentProfile;
  }

  /**
   * Checks whether result exists for the particular exam for the student.
   *
   * @return bool
   *  Returns 0 if no result exists otherwise returns 1.
   */
  public function checkResult(): bool
  {
    $result = $this->em->getRepository(Results::class)->existingResult(
        $this->examNumber,
        $this->studentProfile->getId()
    );
    if (!$result) {
      return 0;
    } else {
      return 1;
    }
  }

  /**
   * Fetches the questions and the duration for the particular exam.
   *
   * @return array
   *  Contains the questions and the duration of the exam.
   */
  public function getQuestions(): array
  {
    // Array to store the questions and the duration.
    $examInfo = [];
    // Contains the records from Questions class for the particular exam number.
    $questions = $this->em->getRepository(Questions::class)->findByExamNumber($this->examNumber);
    // Contains the record for the particular exam.
    $exam = $this->em->getRepository(Exam::class)->findDuration($this->examNumber);
    // Contains the value of exam duration in hours.
    $time = $exam['0']->getExamDuration();
    array_push($examInfo, $time);
    array_push($examInfo, $questions);
    return $examInfo;
  }
}
