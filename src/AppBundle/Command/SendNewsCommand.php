<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class SendNewsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('news:send')
            ->setDescription('Sends the news to all users');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em0 = $this->getContainer()->get('doctrine')->getManager();

        $usersList = $em0->getRepository("AppBundle:User")->findAll();
        $userCounter=1;
        $currentUser=1;
        $userFrom=0;
        $userTo=0;

        $fs = new FileSystem();
        $fs->remove($this->container->getParameter('kernel.cache_dir'));

        foreach ($usersList as $user) {
            if ($userCounter==1) {
                $userFrom = $user->getID();
            } 
            $userCounter++;
            if ($userCounter==10 || $currentUser==count($usersList)) {
                $userTo = $user->getID();
                $url = "http://redperiurban.com/email/news/".$userFrom."/".$userTo;
                echo $url;
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($curl);
                curl_close($curl);
                sleep(20);
                echo $result;
                $userCounter=1; 
    
                $fs = new FileSystem();
                $fs->remove($this->container->getParameter('kernel.cache_dir'));
            }
            $currentUser++;
        }
        $output->writeln('Hola mundo');
    }
}
