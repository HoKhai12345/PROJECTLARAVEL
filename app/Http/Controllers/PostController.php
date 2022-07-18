<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Events\PostCreated;
use App\Events\PostCreated2;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function store(Request $request){
//        $post_data = $request->validate(
//            ['title'=>'required',
//             'content'=>'required'
//            ]
//        );
     //   dd($request);die();
        $post_data['title'] = $request->title;
        $post_data['content'] = $request->contents;
//        $post_data['user_id'] = auth()->user()->id;
        $post_data['user_id'] = 41;
        Post::create($post_data);
        $data = ["title"=>$post_data['title'] , '_author'=>"69 takeshi"];
        event(New PostCreated2($data));
        return redirect()->back()->withSuccess("POST CREATED");

    }

    public function formAdd(){
        return view('formPost');
    }
}
