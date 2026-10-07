@php $isEdit = $education->exists; @endphp

<div class="panel max-w-3xl p-6">
    <div class="grid gap-5 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="degree" class="field-label">Degree / qualification <span class="text-rose-500">*</span></label>
            <input id="degree" name="degree" type="text" value="{{ old('degree', $education->degree) }}"
                   class="field-input" required autofocus placeholder="B.Tech in Computer Science">
            @error('degree') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="institution" class="field-label">Institution <span class="text-rose-500">*</span></label>
            <input id="institution" name="institution" type="text" value="{{ old('institution', $education->institution) }}"
                   class="field-input" required>
            @error('institution') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="institution_url" class="field-label">Institution website</label>
            <input id="institution_url" name="institution_url" type="url"
                   value="{{ old('institution_url', $education->institution_url) }}" class="field-input" placeholder="https://">
            @error('institution_url') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="location" class="field-label">Location</label>
            <input id="location" name="location" type="text" value="{{ old('location', $education->location) }}" class="field-input">
            @error('location') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label for="start_year" class="field-label">Start year</label>
                <input id="start_year" name="start_year" type="text" maxlength="4" inputmode="numeric"
                       value="{{ old('start_year', $education->start_year) }}" class="field-input" placeholder="2019">
                @error('start_year') <p class="field-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="end_year" class="field-label">End year</label>
                <input id="end_year" name="end_year" type="text" maxlength="4" inputmode="numeric"
                       value="{{ old('end_year', $education->end_year) }}" class="field-input" placeholder="2023">
                @error('end_year') <p class="field-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="sm:col-span-2">
            <label for="sort_order" class="field-label">Display order</label>
            <input id="sort_order" name="sort_order" type="number" min="0"
                   value="{{ old('sort_order', $education->sort_order ?? 0) }}" class="field-input">
            @error('sort_order') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="field-label">Details</label>
            <textarea id="description" name="description" rows="4" class="field-input">{{ old('description', $education->description) }}</textarea>
            @error('description') <p class="field-error">{{ $message }}</p> @enderror
        </div>
    </div>
</div>

<div class="mt-6 flex items-center justify-end gap-3">
    <a href="{{ route('admin.educations.index') }}" class="btn-secondary">Cancel</a>
    <button type="submit" class="btn-primary">
        <i class="fas fa-check"></i> {{ $isEdit ? 'Save changes' : 'Add education' }}
    </button>
</div>
