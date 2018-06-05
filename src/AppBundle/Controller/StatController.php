<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Agents;
use AppBundle\Entity\Stats_sales;
use AppBundle\Entity\Card_sub_type;
use AppBundle\Entity\Card_type;
use AppBundle\Entity\Kassir;
use Symfony\Component\Validator\Constraints\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class StatController extends Controller
{
    /**
     * @Security("has_role('ROLE_DOC_LEAD') or has_role('ROLE_SUPER_USER')")
     * @Route("/list/{year}", name="gist")
     */
    public function indexAction(EntityManagerInterface $em, Request $request, $year)
    {
    	$user = $this->get('security.token_storage')->getToken()->getUser();
    	$connection = $em->getConnection();
    	$arr;
    	for($i=1; $i<=12; $i++)
    	{
    		$statement = $connection->prepare("select sum(sum), type from (
    			select * from (
    			SELECT card_type, Sum(transcount) FROM stats_sales where date_part('month', date) = :d  and date_part('year', date) = :year GROUP BY card_type order by card_type) as t1 
    			inner join (
    			SELECT id, type FROM card_sub_type order by id
    			) as t2 
    			ON t1.card_type = t2.id
    			) as tab group by type order by type");
    		$statement->bindValue('d', $i);
    		$statement->bindValue('year', $year);
    		$statement->execute();
    		$results = $statement->fetchAll();
    		$arr[] = $results;
    	}

    	$statement = $connection->prepare("select id, descr from card_type");
    	$statement->execute();
    	$descr = $statement->fetchAll();
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
    $date = "30-05-2018";
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

return $this->render('Stats/index.html.twig', [
	'information' => $res,
	'current_user' => $user,
	'description'=>$descr,
	'year' => $year,
	]);
}

    /**
     * @Security("has_role('ROLE_DOC_LEAD') or has_role('ROLE_SUPER_USER')")
     * @Route("/chart", name="chart")
     */
    public function grafAction(EntityManagerInterface $em, Request $request)
    {
    	$user = $this->get('security.token_storage')->getToken()->getUser();
    	return $this->render('Stats/chart.html.twig',[
    		'current_user' => $user,
    		]);

    }
     /**
     * @Security("has_role('ROLE_DOC_LEAD') or has_role('ROLE_DOC_EMP') or has_role('ROLE_SUPER_USER')")
     * @Route("/pie", name="pie")
     */
     public function pieAction(EntityManagerInterface $em, Request $request)
     {
     	$user = $this->get('security.token_storage')->getToken()->getUser();
     	return $this->render('Stats/pie.html.twig',[
     		'current_user' => $user,
     		]);

     }
     /**
      * @Security("has_role('ROLE_DOC_LEAD') or has_role('ROLE_DOC_EMP') or has_role('ROLE_SUPER_USER')")
     * @Route("/pie/{year}", name="piejson")
     */
     public function piejsonAction(EntityManagerInterface $em, Request $request, $year)
     {
     	$connection = $em->getConnection();
     	$statement = $connection->prepare("select descr as name, y from (select type as name, sum(sum) as y from (
     		select * from (
     		SELECT card_type, Sum(transcount) FROM stats_sales where date_part('month', date) >= 1 and date_part('month', date) <=12  and date_part('year', date) = :year GROUP BY card_type order by card_type) as t1 
     		inner join (
     		SELECT id, type FROM card_sub_type order by id
     		) as t2 
     		ON t1.card_type = t2.id
     		) as tab group by type order by type) as table1 inner join (select * from card_type) as table2 on table1.name=table2.id");
     	$statement->bindValue('year', $year);
     	$statement->execute();
     	$results = $statement->fetchAll();
     	$results = json_encode($results);
     	return new Response($results);

     }
     /**
     * @Route("/lastmonth", name="lastmonth")
     */
     public function kassjsonAction(EntityManagerInterface $em, Request $request)
     {
     	$connection = $em->getConnection();
     	$statement = $connection->prepare("select descr as name, y from (select type as name, sum(sum) as y from (
     		select * from (
     		SELECT card_type, Sum(transcount) FROM stats_sales where date_part('month', date) = date_part('month', now()) GROUP BY card_type order by card_type) as t1 
     		inner join (
     		SELECT id, type FROM card_sub_type order by id
     		) as t2 
     		ON t1.card_type = t2.id
     		) as tab group by type order by type) as table1 inner join (select * from card_type) as table2 on table1.name=table2.id");
     	$statement->execute();
     	$results = $statement->fetchAll();
     	$results = json_encode($results);
     	return new Response($results);

     }
    /**
     * @Security("has_role('ROLE_STAT_EMP') or has_role('ROLE_STAT_LEAD') or has_role('ROLE_SUPER_USER')")
     * @Route("/kassirtable", name="kassirtable")
     */
    public function kasstableAction(EntityManagerInterface $em, Request $request)
    {
    	$user = $this->get('security.token_storage')->getToken()->getUser();
    	$connection = $em->getConnection();
    	$statement = $connection->prepare("select kassir_id, name, sum, summ from (SELECT kassir_id, Sum(transcount), sum(transsum) as summ FROM stats_sales where date_part('year', date) =2015 GROUP BY kassir_id order by kassir_id) as t1 inner join (
    		SELECT id, name FROM kassir order by name
    		) as t2 ON t1.kassir_id = t2.id order by kassir_id");
		//$statement->bindValue('d', $i);
    	$statement->execute();
    	$results = $statement->fetchAll();
    	$lastmonth = $connection->prepare("select kassir_id, name, sum, summ from (SELECT kassir_id, Sum(transcount), sum(transsum) as summ FROM stats_sales where date_part('month', date) =date_part('month', now()) GROUP BY kassir_id order by kassir_id) as t1 inner join (
    		SELECT id, name FROM kassir order by name
    		) as t2 ON t1.kassir_id = t2.id order by kassir_id");
    	$lastmonth->execute();
    	$res = $lastmonth->fetchAll();
        /*
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
        	$results, 
        	$request->query->getInt('page',1),
        	$request->query->getInt('limit',5)      
        	);

        $pag  = $this->get('knp_paginator');
        $resu = $pag->paginate(
        	$res, 
        	$request->query->getInt('page',1),
        	$request->query->getInt('limit',5)      
        	);

            	//var_dump($results);
        return $this->render('Stats/table.html.twig', [
        	'kassirs' => $result,
        	'current_user' => $user,
        	'monthkass' => $resu             
        	]);
    }
             /**
     * @Security("has_role('ROLE_STAT_LEAD') or has_role('ROLE_SUPER_USER')")
     * @Route("/jsonkassperiod/{name}", name="jsonkassperiod")
     */
             public function kassperiodAction(EntityManagerInterface $em, Request $request, $name)
             {
              $user = $this->get('security.token_storage')->getToken()->getUser();
    	//$kassir = $em->getRepository('AppBundle:Kassir')->find($name);
              $connection = $em->getConnection();
              $statement = $connection->prepare("select date_part('month', date) as dat, sum(transsum), sum(transcount) as summ from stats_sales where kassir_id=:name group by dat order by dat");
              $statement->bindValue('name', $name);
              $statement->execute();
              $results = $statement->fetchAll();
              return $this->render('Stats/kassperiod.html.twig', [
                 'current_user' => $user,
                 'kassir' => $results             
                 ]);
          }
     /**
     * @Security("has_role('ROLE_DOC_LEAD') or has_role('ROLE_SUPER_USER')")
     * @Route("/jsonformation/{year}", name="jsonformation")
     */
     public function jsonAction(EntityManagerInterface $em, Request $request, $year)
     {
     	$connection = $em->getConnection();
     	$statement = $connection->prepare("SELECT date_part('month', date) AS txn_year, sum(transcount) as monthly_sum
     		FROM stats_sales where date_part('year', date)=:year
     		GROUP BY txn_year order by txn_year ");
     	$statement->bindValue('year', $year);
     	$statement->execute();
     	$results = $statement->fetchAll();
     	$jst = json_encode($results);
     	return new Response($jst);
     }
     /**
     * @Security("has_role('ROLE_DOC_LEAD') or has_role('ROLE_SUPER_USER')")
     * @Route("/jsonformation/{year}/{m1}/{m2}", name="jsonmoth")
     */
     public function jsonmAction(EntityManagerInterface $em, Request $request, $year,$m1, $m2)
     {

     	if($m1>$m2){
     		$f=$m2;
     		$m2=$m1;
     		$m1=$f;
     	}	
     	$connection = $em->getConnection();
     	$statement = $connection->prepare("SELECT date_part('month', date) AS txn_year, sum(transcount) as monthly_sum
     		FROM stats_sales where date_part('year', date)=:year and date_part('month', date)>=:m1 and date_part('month', date)<=:m2
     		GROUP BY txn_year order by txn_year ");
     	$statement->bindValue('year', $year);
     	$statement->bindValue('m1', $m1);
     	$statement->bindValue('m2', $m2);
     	$statement->execute();
     	$results = $statement->fetchAll();
       $jst = json_encode($results);
       return new Response($jst);
   }

     /**
      * @Route("/exelexplstmnth", name="exelexplstmnth")
     */
     public function excelAction(EntityManagerInterface $em, Request $request)
     {
     	$connection = $em->getConnection();
     	$statement = $connection->prepare("select descr as name, y from (select type as name, sum(sum) as y from (
     		select * from (
     		SELECT card_type, Sum(transcount) FROM stats_sales where date_part('month', date) = date_part('month', now()) GROUP BY card_type order by card_type) as t1 
     		inner join (
     		SELECT id, type FROM card_sub_type order by id
     		) as t2 
     		ON t1.card_type = t2.id
     		) as tab group by type order by type) as table1 inner join (select * from card_type) as table2 on table1.name=table2.id");
     	$statement->execute();
     	$results = $statement->fetchAll();
     	$row=1;
     	$col = 1;
     	$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
     	foreach ($results as $res) {
     		$phpExcelObject->getActiveSheet()->setCellValueByColumnAndRow($col-1, $row, $res['name']);
     		$phpExcelObject->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $res['y']);
     		$row++;
     	}

     	$writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
     	$writer->save('lastmonth.xls');
     	return new Response(' &#10004;');
     }

     /**
      * @Route("/exelexpalltime", name="exelexpalltime")
     */
     public function excelexpAction(EntityManagerInterface $em, Request $request)
     {
        $connection = $em->getConnection();
        $statement = $connection->prepare("select descr as name, y from (select type as name, sum(sum) as y from (
            select * from (
            SELECT card_type, Sum(transcount) FROM stats_sales GROUP BY card_type order by card_type) as t1 
            inner join (
            SELECT id, type FROM card_sub_type order by id
            ) as t2 
            ON t1.card_type = t2.id
            ) as tab group by type order by type) as table1 inner join (select * from card_type) as table2 on table1.name=table2.id");
        $statement->execute();
        $results = $statement->fetchAll();
        $row=1;
        $col = 1;
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
        foreach ($results as $res) {
            $phpExcelObject->getActiveSheet()->setCellValueByColumnAndRow($col-1, $row, $res['name']);
            $phpExcelObject->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $res['y']);
            $row++;
        }

        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        $writer->save('alltime.xls');
        return new Response(' &#10004;');
    }

     /**
      * @Route("/wordexportalltime", name="wordexportalltime")
     */
     public function wordalltimeexportAction(EntityManagerInterface $em, Request $request)
     {
        $connection = $em->getConnection();
        $statement = $connection->prepare("select descr as name, y from (select type as name, sum(sum) as y from (
            select * from (
            SELECT card_type, Sum(transcount) FROM stats_sales GROUP BY card_type order by card_type) as t1 
            inner join (
            SELECT id, type FROM card_sub_type order by id
            ) as t2 
            ON t1.card_type = t2.id
            ) as tab group by type order by type) as table1 inner join (select * from card_type) as table2 on table1.name=table2.id");
        $statement->execute();
        $results = $statement->fetchAll();
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        foreach ($results as $res) {
            $section->addText($res['name'].' - '.$res['y'].'<br>',
                array('name' => 'Tahoma', 'size' => 10)
                );
        }
        
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $objWriter->save('alltime.html');
        return new Response(' &#10004;');
    }
     /**
      * @Route("/wordexportlstmnth", name="wordexportlstmnth")
     */
     public function wordlstmnthexportAction(EntityManagerInterface $em, Request $request)
     {
        $connection = $em->getConnection();
        $statement = $connection->prepare("select descr as name, y from (select type as name, sum(sum) as y from (
            select * from (
            SELECT card_type, Sum(transcount) FROM stats_sales where date_part('month', date) = date_part('month', now()) GROUP BY card_type order by card_type) as t1 
            inner join (
            SELECT id, type FROM card_sub_type order by id
            ) as t2 
            ON t1.card_type = t2.id
            ) as tab group by type order by type) as table1 inner join (select * from card_type) as table2 on table1.name=table2.id");
        $statement->execute();
        $results = $statement->fetchAll();
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        foreach ($results as $res) {
            $section->addText($res['name'].' - '.$res['y'].'<br>',
                array('name' => 'Tahoma', 'size' => 10)
                );
        }
        
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $objWriter->save('lastmonth.html');
        return new Response(' &#10004;');
    }

      /**
     * @Route("/transport", name="transport")
     */
      public function transportAction(EntityManagerInterface $em, Request $request)
      {
          $user = $this->get('security.token_storage')->getToken()->getUser();
          return $this->render('Stats/transport.html.twig',[
             'current_user' => $user,
             ]);

      }
     /**
     * @Route("/transportjson/{year}", name="transportjson")
     */
     public function transjsonAction(EntityManagerInterface $em, Request $request, $year)
     {
     	$connection = $em->getConnection();
        if($year=='lstmnth'){
            $statement = $connection->prepare("select trans_type as name, sum from (select transport_type, sum(sum) from (select * from (
                SELECT card_type, Sum(transcount) FROM stats_sales where date_part('month', date) = date_part('month', now()) GROUP BY card_type order by card_type) as t1 
                inner join (
                SELECT id, transport_type FROM card_sub_type order by id
                ) as t2 
                ON t1.card_type = t2.id
                ) as tab group by transport_type order by transport_type) as table1 inner join (select id, trans_type from transport_type) as table2 on table1.transport_type = table2.id");
            $statement->execute();
        } else {
            $statement = $connection->prepare("select trans_type as name, sum from (select transport_type, sum(sum) from (select * from (
             SELECT card_type, Sum(transcount) FROM stats_sales where date_part('year', date) = :year GROUP BY card_type order by card_type) as t1 
             inner join (
             SELECT id, transport_type FROM card_sub_type order by id
             ) as t2 
             ON t1.card_type = t2.id
             ) as tab group by transport_type order by transport_type) as table1 inner join (select id, trans_type from transport_type) as table2 on table1.transport_type = table2.id");
            $statement->bindValue('year', $year);
            $statement->execute();
        }
        $results = $statement->fetchAll();
        $results = json_encode($results);
        return new Response($results);

    }



}
