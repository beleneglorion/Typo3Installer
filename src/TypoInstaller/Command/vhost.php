<?php

namespace TypoInstaller\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Process\Process;
use TypoInstaller\Webserver\WebserverGuesser;

class Vhost extends Command
{
    
    protected $hostname;
    protected $rootdir;
    
    protected function configure()
    {
        
        $this->setName('create-vhost');
    }
    
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
       try { 
       $ws = getWebserverInstance    
       $this->askHostname($output);
       $this->askRootdir($output);
       $this->generateVhost($output);
       } 
       catch(\Exception $e ) {
           
           $output->writeln('<error>Nasty error happened :\'-(</error>');
           $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));

       }
         
        
    }
    
   
     protected function askHostname( OutputInterface $output) {
         
           $dialog = $this->getHelper('dialog');
           $this->hostname   = $dialog->askAndValidate(
                   $output,
                   '<question>Please specify a non-existing directory to start the installation</question>',
                   function($hostname) {
                    // verifier que le hostname est valide
                   //
               
               
                   }
                         
                   );

        
    }
    
     protected function askRootdir( OutputInterface $output) {
        
    }
    
     protected function generateVhost( OutputInterface $output) {
        
    }
    
}