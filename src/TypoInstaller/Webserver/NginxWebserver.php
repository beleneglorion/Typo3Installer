<?php


namespace TypoInstaller\Webserver;

use Symfony\Component\Process\Process;

/**
 * Description of ApacheWebserver
 *
 * @author sebastien
 */
class NginxWebserver implements WebserverInterface {
    
    public function vhostExist($hostname) {
      
        $exist = new Process(sprintf('$(test 1 -ge $(grep -Rin %s /etc/nginx|grep server|wc -l))',$hostname));
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
