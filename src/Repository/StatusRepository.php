<?php

namespace App\Repository;

use App\Entity\Status;
use Doctrine\ORM\Query;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Status>
 *
 * @method Status|null find($id, $lockMode = null, $lockVersion = null)
 * @method Status|null findOneBy(array $criteria, array $orderBy = null)
 * @method Status[]    findAll()
 * @method Status[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Status::class);
    }

    public function add(Status $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Status $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function selectFreeColors()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $colorsUse =   $qb->select('c.id')
            ->from('App\Entity\Status','s')
            ->innerJoin('s.color', 'c')
            ->where($qb->expr()->isNotNull('s.color'))
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_SCALAR_COLUMN);

        $colorsFree =  $qb->select('color')
            ->from('App\Entity\ColorsStatus', 'color')
            ->where($qb->expr()->notIn('color.id', $colorsUse))
            ->getQuery()
            ->getResult();

        return $colorsFree;

    }

//    /**
//     * @return Status[] Returns an array of Status objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Status
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
