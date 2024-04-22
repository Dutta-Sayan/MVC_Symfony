<?php

namespace App\Repository;

use App\Entity\Exam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exam>
 *
 * @method Exam|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exam|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exam[]    findAll()
 * @method Exam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExamRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
      parent::__construct($registry, Exam::class);
  }

  /**
   * Finds the exams based on eligible marks.
   *
   * @param int $marks
   *  Contains the academic marks of the student.
   *
   * @return array
   *  Returns the list of results for the query.
   */
  public function findByEligibleMarks(int $marks) : array
  {
    $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery(
        'SELECT e from App\Entity\Exam e WHERE
      e.eligibility_marks <= :marks'
    )->setParameter('marks', $marks);
    $result = $query->getResult();
    return $result;
  }

  /**
   * Finds the exam duration for a particular exam searched by exam number.
   *
   * @param string $examNumber
   *  Contains the exam number.
   *
   * @return array
   *  Returns the list of results for the query.
   */
  public function findDuration(string $examNumber) : array
  {
    $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery(
        'SELECT e from App\Entity\Exam e WHERE
      e.exam_number = :examNumber'
    )->setParameter('examNumber', $examNumber);
    $result = $query->getResult();
    return $result;
  }
}
