<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Models\Profile;

class ProfileController extends Controller
{
    use HandlesUploads;

    public function edit()
    {
        $profile = Profile::current() ?? new Profile;

        return view('admin.profile.edit', [
            'profile' => $profile,
        ]);
    }

    public function update(ProfileRequest $request)
    {
        $profile = Profile::current() ?? new Profile;
        $data = $request->safe()->except(['avatar', 'resume', 'remove_avatar', 'remove_resume']);

        if ($request->boolean('remove_avatar')) {
            $this->deleteUpload($profile->avatar);
            $data['avatar'] = null;
        }

        if ($request->boolean('remove_resume')) {
            $this->deleteUpload($profile->resume);
            $data['resume'] = null;
        }

        if ($request->hasFile('avatar')) {
            $this->deleteUpload($profile->avatar);
            $data['avatar'] = $this->storeUpload($request->file('avatar'), 'avatar');
        }

        if ($request->hasFile('resume')) {
            $this->deleteUpload($profile->resume);
            $data['resume'] = $this->storeUpload($request->file('resume'), 'resume');
        }

        $profile->fill($data)->save();

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Profile details saved successfully.');
    }
}
