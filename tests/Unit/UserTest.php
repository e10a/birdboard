<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Facades\Tests\Setup\ProjectFactory;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test **/
    public function a_user_has_projects()
    {
        $user = factory('App\User')->create();
        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test **/
    public function a_user_has_accessible_projects()
    {
        $user1 = $this->signIn();

        $user2 = factory(User::class)->create();
        ProjectFactory::ownedBy($user2)->create()->invite($user1);
        $this->assertCount(1, $user1->accessibleProjects());

        $user3 = factory(User::class)->create();
        $project = tap(ProjectFactory::ownedBy($user2)->create())->invite($user3);

        $this->assertCount(1, $user1->accessibleProjects());

        $project->invite($user1);
        $this->assertCount(2, $user1->accessibleProjects());
    }
}
