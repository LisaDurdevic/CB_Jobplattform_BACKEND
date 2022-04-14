<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    public function index()
    {
        $model = model(UsersModel::class);

        $data = [
            'user'  => $model->getUser(),
            'title' => 'All Users',
        ];

        echo view('templates/header', $data);
        echo view('user/overview', $data);
        echo view('templates/footer', $data);
    }

    public function view($userName = null)
    {
        $model = model(UsersModel::class);

        $data['user'] = $model->getUser($userName);

        if (empty($data['user'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find this user: ' . $userName);
        }
    
        $data['title'] = $data['user']['userName'];
    
        echo view('templates/header', $data);
        echo view('user/view', $data);
        echo view('templates/footer', $data);
    }

    public function create() {
        $model = model(UsersModel::class);
        $userName = include('UsernameCreator.php');

        if ($this->request->getMethod() === 'post' && $this->validate([
            'firstName' => 'required|min_length[1]|max_length[20]',
            'lastName'  => 'required|min_length[1]|max_length[20]',
            'mail'  => 'required|min_length[1]|max_length[30]',
            'password'  => 'required|min_length[1]|max_length[60]'
        ])) {
            $model->save([
                'firstName' => $this->request->getPost('firstName'),
                'lastName' => $this->request->getPost('lastName'),
                'mail' => $this->request->getPost('mail'),
                'password' => $this->request->getPost('password'),
                'userName' => $userName
            ]);
    
            echo view('user/success');
        } else {
            echo view('templates/header', ['title' => 'Create a new account']);
            echo view('user/new');
            echo view('templates/footer');
        }
    }
    public function update() {

    }

    public function search($userName = null) {

    }

    public function login() {
        $model = model(UsersModel::class);

        $data['user'] = $model->getUser($userName);

        if (empty($data['user'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find this user: ' . $userName);
        }
    
        if ($this->request->getMethod() === 'post' && $this->validate([
            'mail'  => 'required|min_length[1]|max_length[30]',
            'password'  => 'required|min_length[1]|max_length[60]'
        ])) {
            $this->validate([
                'mail' => $data['user']['mail'],
                'password' => $data['user']['password']
            ]);
    
            echo view('user/login');
        } else {
            echo view('templates/header', ['title' => 'Create a new account']);
            echo view('pages/login');
            echo view('templates/footer');
        }
    }
}