<?php

namespace App\Http\Controllers\Frontend\Information;

use App\Models\Cms\Cms;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InformationController extends Controller
{

    public function aboutus()
    {
        $about_us=Cms::find(1);
        return view('frontend.information.aboutus')->with('about_us', $about_us);
    }

    public function terms(){
        $terms=Cms::find(2);
        return view('frontend.information.terms')->with('terms', $terms);
    }

    public function privacy(){
        $privacy=Cms::find(3);
        return view('frontend.information.privacy')->with('privacy', $privacy);
    }

    public function career(){
        $career=Cms::find(4);
        return view('frontend.information.career')->with('career', $career);
    }

    public function contact(){
        $contact=Cms::find(5);
        return view('frontend.information.contact')->with('contact', $contact);
    }

    public function faq(){
        $faq=Cms::find(6);
        return view('frontend.information.faq')->with('faq', $faq);
    }

}
