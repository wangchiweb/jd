<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Movie;

class MovieController extends Controller{
    /**电影票列表 */
    public function index(){

        $res=1;
        $res=$res+1;
        echo $res;die;
        return view('admin/movie/index',['res'=>$res]);
    }
}
