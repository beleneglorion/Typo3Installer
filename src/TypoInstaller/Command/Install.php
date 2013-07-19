<?php

namespace TypoInstaller\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Process\Process;
use TypoInstaller\Typo3Manager;

class Install extends Command
{
    protected $installDir;
    protected $failingProcess;
    protected $manager;
    
    public function __construct()
    {
        parent::__construct();
        $this->manager = new Typo3Manager();
        
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (
         //$this->createInstallationDirectory($output)
        // &&
                $this->askVersion($output)
        // && $this->install($output)
         ) 
         {
            $output->writeln('<info>MISSION ACCOMPLISHED</info>');
        } else {
            $output->writeln('<error>Nasty error happened :\'-(</error>');

            if ($this->failingProcess instanceOf Process) {
                $output->writeln(sprintf('<error>%s</error>', $this->failingProcess->getErrorOutput()));
            }
        }
    }

    protected function configure()
    {
        $this
            ->setName('install')
        ;
    }
    
    
protected function createInstallationDirectory(OutputInterface $output)
{
    $dialog             = $this->getHelper('dialog');
    $this->installDir   = $dialog->ask($output, '<question>Please specify a non-existing directory to start the installation</question>');

    if (!is_dir($this->installDir)) {
        $mkdir = new Process(sprintf('mkdir -p %s', $this->installDir));
        $mkdir->run();

        if ($mkdir->isSuccessful()) {
            $output->writeln(sprintf('<info>Directory %s succesfully  created</info>', $this->installDir));

            return true;
        }
    }

    $this->failingProcess = $mkdir;
    return false;
}

protected function askVersion(OutputInterface $output){
    
    $dialog = $this->getHelper('dialog');
    
    
    $branches =  $this->manager->getBranches();
    $branch= $dialog->select(
        $output,
        'Choisissez une version branche de Typo3',
        $branches,
        0
    );
    $branch = $branches[$branch];
    $output->writeln('Vous venez de sélectionner : '.$branch);
    //$output->writeln(var_export($this->manager->getBranch($branch),true));
    $releases = $this->manager->getReleases($branch);
    if(!is_null($releases)) {
        
   
        $release= $dialog->select(
        $output,
        'Choisissez une version releases de Typo3',
        $releases,
        0
        );
        $release = $releases[$release];
        $r = $this->manager->getRelease($branch, $release);

        $output->writeln(sprintf('Téléchargement de la version %s depuis %s',$release,$r->url->tar));
    }
    return true;
}


protected function install(OutputInterface $output)
{
    $install = new Process(sprintf('cd %s && php composer.phar install', $this->installDir));
    $install->run();

    if ($install->isSuccessful()) {
        $output->writeln('<info>Packages succesfully installed</info>');

        return true;
    } else {
      $output->writeln($install->getCommandLine());   
    }

    $this->failingProcess = $install;
    return false;
}

    
}
