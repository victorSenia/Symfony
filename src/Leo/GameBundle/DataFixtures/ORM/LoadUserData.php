<?php
namespace Leo\GameBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Leo\GameBundle\Entity\Game;
use Leo\GameBundle\Entity\TypeGame;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadGameData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        //TypeGames
        $typeGamec = new TypeGame();
        $typeGamec->setName('chess');
        $manager->persist($typeGamec);
        $typeGamef = new TypeGame();
        $typeGamef->setName('football');
        $manager->persist($typeGamef);
        $typeGamet = new TypeGame();
        $typeGamet->setName('test');
        $manager->persist($typeGamet);
        //Games
        $game = new Game();
        $game->setName('chess1');
        $game->setTypeGame($typeGamec);
        $manager->persist($game);
        $game = new Game();
        $game->setName('chess2');
        $game->setTypeGame($typeGamec);
        $manager->persist($game);
        $game = new Game();
        $game->setName('football1');
        $game->setTypeGame($typeGamef);
        $manager->persist($game);
        $game = new Game();
        $game->setName('football2');
        $game->setTypeGame($typeGamef);
        $manager->persist($game);
        $game = new Game();
        $game->setName('test1');
        $game->setTypeGame($typeGamet);
        $manager->persist($game);
        $game = new Game();
        $game->setName('test2');
        $game->setTypeGame($typeGamet);
        $manager->persist($game);
        $manager->flush();
    }
}