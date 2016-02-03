<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

// ...
class ArticleController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller {

    public function recentArticlesAction($max = 3) {
// make a database call or other logic
// to get the "$max" most recent articles
        $articles = null;
        return $this->render(
                        'article/recent_list.html.twig', array('articles' => $articles)
        );
    }

    /**
     * @Route("/article/{slug}", name="article_show")
     */
    public function showAction($slug) {
// ...
    }

}
