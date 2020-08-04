<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class TestController extends Controller
{
    public function index()
    {



        echo '<pre>';
        print_r('sdj');
        echo '</pre>';
        die;
    }
}
