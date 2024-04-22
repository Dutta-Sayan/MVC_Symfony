<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
   *  The user email
   */
  #[ORM\Column(length: 180)]
  #[Assert\Email(
      message: 'The email {{ value }} is not a valid email.',
  )]
  private ?string $email = NULL;

  /**
   * @var list<string> The user roles
   */
  #[ORM\Column]
  private array $roles = [];

  /**
   * @var string
   *  The hashed password
   */
  #[ORM\Column]
  #[Assert\Length(
      min: 8,
      minMessage: 'Your password must be at least {{ limit }} characters long',
  )]
  private ?string $password = NULL;

/**
   * @var string
   *  The user name.
   */
  #[ORM\Column(length: 30)]
  #[Assert\NotBlank]
  #[Assert\Regex(pattern: '/^[a-zA-Z ]*$/i')]
  #[Assert\Length(
      min: 5,
      max: 30,
      minMessage: 'Your name must be at least {{ limit }} characters long',
      maxMessage: 'Your name cannot be longer than {{ limit }} characters'
  )]
  private ?string $Name = NULL;

  /**
   * @var string
   *  User Role
   */
  #[ORM\Column(length: 15)]
  private ?string $Role = NULL;

  #[ORM\OneToOne(mappedBy: 'studentEmail', cascade: ['persist', 'remove'])]
  private ?StudentProfile $studentProfile = NULL;

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
   *  Returns the email.
   */
  public function getEmail(): ?string
  {
      return $this->email;
  }

  /**
   * Sets the email.
   *
   * @param string $email
   *  User email.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setEmail(string $email): static
  {
      $this->email = $email;

      return $this;
  }

  /**
   * A visual identifier that represents this user.
   *
   * @see UserInterface
   */
  public function getUserIdentifier(): string
  {
      return (string) $this->email;
  }

  /**
   * @see UserInterface
   *
   * @return list<string>
   */
  public function getRoles(): array
  {
      $roles = $this->roles;
      // guarantee every user at least has ROLE_USER
      $roles[] = 'ROLE_USER';

      return array_unique($roles);
  }

  /**
   * @param list<string> $roles
   */
  public function setRoles(array $roles): static
  {
      $this->roles = $roles;

      return $this;
  }

  /**
   * @see PasswordAuthenticatedUserInterface
   */
  public function getPassword(): string
  {
      return $this->password;
  }

  /**
   * Sets the password.
   *
   * @param string $password
   *  User hashed password.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setPassword(string $password): static
  {
      $this->password = $password;

      return $this;
  }

  /**
   * @see UserInterface
   */
  public function eraseCredentials(): void
  {
      // If you store any temporary, sensitive data on the user, clear it here
      // $this->plainPassword = null;
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
   * Sets the user name.
   *
   * @param string $Name
   *  User name.
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
   * @return string
   *  Returns the role of user.
   */
  public function getRole(): ?string
  {
      return $this->Role;
  }

  /**
   * Sets the user role.
   *
   * @param string $Role
   *  User role.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setRole(string $Role): static
  {
      $this->Role = $Role;

      return $this;
  }

  /**
   * @return StudentProfile
   *  Returns the student profile of the student user.
   */
  public function getStudentProfile(): ?StudentProfile
  {
      return $this->studentProfile;
  }

  /**
   * Sets the student profile of the student user.
   *
   * @param StudentProfile $studentprofile
   *  Object of student profile class.
   *
   * @return static
   *  Reference to the calling object.
   */
  public function setStudentProfile(StudentProfile $studentProfile): static
  {
    // set the owning side of the relation if necessary
    if ($studentProfile->getStudentEmail() !== $this) {
        $studentProfile->setStudentEmail($this);
    }

    $this->studentProfile = $studentProfile;

    return $this;
  }
}
