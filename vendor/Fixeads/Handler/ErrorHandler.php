<?php

namespace Fixeads\Handler;

use Fixeads\Controller\FrontController;

class ErrorHandler
{
    private $debug;

    public function __construct($debug = false)
    {
        $this->debug = $debug;

        set_error_handler(array($this, 'handleError'));
        register_shutdown_function(array($this, 'handleFatalError'));
    }

    public function handleError($code, $_message, $file, $line)
    {
        $codeString = $this->codeToString($code);
        $message = sprintf(
            '%s: %s at %s line %s',
            $codeString,
            $_message,
            $file,
            $line
        );

        if (!$this->debug)
            $message = '';

        $this->printError($message);
        exit();
    }

    function handleFatalError() {
        $error = error_get_last();

        switch ($error['type']) {
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
            case E_RECOVERABLE_ERROR:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_PARSE:
                $codeString = $this->codeToString($error['type']);
                $message = sprintf(
                    '%s: %s at %s line %s',
                    $codeString,
                    $error['message'],
                    $error['file'],
                    $error['line']
                );

                $this->printError($message);
                exit();
        }
    }

    private function printError($message)
    {
        $frontController = FrontController::getInstance();

        if(!$frontController->getPath())
            $frontController->setPath(
                sprintf(__DIR__ . '%s..%1$s..%1$s../Application%1$sView', DIRECTORY_SEPARATOR)
            );

        $frontController->dispatch(
            'error',
            'index',
            [
                'code' => 500,
                'message' => $message
            ]
        );
    }

    private static function codeToString($code)
    {
        switch ($code) {
            case E_ERROR:
                return 'E_ERROR';
            case E_WARNING:
                return 'E_WARNING';
            case E_PARSE:
                return 'E_PARSE';
            case E_NOTICE:
                return 'E_NOTICE';
            case E_CORE_ERROR:
                return 'E_CORE_ERROR';
            case E_CORE_WARNING:
                return 'E_CORE_WARNING';
            case E_COMPILE_ERROR:
                return 'E_COMPILE_ERROR';
            case E_COMPILE_WARNING:
                return 'E_COMPILE_WARNING';
            case E_USER_ERROR:
                return 'E_USER_ERROR';
            case E_USER_WARNING:
                return 'E_USER_WARNING';
            case E_USER_NOTICE:
                return 'E_USER_NOTICE';
            case E_STRICT:
                return 'E_STRICT';
            case E_RECOVERABLE_ERROR:
                return 'E_RECOVERABLE_ERROR';
            case E_DEPRECATED:
                return 'E_DEPRECATED';
            case E_USER_DEPRECATED:
                return 'E_USER_DEPRECATED';
        }

        return 'Unknown PHP error';
    }
}
