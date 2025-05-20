<?php

namespace Http\Forms;

use \Core\Validator;

class LoginForm
{
    protected $errors = [];
    public function validate($email, $password)
    {
        if (!Validator::email($email)) {
            $this->errors['email'] = 'Graag een geldig email adress';
        }

        if (!Validator::string($password)) {
            $this->errors['password'] = 'Wachtwoord moet geldig zijn!';
        }

        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }
}