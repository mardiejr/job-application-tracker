<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_their_applications_list(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();

        JobApplication::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'position' => 'Frontend Developer',
            'status' => 'applied',
        ]);

        $response = $this->actingAs($user)->get('/applications');

        $response->assertStatus(200);
        $response->assertSee('Frontend Developer');
    }

    public function test_guest_cannot_view_applications(): void
    {
        $response = $this->get('/applications');

        $response->assertRedirect('/login');
    }

    public function test_user_can_create_a_job_application(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $response = $this->actingAs($user)->post('/applications', [
            'company_id' => $company->id,
            'position' => 'Backend Engineer',
            'status' => 'applied',
            'applied_date' => now()->format('Y-m-d'),
        ]);

        $response->assertRedirect('/applications');
        $this->assertDatabaseHas('job_applications', [
            'user_id' => $user->id,
            'position' => 'Backend Engineer',
        ]);
    }

    public function test_creating_an_application_requires_a_position(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $response = $this->actingAs($user)->post('/applications', [
            'company_id' => $company->id,
            'status' => 'applied',
        ]);

        $response->assertSessionHasErrors('position');
    }

    public function test_user_can_update_their_application(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $application = JobApplication::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'position' => 'QA Analyst',
            'status' => 'applied',
        ]);

        $response = $this->actingAs($user)->put("/applications/{$application->id}", [
            'company_id' => $company->id,
            'position' => 'QA Analyst',
            'status' => 'interviewing',
        ]);

        $response->assertRedirect('/applications');
        $this->assertDatabaseHas('job_applications', [
            'id' => $application->id,
            'status' => 'interviewing',
        ]);
    }

    public function test_user_can_delete_their_application(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $application = JobApplication::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'position' => 'DevOps Engineer',
            'status' => 'applied',
        ]);

        $response = $this->actingAs($user)->delete("/applications/{$application->id}");

        $response->assertRedirect('/applications');
        $this->assertDatabaseMissing('job_applications', [
            'id' => $application->id,
        ]);
    }
}
