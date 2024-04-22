<?php

namespace Services\Student;

use App\Entity\Questions;
use App\Entity\Results;
use App\Entity\StudentProfile;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class to process exam submission.
 */
class SubmitExam
{
  /**
   * @var array
   *  Contains the POST variables.
   */
  private $post;

  /**
   * @var object
   *  Stores the object of EntityManagerInterface.
   */
  private $em;

  /**
   * @var string
   *  Exam Nummber variable.
   */
  private $examNumber;

  /**
   * @var string
   *  Contains the student roll number.
   */
  private $studentRoll;

  /**
   * Initialises the class variables.
   *
   * @param EntityManagerInterface $em
   *  Object of EntityManagerInterface.
   *
   * @param array $post
   *  Contains the POST variables.
   *
   * @param string $examNumber
   *  Exam Number variable.
   *
   * @param int $studentRoll
   *  Student roll no.
   */
  public function __construct(EntityManagerInterface $em, array $post, string $examNumber, int $studentRoll)
  {
    $this->post = $post;
    $this->em = $em;
    $this->examNumber = $examNumber;
    $this->studentRoll = $studentRoll;
  }

  /**
   * Processes the correct answers and calculates the marks percentage.
   *
   * @return float
   *  Returns the percentage marks.
   */
  public function processAnswers(): float
  {
    // Contains the Questions obejcts of the particular exam.
    $questions = $this->em->getRepository(Questions::class)->findByExamNumber($this->examNumber);
    // Number of questions.
    $val = count($questions);


    $marks = 0;
    $i = 0;
    $totalMarks = 0;
    // For each answer submitted checking against the correct answer
    // present in the database.
    foreach ($this->post as $ans) {
      // If last answer is checked break the loop.
      if ($i == $val) {
        break;
      }
      // Storing the correct answer for each question.
      $d = $questions[(string)($i)]->getCorrectAnswer();
      // Adding marks of each question to get total marks.
      $totalMarks += $questions[(string)($i)]->getMarks();

      // If answer given is correct, marks is added.
      if ($ans == $d) {
        $marks += $questions[(string)($i)]->getMarks();
      }
      $i++;
    }
    // Conversion to percentage.
    $marks = ($marks/$totalMarks)*100;
    // Update result to database.
    $this->updateResult($marks);
    return $marks;
  }

  /**
   * Updates the resuslt for the student in the database.
   *
   * @param float $marks
   *  Contains the amrks obtained in percentage.
   *
   * @return void
   */
  public function updateResult(float $marks)
  {
    // Object of Results Entity.
    $result = new Results();
    // Fetching the student profile.
    $studentProfile = $this->em->getRepository(StudentProfile::class)->findOneBy(['roll_no'=>$this->studentRoll]);

    // Updating the values in the Results Entity.
    $result->setStudentRoll($this->studentRoll);
    $result->setExamNumber($this->examNumber);
    $result->setMarks($marks);
    $result->setResultId($studentProfile);

    $this->em->persist($result);
    $this->em->flush();
  }
}
