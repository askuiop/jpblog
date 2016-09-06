<?php

namespace Jims\MsgQueueBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GreetCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('jims_msg_queue:greet_command')
            ->setDescription('Hello PhpStorm')
            ->addArgument(
              'name',
              #InputArgument::OPTIONAL,
                InputArgument::REQUIRED,
              'Who do you want to greet?'
              )
            ->addOption(
              'yell',
              'null',
              InputOption::VALUE_NONE,
              'if set ...'

            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('xxxxxxxxxxxxxxx');
        $io->section('Adding a User');
        $io->text(array(
          'Lorem ipsum dolor sit amet',
          'Consectetur adipiscing elit',
          'Aenean sit amet arcu vitae sem faucibus porta',
        ));
        $io->listing(array(
          'Element #1 Lorem ipsum dolor sit amet',
          'Element #2 Lorem ipsum dolor sit amet',
          'Element #3 Lorem ipsum dolor sit amet',
        ));
        $io->table(
          array('Header 1', 'Header 2'),
          array(
            array('Cell 1-1', 'Cell 1-2'),
            array('Cell 2-1', 'Cell 2-2'),
            array('Cell 3-1', 'Cell 3-2'),
          )
        );
        $io->newLine(3);
        $io->note(array(
          'Lorem ipsum dolor sit amet',
          'Consectetur adipiscing elit',
          'Aenean sit amet arcu vitae sem faucibus porta',
        ));
        $io->caution(array(
          'Lorem ipsum dolor sit amet',
          'Consectetur adipiscing elit',
          'Aenean sit amet arcu vitae sem faucibus porta',
        ));
        // displays a progress bar of unknown length
        $io->progressStart();


// displays a 100-step length progress bar
        $io->progressStart(100);

        // advances the progress bar 1 step
        $io->progressAdvance();

// advances the progress bar 10 steps
        $io->progressAdvance(10);
        $io->progressFinish();

        $name2 = $io->ask('What is your name?');


        $name = $input->getArgument('name');
        $output->writeln('yes!'. $name. $name2);
    }
}
