<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use App\Task;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function creating_a_project()
    {
        $project = ProjectFactory::create();
        // get collection of all the activity for the project
        $this->assertCount(1, $project->activity);

        tap($project->activity->last(), function($activity) {
            $this->assertEquals('created_project', $activity->description);
            $this->assertNull($activity->changes);
        });
    }

    /** @test **/
    public function updating_a_project()
    {
        $project = ProjectFactory::create();
        $originalTitle = $project->title;

        $project->update(['title' => 'Changed']);

        tap($project->activity->last(), function($activity) use ($originalTitle){
            $this->assertEquals('updated_project', $activity->description);
            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'Changed']
            ];
            $this->assertEquals($expected, $activity->changes);
        });
    }

    /** @test **/
    public function creating_a_task()
    {
        $project = ProjectFactory::create();
        $project->addTask('Do something');

        tap($project->activity->last(), function($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertEquals('Do something', $activity->subject->body);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

    }

    /** @test **/
    public function completing_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();
        $this->actingAs($project->owner)->patch($project->tasks[0]->path(),[
            'body' => 'foobar',
            'completed' => true
        ]);
        $this->assertEquals('completed_task', $project->activity->last()->description);

        tap($project->activity->last(), function($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

    }

    /** @test **/
    public function incompleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();
        $this->assertCount(2,  $project->activity);

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(),[
            'body' => 'foobar',
            'completed' => true
        ]);
        $project->refresh();
        $this->assertCount(3,  $project->activity);
        $this->assertEquals('completed_task', $project->activity->last()->description);


        $this->actingAs($project->owner)->patch($project->tasks[0]->path(),[
            'body' => 'foobar',
            'completed' => false
        ]);
        $project->refresh();
        $this->assertCount(4,  $project->activity);
        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }

    /** @test **/
    public function deleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();
        $project->tasks[0]->delete();
        $this->assertCount(3, $project->activity);
    }
}
