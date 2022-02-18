<?php

namespace App\controllers;

use App\exceptions\AccountIsBlockedException;
use App\exceptions\NotEnoughMoneyException;
use Exception;
use App\QueryBilder;
use League\Plates\Engine;
use PDO;
use Delight\Auth\Auth;

class LoginController
{

    private $templates;
    private $qb;
    private $engine;

    public function __construct(QueryBilder $qb, Engine $engine, Auth $auth)
    {
        $this->templates = $engine;
        $this->qb = $qb;
        $this->auth = $auth;
    }

    //Sign in
    public function index()
    {
        echo $this->templates->render('page_login', ['name' => 'Sign in']);
    }

    public function login_handler()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $this->auth->login($email, $password);

            echo 'User is logged in';
        } catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function logout()
    {
        try {
            $this->auth->logOutEverywhereElse();
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            die('Not logged in');
        }
        $this->auth->destroySession();
    }
}