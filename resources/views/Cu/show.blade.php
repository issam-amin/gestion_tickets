<x-layout>
    <x-slot name="headings">
        <div class="flex justify-between items-center">
            <div>La Commune Urbaine : <p class="text-blue-500">{{$nomCom->cu_name}}</p></div>
            <x-button href="/names/create">Create</x-button>
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
       <button type="submit" class="btn btn-light">Submit</button>
    </form>
</x-layout>
