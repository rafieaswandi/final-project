<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Photo') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Upload or update your profile photo.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.photo.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="mt-4">
            <div class="flex items-center">
                <div class="mr-4">
                    @if (auth()->user()->photo)
                        <img id="preview" src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile Photo" class="h-24 w-24 rounded-full object-cover">
                    @else
                        <img id="preview" src="{{ asset('storage/profile-photos/default.png') }}" alt="Default Profile Photo" class="h-24 w-24 rounded-full object-cover">
                    @endif
                </div>
                <div>
                    <x-input-label for="photo" :value="__('Choose Photo')" />
                    <input type="file" id="photo" name="photo" class="mt-1 block w-full" accept="image/*" onchange="previewImage()">
                    <p class="mt-1 text-sm text-gray-600">{{ __('JPEG, PNG, GIF up to 2MB') }}</p>
                    <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Photo') }}</x-primary-button>

            @if (session('status') === 'photo-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Photo updated.') }}</p>
            @endif
        </div>
    </form>

    <script>
        function previewImage() {
            const fileInput = document.getElementById('photo');
            const preview = document.getElementById('preview');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>
</section>
