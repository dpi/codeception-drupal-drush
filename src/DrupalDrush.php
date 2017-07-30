<?php

namespace Codeception\Module;

use Codeception\Module;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

class DrupalDrush extends Module {

    /**
     * Execute a drush command.
     *
     * @param string $command
     *   Command to run.
     *   e.g. "cc"
     * @param array $arguments
     *   Array of arguments.
     *   e.g. array("all")
     * @param array $options
     *   Array of options
     *   e.g. array("--uid=1").
     *
     * @return Process
     *   a symfony/process instance to execute.
     */
    public function getDrush($command, array $arguments = [], $options = [])
    {
        $args = [
          $this->config['drush'] ?? 'drush',
        ];

        if (isset($this->config['drush-alias'])) {
          $args[] = $this->config['drush-alias'];
        }

        if (isset($this->config['default_args'])) {
          $default_args = explode(' ', $this->config['default_args']);
          $args = array_merge($args, $default_args);
        }

        $args[] = '-y';
        $args[] = $command;
        $command_args = array_merge($args, $arguments);

        $b = new ProcessBuilder($command_args);

        foreach ($options as $option) {
          $processBuilder->add($option);
        }

        $this->debugSection('Command', $b->getProcess()->getCommandLine());
        return $b->getProcess();
    }
}
