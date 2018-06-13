<?php

namespace Junxwan\Console;

use Junxwan\Rename;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;

class RenameCommand extends BaseCommand
{
    /**
     * command init
     */
    protected function configure()
    {
        $this->setName('rename')
            ->addArgument('name', InputArgument::REQUIRED, 'What is file name?')
            ->addArgument('path', InputArgument::REQUIRED, 'What is file path?');
    }

    /**
     * run command to rename file
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rename = new Rename($input->getArgument('path'));

        $rename->to($input->getArgument('name'));

        $output->writeln('success');
    }
}
