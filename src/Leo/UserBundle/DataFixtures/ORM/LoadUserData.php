<?php
namespace Leo\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Leo\UserBundle\Entity\Role;
use Leo\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = NULL)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        //Roles
        $roleu = new Role();
        $roleu->setRole('ROLE_USER');
        $manager->persist($roleu);
        $rolea = new Role();
        $rolea->setRole('ROLE_ADMIN');
        $manager->persist($rolea);
        $roles = new Role();
        $roles->setRole('ROLE_SUPER_ADMIN');
        $manager->persist($roles);
        //Users
        $users = new User();
        $users->setEmail('a@a.a');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($users, 'a');
        $users->setPassword($password);
        $users->setName('a');
        $users->setSurename('a');
        $users->setUsername('a');
        $users->setRole($roles);
        $manager->persist($users);
        $usera = new User();
        $usera->setEmail('b@b.b');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($usera, 'b');
        $usera->setPassword($password);
        $usera->setName('b');
        $usera->setSurename('b');
        $usera->setUsername('b');
        $usera->setRole($rolea);
        $manager->persist($usera);
        $useru = new User();
        $useru->setEmail('c@c.c');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($useru, 'c');
        $useru->setPassword($password);
        $useru->setName('c');
        $useru->setSurename('c');
        $useru->setUsername('c');
        $useru->setRole($roleu);
        $manager->persist($useru);
        $manager->flush();
    }
}