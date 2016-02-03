<?php

namespace AppBundle\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class BlogController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller {

    /**
     * @Route("/blog/{page}", defaults={"page" = 1}, requirements={ "page": "\d+" })
     */
    public function indexAction($page) {
// ...
        return new \Symfony\Component\HttpFoundation\Response("page = $page");
    }

    /**
     * @Route("/blog/{slug}")
     */
    public function showAction($slug) {
        return new \Symfony\Component\HttpFoundation\Response("slug = $slug");
    }

    /**
     * @Route("/re{_locale}", defaults={"_locale": "en"}, requirements={
     * "_locale": "en|fr"
     * })
     */
    public function homepageAction($_locale) {
        return new \Symfony\Component\HttpFoundation\Response("locale = $_locale");
    }

    /**
     * @Route("/api/posts/{id}")
     * @Method({"GET","HEAD"})
     */
    public function showGetHeadAction($id) {
// ... return a JSON response with the post
    }

    /**
     * @Route(
     * "/articles/{_locale}/{year}/{title}.{_format}",
     * defaults={"_format": "html"},
     * requirements={
     * "_locale": "en|fr",
     * "_format": "html|rss",
     * "year": "\d+"
     * }
     * )
     */
    public function showFullAction($_locale, $year, $title) {
        $url = $this->generateUrl(
                'app_blog_show', array('slug' => 'my-blog-post')
        );

        $url = $this->container->get('router')->generate(
                'app_blog_show', array('slug' => 'my-blog-post')
        );

        $url = $this->get('router')->generate('blog', array(
            'page' => 2,
            'category' => 'Symfony'
        ));
// /blog/2?category=Symfony
    }

}
