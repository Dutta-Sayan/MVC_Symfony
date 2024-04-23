<?php

namespace App\Repository;

use App\Entity\StudentProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudentProfile>
 *
 * @method StudentProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentProfile[]    findAll()
 * @method StudentProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentProfileRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
      parent::__construct($registry, StudentProfile::class);
  }
  // public function findByExamNumber(string $examNumber)
  // {
  //   $entityManager = $this->getEntityManager();
  //   $query = $entityManager->createQuery(
  //       'SELECT q from App\Entity\Questions q WHERE
  //     q.exam_number = :examNumber'
  //   )->setParameter('examNumber', $examNumber);
  //   $result = $query->getResult();
  //   return $result;
  // }
}
