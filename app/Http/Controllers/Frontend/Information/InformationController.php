<?php

namespace App\Http\Controllers\Frontend\Information;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InformationController extends Controller
{

    public function aboutus()
    {
        return view('frontend.information.aboutus');
    }

    public function terms(){
        return view('frontend.information.terms');
    }

    public function privacy(){
        return view('frontend.information.privacy');
    }

    public function career(){
        return view('frontend.information.career');
    }

    public function contact(){
        return view('frontend.information.contact');
    }

    public function faq(){
        return view('frontend.information.faq');
    }

}
