<?php

namespace App\Services\Student;

use App\Entity\Results;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class to show the results of exam given by students.
 */
class ComputeResult
{
  /**
   * @var string $studentRoll
   *  Stores the student roll.
   */
  private $studentRoll;

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
   * @param int
   *  Studdent roll no.
   *
   * @return void
   */
  public function __construct(EntityManagerInterface $em, int $studentRoll)
  {
    $this->studentRoll = $studentRoll;
    $this->em= $em;
  }

  /**
   * Fetches the result according to the given student roll.
   *
   * @return array
   */
  public function showResults(): array
  {
    $results = $this->em->getRepository(Results::class)->findByStudentRoll($this->studentRoll);
    return $results;
  }
}
