<?php

namespace Application\Controller;

use Fixeads\Controller\PageController;

class IndexController extends PageController
{
    public function indexAction()
    {
        header("Location: /register/");
    }
}
