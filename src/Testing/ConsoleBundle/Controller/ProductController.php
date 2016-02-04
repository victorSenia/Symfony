<?php

namespace Testing\ConsoleBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Symfony\Bundle\FrameworkBundle\Controller\Controller {

    public function createAction() {
        $product = new \Testing\ConsoleBundle\Entity\Product();
        $product->setName('A Foo Bar')->setPrice('19.99')->setDescription('Lorem ipsum dolor');
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        return new Response('Created product id ' . $product->getId());
    }

    public function showAction($id) {
        $product = $this->getDoctrine()
                ->getRepository('AppBundle:Product')
                ->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                    'No product found for id ' . $id
            );
        }
// ... do something, like pass the $product object into a template
    }

    public function otherGetAction() {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');

// query by the primary key (usually "id")
        $product = $repository->find($id);

// dynamic method names to find based on a column value
        $product = $repository->findOneById($id);
        $product = $repository->findOneByName('foo');

// find *all* products
        $products = $repository->findAll();

// find a group of products based on an arbitrary column value
        $products = $repository->findByPrice(19.99);

        // query for one product matching by name and price
        $product = $repository->findOneBy(
                array('name' => 'foo', 'price' => 19.99)
        );
// query for all products matching the name, ordered by price
        $products = $repository->findBy(
                array('name' => 'foo'), array('price' => 'ASC')
        );
    }

    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                    'No product found for id ' . $id
            );
        }
        $product->setName('New product name!');
        $em->flush();
        return $this->redirectToRoute('homepage');

        $em->remove($product);
        $em->flush();
    }

    public function otherQueryAction() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        'SELECT p
FROM AppBundle:Product p
WHERE p.price > :price
ORDER BY p.price ASC'
                )->setParameter('price', '19.99');
        $products = $query->getResult();
// to get just one result:
// $product = $query->setMaxResults(1)->getOneOrNullResult();


        $repository = $this->getDoctrine()
                ->getRepository('AppBundle:Product');
// createQueryBuilder automatically selects FROM AppBundle:Product
// and aliases it to "p"
        $query = $repository->createQueryBuilder('p')
                ->where('p.price > :price')
                ->setParameter('price', '19.99')
                ->orderBy('p.price', 'ASC')
                ->getQuery();
        $products = $query->getResult();
// to get just one result:
// $product = $query->setMaxResults(1)->getOneOrNullResult();
    }

}
