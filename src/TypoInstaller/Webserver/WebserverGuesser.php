<?php

namespace TypoInstaller\Webserver;

use Symfony\Component\Process\Process;
use Symfony\Component\Console\Output\OutputInterface;
/**
 * Description of WebserverGuesser
 *
 * @author sebastien
 */
class WebserverGuesser {
   
    
   public static function findWebserver()
   {
       
       $returnValue = array();
       
       //find apache
       $testApache = new Process('$(which apache2ctl|wc - l)');
       $testApache->run();
       if ($testApache->isSuccessful()) {
           $returnValue[] = 'Apache';
        }
        //find nginx
       $testNginx = new Process('$(which nginx|wc - l)');
       $testNginx->run();
       if ($testNginx->isSuccessful()) {
           $returnValue[] = 'Nginx';
        }

       return $returnValue;
       
   }
   
   
   public function getWebserverInstance(OutputInterface $output)
   {
       
      $webservers = self::findWebserver();
      
      if(count($webservers) == 0) {
          throw new \Exception('Could not find any webserver');
      }elseif(count($webservers) == 1) {
          $classname = $webservers[0].'Webserver';
         $ws = new $classname();
      }else {
          
            $dialog = $this->getHelper('dialog');
            $w= $dialog->select(
            $output,
            'Choisissez un webserver',
            $webservers,
            0);
             $classname = $webservers[$w].'Webserver';
             $ws = new $classname();
      }
      
      return $ws;
       
       
   }

    
}

?>
