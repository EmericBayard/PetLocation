<?php

namespace App\DataFixtures;

use App\Entity\Mydb\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixture extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $admin = new Admin();
        $admin->setFirstname('Admin');
        $admin->setLastname('Admin');
        $admin->setEmail('admin@gmail.com');
        $admin->setPassword(
            $this->encoder->encodePassword($admin, 'test')
        );
        $admin->setRole('ROLE_ADMIN');

        $manager->persist($admin);
        $manager->flush();
    }
}
