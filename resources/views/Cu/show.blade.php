<x-layout>
    <x-slot name="headings">
        <div class="flex items-center justify-between" style="margin-top:20px">
            <div class="text-blue-500">La Commune Urbaine : {{$nomCom->cu_name}}</div>
            <div style="margin-left:20px">
                <x-button href="/names/create">Create</x-button>
            </div>
        </div>
    </x-slot>
    <form method="POST" action="/Regisseur" class="max-w-sm mx-auto mt-6 space-y-4">
        @csrf
        <div class="flex justify-content-around">
        <div >
            <label for="regisseurs" class="block mb-2 text-3xl text-gray-900 dark:text-white font-bold">Select an option</label>
            <select id="regisseurs" name="regisseurs"  class="form-select form-select-lg mb-3" aria-label="Large select example">
                @if (!empty($regisseurs))
                    @foreach($regisseurs as $regisseur)
                        <option value="{{$regisseur->id}}">{{$regisseur->name}}</option>
                    @endforeach
                @else
                    <option>No regisseurs found for this CU.</option>
                @endif
            </select>
        </div>

        <div>
            <label for="typeRegi" class="block mb-2 text-3xl text-gray-900 dark:text-white font-bold">Select an option</label>
            <select id="typeRegi" name="typeRegi"  class="form-select form-select-lg mb-3" aria-label="Large select example">
                @if (!empty($typeRegisseur))
                    @foreach($typeRegisseur as $type)
                        <option value="{{$type}}">{{$type}}</option>
                    @endforeach
                @else
                    <option>No type found for this CU.</option>
                @endif
            </select>
        </div>

        <div>
            <label for="anneetab" class="block mb-2 text-3xl text-gray-900 dark:text-white font-bold">Select an option</label>
            <select id="anneetab" name="anneetab"  class="form-select form-select-lg mb-3" aria-label="Large select example">
                @if (!empty($annees))
                    @foreach($annees as $annee)
                        <option value="{{$annee}}">{{$annee}}</option>
                    @endforeach
                @else
                    <option>No Year found for this CU.</option>
                @endif
            </select>
        </div>
        </div>
       <x-form-button type="submit" class="btn btn-light">Submit</x-form-button>

    </form>

    <form method="POST" action="/show/{{$cu_name}}">
        @csrf
        <div class="flex items-center justify-content-around flex-column" style="margin-top:50px">
            <p class="text-3xl dark:text-white font-bold text-blue-500">La Recaps De La Liste Des Regisseurs :</p>
            <div class="w-25">
                <label for="anneetab1" class="block mb-2 text-3xl text-gray-500 dark:text-white">Année</label>
                <select id="anneetab1" name="anneetab1" class="form-select form-select-lg mb-3" aria-label="Large select example">
                    @if (!empty($annees))
                        @foreach($annees as $annee)
                            <option value="{{$annee}}" {{ session('selected_year') == $annee ? 'selected' : '' }}>{{$annee}}</option>
                        @endforeach
                    @else
                        <option>No Year found for this CU.</option>
                    @endif
                </select>
            </div>
            <x-form-button type="submit" class="btn btn-light">Visualiser</x-form-button>
        </div>
    </form>

</x-layout>
