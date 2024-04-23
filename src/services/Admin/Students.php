<?php

namespace Services\Admin;

use App\Entity\StudentProfile;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Fetches all the students records.
 */
class Students
{
  /**
   * Fetches the students records to be shown to the admin.
   *
   * @param EntityManagerInterface $em
   *  Object of EntityManagerInterface.
   *
   * @return array
   *  Returns the recors of Students entity.
   */
  public function showStudents(EntityManagerInterface $em) : array
  {
    $students = $em->getRepository(StudentProfile::class)->findAll();
    return $students;
  }
}
