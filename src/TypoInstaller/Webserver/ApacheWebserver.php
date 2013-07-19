<?php


namespace TypoInstaller\Webserver;

use Symfony\Component\Process\Process;

/**
 * Description of ApacheWebserver
 *
 * @author sebastien
 */
class ApacheWebserver implements WebserverInterface {
    
    public function vhostExist($hostname) {
      
        $exist = new Process(sprintf('$(test 1 -eq $(apache2ctl -S|grep namevhost | grep %s |wc -l))',$hostname));
        $exist->run();

        if ($exist->isSuccessful()) {
            $output->writeln(sprintf('<info>Hostname doesn\'t exist</info>', $hostname));

            return true;
        }
        
        return false;
        
    }

    public function vhostGenerate(array $options) {
        
    }

}

?>
