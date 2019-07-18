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
}