<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Select;

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

    /**
    * @return User[] Returns an array of User objects
    */
    public function getUsersDataTable($params)
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

        $where = "1=1";
        $parametersQuery = array();

        if(isset($params["search"]) && isset($params["search"]["value"])){
            $filters = json_decode($params["search"]["value"]);
            if(isset($filters->email)){
                $where .= " AND u.email LIKE :email";
                $parametersQuery["email"] = "%".$filters->email."%";
            }
        }

        $total = $this->createQueryBuilder('u')
            ->where($where)
            ->setParameters($parametersQuery)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        $filter = $this->createQueryBuilder('u')
            ->where($where)
            ->setParameters($parametersQuery)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        $return = $this->createQueryBuilder('u')
            ->where($where)
            ->setParameters($parametersQuery)
            ->orderBy('u.id', 'ASC')
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
    * @return User[] Returns an array of User objects
    */
    public function getUsers($params)
    {

        $return = $this->createQueryBuilder('u')
            ->select("partial u.{id,email,roles}")
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult(2)
        ;

        return $return;
    }

}
