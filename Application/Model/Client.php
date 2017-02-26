<?php

namespace Application\Model;

use Application\Model\Mapper\Client as ClientMapper;

class Client
{
    private $errors;
    private $mapper = null;
    private $countries = ['PT','BR','ES','NL'];

    private $id;
    private $email;
    private $password;
    private $firstname;
    private $lastname;
    private $address;
    private $zipCode;
    private $city;
    private $nif;
    private $phone;
    private $country;

    public function __construct()
    {
        $this->mapper = new ClientMapper();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    public function setNif($nif)
    {
        $this->nif = $nif;
        return $this;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    public function findByEmail($email)
    {
        return $this->mapper->select('*', ['email'=>$email])->getElements();
    }

    public function findById($id)
    {
        $client = $this->mapper->select('*', ['id'=>$id])->getElements();

        return count($client)>0 ? $client[0] : $client;
    }

    public function getErros()
    {
        return $this->errors;
    }

    public function save()
    {
        $client = $this->mapper->newRow();

        $client->email = $this->email;
        $client->password = $this->password;
        $client->firstname = $this->firstname;
        $client->lastname = $this->lastname;
        $client->address = $this->address;
        $client->zip_code = str_replace('-', '', $this->zipCode);
        $client->city = $this->city;
        $client->nif = $this->nif;
        $client->phone = $this->phone;
        $client->country = $this->country;

        if(!$this->valid())
            return false;

        $this->id = $client->save();

        return $this->id;
    }

    private function valid()
    {
        $this->errors = [];

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
            $this->errors['email'] = 'E-mail inválido';

        if(trim($this->firstname) == '')
            $this->errors['firstname'] = 'Nome inválido';

        if(trim($this->lastname) == '')
            $this->errors['lastname'] = 'Apelido inválido';

        if(trim($this->password) == '')
            $this->errors['password'] = 'Password inválida';

        if (trim($this->nif) != '' && (!is_numeric($this->nif) || strlen($this->nif)!=9))
            $this->errors['nif'] = 'NIF inválido';

        if (trim($this->zipCode) != '' && !preg_match("/^[0-9]{4}-[0-9]{3}$/", $this->zipCode))
            $this->errors['zipcode'] = 'Código postal inválido';

        if (trim($this->country) != '' && false === array_search($this->country, $this->countries))
            $this->errors['country'] = 'País inválido';

        $phonePattern = '/^(?:9[1-36][0-9]|2[12][0-9]|2[35][1-689]|24[1-59]|26[1-35689]
                        |27[1-9]|28[1-69]|29[1256])[0-9]{6}$/x'
        ;

        if(trim($this->country) == 'PT' && trim($this->phone) != '' && !preg_match($phonePattern, $this->phone))
            $this->errors['phone'] = 'Telefone inválido';

        return 0===count($this->errors);
    }
}
