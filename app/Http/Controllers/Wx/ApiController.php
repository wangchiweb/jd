<?php

namespace App\Http\Controllers\Wx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**测试 */
    public function test(){
        echo 1234;die;
        echo '<pre>';print_r($_GET);echo '<pre>';
        echo '<pre>';print_r($_POST);echo '<pre>';
    }
}
