<?php

namespace App\Repository;

use App\Entity\Petdb\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Repository\Query;
use App\Entity\Petdb\UserSearch;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUsersCount() {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.iduser)')
            ->getQuery()
            ->getArrayResult();
            // ->getResult();
    }

    public function getUsersCountByPeriod($period) {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.iduser)')
            ->setParameter('period', $period)
            ->andWhere('u.createdAt < :period')
            ->getQuery()
            ->getArrayResult();
            // ->getResult();
    }

    // Ancienne pagination
    public function getAllUSers($nbPerPage, $page)
    {
        $qb = $this->createQueryBuilder('u');
    
        $query = $qb->getQuery();

        // On doit définir l'utilisateur à partir duquel commence la liste (par page): $offset
        // $page >= 1
        $offset = ($page - 1) * $nbPerPage;
        $query->setFirstResult($offset);
        $query->setMaxResults($nbPerPage);

        // return $query->getResult();
        return new Paginator($query);
    }

    private function findWithSearchQb(): QueryBuilder {
        return $this->createQueryBuilder('App\Entity\Petdb\User u');
    }

    // On modifie pour passer la recherche
    public function findWithSearchQuery(UserSearch $search) {
        // return $this->createQueryBuilder('u')
        //             ->getQuery();
        $query = $this->createQueryBuilder('u');

        if ($search->getEmail()) {
            $query = $query->where('u.email LIKE :email')
                           ->setParameter('email', $search->getEmail());
        }
        
        if ($search->getDateCreatedAt()) {
            $start = $search->getDateCreatedAt()->format("Y-m-d");
            $end = $search->getDateCreatedAt()->add(new \DateInterval('P1D'))->format("Y-m-d");
            $query = $query->andWhere('u.createdat BETWEEN :start AND :end')
                           ->setParameter('start', new \Datetime($start))
                           ->setParameter('end', new \Datetime($end));
        }

        return $query->getQuery();
    }



    
    

    
    // SELECT COUNT(*)
    // FROM user
    // WHERE createdAt > @VarJour AND createdAt < @VarJour + INTERVAL 1 DAY

    // public function findByAuthorAndDate($author, $annee)
    // {
    //     $qb = $this->createQueryBuilder('a');
    //     $qb->where('a.author = :author')
    //        ->setParameter('author', $author)
    //        ->andWhere('a.date < :annee')
    //        ->setParameter('annee', $annee)
    //        ->orderBy('a.date', 'DESC');

    //     return $qb->getQuery()->getResult();
    // }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    // public function whereCurrentYear(\Doctrine\ORM\QueryBuilder $qb)
    // {
    //     $qb->andWhere('a.date BETWEEN :start AND :end')
    //        ->setParameter('start', new \Datetime(date('Y').'-01-01'))
    //        ->setParameter('end', new \Datetime(date('Y').'-12-31'));

    //     return $qb;
    // }

    // public function findByAuthorCurrentYear($author)
    // {
    //     $qb =$this->createQueryBuilder('a');
    //     $qb->where('a.author = :author')
    //        ->setParameter('author', $author);

    //     $qb = $this->whereCurrentYear($qb);

    //     $qb->orderBy('a.date', 'DESC');

    //     return $qb->getQuery()->getResult();
    // }

    /*
    public function findOneBySomeField($value): ?User
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
