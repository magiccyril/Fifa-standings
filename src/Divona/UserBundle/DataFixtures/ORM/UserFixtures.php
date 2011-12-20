<?php

namespace Divona\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Divona\UserBundle\Entity\User;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
        $user1 = new User();
        $user1->setUsername('Jean');
        $user1->setEmail('jean@example.com');
        $user1->setPassword('password');
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('Louis');
        $user2->setEmail('louis@example.com');
        $user2->setPassword('password');
        $manager->persist($user2);

        $user3 = new User();
        $user3->setUsername('Michel');
        $user3->setEmail('michel@example.com');
        $user3->setPassword('password');
        $manager->persist($user3);

        $manager->flush();

        $this->addReference('user-1', $user1);
        $this->addReference('user-2', $user2);
        $this->addReference('user-3', $user3);
    }

    public function getOrder()
    {
        return 1;
    }
}