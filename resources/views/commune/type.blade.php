<x-layout>
    <x-slot name="headings">

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex justify-between">
            <div class="font-extrabold text-blue-900 mr-4 flex-1">Récape de: "{{$name}}"</div>
            <div class="font-extrabold text-red-500 ml-4 flex-0.5 text-right">Année : {{$selectedYear}}</div>
        </div>
    </x-slot>
    <form method="POST" action="/type/{{$name}}/{{$selectedYear}}" class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        @csrf
        <!-- Hidden input to store the type value -->
        <input type="hidden" name="type" id="typeInput">

        <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
            <div class="w-full sm:w-auto">
                <x-form-button type="submit" id="approvisionnement" onclick="setType('approvisionnement')" class="w-75 sm:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    APPROVISIONNEMENT
                </x-form-button>
            </div>
            <div class="w-full sm:w-auto">
                <x-form-button type="submit" id="versement" onclick="setType('versement')" class="w-75 sm:w-auto bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    VERSEMENT
                </x-form-button>
            </div>
            <div class="w-full sm:w-auto">
                <x-form-button type="submit" id="reste" onclick="setType('reste')" class="w-75 sm:w-auto bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    RESTE
                </x-form-button>
            </div>
        </div>
    </form>

    <script>
        function setType(type) {
            document.getElementById('typeInput').value = type;
        }
    </script>


</x-layout>
