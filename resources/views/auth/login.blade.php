<x-layout>
    <x-slot:headings>
        <div class="text-center text-2xl font-bold text-gray-800 mb-8">
            Login Page
        </div>
    </x-slot:headings>

    <div class="min-h-screen flex items-center justify-center">
        <form method="POST" action="/login" class="max-w-lg w-full bg-gray-700/10 p-8 rounded-lg shadow-md">
            @csrf
            <div class="space-y-6 ">
                <x-form-field>
                    <x-form-label for="email">Email</x-form-label>
                    <div class="m-10">
                        <x-form-input name="email" id="email" type="email" autocomplete="email" :value="old('email')" required class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"/>
                        <x-form-error name="email"/>
                    </div>
                </x-form-field>

                <x-form-field>
                    <x-form-label for="password">Password</x-form-label>
                    <div class="m-10">
                        <x-form-input name="password" id="password" type="password" required class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"/>
                        <x-form-error name="password"/>
                    </div>
                </x-form-field>

                <div class="flex items-center justify-between mt-4">
                    <a href="/" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Cancel</a>
                    <x-form-button class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow hover:bg-indigo-700">Log In</x-form-button>
                </div>
            </div>
        </form>
    </div>
</x-layout>
