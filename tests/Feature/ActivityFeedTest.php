<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function creating_a_project_generates_activity()
    {
        $project = ProjectFactory::create();
        // get collection of all the activity for the project
        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);
    }

    /** @test **/
    public function updating_a_project_generates_activity()
    {
        $project = ProjectFactory:: create();
        $project->update(['title' => 'Changed']);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    /** @test **/
    public function creating_a_new_task_records_project_activity()
    {
        $project = ProjectFactory::create();
        $project->addTask('Do something');
        $this->assertEquals('created_task', $project->activity->last()->description);
    }

    /** @test **/
    public function completing_a_task_records_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();
        $this->actingAs($project->owner)->patch($project->tasks[0]->path(),[
            'body' => 'foobar',
            'completed' => true
        ]);
        $this->assertEquals('completed_task', $project->activity->last()->description);
    }

}
