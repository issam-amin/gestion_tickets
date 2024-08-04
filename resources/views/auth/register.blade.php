<x-layout>
    <x-slot:headings>
        Register
    </x-slot:headings>


    <form method="POST" action="/register">
        @csrf
        <div class="space-y-12 ">
            <div class="border-b border-gray-900/10 pb-12 ">
                <div class=" grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 ">

                    <x-form-field>
                        <x-form-label for="last_name">Name</x-form-label>
                        <div class="mt-2">
                            <x-form-input name="name" id="name" type="text" autocomplete="name"  required/>
                            <x-form-error name="name"/>
                        </div>
                    </x-form-field>


                    <x-form-field>
                        <x-form-label for="email">Email</x-form-label>
                        <div class="mt-2">
                            <x-form-input name="email" id="email" type="email" autocomplete="email"  required/>
                            <x-form-error name="email"/>
                        </div>
                    </x-form-field>

                    <x-form-field>
                        <x-form-label for="password">Password</x-form-label>
                        <div class="mt-2">
                            <x-form-input name="password" id="password" type="password" required/>
                            <x-form-error name="password"/>
                        </div>
                    </x-form-field>
                    <x-form-field>
                        <x-form-label for="password_confirmation">Password Confirmation</x-form-label>
                        <div class="mt-2">
                            <x-form-input name="password_confirmation" id="password_confirmation" type="password" required/>

                            <x-form-error name="password_confirmation"/>
                        </div>
                    </x-form-field>

                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <div class="text-sm font-semibold leading-6 text-gray-900 ml-10">
                    <a href="/"  >Cancel</a>

                </div>
                <div class="text-sm font-semibold leading-6 text-gray-900 ml-10">
                            <x-form-button>Register</x-form-button>
               </div>
            </div>
        </div>
    </form>


</x-layout>
