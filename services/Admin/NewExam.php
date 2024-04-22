<?php

namespace Services\Admin;

use App\Entity\Exam;
use Doctrine\ORM\EntityManagerInterface;

class NewExam
{
  /**
   * @var array
   *  Contains the POST parameters array.
   */
  private $post;

  /**
   * @var object
   *  Contains the object of Exam class.
   */
  private $exam;

  /**
   * Initialise the $post and $exam variable.
   * @param array $post
   *  Contains the POST parameter values.
   */
  public function __construct(array $post)
  {
    $this->post = $post;
    $this->exam = new Exam();
  }

  /**
   * Function to process the new exam details form values.
   * @param EntityManagerInterface $entityManager
   *  Contains instance to manipulate dataabse operations.
   */
  public function processForm(EntityManagerInterface $entityManager)
  {
    $examName = $this->post['examName'];
    $examId = $this->post['examId'];
    $examDuration = $this->post['examDuration'];
    $eligibilityMarks = $this->post['eligibilityMarks'];
    $passingMarks = $this->post['passingMarks'];
    $creatorEmail = $this->post['email'];
    $creatorName = $this->post['creatorName'];

    $this->exam->setExamName($examName);
    $this->exam->setExamNumber($examId);
    $this->exam->setExamDuration($examDuration);
    $this->exam->setEligibilityMarks($eligibilityMarks);
    $this->exam->setPassingMarks($passingMarks);
    $this->exam->setCreatorEmail($creatorEmail);
    $this->exam->setCreatedBy($creatorName);
    
    $entityManager->persist($this->exam);
    $entityManager->flush();
  }
}
