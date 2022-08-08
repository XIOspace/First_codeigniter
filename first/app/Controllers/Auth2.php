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
        helper(['url', 'form']);
    }


    /**
      * Responsible for login page view.
    */
    public function index()
    {
        return view('auth/login');
    }

    /**
      *Responsible for register page view.
    */  
    public function register()
    {
        return view('auth/register');
    }

    /**
     * Save new user to database.
     */

     public function registerUser()
     {
         // Validate user input.

        //  $validated = $this->validate([
        //     'name'=> 'required',
        //     'email' => 'required|valid_email',
        //     'password' => 'required|min_length[5]|max_length[20]',
        //     'passwordConf'=> 'required|min_length[5]|max_length[20]|matches[password]'
        //  ]);

        $validated = $this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Your full name is required', 
                ]
            ],
            'email'=> [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Your email is required', 
                    'valid_email' => 'Email is already used.',
                ]
            ],
            'password'=> [
                'rules' => 'required|min_length[5]|max_length[20]',
                'errors' => [
                    'required' => 'Your password is required', 
                    'min_length' => 'Password must be 5 charectars long',
                    'max_length' => 'Password cannot be longer than 20 charectars'
                ]
            ],
            'passwordConf'=> [
                'rules' => 'required|min_length[5]|max_length[20]|matches[password]',
                'errors' => [
                    'required' => 'Your confirm password is required', 
                    'min_length' => 'Password must be 5 charectars long',
                    'max_length' => 'Password cannot be longer than 20 charectars',
                    'matches' => 'Confirm password must match the password',
                ]
            ],
        ]);

         if(!$validated)
         {
             return view('auth/register', ['validation' => $this->validator]);
         }

         // Here we save the user.

         $name = $this->request->getPost('name');
         $email = $this->request->getPost('email');
         $password = $this->request->getPost('password');
         $passwordConf = $this->request->getPost('passwordConf');

         $data = [
            'name' => $name,
            'email' => $email,
            'password' => Hash::encrypt($password)
         ];

         // Storing data

         $userModel = new \App\Models\UserModel();
         $query = $userModel->insert($data);

        if(!$query)
        {
            return redirect()->back()->with('fail', 'Saving user failed');
        }
        else
        {
            return redirect()->back()->with('success', 'Registered successfully');
        }
     }

     /**
      * User login method.
      */
      public function loginUser()
      {
        // Validating user input.

        $validated = $this->validate([
            'email'=> [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Your email is required', 
                    'valid_email' => 'Email is already used.',
                ]
            ],
            'password'=> [
                'rules' => 'required|min_length[5]|max_length[20]',
                'errors' => [
                    'required' => 'Your password is required', 
                    'min_length' => 'Password must be 5 charectars long',
                    'max_length' => 'Password cannot be longer than 20 charectars'
                ]
            ],
        ]);


        if(!$validated)
        {
            return view('auth/login', ['validation' => $this->validator]);
        }
        else
        {
            // Checking user details in database.

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $userInfo = $userModel->where('email', $email)->first();

            $checkPassword = Hash::check($password, $userInfo['password']);

            if(!$checkPassword)
            {
                session()->setFlashdata('fail', 'Incorrect password provided');
                return redirect()->to('auth');
            }
            else
            {
                // Process user info.

                $userId = $userInfo['id'];

                session()->set('loggedInUser', $userId);
                return redirect()->to('/dashboard');

            }
        }
      }

      /**
       * Upload user image.
       */
      public function uploadImage()
      {
        try
        {

            $loggedInUserId = session()->get('loggedInUser');
            $config['upload_path'] = getcwd().'/images';
            $imageName = $this->request->getFile('userImage')->getName();
  
            // if Directory not present then create.
  
            if(!is_dir( $config['upload_path']))
            {
                mkdir( $config['upload_path'], 0777 );
            }
  
            // Get image.
  
            $img = $this->request->getFile('userImage');
              
            if(!$img->hasMoved() && $loggedInUserId)
            {
                
                $img->move($config['upload_path'], $imageName);
  
                $data = [
                    'avatar' => $imageName,
                ];
  
                $userModel = new UserModel();
                $userModel->update($loggedInUserId, $data);
  
                return redirect()->to('dashboard/index')->with('notification',
                  'Image uploaded successfully'
              );
  
            }
            else
            {
              return redirect()->to('dashboard/index')->with('notification',
              'Image uploaded failed');
            }
  
  
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
      }

      /**
       * Log out the user.
       */
      public function logout()
      {
          if(session()->has('loggedInUser'))
          {
              session()->remove('loggedInUser');
          }

          return redirect()->to('/auth?access=loggedout')->with('fail',
          'You are logged out');
      }
}
