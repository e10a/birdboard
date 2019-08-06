<?php

namespace Tests\Unit;

use App\Project;
use App\Activity;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    function it_has_a_user()
    {
        $user = $this->signIn();
        $project = ProjectFactory::ownedBy($user)->create();
        $this->assertEquals($user->id, $project->activity->first()->user->id);
    }
}
