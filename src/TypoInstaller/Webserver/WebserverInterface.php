<?php

namespace TypoInstaller\Webserver;

/**
 *
 * @author sebastien
 */
interface WebserverInterface {
   
    
    public function vhostExist($hostname);
    
    public function vhostGenerate(array $options);
    
}

?>
