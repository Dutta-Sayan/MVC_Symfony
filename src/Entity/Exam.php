<?php

namespace App\Entity;

use App\Repository\ExamRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExamRepository::class)]
class Exam
{
  /**
   * @var int
   *  Primary Key
   */
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;

  /**
   * @var string
   *  Name of the exam.
   */
  #[ORM\Column(length: 50)]
  private ?string $exam_name = NULL;

  /**
   * @var string
   *  Exam Number
   */
  #[ORM\Column(length: 10)]
  private ?string $exam_number = NULL;

  /**
   * @var string
   *  Duration of the exam in hours.
   */
  #[ORM\Column(length: 3)]
  private ?string $exam_duration = NULL;

  /**
   * @var int
   *  Contains the passing marks in percentage required.
   */
  #[ORM\Column]
  private ?int $passing_marks = NULL;

  /**
   * @var string
   *  Name of exam creator.
   */
  #[ORM\Column(length: 255)]
  private ?string $created_by = NULL;

  /**
   * @var int
   *  Contains the academic marks required to be eligible for the exam.
   */
  #[ORM\Column]
  private ?int $eligibility_marks = NULL;

  /**
   * @var string
   *  Contains the email of the creator.
   */
  #[ORM\Column(length: 255)]
  private ?string $CreatorEmail = NULL;

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
   *  Returns the exam name.
   */
  public function getExamName(): ?string
  {
      return $this->exam_name;
  }

  /**
   * Sets the exam name.
   *
   * @param string $exam_name
   *  Contains the exam name.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setExamName(string $exam_name): static
  {
      $this->exam_name = $exam_name;

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
   *  Returns the exam duration.
   */
  public function getExamDuration(): ?string
  {
      return $this->exam_duration;
  }

  /**
   * Sets the exam duration.
   *
   * @param string $exam_duration
   *  Contains the exam duration.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setExamDuration(string $exam_duration): static
  {
      $this->exam_duration = $exam_duration;

      return $this;
  }

   /**
   * @return int
   *  Returns the exam passing marks.
   */
  public function getPassingMarks(): ?int
  {
      return $this->passing_marks;
  }

  /**
   * Sets the exam passing marks.
   *
   * @param string $passing_marks
   *  Contains the passing marks.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setPassingMarks(int $passing_marks): static
  {
      $this->passing_marks = $passing_marks;

      return $this;
  }

   /**
   * @return string
   *  Returns the exam creator's name.
   */
  public function getCreatedBy(): ?string
  {
      return $this->created_by;
  }

  /**
   * Sets the exam creator's name.
   *
   * @param string $created_by
   *  Contains the exam creator's name.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setCreatedBy(string $created_by): static
  {
      $this->created_by = $created_by;

      return $this;
  }

   /**
   * @return int
   *  Returns the exam eligibility marks.
   */
  public function getEligibilityMarks(): ?int
  {
      return $this->eligibility_marks;
  }

  /**
   * Sets the exam eligibility marks.
   *
   * @param int $eligibility_marks
   *  Contains the exam eligibility marks.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setEligibilityMarks(int $eligibility_marks): static
  {
      $this->eligibility_marks = $eligibility_marks;

      return $this;
  }

   /**
   * @return string
   *  Returns the exam creator's email.
   */
  public function getCreatorEmail(): ?string
  {
      return $this->CreatorEmail;
  }

  /**
   * Sets the exam creator's email.
   *
   * @param string $CreatorEmail
   *  Contains the exam creator's email.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setCreatorEmail(string $CreatorEmail): static
  {
      $this->CreatorEmail = $CreatorEmail;

      return $this;
  }
}
