<?php

namespace Services\Student;

use App\Entity\StudentProfile;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Constraint\IsEmpty;

/**
 * Class to create a new profile for student.
 */
class NewProfile
{
  /**
   * @var array
   *  Contains the POST parameters array.
   */
  private $post;

  /**
   * @var object
   *  Contains the object of NewProfile class.
   */
  private $profile;

  /**
   * Initialise the $post and $profile variable.
   * @param array $post
   *  Contains the POST parameter values.
   */
  public function __construct(array $post)
  {
    $this->post = $post;
    $this->profile = new StudentProfile();
  }

  /**
   * Function to process the new exam details form values.
   * @param EntityManagerInterface $entityManager
   *  Contains instance to manipulate dataabse operations.
   */
  public function processForm(EntityManagerInterface $entityManager, string $email, string $name)
  {
    $errors = [];
    // Stores the age of student.
    $age = $this->post['age'];
    if ($age < 20 || $age > 30) {
      array_push($errors, "Invalid age");
    }
    // Stores the roll no. of student.
    $rollNo = $this->post['rollNo'];
    if ($rollNo < 1 || $rollNo > 100) {
      array_push($errors, "Invalid Roll No.");
    }
    // Stores the graduation year of student.
    $gradYear = $this->post['gradYear'];
    if ($gradYear < 2015 || $gradYear > 2027) {
      array_push($errors, "Invalid Graduation Year");
    }
    // Stores the percentage value of academic marks of student.
    $academicMarks = $this->post['academicMarks'];
    if ($academicMarks < 1 || $academicMarks > 100) {
      array_push($errors, "Invalid Academic Marks");
    }
    // Stores the link of resume of student.
    $resumeLink = (string)$this->post['resumeLink'];

    if (empty($errors)) {
      // Stores the student user object.
      $user = $entityManager->getRepository(User::class)->findOneBy(['email'=>$email]);
      $this->profile->setName($name);
      $this->profile->setAge($age);
      $this->profile->setRollNo($rollNo);
      $this->profile->setGraduationYear($gradYear);
      $this->profile->setAcademicMarks($academicMarks);
      $this->profile->setLinkToResume($resumeLink);
      $this->profile->setStudentEmail($user);
      
      $entityManager->persist($this->profile);
      $entityManager->flush();
    }
      return $errors;
  }
}
