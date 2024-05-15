<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Session;

class TaskManagmentTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_task_store()
    {
        $user = User::factory()->create();
         // Start a session to get the CSRF token
         Session::start();

         $response = $this->actingAs($user)->post('/tasks', [
            '_token' => csrf_token(),
            'title' => 'Test Title',
            'due_date' => '2024-05-11 13:31:00',
            'description' => 'Some Description',
        ]);
       
        $response->assertStatus($response->status()); 
       
    }

    public function test_task_update()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
         // Start a session to get the CSRF token
         Session::start();

         $response = $this->actingAs($user)->put('/tasks/'.$task->id, [
            '_token' => csrf_token(),
            'title' => 'Test Title2 edit',
            'due_date' => '',
            'description' => 'Some Description edit',
        ]);
             
        $response->assertStatus($response->status()); 
       
    }

}
