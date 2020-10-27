<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class TestController extends Controller{
    //使用 file_get_contents 请求天气查询接口
    public function weather(){
        $url='https://devapi.qweather.com/v7/weather/now?location=101010100&key=90b245c4fc6f4f0499cb1b7e69f7f31e&gzip=n';
        $json_str=file_get_contents($url);
        //echo $json_str;die;
        $data=json_decode($json_str,true);
        //print_r($data);die;
        dd($data);
    }
    //使用 curl 请求天气查询接口
    public function curl(){
        //初始化资源
        $data='theCityName=北京';
        $curlobj=curl_init();
        curl_setopt($curlobj,CURLOPT_URL,'http://www.webxml.com.cn/WebServices/WeatherWebService.asmx/getWeatherbyCityName');
        curl_setopt($curlobj,CURLOPT_HEADER,0);
        curl_setopt($curlobj,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curlobj,CURLOPT_POST,1);
        curl_setopt($curlobj,CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);//刚开始没加这句，结果就报错(未将对象引用设置到对象的实例) ,然后加上这句,就好了，参数：CURLOPT_USERAGENT : 在HTTP请求中包含一个”user-agent”头的字符串。
        curl_setopt($curlobj,CURLOPT_POSTFIELDS,$data);
        curl_setopt($curlobj,CURLOPT_HTTPHEADER,array("application/x-www-form-urlencoded;charset=utf-8","Content-length: ".strlen($data)));
        $rtn=curl_exec($curlobj);
        if(!curl_errno($curlobj)){
            dd($rtn);
            echo '<pre>'.$rtn.'<pre>';    
        }else{    
            echo 'Curl error:'.curl_error($curlobj);
        }
        echo curl_close($curlobj);   
    }   
    //使用GuzzleHttp 请求天气查询接口
    public function guzzle(){
        $url='https://devapi.qweather.com/v7/weather/now?location=101010100&key=90b245c4fc6f4f0499cb1b7e69f7f31e&gzip=n';
        $client=new Client();
        $res=$client->request('GET',$url,['verify'=>false]);
        $body=$res->getBody();   //获取接口相应的数据
        echo $body;
        $data=json_decode($body,true);
        dd($data);
    }
}
