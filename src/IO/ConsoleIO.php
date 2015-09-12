<?php

/*
 * This file is part of the Yosymfony\Spress.
 *
 * (c) YoSymfony <http://github.com/yosymfony>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yosymfony\Spress\IO;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Yosymfony\Spress\Core\IO\IOInterface;

/**
 * Symfony Console implementation.
 *
 * @author Victor Puertas <vpgugr@gmail.com>
 */
class ConsoleIO implements IOInterface
{
    protected $input;
    protected $output;
    protected $helperSet;
    protected $lastMessage;

    public function __construct(InputInterface $input, OutputInterface $output, HelperSet $helperSet)
    {
        $this->input = $input;
        $this->output = $output;
        $this->helperSet = $helperSet;

        $successStyle = new OutputFormatterStyle('white', 'blue', ['bold']);

        $this->output->getFormatter()->setStyle('success', $successStyle);
    }

    public function isInteractive()
    {
        return $this->input->isInteractive();
    }

    /**
     * {@inheritDoc}
     */
    public function isVerbose()
    {
        return OutputInterface::VERBOSITY_VERBOSE <= $this->output->getVerbosity();
    }

    /**
     * {@inheritDoc}
     */
    public function isVeryVerbose()
    {
        return OutputInterface::VERBOSITY_VERY_VERBOSE <= $this->output->getVerbosity();
    }

    /**
     * {@inheritDoc}
     */
    public function isDebug()
    {
        return OutputInterface::VERBOSITY_DEBUG === $this->output->getVerbosity();
    }

    /**
     * {@inheritDoc}
     */
    public function isDecorated()
    {
        return $this->output->isDecorated();
    }

    /**
     * {@inheritDoc}
     */
    public function write($messages, $newline = true)
    {
        $this->output->write($messages, $newline);
    }

    /**
     * {@inheritDoc}
     */
    public function ask($question, $default = null)
    {
        $helper = $this->helperSet->get('question');

        $questionObj = new Question($question, $default);

        return $helper->ask($this->input, $this->output, $questionObj);
    }

    /**
     * {@inheritDoc}
     */
    public function askConfirmation($question, $default = true)
    {
        $helper = $this->helperSet->get('question');

        $questionObj = new ConfirmationQuestion($question, $default);

        return $helper->ask($this->input, $this->output, $questionObj);
    }

    /**
     * {@inheritDoc}
     */
    public function askAndValidate($question, callable $validator, $attempts = false, $default = null)
    {
        $helper = $this->helperSet->get('question');

        $attempts = is_int($attempts) ?: null;

        $questionObj = new Question($question, $default);
        $questionObj->setValidator($validator);
        $questionObj->setMaxAttempts($attempts);

        return $helper->ask($this->input, $this->output, $questionObj);
    }

    /**
     * {@inheritDoc}
     */
    public function askAndHideAnswer($question, $fallback = true)
    {
        return $this->helperSet->get('dialog')->askHiddenResponse($this->output, $question, $fallback);
    }

    public function askHiddenResponseAndValidate($question, callable $validator, $attempts = false, $fallback)
    {
        return $this->helperSet->get('dialog')->askHiddenResponseAndValidate($this->output, $question, $validator, $attempts, $fallback);
    }
}
