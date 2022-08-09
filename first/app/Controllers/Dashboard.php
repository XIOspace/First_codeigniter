<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        //
        $userModel = new UserModel();
        $loggedInUserId = session()->get('loggedInUser');
        $userInfo = $userModel->find($loggedInUserId);

        $data = [
            'userInfo' => $userInfo,
            'title' => 'Dashboard',
        ];
        // echo json_encode($data['userInfo'][0]['username']);

        return view('dashboard/index', $data);
    }
}
