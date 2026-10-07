<?php

namespace Tests\Feature;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioPublicTest extends TestCase
{
    use RefreshDatabase;

    public function test_portfolio_is_reachable_without_logging_in(): void
    {
        $response = $this->get(route('portfolio.index'));

        $response->assertOk();
    }

    public function test_portfolio_renders_content_that_is_marked_as_hidden(): void
    {
        Profile::create(['full_name' => 'Ada Lovelace', 'headline' => 'Backend developer']);

        Project::create(['title' => 'Visible project']);
        Project::create(['title' => 'Hidden project', 'is_deleted' => 1]);
        Skill::create(['name' => 'Laravel', 'proficiency' => 90]);
        Skill::create(['name' => 'Hidden skill', 'proficiency' => 50, 'is_deleted' => 1]);
        Experience::create(['job_title' => 'Developer', 'company' => 'Acme', 'is_deleted' => 1]);
        Education::create(['degree' => 'BSc', 'institution' => 'State University']);
        Education::create(['degree' => 'Hidden degree', 'institution' => 'Nowhere', 'is_deleted' => 1]);

        $response = $this->get(route('portfolio.index'));

        $response->assertOk()
            ->assertSee('Ada Lovelace')
            ->assertSee('Visible project')
            ->assertSee('Laravel')
            ->assertSee('BSc')
            ->assertSee('State University')
            ->assertDontSee('Hidden project')
            ->assertDontSee('Hidden skill')
            ->assertDontSee('Hidden degree');
    }

    public function test_portfolio_works_when_no_profile_has_been_created_yet(): void
    {
        $response = $this->get(route('portfolio.index'));

        $response->assertOk();
        $this->assertNull(Profile::current());
    }

    public function test_featured_projects_are_listed_before_others(): void
    {
        Project::create(['title' => 'Ordinary project', 'sort_order' => 1]);
        Project::create(['title' => 'Featured project', 'featured' => true, 'sort_order' => 2]);

        $projects = Project::query()->active()->ordered()->get();

        $this->assertSame('Featured project', $projects->first()->title);
    }
}
