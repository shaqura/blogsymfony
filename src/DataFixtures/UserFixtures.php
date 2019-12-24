<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
	/**
	*@var UserPasswordEncoderInterface
	*/
    private $encoder;

	public function __construct(UserPasswordEncoderInterface $encoder){
		$this->encoder=$encoder;
	}


    public function load(ObjectManager $manager)
    {
         $user = new User();
		 $user->setUsername('demo');
         $user->setPassword($this->encoder->encodePassword($user,'demodemo'));
         $user->setEmail('demo@demo.com');
		 $user->setRoles(['ROLE_ADMIN']);
         $manager->persist($user);

        $manager->flush();
		$user1 = new User();
		 $user1->setUsername('demo1');
         $user1->setPassword($this->encoder->encodePassword($user,'demodemo1'));
         $user1->setEmail('demo1@demo.com');
		 $user1->setRoles(['ROLE_USER']);
         $manager->persist($user1);

        $manager->flush();
    }
}
