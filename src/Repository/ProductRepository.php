<?php

namespace App\Repository;

use App\Entity\Product;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findHomepageProducts(): array
    {
        return $this
            ->createQueryBuilder('p')
            ->andWhere('p.visible = :visible')
            ->andWhere('p.OnSale = :onSale')
            ->andWhere('p.dateCreated > :last_year')
            ->setParameter('visible', true)
            ->setParameter('onSale', true)
            ->setParameter('last_year', (new DateTime())->modify('-1 year'))
            ->orderBy('p.PBT', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
        //sur ma page d'accueil je veux les produits 
        // -visible
        // -en promotion
        // -créés il a y moins d'un an
        // -ordonnées pas prix croissant
        // -limités à 5
        // return $this
        //     ->getEntityManager()
        //     ->createQuery("SELECT p FROM " . Product::class . " p WHERE p.visible = 1 AND p.OnSale = 1 AND p.datecreated > DATE_SUB(CURRENT_DATE(), 1, 'YEAR') ORDER BY p.pbt")
        //     ->setMaxResults(5)
        //     ->getResult();
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
