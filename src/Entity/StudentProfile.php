<?php

namespace App\Entity;

use App\Repository\StudentProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class to set the student profile.
 */
#[ORM\Entity(repositoryClass: StudentProfileRepository::class)]
class StudentProfile
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
   *  Name of the student.
   */
  #[ORM\Column(length: 30)]
  private ?string $Name = NULL;

  /**
   * @var int
   *  Age of the student.
   */
  #[ORM\Column]
  private ?int $age = NULL;

  /**
   * @var int
   *  Roll no. of the student.
   */
  #[ORM\Column]
  private ?int $roll_no = NULL;

  /**
   * @var int
   *  Graduation year of the student.
   */
  #[ORM\Column]
  private ?int $graduation_year = NULL;

  /**
   * @var float
   *  Academic marks of the student.
   */
  #[ORM\Column]
  private ?float $academic_marks = NULL;

  /**
   * @var string
   *  Link to the student's resume.
   */
  #[ORM\Column(length: 255)]
  private ?string $link_to_resume = NULL;

  /**
   * @var User
   *  Foreign Key.
   */
  #[ORM\OneToOne(inversedBy: 'studentProfile', cascade: ['persist', 'remove'])]
  #[ORM\JoinColumn(nullable: FALSE)]
  private ?User $studentEmail = NULL;

  /**
   * @var Collection<int, Results>
   */
  #[ORM\OneToMany(targetEntity: Results::class, mappedBy: 'result_id')]
  private Collection $results;

  public function __construct()
  {
      $this->results = new ArrayCollection();
  }


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
   *  Returns the name.
   */
  public function getName(): ?string
  {
      return $this->Name;
  }

  /**
   * Sets the student name.
   *
   * @param string $Name
   *  Student name.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setName(string $Name): static
  {
      $this->Name = $Name;

      return $this;
  }

  /**
   * @return int
   *  Returns the student's age.
   */
  public function getAge(): ?int
  {
      return $this->age;
  }

  /**
   * Sets the student's age.
   *
   * @param int $age
   *  Student age.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setAge(int $age): static
  {
      $this->age = $age;

      return $this;
  }

  /**
   * @return int
   *  Returns the student's roll no.
   */
  public function getRollNo(): ?int
  {
      return $this->roll_no;
  }

  /**
   * Sets the student's roll no.
   *
   * @param int $roll_no
   *  Student roll no.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setRollNo(int $roll_no): static
  {
      $this->roll_no = $roll_no;

      return $this;
  }

  /**
   * @return int
   *  Returns the student's graduation year.
   */
  public function getGraduationYear(): ?int
  {
      return $this->graduation_year;
  }

  /**
   * Sets the student's graduation year.
   *
   * @param int $graduation_year
   *  Student graduation year.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setGraduationYear(int $graduation_year): static
  {
      $this->graduation_year = $graduation_year;

      return $this;
  }

  /**
   * @return float
   *  Returns the student's academic marks.
   */
  public function getAcademicMarks(): ?float
  {
      return $this->academic_marks;
  }

  /**
   * Sets the student's academic marks.
   *
   * @param float $academic_marks
   *  Student academic marks.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setAcademicMarks(float $academic_marks): static
  {
      $this->academic_marks = $academic_marks;

      return $this;
  }

  /**
   * @return string
   *  Returns the student's resume link.
   */
  public function getLinkToResume(): ?string
  {
      return $this->link_to_resume;
  }

  /**
   * Sets the student's resume link.
   *
   * @param string $link_to_resume
   *  Student resume link.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setLinkToResume(string $link_to_resume): static
  {
      $this->link_to_resume = $link_to_resume;

      return $this;
  }

  /**
   * @return User
   *  Returns foreign key linked with User profile.
   */
  public function getStudentEmail(): ?User
  {
      return $this->studentEmail;
  }

  /**
   * Sets foreign key to link User entity.
   *
   * @param User $studentEmail
   *  Foreign Key.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setStudentEmail(User $studentEmail): static
  {
      $this->studentEmail = $studentEmail;

      return $this;
  }

  /**
   * @return Collection<int, Results>
   */
  public function getResults(): Collection
  {
      return $this->results;
  }

  /**
   * Add result for the following student.
   *
   * @param Results $result
   *  Object of Results class.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function addResult(Results $result): static
  {
    if (!$this->results->contains($result)) {
        $this->results->add($result);
        $result->setResultId($this);
    }

    return $this;
  }

  /**
   * Remove the result for the student.
   *
   * @param Results $result
   *  Object of Results class.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function removeResult(Results $result): static
  {
    if ($this->results->removeElement($result)) {
      // set the owning side to null (unless already changed)
      if ($result->getResultId() === $this) {
          $result->setResultId(NULL);
      }
    }

    return $this;
  }
}
