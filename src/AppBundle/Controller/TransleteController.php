<?php

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;

class TransleteController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller {

    /**
     * @return \Response
     */
    public function indexAction(\Symfony\Component\HttpFoundation\Request $request) {
//        $translated = $this->get('translator')->trans('test.test');
//        $translator = new \Symfony\Component\Translation\Translator('fr_FR');
//        $translator->addLoader('array', new \Symfony\Component\Translation\Loader\ArrayLoader());
//        $translator->addResource('array', array(
//            'Symfony is great!' => 'J\'aime Symfony!',
//                ), 'fr_FR');
//        var_dump($translator->trans('Symfony is great!'));
//        return new \Symfony\Component\HttpFoundation\Response($translator->trans('Symfony is great!'));
//        return new \Symfony\Component\HttpFoundation\Response($translated);
//        return new \Symfony\Component\HttpFoundation\Response($request->getLocale());

        var_dump($request->getLocale());
        var_dump($request);
        return $this->render('AppBundle::transl.html.twig');
    }

}
