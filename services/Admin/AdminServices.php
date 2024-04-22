<?php
namespace Services\Admin;

use App\Entity\Questions;
use Doctrine\ORM\EntityManagerInterface;

class AdminServices
{
  /**
   * @var array
   *  Contains the POST parameters array.
   */
  private $post;

  /**
   * Initialises the classs variables.
   *
   * @param array $post
   *  Contains the POST variables array.
   */
  public function __construct(array $post)
  {
    $this->post = $post;
  }
  
  /**
   * Sets the new questions in the database.
   *
   * @param EntityManagerInterface $entityManager
   */
  public function processForm(EntityManagerInterface $entityManager)
  {
    for ($i = 0; $i<count($_POST['slno']); $i++) {
      // Object of Questions Entity.
      $ques = new Questions();
      // Stores exam number.
      $examNumber = $this->post['examNumber'];
      // Contains the question.
      $question = $this->post['ques'][$i];
      // Contains first option.
      $firstOption = $this->post['optionA'][$i];
      // Contains second option.
      $secondOption = $this->post['optionB'][$i];
      // Contains third option.
      $thirdOption = $this->post['optionC'][$i];
      // Contains the correct answer.
      $answer = $this->post['answer'][$i];
      // Contains the marks for the particular question.
      $marks = $this->post['marks'][$i];

      // Sets the values in Entity variables.
      $ques->setQuestion($question);
      $ques->setOption1($firstOption);
      $ques->setOption2($secondOption);
      $ques->setOption3($thirdOption);
      $ques->setCorrectAnswer($answer);
      $ques->setExamNumber($examNumber);
      $ques->setMarks($marks);
      
      $entityManager->persist($ques);
    }
    $entityManager->flush();
  }
}
