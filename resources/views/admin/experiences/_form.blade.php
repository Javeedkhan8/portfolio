@php
    $isEdit = $experience->exists;
    $startValue = old('start_date', $experience->start_date?->format('Y-m-d'));
    $endValue = old('end_date', $experience->end_date?->format('Y-m-d'));
@endphp

<div class="panel max-w-3xl p-6">
    <div class="grid gap-5 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="job_title" class="field-label">Job title <span class="text-rose-500">*</span></label>
            <input id="job_title" name="job_title" type="text" value="{{ old('job_title', $experience->job_title) }}"
                   class="field-input" required autofocus placeholder="Backend Developer">
            @error('job_title') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="company" class="field-label">Company <span class="text-rose-500">*</span></label>
            <input id="company" name="company" type="text" value="{{ old('company', $experience->company) }}"
                   class="field-input" required>
            @error('company') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="company_url" class="field-label">Company website</label>
            <input id="company_url" name="company_url" type="url" value="{{ old('company_url', $experience->company_url) }}"
                   class="field-input" placeholder="https://">
            @error('company_url') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="location" class="field-label">Location</label>
            <input id="location" name="location" type="text" value="{{ old('location', $experience->location) }}"
                   class="field-input" placeholder="Remote">
            @error('location') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="sort_order" class="field-label">Display order</label>
            <input id="sort_order" name="sort_order" type="number" min="0"
                   value="{{ old('sort_order', $experience->sort_order ?? 0) }}" class="field-input">
            @error('sort_order') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="start_date" class="field-label">Start date</label>
            <input id="start_date" name="start_date" type="date" value="{{ $startValue }}" class="field-input">
            @error('start_date') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div x-data="{ isCurrent: {{ old('is_current', $experience->is_current) ? 'true' : 'false' }} }">
            <div>
                <label for="end_date" class="field-label">End date</label>
                <input id="end_date" name="end_date" type="date" value="{{ $endValue }}" class="field-input"
                       x-bind:disabled="isCurrent">
                <p class="field-hint">Ignored while this is your current role.</p>
                @error('end_date') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <label class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                <input type="checkbox" name="is_current" value="1" x-model="isCurrent"
                       @checked(old('is_current', $experience->is_current))
                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                I currently work here
            </label>
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="field-label">What you did</label>
            <textarea id="description" name="description" rows="5" class="field-input">{{ old('description', $experience->description) }}</textarea>
            @error('description') <p class="field-error">{{ $message }}</p> @enderror
        </div>
    </div>
</div>

<div class="mt-6 flex items-center justify-end gap-3">
    <a href="{{ route('admin.experiences.index') }}" class="btn-secondary">Cancel</a>
    <button type="submit" class="btn-primary">
        <i class="fas fa-check"></i> {{ $isEdit ? 'Save changes' : 'Add experience' }}
    </button>
</div>
