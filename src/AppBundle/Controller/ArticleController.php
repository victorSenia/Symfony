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
    public function showaAction($slug) {
// ...
    }

    public function showAction(Article $article, Request $request) {
        $author = $article->getAuthor();
        $articleDate = new \DateTime($article->getUpdatedAt());
        $authorDate = new \DateTime($author->getUpdatedAt());
        $date = $authorDate > $articleDate ? $authorDate : $articleDate;
        $response = new Response();
        $response->setLastModified($date);
// Set response as public. Otherwise it will be private by default.
        $response->setPublic();

        // set one vary header
        $response->setVary('Accept-Encoding');
// set multiple vary headers
        $response->setVary(array('Accept-Encoding', 'User-Agent'));

        if ($response->isNotModified($request)) {
            return $response;
        }

        // Marks the Response stale
        $response->expire();
// Force the response to return a proper 304 response with no content
        $response->setNotModified();
        // Set cache settings in one call
        $response->setCache(array(
            'etag' => $etag,
            'last_modified' => $date,
            'max_age' => 10,
            's_maxage' => 10,
            'public' => true,
// 'private' => true,
        ));

// ... do more work to populate the response with the full content
        return $response;
    }

}
