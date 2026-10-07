<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'projects' => Project::query()->active()->count(),
                'skills' => Skill::query()->active()->count(),
                'experiences' => Experience::query()->active()->count(),
                'educations' => Education::query()->active()->count(),
            ],
            'profile' => Profile::current(),
            'latestProjects' => Project::query()->active()->ordered()->limit(5)->get(),
        ]);
    }
}
