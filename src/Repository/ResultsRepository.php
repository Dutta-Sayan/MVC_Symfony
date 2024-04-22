<?php

namespace App\Repository;

use App\Entity\Results;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Results>
 *
 * @method Results|null find($id, $lockMode = null, $lockVersion = null)
 * @method Results|null findOneBy(array $criteria, array $orderBy = null)
 * @method Results[]    findAll()
 * @method Results[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultsRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
      parent::__construct($registry, Results::class);
  }

  /**
   * Finds the results based on a student roll.
   *
   * @param string $studentRoll
   *  Contains the student roll.
   *
   * @return array
   *  Returns the list of results for the query.
   */
  public function findByStudentRoll(string $studentRoll)
  {
    $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery(
        'SELECT r from App\Entity\Results r WHERE
      r.student_roll = :studentRoll'
    )->setParameter('studentRoll', $studentRoll);
    $result = $query->getResult();
    return $result;
  }

  /**
   * Finds if results for a particular exam exists for a student.
   *
   * @param string $examNumber
   *  Contains the exam number.
   *
   * @param string $studentId
   *  Contains the respective student id.
   *
   * @return array
   *  Returns the list of results for the query.
   */
  public function existingResult($examNumber, $studentId)
  {
    $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery(
        'SELECT r from App\Entity\Results r WHERE
      r.exam_number = :examNumber AND r.result_id = :studentId'
    )->setParameters(['examNumber'=> $examNumber, 'studentId'=>$studentId]);
    $result = $query->getResult();
    return $result;
  }
}
