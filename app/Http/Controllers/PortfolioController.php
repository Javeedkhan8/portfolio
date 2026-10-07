<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;

class PortfolioController extends Controller
{
    public function index()
    {
        $profile = Profile::current();

        return view('portfolio.index', [
            'profile' => $profile,
            'skills' => Skill::query()->active()->ordered()->get()->groupBy(fn (Skill $skill) => $skill->category ?: 'Other'),
            'projects' => Project::query()->active()->ordered()->get(),
            'experiences' => Experience::query()->active()->ordered()->get(),
            'educations' => Education::query()->active()->ordered()->get(),
        ]);
    }
}
