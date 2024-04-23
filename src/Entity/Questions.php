<?php

namespace App\Entity;

use App\Repository\QuestionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionsRepository::class)]
class Questions
{
  /**
   * @var int
   *  Primary Key.
   */
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;

  /**
   * @var string
   *  Exam Number.
   */
  #[ORM\Column(length: 10)]
  private ?string $exam_number = NULL;

  /**
   * @var string
   *  Question description.
   */
  #[ORM\Column(length: 255)]
  private ?string $question = NULL;

  /**
   * @var string
   *  First option choice.
   */
  #[ORM\Column(length: 255)]
  private ?string $option_1 = NULL;

  /**
   * @var string
   *  Second option choice.
   */
  #[ORM\Column(length: 255)]
  private ?string $option_2 = NULL;

  /**
   * @var string
   *  Third option choice.
   */
  #[ORM\Column(length: 255)]
  private ?string $option_3 = NULL;

  /**
   * @var string
   *  Correct answer.
   */
  #[ORM\Column(length: 255)]
  private ?string $correct_answer = NULL;

  /**
   * @var int
   *  Marks for the question.
   */
  #[ORM\Column]
  private ?int $marks = NULL;

  /**
   * @return int
   *  Returns the primary key.
   */
  public function getId(): ?int
  {
      return $this->id;
  }

  /**
   * @return string
   *  Returns the exam number.
   */
  public function getExamNumber(): ?string
  {
      return $this->exam_number;
  }

  /**
   * Sets the exam number.
   *
   * @param string $exam_number
   *  Contains the exam number.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setExamNumber(string $exam_number): static
  {
      $this->exam_number = $exam_number;

      return $this;
  }

  /**
   * @return string
   *  Returns the question.
   */
  public function getQuestion(): ?string
  {
      return $this->question;
  }

  /**
   * Sets the question.
   *
   * @param string $question
   *  Contains the question.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setQuestion(string $question): static
  {
      $this->question = $question;

      return $this;
  }

  /**
   * @return string
   *  Returns first option.
   */
  public function getOption1(): ?string
  {
      return $this->option_1;
  }

  /**
   * Sets the first optiom.
   *
   * @param string $option_1
   *  Contains the first option.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setOption1(string $option_1): static
  {
      $this->option_1 = $option_1;

      return $this;
  }

  /**
   * @return string
   *  Returns second option.
   */
  public function getOption2(): ?string
  {
      return $this->option_2;
  }

  /**
   * Sets the second optiom.
   *
   * @param string $option_2
   *  Contains the second option.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setOption2(string $option_2): static
  {
      $this->option_2 = $option_2;

      return $this;
  }

  /**
   * @return string
   *  Returns third option.
   */
  public function getOption3(): ?string
  {
      return $this->option_3;
  }

  /**
   * Sets the third optiom.
   *
   * @param string $option_3
   *  Contains the third option.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setOption3(string $option_3): static
  {
      $this->option_3 = $option_3;

      return $this;
  }

  /**
   * @return string
   *  Returns the correct answer.
   */
  public function getCorrectAnswer(): ?string
  {
      return $this->correct_answer;
  }

  /**
   * Sets the correct answer.
   *
   * @param string $correct_answer
   *  Contains the correct answer.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setCorrectAnswer(string $correct_answer): static
  {
      $this->correct_answer = $correct_answer;

      return $this;
  }

  /**
   * @return string
   *  Returns the marks for the question.
   */
  public function getMarks(): ?int
  {
      return $this->marks;
  }

  /**
   * Sets the marks for the question.
   *
   * @param int $marks
   *  Contains the marks.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setMarks(int $marks): static
  {
      $this->marks = $marks;

      return $this;
  }
}
