<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Hash;
use App\Models\UserModel;

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

        $validated = $this->validate([
            'username' => [
                'rules' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
                'errors' => [
                    'required' => '名字必填',
                    'min_length' => '名字至少3個字',
                    'max_length' => '名字不能超過20個字',
                    'is_unique' => '名字已被使用',
                ],
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email必填',
                    'valid_email' => 'Email格式不正確',
                    'is_unique' => 'Email已被使用',
                ],
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[255]',
                'errors' => [
                    'required' => '密碼必填',
                    'min_length' => '密碼至少8個字',
                    'max_length' => '密碼不能超過255個字',
                ],
            ],
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

// print_r($this->validator,true);

        if (!$validated) {
            return view('auth/register', ['validation' => $this->validator]);
        }else{}



        // here we can save user data to database
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');

        $data = [
            'username' => $username,
            'email' => $email,
            'password' => Hash::encrypt($password),
        ];

        // storing user data to database
        $userModel = new \App\Models\UserModel();
        $query = $userModel->insert($data);

        if(!$query) {
            // return view('auth/register', ['validation' => $this->validator]);
            return redirect()->back()->with('fail', '註冊失敗');
        } else {
            // redirect to login page
            // return redirect()->to(site_url('auth/login'));
            // return redirect()->to(site_url('auth/login'))->with('success', '註冊成功');
            return redirect()->back()->with('success', '註冊成功');
        }
    }




    // login user
    public function loginUser()
    {
        //Validate user input
        $validated = $this->validate([
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email必填',
                    'valid_email' => 'Email格式不正確',
                    // 'is_unique' => 'Email已被使用',
                ],
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[255]',
                'errors' => [
                    'required' => '密碼必填',
                    'min_length' => '密碼至少8個字',
                    'max_length' => '密碼不能超過255個字',
                ],
            ],
        ]);
        // if validation fails, show error message
        if (!$validated) {
            return view('auth/login', ['validation' => $this->validator]);
        }else{
            // Check user details in database

            // here we can login user
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $userModel = new \App\Models\UserModel();
            $userInfo = $userModel->where('email', $email)->first();
            
            // if (!$userInfo) {
            //     // session()->setFlashdata('fail', '帳號或密碼錯誤');
            //     return redirect()->to(site_url('auth'))->with('fail', '帳號或密碼錯誤');
            // }
            // if (!Hash::check($password, $userInfo['password'])) {
            //     // session()->setFlashdata('fail', '帳號或密碼錯誤');
            //     return redirect()->to(site_url('auth'))->with('fail', '帳號或密碼錯誤');
            // }
            if (!$userInfo||!Hash::check($password, $userInfo['password'])) {
                return redirect()->to(site_url('auth'))->with('fail', '帳號或密碼錯誤');
            }

            $userId = $userInfo['id'];
            // set user data to session
            session()->set('user', $userId);
            // print_r(session()->get('user'));
            // exit;
            // redirect to home page
            return redirect()->to(site_url('dashboard'));
        }
    }







    // upload image
    public function uploadImage()
    {
        // try {
            $loggedInUserId = session()->get('user');
            $config['upload_path'] = getcwd().'/images';
            $imageName = $this->request->getFile('userImage')->getName();

            // If directory not present, create directory
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777);
            }

            // Get image
            $image = $this->request->getFile('userImage');

            if (!$image->hasMoved() && $loggedInUserId) {
                $image->move($config['upload_path'], $imageName);

                $data = [
                    'avatar' => $imageName,
                ];
                $userModel = new UserModel();
                $userModel->update($loggedInUserId,$data);

                return redirect()->to('dashboard')->with('success', '上傳成功');
            }else{
                return redirect()->to('dashboard')->with('fail', '上傳失敗');
            }
        // } catch(Exception $e) {
        //     echo $e->getMessage();
        // }
    }



    // logout user
    // public function logout()
    // {
    //     if(session()->has('user')){
    //         session()->remove('user');
    //         // session()->destroy();
    //     }
    //     return view('auth')->with('fail', '您已登出');
    // }

    public function logout()
      {
          if(session()->has('user'))
          {
            session()->remove('user');
            print_r(session()->get('user'));
            // echo($_SESSION);
          }else{
            echo 'empty';
          }

            // session_destroy();
            // session()->destroy('ci_session');
            // setcookie('ci_session', null, -1, '/');
            // session()->unset_userdata('user');

        return redirect()->to('/auth?access=loggedout')->with('fail','您已登出');
      }
}
