<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

class AbstractCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        parent::configure();
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param string $message
     *
     * @return void
     */
    protected function writeError(OutputInterface $output, $message)
    {
        $output->writeln(sprintf('<error>%s</error>', $message));
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param string $message
     *
     * @return void
     */
    protected function writeInfo(OutputInterface $output, $message)
    {
        $output->writeln(sprintf('<info>%s</info>', $message));
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param $message
     *
     * @return void
     */
    protected function write(OutputInterface $output, $message)
    {
        $output->writeln($message);
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param array $messages
     */
    protected function writeList(OutputInterface $output, $messages)
    {
        foreach ($messages as $message) {
            $this->writeInfo($output, $message);
        }
    }
}