<?php

namespace App\Repository;

use App\Entity\ImageFilename;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UploadAdmin|null find($id, $lockMode = null, $lockVersion = null)
 * @method UploadAdmin|null findOneBy(array $criteria, array $orderBy = null)
 * @method UploadAdmin[]    findAll()
 * @method UploadAdmin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageFilenameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageFilename::class);
    }

    /*
    public function findOneBySomeField($value): ?UploadAdmin
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
