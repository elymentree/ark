<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
   public function store()
   {
   	    $data = request()->validate([
   	    	'data.attributes.body' =>'', // SHORTCUT FOR NESTED JSON STRUCTURE
        ]);

   	   // dd($data);
   	    // user() [MODEL] -> posts() [METHOD]
   	    // $post  = request()->user()->posts()->create($data);
   	    $post  = request()->user()->posts()->create($data['data']['attributes']);  // TO POINT TO ATTRIBUTES

		return response([
			'data' => [
				'type' => 'post',
				'post_id' => $post->id,
				'attributes'=>[
					'body' =>$post->body,
				]
			],
			'links' =>[
				'self' => url('/posts/' .$post->id)
			]

		],201);
   }

}
