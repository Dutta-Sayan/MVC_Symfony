<?php

namespace Services\Student;

use App\Entity\StudentProfile;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

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
    // Stores the age of student.
    $age = $this->post['age'];
    // Stores the roll no. of student.
    $rollNo = $this->post['rollNo'];
    // Stores the graduation year of student.
    $gradYear = $this->post['gradYear'];
    // Stores the percentage value of academic marks of student.
    $academicMarks = $this->post['academicMarks'];
    // Stores the link of resume of student.
    $resumeLink = (string)$this->post['resumeLink'];

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
}
