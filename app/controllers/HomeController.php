<?php

namespace App\controllers;

session_start();
use App\exceptions\AccountIsBlockedException;
use App\exceptions\NotEnoughMoneyException;
use Exception;
use App\QueryBilder;
use League\Plates\Engine;
use PDO;
use Delight\Auth\Auth;

// $db = new QueryBilder();
// // $posts = $db->getAll('posts');//Загрузить все записи с БД
// // $db->insert(['title' => 'New Post2'], 'posts');//Добавить новую запись в БД
// // $db->update(['title' => 'New Post2'], 7, 'posts');//Обновляем запись в БД
// // $db->delete('posts', 6);//Удалить запись с БД
// $posts = $db->getOne(['id' , 'title'], 'posts', 5);//Вывод одной записи с БД

class HomeController
{

    private $templates;
    private $qb;
    private $engine;

    public function __construct(QueryBilder $qb, Engine $engine, Auth $auth)
    {
        $this->templates = $engine;
        $this->qb = $qb;
        $this->auth = $auth;
        // d($this->templates);die();
    }

    public function index()
    {
        if ($this->auth->isLoggedIn()) {
            $select_user = $this->qb->getAll('users');
            $get_user_id = $this->auth->getUserId();
            $is_admin = $this->auth->hasRole(\Delight\Auth\Role::ADMIN);
            echo $this->templates->render('homepage', ['users' => $select_user, 'authorized_user_id' => $get_user_id, 'is_admin' => $is_admin]);
        } else {
            header("Location: /login");
        }


    }

    //Sign in
    public function login()
    {
        echo $this->templates->render('page_login', ['name' => 'Sign in']);
    }

    //create user
    public function create_user()
    {
        echo $this->templates->render('create_user', ['name' => 'Create User']);
    }

    //edit
    public function edit()
    {
        echo $this->templates->render('edit', ['name' => 'Edit']);
    }

    //media
    public function media()
    {
        echo $this->templates->render('media', ['name' => 'Media']);
    }

    //Page Profile
    public function page_profile()
    {
        echo $this->templates->render('page_profile', ['name' => 'Page Profile']);
    }

    //Security
    public function security()
    {
        echo $this->templates->render('security', ['name' => 'Security']);
    }

    //Status
    public function status()
    {
        echo $this->templates->render('status', ['name' => 'Status']);
    }
    // public function about(){
    // 	echo $this->templates->render('about', ['name' => 'About']);
    // }
}
