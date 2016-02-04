<?php

namespace Testing\ConsoleBundle\Controller;

class CategoryAndProductController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller {

    public function createProductAction() {
        $category = new Category();
        $category->setName('Main Products');
        $product = new Product();
        $product->setName('Foo')->setPrice(19.99)->setDescription('Lorem ipsum dolor');
// relate this product to the category
        $product->setCategory($category);
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->persist($product);
        $em->flush();
        return new Response(
                'Created product id: ' . $product->getId()
                . ' and category id: ' . $category->getId()
        );
    }

    public function showAction($id) {
        $product = $this->getDoctrine()
                ->getRepository('AppBundle:Product')
                ->find($id);
        $categoryName = $product->getCategory()->getName();
// ...
    }

    public function showProductsAction($id) {
        $category = $this->getDoctrine()
                ->getRepository('AppBundle:Category')
                ->find($id);
        $products = $category->getProducts();
// ...
    }

    public function showWithCategoryAction($id) {
        $product = $this->getDoctrine()
                ->getRepository('AppBundle:Product')
                ->findOneByIdJoinedToCategory($id);
        $category = $product->getCategory();
// ...
    }

}
