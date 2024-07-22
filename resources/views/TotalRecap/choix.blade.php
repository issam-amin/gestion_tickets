<x-layout>
    <x-slot:headings>
        Choix :
    </x-slot:headings>
    <form action="/choix" method="POST">
        @csrf
    <div>
        <label for="typeRegisseur" class="block mb-2 text-3xl text-gray-900 dark:text-white font-bold">Selectionner la commune:</label>
        <select id="typeRegisseur" name="typeRegisseur"  class="form-select form-select-lg mb-3" aria-label="Large select example">
            @if (!empty($communes))
                @foreach($communes as $commune)
                    <option value="{{$commune}}">{{$commune}}</option>
                @endforeach
            @else
                <option>No commune .</option>
            @endif
        </select>

        <label for="typeRegisseur" class="block mb-2 text-3xl text-gray-900 dark:text-white font-bold">Selectionner Table d' :</label>
        <select id="typeRegisseur" name="typeRegisseur"  class="form-select form-select-lg mb-3" aria-label="Large select example">
            @if (!empty($typeRegisseur))
                @foreach($typeRegisseur as $type)
                    <option value="{{$type}}">{{$type}}</option>
                @endforeach
            @else
                <option>No type found for this CU.</option>
            @endif
        </select>
        <label for="annee" class="block mb-2 text-3xl text-gray-900 dark:text-white font-bold">Selectionner Année</label>
        <select id="annee" name="annee"  class="form-select form-select-lg mb-3" aria-label="Large select example">
            @if (!empty($annees))
                @foreach($annees as $annee)
                    <option value="{{$annee}}">{{$annee}}</option>
                @endforeach
            @else
                <option>No year found for this CU.</option>
            @endif
        </select>
        <div>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2
                text-sm font-semibold text-white shadow-sm
                hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2
                 focus:ring-indigo-600 transition duration-200 ease-in-out">
                Save
            </button>
        </div>
    </div>

    </form>
</x-layout>
