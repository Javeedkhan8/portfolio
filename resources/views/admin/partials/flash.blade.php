@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition
         class="mb-5 flex items-start gap-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
        <i class="fas fa-circle-check mt-0.5"></i>
        <p class="flex-1 font-medium">{{ session('success') }}</p>
        <button @click="show = false" class="text-emerald-600 hover:text-emerald-800">
            <i class="fas fa-xmark"></i>
        </button>
    </div>
@endif

@if ($errors->any())
    <div x-data="{ show: true }" x-show="show" x-transition
         class="mb-5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
        <div class="flex items-start gap-3">
            <i class="fas fa-triangle-exclamation mt-0.5"></i>
            <div class="flex-1">
                <p class="font-semibold">Please fix the following:</p>
                <ul class="mt-1 list-inside list-disc space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button @click="show = false" class="text-rose-600 hover:text-rose-800">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
    </div>
@endif
