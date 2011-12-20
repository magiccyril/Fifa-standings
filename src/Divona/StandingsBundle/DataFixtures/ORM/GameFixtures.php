<?php

namespace Divona\StandingsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Divona\StandingsBundle\Entity\Game;
use Divona\UserBundle\Entity\User;

class GameFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
        $game1 = new Game();
        $game1->setPlayer1($manager->merge($this->getReference('user-1')));
        $game1->setPlayer2($manager->merge($this->getReference('user-2')));
        $game1->setScorePlayer1(0);
        $game1->setScorePlayer2(0);
        $manager->persist($game1);

        $game2 = new Game();
        $game2->setPlayer1($manager->merge($this->getReference('user-2')));
        $game2->setPlayer2($manager->merge($this->getReference('user-3')));
        $game2->setScorePlayer1(0);
        $game2->setScorePlayer2(3);
        $manager->persist($game2);

        $game3 = new Game();
        $game3->setPlayer1($manager->merge($this->getReference('user-3')));
        $game3->setPlayer2($manager->merge($this->getReference('user-1')));
        $game3->setScorePlayer1(2);
        $game3->setScorePlayer2(1);
        $manager->persist($game3);

        $game4 = new Game();
        $game4->setPlayer1($manager->merge($this->getReference('user-3')));
        $game4->setPlayer2($manager->merge($this->getReference('user-2')));
        $game4->setScorePlayer1(2);
        $game4->setScorePlayer2(2);
        $manager->persist($game4);

        $game5 = new Game();
        $game5->setPlayer1($manager->merge($this->getReference('user-2')));
        $game5->setPlayer2($manager->merge($this->getReference('user-1')));
        $game5->setScorePlayer1(4);
        $game5->setScorePlayer2(1);
        $manager->persist($game5);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}