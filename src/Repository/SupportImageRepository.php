<?php

namespace App\Repository;

use App\Entity\SupportImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SupportImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SupportImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SupportImage[]    findAll()
 * @method SupportImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupportImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SupportImage::class);
    }

    public function findConf()
    {
        $result = $this->createQueryBuilder('supportImage')
            ->getQuery()
            ->getArrayResult();

        return array_reduce($result, function ($result, $item) {
            $result[$item['type']] = $item['priceStart'];
            return $result;
        }, array());
    }

//    /**
//     * @return SupportImage[] Returns an array of SupportImage objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SupportImage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
