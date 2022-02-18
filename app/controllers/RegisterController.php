<?php

namespace App\controllers;

use App\exceptions\AccountIsBlockedException;
use App\exceptions\NotEnoughMoneyException;
use Exception;
use App\QueryBilder;
use League\Plates\Engine;
use PDO;
use Delight\Auth\Auth;

class RegisterController
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

    //sign up
    public function index()
    {
        echo $this->templates->render('page_register', ['name' => 'Sign up']);
    }

    public function register()
    {
        $email = $_POST['email'];//Create a mail variable
        $password = $_POST['password'];//Create a password variable
        $user_name = $_POST['user_name'];//Create User Name

        try {
            $userId = $this->auth->register($email, $password, $user_name, function ($selector, $token) {
                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                echo '  For SMS, consider using a third-party service and a compatible SDK';
            });

            echo 'We have signed up a new user with the ID ' . $userId;
        } catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function email_verify()
    {
        try {
            $this->auth->confirmEmail($_GET['selector'], $_GET['token']);

            echo 'Email address has been verified';
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        } catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }
}