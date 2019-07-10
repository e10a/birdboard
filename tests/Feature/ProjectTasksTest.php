<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;
    /** @test **/
    public function guests_cannot_add_tasks_to_projects()
    {
        // $this->signIn();
        $project = factory(Project::class)->create();
        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test **/
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();
        $project = factory(Project::class)->create();
        // $project->addTask('Test task body');
        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test **/
    public function only_the_owner_of_a_project_may_update_tasks()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();
        $project = factory(Project::class)->create();
        $task = $project->addTask('Test task');
        $this->patch($task->path(), [
            'body' => 'changed',
            'completed' => true
        ])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    /** @test **/
    public function a_project_can_have_tasks()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();
        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);
        $project->addTask('Test task');

        $this->get($project->path())->assertSee('Test task');
    }

    /** @test **/
    public function a_task_can_be_updated()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();
        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);
        $task = $project->addTask('Test task');

        $this->patch($task->path(), [
            'body' => 'Changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Changed',
            'completed' => true
        ]);
    }

    /** @test **/
    public function a_task_requires_a_body()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
