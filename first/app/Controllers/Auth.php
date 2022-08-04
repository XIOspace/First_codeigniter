<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Hash;

class Auth extends BaseController
{
    // Enabling features
    public function __construct()
    {
        //
        helper(['url', 'form']);
    }

    public function register()
    {
        //
        // echo 'register page';
        return view('auth/register');
    }
    // public function login()
    // {
    //     //
    //     echo 'login page';
    // }
    public function index()
    {
        //
        // echo 'login page';
        return view('auth/login');
    }

    // save user data to database
    public function registerUser()
    {
        // //Validate user input
        // $validated = $this->validate([
        //     'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
        //     'email' => 'required|valid_email|is_unique[users.email]',
        //     'password' => 'required|min_length[8]|max_length[255]',
        //     'confirm_password' => 'required|min_length[8]|max_length[255]|matches[password]',
        // ]);

        $validated_username = $this->validate([
            'username' => [
                'rules' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
                'errors' => [
                    'required' => '名字必填',
                    'min_length' => '名字至少3個字',
                    'max_length' => '名字不能超過20個字',
                    'is_unique' => '名字已被使用',
                ],
            ],
        ]);
        $validated_email = $this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email必填',
                    'valid_email' => 'Email格式不正確',
                    'is_unique' => 'Email已被使用',
                ],
            ],
        ]);
        $validated_password = $this->validate([
            'password' => [
                'rules' => 'required|min_length[8]|max_length[255]',
                'errors' => [
                    'required' => '密碼必填',
                    'min_length' => '密碼至少8個字',
                    'max_length' => '密碼不能超過255個字',
                ],
            ],
        ]);
        $validated_confirm_password = $this->validate([
            'confirm_password' => [
                'rules' => 'required|min_length[8]|max_length[255]|matches[password]',
                'errors' => [
                    'required' => '確認密碼必填',
                    'min_length' => '確認密碼至少8個字',
                    'max_length' => '確認密碼不能超過255個字',
                    'matches' => '確認密碼不一致',
                ],
            ],
        ]);

        // echo $validated==true?'true':'false';

        // if validation fails, show error message
        if (!$validated_username||!$validated_email||!$validated_password||!$validated_confirm_password) {
            return view('auth/register', ['validation' => $this->validator]);
        }

        // here we can save user data to database
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');

        $data = [
            'username' => $name,
            'email' => $email,
            'password' => Hash::encrypt($password),
        ];

        // storing user data to database
        $userModel = new \App\Models\UserModel();
        $query = $userModel->insert($data);

        if(!$query) {
            // return view('auth/register', ['validation' => $this->validator]);
            return redirect()->back()->with('fails', '註冊失敗');
        } else {
            // redirect to login page
            // return redirect()->to(site_url('auth/login'));
            // return redirect()->to(site_url('auth/login'))->with('success', '註冊成功');
            return redirect()->back()->with('success', '註冊成功');
        }
    }
}
