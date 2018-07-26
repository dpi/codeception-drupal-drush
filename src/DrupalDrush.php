<?php

namespace Codeception\Module;

use Codeception\Module;
use Symfony\Component\Process\Process;

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
        $command_line = [
          $this->config['drush'] ?? 'drush',
        ];

        if (isset($this->config['drush-alias'])) {
          $command_line[] = $this->config['drush-alias'];
        }

        if (isset($this->config['default_args'])) {
          $default_args = explode(' ', $this->config['default_args']);
          $command_line = array_merge($command_line, $default_args);
        }

        $command_line[] = '-y';
        $command_line[] = $command;
        $command_line = array_merge($command_line, $arguments);
        $command_line = array_merge($command_line, $options);

        $b = new Process($command_line);

        $this->debugSection('Command', $b->getCommandLine());
        return $b;
    }
}
