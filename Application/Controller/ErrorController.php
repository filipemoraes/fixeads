<?php

namespace Application\Controller;

use Fixeads\Controller\PageController;

class ErrorController extends PageController
{
    public function indexAction($args)
    {
        $code = isset($args['code']) ? $args['code'] : 0;
        $message = isset($args['message']) ? $args['message'] : '';

        $this->view->code = $code;
        $this->view->message = $message;
    }
}
