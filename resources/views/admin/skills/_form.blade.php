@php $isEdit = $skill->exists; @endphp

<div class="panel max-w-2xl p-6">
    <div class="grid gap-5 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="name" class="field-label">Skill name <span class="text-rose-500">*</span></label>
            <input id="name" name="name" type="text" value="{{ old('name', $skill->name) }}"
                   class="field-input" required autofocus placeholder="Laravel">
            @error('name') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="category" class="field-label">Category</label>
            <input id="category" name="category" type="text" value="{{ old('category', $skill->category) }}"
                   class="field-input" placeholder="Backend">
            <p class="field-hint">Skills with the same category are grouped together.</p>
            @error('category') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="sort_order" class="field-label">Display order</label>
            <input id="sort_order" name="sort_order" type="number" min="0"
                   value="{{ old('sort_order', $skill->sort_order ?? 0) }}" class="field-input">
            <p class="field-hint">Lower numbers show first.</p>
            @error('sort_order') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2" x-data="{ value: {{ old('proficiency', $skill->proficiency ?? 80) }} }">
            <label for="proficiency" class="field-label">
                Proficiency: <span x-text="value + '%'" class="font-bold text-indigo-600">{{ old('proficiency', $skill->proficiency ?? 80) }}%</span>
            </label>
            <input id="proficiency" name="proficiency" type="range" min="0" max="100" step="5"
                   x-model.number="value"
                   value="{{ old('proficiency', $skill->proficiency ?? 80) }}"
                   class="mt-2 w-full accent-indigo-600">
            <p class="field-hint">Shown as a progress bar on the public site.</p>
            @error('proficiency') <p class="field-error">{{ $message }}</p> @enderror
        </div>
    </div>
</div>

<div class="mt-6 flex items-center justify-end gap-3">
    <a href="{{ route('admin.skills.index') }}" class="btn-secondary">Cancel</a>
    <button type="submit" class="btn-primary">
        <i class="fas fa-check"></i> {{ $isEdit ? 'Save changes' : 'Add skill' }}
    </button>
</div>
