<?php

namespace Application\Controller;

use Application\Model\Client;
use Fixeads\Controller\PageController;
use Fixeads\Util\Security\Bcrypt;
use Fixeads\Util\Security\Csrf;

class RegisterController extends PageController
{
    public function indexAction()
    {
        $this->view->crsftoken = Csrf::create();
    }

    public function saveAction()
    {
        $errors = [];

        if(!Csrf::check($_POST))
            $errors['csrf'] = 'Token inválido';

        if(!isset($_POST['password']) || !isset($_POST['copypassword']) || $_POST['password'] != $_POST['copypassword'])
            $errors['copypassword'] = 'Password incorreta';

        if(!isset($_POST['email']) || !isset($_POST['copyemail']) || $_POST['email'] != $_POST['copyemail'])
            $errors['copyemail'] = 'E-mail incorreto';

        if(isset($_POST['email']) && $this->clientExist($_POST['email']))
            $errors['email'] = 'O e-mail informado já foi registado';

        if(count($errors)>0)
            $this->createResponse(400, ['errors' => $errors]);

        $hash = '';
        if(isset($_POST['password']))
            $hash = Bcrypt::hash($_POST['password']);

        $client = new Client();
        $client
            ->setEmail($this::POST('email'))
            ->setPassword($hash)
            ->setLastname($this::POST('lastname'))
            ->setFirstname($this::POST('firstname'))
            ->setAddress($this::POST('address'))
            ->setZipCode($this::POST('zipcode'))
            ->setCity($this::POST('city'))
            ->setNif($this::POST('nif'))
            ->setPhone($this::POST('phone'))
            ->setCountry($this::POST('country'))
        ;

        if($client->save() === false)
            $this->createResponse(400, ['errors' => $client->getErros()]);

        Csrf::clear();

        $this->createResponse(201, ['id' => $client->getId()]);
    }

    public function existAction()
    {
        $email = isset($_GET['email']) ? $_GET['email'] : '';
        $data = ["exist" => $this->clientExist($email)];

        $this->createResponse(200, $data);
    }

    private function clientExist($email)
    {
        $client = new Client();
        $client = $client->findByEmail($email);

        return 0!==count($client);
    }

    private function createResponse($status, $data)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit();
    }
}
