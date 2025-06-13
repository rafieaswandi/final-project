<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EventEase | Login & Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script defer>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('[data-tab]');
            const panels = document.querySelectorAll('[data-panel]');

            function showPanel(target) {
                panels.forEach(panel => {
                    panel.classList.add('hidden', 'opacity-0', 'scale-95');
                    if (panel.dataset.panel === target) {
                        setTimeout(() => {
                            panel.classList.remove('hidden');
                            panel.classList.add('opacity-100', 'scale-100');
                        }, 100);
                    }
                });

                tabs.forEach(t => t.classList.remove('border-violet-600', 'text-violet-600'));
                document.querySelector(`[data-tab="${target}"]`).classList.add('border-violet-600', 'text-violet-600');
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', () => showPanel(tab.dataset.tab));
            });

            // Default to login
            showPanel('login');
        });
    </script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-purple-900 to-violet-600 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white/80 backdrop-blur-md shadow-xl rounded-2xl overflow-hidden border border-white/30">
        <div class="p-6 space-y-4">
            <div class="flex justify-center gap-6 border-b pb-2">
                <button data-tab="login" class="text-gray-600 font-semibold border-b-2 border-transparent hover:text-violet-600 transition-all duration-300 ease-in-out">
                    Login
                </button>
                <button data-tab="register" class="text-gray-600 font-semibold border-b-2 border-transparent hover:text-violet-600 transition-all duration-300 ease-in-out">
                    Register
                </button>
            </div>

            <div class="relative">
                <!-- Login Panel -->
                <div data-panel="login" class="transition-all duration-300 ease-in-out opacity-100 scale-100">
                    @livewire('auth.login')
                    <div class="mt-4 text-center text-sm text-gray-600">
                        Belum punya akun?
                        <button data-tab="register" class="text-violet-600 font-medium hover:underline transition-all duration-200">
                            Daftar terlebih dahulu
                        </button>
                    </div>
                </div>

                <!-- Register Panel -->
                <div data-panel="register" class="hidden transition-all duration-300 ease-in-out opacity-0 scale-95">
                    @livewire('auth.register')
                    <div class="mt-4 text-center text-sm text-gray-600">
                        Sudah punya akun?
                        <button data-tab="login" class="text-violet-600 font-medium hover:underline transition-all duration-200">
                            Masuk sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-violet-600 to-purple-700 py-4 text-center text-white text-sm hover:opacity-90 transition-all duration-300 ease-in-out">
            &copy; {{ date('Y') }} EventEase. All rights reserved.
        </div>
    </div>
    @livewireScripts
</body>
</html>
