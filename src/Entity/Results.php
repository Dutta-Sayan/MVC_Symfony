<?php

namespace App\Entity;

use App\Repository\ResultsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultsRepository::class)]
class Results
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
   * @var int
   *  Student roll number.
   */
  #[ORM\Column(nullable: TRUE)]
  private ?int $student_roll = NULL;

  /**
   * @var string
   *  Exam Number.
   */
  #[ORM\Column(length: 10, nullable: TRUE)]
  private ?string $exam_number = NULL;

  /**
   * @var float
   *  Marks obtained.
   */
  #[ORM\Column(nullable: TRUE)]
  private ?float $marks = NULL;

  /**
   * @var StudentProfile
   *  Foreign key.
   */
  #[ORM\ManyToOne(inversedBy: 'results')]
  #[ORM\JoinColumn(nullable: FALSE)]
  private ?StudentProfile $result_id = NULL;

  /**
   * @return int
   *  Returns the primary key.
   */
  public function getId(): ?int
  {
      return $this->id;
  }

  /**
   * @return int
   *  Returns the student roll no.
   */
  public function getStudentRoll(): ?int
  {
      return $this->student_roll;
  }

  /**
   * Sets the student's roll number.
   *
   * @param int $student_roll
   *  Contains student roll no.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setStudentRoll(?int $student_roll): static
  {
      $this->student_roll = $student_roll;

      return $this;
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
   *  Contains exam no.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setExamNumber(?string $exam_number): static
  {
      $this->exam_number = $exam_number;

      return $this;
  }

   /**
   * @return float
   *  Returns the marks obtained.
   */
  public function getMarks(): ?float
  {
      return $this->marks;
  }

  /**
   * Sets the student's marks obtained.
   *
   * @param float $marks
   *  Contains marks obtained.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setMarks(?float $marks): static
  {
      $this->marks = $marks;

      return $this;
  }

   /**
   * @return StudentPRofile
   *  Returns the foreign key.
   */
  public function getResultId(): ?StudentProfile
  {
      return $this->result_id;
  }

  /**
   * Sets the foreign key.
   *
   * @param StudentProfile $result_id
   *  Contains the id of the student.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setResultId(?StudentProfile $result_id): static
  {
      $this->result_id = $result_id;

      return $this;
  }
}
