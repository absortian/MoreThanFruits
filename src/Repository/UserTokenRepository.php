<?php

namespace App\Repository;

use App\Entity\UserToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserToken[]    findAll()
 * @method UserToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserToken::class);
    }

    /**
    * @return UserToken[] Returns an array of UserToken objects
    */
    public function getUserTokensDataTable($params)
    {
        if(isset($params["draw"])){
            $draw = $params["draw"];
        }else{
            $draw = 0;
        }
        if(isset($params["length"])){
            $len = $params["length"];
        }else{
            $len = 10;
        }
        if(isset($params["start"])){
            $start = $params["start"];
        }else{
            $start = 0;
        }
        if(!$start){
            $start = 0;
        }
        if(!$len){
            $len = 10;
        }
        if(!$draw){
            $draw = 0;
        }
        $total = $this->createQueryBuilder('ut')
            ->andWhere('ut.user = :user')
            ->andWhere('ut.deleted = 0')
            ->setParameter("user",$params["user"])
            ->orderBy('ut.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        $filter = $this->createQueryBuilder('ut')
            ->andWhere('ut.user = :user')
            ->andWhere('ut.deleted = 0')
            ->setParameter("user",$params["user"])
            ->orderBy('ut.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        $return = $this->createQueryBuilder('ut')
            ->andWhere('ut.user = :user')
            ->andWhere('ut.deleted = 0')
            ->setParameter("user",$params["user"])
            ->orderBy('ut.id', 'ASC')
            ->getQuery()
            ->setFirstResult($start)
            ->setMaxResults($len)
            ->getResult(2)
        ;

        return array(
            "draw" => $draw++,
            "recordsTotal" => count($total),
            "recordsFiltered" => count($filter),
            "data" => $return
        );
    }

    /**
    * @return UserToken[] Returns an array of UserToken objects
    */
    public function getUserTokens($params)
    {

        $return = $this->createQueryBuilder('ut')
            ->andWhere('ut.user = :user')
            ->andWhere('ut.deleted = 0')
            ->setParameter("user", $params["user"])
            ->orderBy('ut.id', 'ASC')
            ->getQuery()
            ->getResult(2)
        ;

        return $return;
    }

    // /**
    //  * @return UserToken[] Returns an array of UserToken objects
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

    /*
    public function findOneBySomeField($value): ?UserToken
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
