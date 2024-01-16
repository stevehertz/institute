<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    //
    public function config() 
    {
        if(Artisan::call('db:drop')){
            return 'success';
        }
        return 'failed';
    }

    public function storage()  
    {
        
    }

    public function migrations()  
    {
        
    }
}
