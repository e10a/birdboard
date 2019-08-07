<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    function non_owners_may_not_invite_users()
    {
        $project = ProjectFactory::create();
        $user = factory(User::class)->create();

        $assertInvitationForbidden = function() use ($user, $project) {
            $this->actingAs($user)
                ->post($project->path() . '/invitations')
                ->assertStatus(403);
        };

        $assertInvitationForbidden();

        $project->invite($user);

        $assertInvitationForbidden();
    }
    /** @test **/
    public function a_project_owner_can_invite_a_user()
    {
        // $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
        $userToInvite = factory(User::class)->create();
        $this->actingAs($project->owner)->post(
            $project->path() . '/invitations', [
                'email' => $userToInvite->email
            ]
        )
        ->assertRedirect($project->path());
        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test **/
    function invite_email_must_belong_to_an_existing_user()
    {
        $project = ProjectFactory::create();
        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => 'notauser@example.com'
            ])
            ->assertSessionHasErrors([
                'email' => 'The user you are inviting must have an account'
            ], null, 'invitations');
    }

    /** @test **/
    public function invited_users_may_update_project_details()
    {
        $project = ProjectFactory::create();
        $project->invite($newUser = factory(User::class)->create());
        $this->signIn($newUser);
        $attributes = ['body' => 'Foo task'];
        $this->post(action('ProjectTasksController@store', $project), $attributes);
        $this->assertDatabaseHas('tasks', $attributes);
    }
}
