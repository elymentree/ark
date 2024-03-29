<?php

namespace Tests\Feature;

use \App\User;
use \App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostToTimelineTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function a_user_can_post_a_test_post()
    {
    	$this->withoutExceptionHandling();
    	$this->actingAs($user = factory(User::class)->create(),'api');

    	$response = $this->post('/api/posts',[
    		'data' => [
    			'type'=>'posts',
			    'attributes' => [
			    	'body' =>'Testing Body',
			    ]
		    ]
	    ]);

    	$post = Post::first();

    	$this->assertCount(1,Post::all());
    	$this->assertEquals($user->id,$post->user_id);
    	$this->assertEquals('Testing Body',$post->body);
    	$response->assertStatus(201)
		    ->assertJson([
		    	'data' => [
		    		'type' => 'post',
				    'post_id' => $post->id,
				    'attributes'=>[
				    	'body' =>'Testing Body'
				    ]
			    ],
			    'links' =>[
			    	'self' => url('/posts/' .$post->id)
			    ]
		    ]);


    }
}
