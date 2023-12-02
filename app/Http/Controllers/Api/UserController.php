<?php

namespace App\Http\Controllers\Api;

use App\Models\User;


class UserController extends BaseController
{
    
    

    public function getUsers()
    {
        
        $user = User::all();
        return $this->sendResponse([$user], 'Users retrieved successfully');

        
    }

    


}