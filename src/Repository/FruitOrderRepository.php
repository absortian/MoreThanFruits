<?php

namespace App\Repository;

use App\Entity\FruitOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use PDO;

/**
 * @method FruitOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method FruitOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method FruitOrder[]    findAll()
 * @method FruitOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FruitOrder::class);
    }

    // /**
    //  * @return FruitOrder[] Returns an array of FruitOrder objects
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
    public function findOneBySomeField($value): ?FruitOrder
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
    * @return FruitOrder[] Returns an array of FruitOrder objects
    */
    public function getOrdersDataTable($params)
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
            if(isset($filters->providerName)){
                $where .= " AND o.providerName LIKE :providerName";
                $parametersQuery["providerName"] = "%".$filters->providerName."%";
            }
            if(isset($filters->providerId)){
                $where .= " AND o.providerId LIKE :providerId";
                $parametersQuery["providerId"] = "%".$filters->providerId."%";
            }
            if(isset($filters->countryCode)){
                $where .= " AND o.countryCode LIKE :countryCode";
                $parametersQuery["countryCode"] = "%".$filters->countryCode."%";
            }
            if(isset($filters->phone)){
                $where .= " AND o.phone LIKE :phone";
                $parametersQuery["phone"] = "%".$filters->phone."%";
            }
            if(isset($filters->fruitName)){
                $where .= " AND o.fruitName LIKE :fruitName";
                $parametersQuery["fruitName"] = "%".$filters->fruitName."%";
            }
            if(isset($filters->amount) && $filters->amount){
                $where .= " AND o.amount = :amount";
                $parametersQuery["amount"] = $filters->amount;
            }
            if(isset($filters->startDate) && $filters->startDate && isset($filters->endDate) && $filters->endDate){
                $where .= " AND o.creationDate >= :startDate";
                $where .= " AND o.creationDate <= :endDate";
                $startDate = explode("/", $filters->startDate);
                $startDate = $startDate[2]."-".$startDate[1]."-".$startDate[0].' 00:00:00';
                $endDate = explode("/", $filters->endDate);
                $endDate = $endDate[2]."-".$endDate[1]."-".$endDate[0].' 23:59:59';
                $parametersQuery["startDate"] = $startDate;
                $parametersQuery["endDate"] = $endDate;
            }
        }

        $total = $this->createQueryBuilder('o')
            ->where($where)
            ->setParameters($parametersQuery)
            ->orderBy('o.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        $filter = $this->createQueryBuilder('o')
            ->where($where)
            ->setParameters($parametersQuery)
            ->orderBy('o.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        $return = $this->createQueryBuilder('o')
            ->where($where)
            ->setParameters($parametersQuery)
            ->orderBy('o.id', 'ASC')
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
    * @return FruitOrder[] Returns an array of FruitOrder objects
    */
    public function getOrders($params)
    {

        $return = $this->createQueryBuilder('o')
            ->orderBy('o.id', 'ASC')
            ->getQuery()
            ->getResult(2)
        ;

        return $return;
    }

    public function getOrdersPerDay($params){

        $entityManager = $this->getEntityManager();
        $sqlConnection = $entityManager->getConnection();

        $where = " 1 = 1 ";

        if(isset($params["startDate"]) && isset($params["endDate"])){
            $startDate = explode("/", $params["startDate"]);
            $startDate = $startDate[2]."-".$startDate[1]."-".$startDate[0];
            $endDate = explode("/", $params["endDate"]);
            $endDate = $endDate[2]."-".$endDate[1]."-".$endDate[0];
            $where .= " AND ( fo.creation_date >= '$startDate 00:00:00' AND fo.creation_date <= '$endDate 23:59:59' ) ";
        }

        $queryTotal = "
            SELECT 
                count(fo.id) AS count,
                DATE_FORMAT(fo.creation_date, '%d/%m/%Y') AS date
            FROM fruit_order as fo
            WHERE $where
            GROUP BY DATE_FORMAT(fo.creation_date, '%Y-%m-%d')
        ";
        $queryTotal = $sqlConnection->executeQuery($queryTotal)->fetchAll(PDO::FETCH_ASSOC);

        return $queryTotal;

    }

}
