<?php

namespace App\Repository;

use App\Entity\Fruit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Fruit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fruit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fruit[]    findAll()
 * @method Fruit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fruit::class);
    }

    // /**
    //  * @return Fruit[] Returns an array of Fruit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fruit
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
    * @return Fruit[] Returns an array of FruitOrder objects
    */
    public function getFruitsDataTable($params)
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
            if(isset($filters->fruitName)){
                $where .= " AND f.name LIKE :fruitName";
                $parametersQuery["fruitName"] = "%".$filters->fruitName."%";
            }
        }

        $total = $this->createQueryBuilder('f')
            ->where($where)
            ->setParameters($parametersQuery)
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        $filter = $this->createQueryBuilder('f')
            ->where($where)
            ->setParameters($parametersQuery)
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        $return = $this->createQueryBuilder('f')
            ->where($where)
            ->setParameters($parametersQuery)
            ->orderBy('f.id', 'ASC')
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
    * @return Fruit[] Returns an array of FruitOrder objects
    */
    public function getFruits($params)
    {

        $return = $this->createQueryBuilder('f')
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult(2)
        ;

        return $return;
    }
}
