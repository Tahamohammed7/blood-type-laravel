<?php

namespace App\Http\Controllers\Front;

use App\Client;
use App\DonationRequest;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home(Request $request)
    {
        $client = Client::first();
        $posts = Post::take(9)->get();
        return view('front.home',compact('posts'));
    }
    public function postDetails($id)
    {
        $post = Post::find($id)->first();
        return view('front.postDetails',compact('post'));
    }
    public function donationRequests()
    {
        $donations = DonationRequest::with('governorate','bloodType')->take(9)->get();
        return view('front.donationRequests',compact('donations'));
    }
    public function toggleFavourite(Request $request)
    {
        $toggle = $request->user()->favourites()->toggle($request->post_id);
        return responseJson(1,'success',$toggle);
    }
}
