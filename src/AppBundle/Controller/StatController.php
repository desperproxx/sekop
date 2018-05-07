<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Agents;
use AppBundle\Entity\Stats_sales;
use AppBundle\Entity\Card_sub_type;
use Symfony\Component\Validator\Constraints\DateTime;

class StatController extends Controller
{
    /**
     * @Route("/list", name="homepage")
     */
    public function indexAction(EntityManagerInterface $em, Request $request)
    {
$connection = $em->getConnection();
$arr;
for($i=1; $i<=12; $i++)
{
$statement = $connection->prepare("select sum(sum), type from (
select * from (
SELECT card_type, Sum(transcount) FROM stats_sales where date_part('month', date) = :d GROUP BY card_type order by card_type) as t1 
inner join (
SELECT id, type FROM card_sub_type order by id
) as t2 
ON t1.card_type = t2.id
) as tab group by type order by type");
$statement->bindValue('d', $i);
$statement->execute();
$results = $statement->fetchAll();
$arr[] = $results;
//$sum = $results;
}
$res = array();
foreach ($arr as $array) {
  foreach ($array as $key => $value) {
    $res[$key][] = $value;
  }
}


//var_dump($res);
        //$blogPosts = $em->getRepository('AppBundle:Agents')->findAll();
        // replace this example code with whatever you need
/*$repository = $this->getDoctrine()
    ->getRepository('AppBundle:Card_sub_type');
    for($i=0; $i<12; $i++){
    for($j=1; $j<=26; $j++){
    $stats_sales = new Stats_sales();
    $date = "30-12-2016";
    $stats_sales->setDate(new \DateTime($date));
    $stats_sales->setKassirId($i);  	
    $stats_sales->setCardType($j);
     if($j>=1 && $j<=10){
     $rnd = random_int(1000, 2000);
     $stats_sales->setTranscount($rnd);
     $query = $repository->createQueryBuilder('p')
    ->where('p.id = :id')
    ->setParameter('id', $j)
    ->orderBy('p.id', 'ASC')
    ->getQuery();
     $sum = $query->getResult();
     foreach ($sum as $product){
    $stats_sales->setTranssum($rnd*$product->getPrice());
}
    }
   $rnd = random_int(800, 1500);
   $stats_sales->setTranscount($rnd);
   $query = $repository->createQueryBuilder('p')
    ->where('p.id = :id')
    ->setParameter('id', $j)
    ->orderBy('p.id', 'ASC')
    ->getQuery();
     $sum = $query->getResult();
     foreach ($sum as $product){
    $stats_sales->setTranssum($rnd*$product->getPrice());
}
  
     $em->persist($stats_sales);
     $em->flush();
        
    }
       }*/


    //return new Response('Saved new product with id '.$product->getId());
        return $this->render('Stats/index.html.twig', [
            'information' => $res,
                  ]);
    }
}
