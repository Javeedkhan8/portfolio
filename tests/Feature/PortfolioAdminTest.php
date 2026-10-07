<?php

namespace Tests\Feature;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PortfolioAdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin(array $attributes = []): User
    {
        return User::factory()->create(['is_admin' => true] + $attributes);
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.projects.index'))->assertRedirect(route('login'));
    }

    public function test_non_admin_users_are_forbidden(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_admin_can_view_dashboard(): void
    {
        Project::create(['title' => 'Invoice tool']);

        $this->actingAs($this->admin())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Invoice tool')
            ->assertSee('Dashboard');
    }

    public function test_admin_can_update_profile_details(): void
    {
        $response = $this->actingAs($this->admin())->put(route('admin.profile.update'), [
            'full_name' => 'Ada Lovelace',
            'headline' => 'Backend developer',
            'bio' => 'First paragraph.',
            'email' => 'ada@example.com',
            'github_url' => 'https://github.com/ada',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect(route('admin.profile.edit'));

        $profile = Profile::current();
        $this->assertSame('Ada Lovelace', $profile->full_name);
        $this->assertSame('https://github.com/ada', $profile->github_url);
    }

    public function test_profile_requires_a_name_and_rejects_bad_urls(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.profile.update'), [
                'full_name' => '',
                'github_url' => 'not-a-url',
            ])
            ->assertSessionHasErrors(['full_name', 'github_url']);
    }

    public function test_profile_avatar_upload_is_stored_and_replaced(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->put(route('admin.profile.update'), [
            'full_name' => 'Ada Lovelace',
            'avatar' => UploadedFile::fake()->create('me.png', 20, 'image/png'),
        ])->assertSessionHasNoErrors();

        $profile = Profile::current();
        $this->assertStringStartsWith('uploads/portfolio/avatar/', $profile->avatar);
        $this->assertFileExists(public_path($profile->avatar));

        $previousPath = $profile->avatar;

        $this->actingAs($admin)->put(route('admin.profile.update'), [
            'full_name' => 'Ada Lovelace',
            'avatar' => UploadedFile::fake()->create('me-2.png', 20, 'image/png'),
        ])->assertSessionHasNoErrors();

        $this->assertFileDoesNotExist(public_path($previousPath));
        $this->deleteDirectory(public_path('uploads/portfolio/avatar'));
    }

    public function test_admin_can_create_a_project_with_a_generated_slug(): void
    {
        $response = $this->actingAs($this->admin())->post(route('admin.projects.store'), [
            'title' => 'Invoice Automation Tool',
            'summary' => 'Reconciles invoices',
            'tech_stack' => 'Laravel, MySQL',
            'featured' => '1',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect(route('admin.projects.index'));

        $project = Project::first();
        $this->assertSame('invoice-automation-tool', $project->slug);
        $this->assertTrue($project->featured);
        $this->assertSame(['Laravel', 'MySQL'], $project->tech_list);
    }

    public function test_project_slug_must_be_unique(): void
    {
        Project::create(['title' => 'Existing project']);

        $this->actingAs($this->admin())
            ->post(route('admin.projects.store'), [
                'title' => 'Another project',
                'slug' => 'existing-project',
            ])
            ->assertSessionHasErrors('slug');
    }

    public function test_admin_can_update_and_delete_a_project(): void
    {
        $project = Project::create(['title' => 'Old title']);

        $this->actingAs($this->admin())
            ->put(route('admin.projects.update', $project), [
                'title' => 'New title',
                'live_url' => 'https://example.com',
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.projects.index'));

        $project->refresh();
        $this->assertSame('New title', $project->title);
        $this->assertSame('https://example.com', $project->live_url);

        $this->actingAs($this->admin())
            ->delete(route('admin.projects.destroy', $project))
            ->assertRedirect(route('admin.projects.index'));

        $this->assertSame(1, $project->refresh()->is_deleted);
        $this->get(route('portfolio.index'))->assertDontSee('New title');
    }

    public function test_admin_can_manage_skills_experiences_and_educations(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.skills.store'), [
            'name' => 'Laravel',
            'category' => 'Backend',
            'proficiency' => 90,
        ])->assertSessionHasNoErrors();

        $this->assertSame('Laravel', Skill::first()->name);

        $this->actingAs($admin)->post(route('admin.experiences.store'), [
            'job_title' => 'Senior Developer',
            'company' => 'Acme',
            'start_date' => '2023-01-01',
            'is_current' => '1',
        ])->assertSessionHasNoErrors();

        $experience = Experience::first();
        $this->assertTrue($experience->is_current);
        $this->assertSame('Jan 2023 — Present', $experience->date_range);

        $this->actingAs($admin)->post(route('admin.educations.store'), [
            'degree' => 'BSc Computer Science',
            'institution' => 'State University',
            'start_year' => '2015',
            'end_year' => '2019',
        ])->assertSessionHasNoErrors();

        $education = Education::first();
        $this->assertSame('2015 — 2019', $education->year_range);

        $this->actingAs($admin)->get(route('admin.skills.index'))->assertOk()->assertSee('Laravel');
        $this->actingAs($admin)->get(route('admin.experiences.index'))->assertOk()->assertSee('Senior Developer');
        $this->actingAs($admin)->get(route('admin.educations.index'))->assertOk()->assertSee('BSc Computer Science');

        $this->actingAs($admin)->delete(route('admin.skills.destroy', Skill::first()));
        $this->actingAs($admin)->delete(route('admin.experiences.destroy', $experience));
        $this->actingAs($admin)->delete(route('admin.educations.destroy', $education));

        $this->assertSame(1, Skill::first()->is_deleted);
        $this->assertSame(1, $experience->refresh()->is_deleted);
        $this->assertSame(1, $education->refresh()->is_deleted);
    }

    public function test_skill_proficiency_must_be_a_percentage(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.skills.store'), ['name' => 'Laravel', 'proficiency' => 250])
            ->assertSessionHasErrors('proficiency');
    }

    public function test_experience_end_date_cannot_precede_start_date(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.experiences.store'), [
                'job_title' => 'Developer',
                'company' => 'Acme',
                'start_date' => '2023-05-01',
                'end_date' => '2022-05-01',
            ])
            ->assertSessionHasErrors('end_date');
    }

    public function test_admin_can_edit_pages_render_forms(): void
    {
        $admin = $this->admin();

        $project = Project::create(['title' => 'Editable project']);
        $skill = Skill::create(['name' => 'Editable skill']);
        $experience = Experience::create(['job_title' => 'Editable role', 'company' => 'Acme']);
        $education = Education::create(['degree' => 'Editable degree', 'institution' => 'Uni']);

        $this->actingAs($admin)->get(route('admin.profile.edit'))->assertOk();
        $this->actingAs($admin)->get(route('admin.projects.create'))->assertOk();
        $this->actingAs($admin)->get(route('admin.skills.create'))->assertOk();
        $this->actingAs($admin)->get(route('admin.experiences.create'))->assertOk();
        $this->actingAs($admin)->get(route('admin.educations.create'))->assertOk();
        $this->actingAs($admin)->get(route('admin.projects.edit', $project))->assertOk()->assertSee('Editable project');
        $this->actingAs($admin)->get(route('admin.skills.edit', $skill))->assertOk()->assertSee('Editable skill');
        $this->actingAs($admin)->get(route('admin.experiences.edit', $experience))->assertOk()->assertSee('Editable role');
        $this->actingAs($admin)->get(route('admin.educations.edit', $education))->assertOk()->assertSee('Editable degree');
    }

    private function deleteDirectory(string $path): void
    {
        if (! is_dir($path)) {
            return;
        }

        foreach (array_diff(scandir($path), ['.', '..']) as $file) {
            @unlink($path.'/'.$file);
        }

        @rmdir($path);
    }
}
