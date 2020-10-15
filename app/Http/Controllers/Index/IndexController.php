<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**前台首页 */
    public function list(){
        return view('index/index/list');
    }
}
