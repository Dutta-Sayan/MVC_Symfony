<?php

namespace App\Services\Admin;

use App\Entity\StudentProfile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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
  public function showStudents(EntityManagerInterface $em, Request $request) : array
  {
    $students = $em->getRepository(StudentProfile::class)->findAll();
    $jsonData = array();
    $idx = 0;

    // Loops through each student record.
    foreach ($students as $student) {
      $temp = array(
        'name'=>$student->getName(),
        'email'=>$student->getStudentEmail()->getEmail(),
        'age'=>$student->getAge(),
        'roll'=>$student->getRollNo(),
        'gradYear'=>$student->getGraduationYear(),
        'marks'=>$student->getAcademicMarks(),
        'link'=>$student->getLinkToResume(),
      );
      $jsonData[$idx++] = $temp;
    }
    
    return $jsonData;
  }
}
