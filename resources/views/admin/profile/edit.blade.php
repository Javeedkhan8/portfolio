@extends('layouts.admin')

@section('title', 'Profile & About')
@section('heading', 'Profile & About')
@section('subheading', 'This is what visitors see at the top of your portfolio')

@section('header-actions')
    <a href="{{ route('portfolio.index') }}" target="_blank" rel="noopener" class="btn-secondary">
        <i class="fas fa-external-link-alt"></i> Preview
    </a>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="max-w-4xl space-y-6">
        @csrf
        @method('PUT')

        <div class="panel p-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500">Identity</h2>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="full_name" class="field-label">Full name <span class="text-rose-500">*</span></label>
                    <input id="full_name" name="full_name" type="text" value="{{ old('full_name', $profile->full_name) }}"
                           class="field-input" required autofocus>
                    @error('full_name') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="headline" class="field-label">Headline</label>
                    <input id="headline" name="headline" type="text" value="{{ old('headline', $profile->headline) }}"
                           class="field-input" placeholder="Full-stack developer focused on Laravel">
                    @error('headline') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="bio" class="field-label">About / bio</label>
                    <textarea id="bio" name="bio" rows="6" class="field-input"
                              placeholder="Tell visitors about yourself. Blank lines start a new paragraph.">{{ old('bio', $profile->bio) }}</textarea>
                    <p class="field-hint">Leave a blank line between paragraphs to split them on the live site.</p>
                    @error('bio') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="availability" class="field-label">Availability badge</label>
                    <input id="availability" name="availability" type="text" value="{{ old('availability', $profile->availability) }}"
                           class="field-input" placeholder="Available for new projects">
                    <p class="field-hint">Leave empty to hide the badge. Visible at the top of your portfolio.</p>
                    @error('availability') <p class="field-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="panel p-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500">Contact details</h2>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="email" class="field-label">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $profile->email) }}" class="field-input">
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="field-label">Phone</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone', $profile->phone) }}" class="field-input">
                    @error('phone') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="location" class="field-label">Location</label>
                    <input id="location" name="location" type="text" value="{{ old('location', $profile->location) }}"
                           class="field-input" placeholder="Bengaluru, India">
                    @error('location') <p class="field-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="panel p-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500">Social links</h2>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                @foreach ([
                    'github_url' => 'GitHub',
                    'linkedin_url' => 'LinkedIn',
                    'twitter_url' => 'Twitter / X',
                    'website_url' => 'Personal website',
                ] as $field => $label)
                    <div>
                        <label for="{{ $field }}" class="field-label">{{ $label }}</label>
                        <input id="{{ $field }}" name="{{ $field }}" type="url" value="{{ old($field, $profile->{$field}) }}"
                               class="field-input" placeholder="https://">
                        @error($field) <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                @endforeach
            </div>
        </div>

        <div class="panel p-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500">Photos &amp; files</h2>

            <div class="mt-5 grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="avatar" class="field-label">Profile photo</label>
                    @if ($profile->avatar_url)
                        <div class="mt-2 flex items-center gap-4">
                            <img src="{{ $profile->avatar_url }}" alt="" class="h-20 w-20 rounded-xl object-cover">
                            <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-600">
                                <input type="checkbox" name="remove_avatar" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                Remove current photo
                            </label>
                        </div>
                    @endif
                    <input id="avatar" name="avatar" type="file" accept="image/*" class="field-input">
                    <p class="field-hint">JPG, PNG or WEBP. Max 2 MB. A square image works best.</p>
                    @error('avatar') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="resume" class="field-label">Resume / CV</label>
                    @if ($profile->resume_url)
                        <div class="mt-2 flex items-center gap-4">
                            <a href="{{ $profile->resume_url }}" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <i class="fas fa-file-pdf text-rose-500"></i> View current file
                            </a>
                            <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-600">
                                <input type="checkbox" name="remove_resume" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                Remove
                            </label>
                        </div>
                    @endif
                    <input id="resume" name="resume" type="file" accept=".pdf,.doc,.docx" class="field-input">
                    <p class="field-hint">PDF or Word document. Max 5 MB.</p>
                    @error('resume') <p class="field-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-check"></i> Save profile
            </button>
        </div>
    </form>
@endsection
