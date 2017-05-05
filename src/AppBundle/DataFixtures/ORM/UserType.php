<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserType extends AbstractFixture implements  OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setUsername('admin');
        $user->setEmail('admin@mail.com');
        $user->setPlainPassword('admin.123456');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SUPER_ADMIN'));

        $userManager->updateUser($user, true);
    }

    public function getOrder()
    {
        return 6;
    }
}