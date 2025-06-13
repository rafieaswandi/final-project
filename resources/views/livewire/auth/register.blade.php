<form wire:submit.prevent="register" class="space-y-4">
    <input type="text" wire:model.defer="name" placeholder="Nama Lengkap" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-violet-500 transition" />
    <input type="email" wire:model.defer="email" placeholder="Email" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-violet-500 transition" />
    <input type="password" wire:model.defer="password" placeholder="Password" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-violet-500 transition" />
    <button type="submit" class="w-full bg-violet-600 hover:bg-violet-700 transition duration-300 ease-in-out text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:shadow-lg">
        Register
    </button>
</form>
