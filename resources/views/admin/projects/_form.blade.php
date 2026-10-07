@php $isEdit = $project->exists; @endphp

<div class="panel p-6">
    <div class="grid gap-5 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="title" class="field-label">Project title <span class="text-rose-500">*</span></label>
            <input id="title" name="title" type="text" value="{{ old('title', $project->title) }}"
                   class="field-input" required autofocus>
            @error('title') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="slug" class="field-label">URL slug</label>
            <input id="slug" name="slug" type="text" value="{{ old('slug', $project->slug) }}" class="field-input"
                   placeholder="auto-generated-from-title">
            <p class="field-hint">Leave empty to generate it from the title.</p>
            @error('slug') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="sort_order" class="field-label">Display order</label>
            <input id="sort_order" name="sort_order" type="number" min="0"
                   value="{{ old('sort_order', $project->sort_order ?? 0) }}" class="field-input">
            <p class="field-hint">Lower numbers show first.</p>
            @error('sort_order') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="summary" class="field-label">Short summary</label>
            <input id="summary" name="summary" type="text" value="{{ old('summary', $project->summary) }}"
                   class="field-input" maxlength="255" placeholder="One line shown on the project card">
            @error('summary') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="field-label">Description</label>
            <textarea id="description" name="description" rows="6" class="field-input">{{ old('description', $project->description) }}</textarea>
            @error('description') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="tech_stack" class="field-label">Tech stack</label>
            <input id="tech_stack" name="tech_stack" type="text" value="{{ old('tech_stack', $project->tech_stack) }}"
                   class="field-input" placeholder="Laravel, Vue 3, MySQL, Tailwind CSS">
            <p class="field-hint">Comma separated. Rendered as tags on the public site.</p>
            @error('tech_stack') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="live_url" class="field-label">Live demo URL</label>
            <input id="live_url" name="live_url" type="url" value="{{ old('live_url', $project->live_url) }}"
                   class="field-input" placeholder="https://">
            @error('live_url') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="repo_url" class="field-label">Repository URL</label>
            <input id="repo_url" name="repo_url" type="url" value="{{ old('repo_url', $project->repo_url) }}"
                   class="field-input" placeholder="https://github.com/...">
            @error('repo_url') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="image" class="field-label">Cover image</label>
            @if ($isEdit && $project->image_url)
                <div class="mt-2 flex items-center gap-4">
                    <img src="{{ $project->image_url }}" alt="" class="h-24 w-40 rounded-lg object-cover">
                    <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-600">
                        <input type="checkbox" name="remove_image" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                        Remove current image
                    </label>
                </div>
            @endif
            <input id="image" name="image" type="file" accept="image/*" class="field-input">
            <p class="field-hint">A 16:9 image looks best. Max 4 MB.</p>
            @error('image') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2">
            <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                <input type="checkbox" name="featured" value="1"
                       @checked(old('featured', $project->featured))
                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                Feature this project
            </label>
            <p class="field-hint">Featured projects are listed first on the public site.</p>
        </div>
    </div>
</div>

<div class="mt-6 flex items-center justify-end gap-3">
    <a href="{{ route('admin.projects.index') }}" class="btn-secondary">Cancel</a>
    <button type="submit" class="btn-primary">
        <i class="fas fa-check"></i> {{ $isEdit ? 'Save changes' : 'Create project' }}
    </button>
</div>
