<?php

namespace Junxwan\Console;

use Junxwan\Rename;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
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
            ->addArgument('path', InputArgument::REQUIRED, 'What is file path?')
            ->addOption('formatZero', 'f', InputOption::VALUE_OPTIONAL, 'file number format', 2)
            ->addOption('start', 's', InputOption::VALUE_OPTIONAL, 'file start number name', 1);
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
        $options = $input->getOptions();

        $ask = new SymfonyStyle($input, $output);
        $ask->title('Batch Rename List');

        /**
         * 事先列出所有要更改的檔案清單
         * 並由使用者確認完成後在決定是否要更改
         */
        $ask->text($rename->lists());

        if ($ask->confirm('Are you rename file', false)) {
            $rename->to($input->getArgument('name'), $options['start'], $options['formatZero']);
            $ask->success('success');
        } else {
            $ask->warning('no rename file');
        }
    }
}
