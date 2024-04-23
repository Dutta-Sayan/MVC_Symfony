<?php

namespace Services\Admin;

use App\Entity\Questions;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Calculates the number of questions present for each exam number.
 */
class CalculateQues
{
  /**
   * Calculates the number of questions for each exam.
   *
   * @param array $exam
   *  Contains the existing exams records.
   *
   * @param EntityManagerInterface $em
   *  Object of EntityManagerInterface.
   *
   * @return array
   *  Returns the associative array containing the exam numbers
   *  with the number of questions for each exam.
   */
  public function calNoOfQues(array $exam, EntityManagerInterface $em): array
  {
    // Array to store exam number and no of questions as key value pair.
    $noOfQues = array();
    foreach ($exam as $examInfo) {
      $examNumber = $examInfo->getExamNumber();
      // Contains the records from Questions class for the particular exam number.
      $questions = $em->getRepository(Questions::class)->findByExamNumber($examNumber);
      $count = count($questions);
      $noOfQues[$examNumber] = $count;
    }
    return $noOfQues;
  }
}
