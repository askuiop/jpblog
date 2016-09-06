<?php

namespace Jims\MsgQueueBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


use Jims\MsgQueueBundle\Service\DaemonOs;

class QtestCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('jims_msg_queue:qtest_command')
            ->setDescription('Hello PhpStorm')
            ->addOption('write-initd', null, InputOption::VALUE_NONE, '')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $write_mode =  $input->getOption('write-initd');

        if ($write_mode) {
            $output->writeln('xxx'.$input->getOption('write-initd'));
            $daemon = $this->getContainer()->get('jims_msg_queue.Daemon');
            #$daemon::setOption("appName", "mydaemon");  // Minimum configuration

            // Setup
            $options = array(
              'appName' => 'logparser',
              'appDir' => "/home/jims/wwwroot/sf3/jpblog/bin",
              'appExecutable' => "console xxxxx",
              'appDescription' => 'Parses vsftpd logfiles and stores them in MySQL',
              'authorName' => 'Kevin van Zonneveld',
              'authorEmail' => 'kevin@vanzonneveld.net',
              'sysMaxExecutionTime' => '0',
              'sysMaxInputTime' => '0',
              'sysMemoryLimit' => '1024M',
              'appRunAsGID' => 0,
              'appRunAsUID' => 0,
              'logVerbosity' => $daemon::LOG_DEBUG,
            );

            $daemon::setOptions($options);

            $daemon::start();

            if (($initd_location = $daemon::writeAutoRun(1)) === false) {
                $daemon::notice('unable to write init.d script');
            } else {
                $daemon::info(
                  'sucessfully written startup script: %s',
                  $initd_location
                );
            }
        }

        $runningOkay = true;
        $cnt = 0;

        while (!$daemon::isDying() && $runningOkay && $cnt <=10) {
            // What mode are we in?
            $mode = '"'.($daemon::isInBackground() ? '' : 'non-' ).
              'daemon" mode';

            $daemon::info('{appName} running in %s %s/3',
              $mode,
              $cnt
            );

            
            $runningOkay = true;
            //$runningOkay = parseLog('vsftpd');

            if (!$runningOkay) {
                $daemon::err('parseLog() produced an error, '.
                  'so this will be my last run');
            }

            // Relax the system by sleeping for a little bit
            // iterate also clears statcache
            $daemon::iterate(2);

            $cnt++;
        }

        $daemon::stop();
    }
}
