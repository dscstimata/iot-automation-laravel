<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class QuestionController extends Controller
{
    public function index(){
        return view("welcome");
    }

    public function question(){
    if(strlen(\Session::get('name')) <= 0)
        return redirect("/");

        return view("question");
    }

    // save session name
    public function store(){
        if(strlen(request("name")) >= 10)
            return redirect("/");

        \Session::put('name', request("name"));
        return redirect("/question");
    }
    
    public function answer(){
        $client = new Client();
        $name = \Session::get('name');

        if(request("answer") == "dsc.stimata"){
            try {
                $res = $client->get('http://192.168.5.4/?q=1&t='.strlen($name).'&n='.$name);
            } catch (\Exception $e) {}
        }else{
            try {
                $res = $client->get('http://192.168.5.4/?q=0&t='.strlen($name).'&n='.$name);
            } catch (\Exception $e) {}
        }

        return redirect("question");
    }
}
