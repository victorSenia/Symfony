<?php

// src/AppBundle/Controller/LuckyController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class LuckyController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller {

    /**
     * @Route("/lucky/number/{count}")
     */
    public function numberCAction($count) {
        $numbers = array();
        for ($i = 0; $i < $count; $i++) {
            $numbers[] = rand(0, 100);
        }
        $numbersList = implode(', ', $numbers);

// render using service container by nickname of servise e.g. "templating" (have to extened "Controller"
//        $html = $this->container->get('templating')->render(
//                'lucky/number.html.twig', array('luckyNumberList' => $numbersList)
//        );
//        return new Response($html);
//        
// render: a shortcut that does the same as above
//        
        return $this->render(
                        'lucky/number.html.twig', array('luckyNumberList' => $numbersList)
        );

//        return new Response(
//                '<html><body>Lucky numbers: ' . $numbersList . '</body></html>'
//        );
    }

    /**
     * @Route("/lucky/number")
     */
    public function numberAction() {
        $number = rand(0, 100);
        return new Response(
                '<html><body>Lucky number: ' . $number . '</body></html>'
        );
    }

    public function apiNumberAction() {
        $data = array(
            'lucky_number' => rand(0, 100),
        );
//        return new Response(
//                json_encode($data), 200, array('Content-Type' => 'application/json')
//        );
        return new \Symfony\Component\HttpFoundation\JsonResponse($data);
    }

}
