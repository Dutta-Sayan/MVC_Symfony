<?php

namespace App\Repository;

use App\Entity\Questions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Questions>
 *
 * @method Questions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Questions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Questions[]    findAll()
 * @method Questions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionsRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
      parent::__construct($registry, Questions::class);
  }

  /**
   * Finds the question based in exam number.
   *
   * @param string $examNumber
   *  Contains the exam number.
   *
   * @return array
   *  Returns the list of results for the query.
   */
  public function findByExamNumber(string $examNumber)
  {
    $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery(
        'SELECT q from App\Entity\Questions q WHERE
      q.exam_number = :examNumber'
    )->setParameter('examNumber', $examNumber);
    $result = $query->getResult();
    return $result;
  }
}
