<x-layout>
    <x-slot name="headings">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <div class="text-xl font-bold text-gray-800 mb-4">Tableau de Commune Urbaine : {{$commune_Name}}</div>
            <div class="bg-white shadow-md rounded-lg p-6 flex flex-col sm:flex-row sm:justify-between items-center">
                <div class="font-extrabold text-blue-900 mr-4 mb-4 sm:mb-0">Regisseur de : "{{$name}}"</div>
                <div class="font-extrabold text-red-500 ml-4 mb-4 sm:mb-0">L'année : {{$annee}}</div>
            </div>
            <x-button class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded" href="/Regisseur/{{$IDRegisseur}}/{{$annee}}">Voir Recap</x-button>
        </div>

    </x-slot>

    <form method="POST" action="/{{$typeRegisseur}}/{{$annee}}/{{$IDRegisseur}}">
        @csrf



        <table class="table table-striped table-hover table-sm">
            <thead>
            <tr>
                <th scope="row" colspan="7" class="text-center">{{strtoupper($typeRegisseur)}} REGISSEURS</th>
            </tr>
            <tr class="text-center">
                <th scope="col">Mois</th>
                @foreach($values as $value)
                    <th scope="col">{{ $value }}</th>
                @endforeach
                <th scope="col">MONTANT DES TICKETS REMIS</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                @php
                    $totalsum = [];
                    $valeurs = ['0.5', '1', '2', '5', '50'];
                @endphp
                <th scope="row" class="text-center text-red-400" style="color: red">Reprise Annee {{$annee-1}}</th>

                @foreach($values as $value)
                    <td class="px-6 py-4 border-b border-gray-300 text-center font-bold" style="color: red ;font-size: large">
                        {{  $reste->isNotEmpty() ? $reste[0]->{$value} : 0 }}
                    </td>
                @endforeach

                <td class="px-6 py-4 border-b border-gray-300 text-center" style="color: red; font-size: large">
                    {{ $sommeAP }}
                </td>

            </tr>

            @php $i = 0; @endphp

            @foreach($months as $month)
                <tr>
                    <th scope="row" class="text-center mt-10">{{ $month }}</th>

                    @foreach($values as $value)
                        <td class="px-6 py-4 border-b border-gray-300">
                            <input name="{{ $month . '[' . $value . ']' }}" class="block w-60 px-3 py-3 text-black bg-white border
                                border-gray-200 rounded-full appearance-none placeholder:text-gray-400 focus:border-blue-500
                                focus:outline-none focus:ring-blue-500 sm:text-sm max-w-[220px] text-center"
                                   value="{{ isset($donnes[$i]) && isset($donnes[$i]->$value) ? $donnes[$i]->$value : 0 }}" type="number">
                        </td>
                    @endforeach


                    <td class="px-6 py-4 border-b border-gray-300 text-center">{{ isset($donnes[$i]) ? $donnes[$i]->Somme : 0 }}</td>
                </tr>
                @php $i++; @endphp
            @endforeach

            <tr>
                <th scope="row" class="text-center">TOTAL</th>
                @foreach($values as $value)
                    <td class="px-6 py-4 border-b border-gray-300 text-center">
                        {{ $total_annuel->{$value} ?? '0' }}
                    </td>
                    <input type="hidden" name="total_annuel[{{ $value }}]" value="{{ $total_annuel->{$value}?? '0' }}">
                @endforeach

                <td class="px-6 py-4 border-b border-gray-300 text-center">
                    {{ $valeurtotal ?? 0}}
                </td>
            </tr>
            </tbody>
        </table>
        <div class="flex items-center justify-between">
            <a href="/commune/{{$commune_Name}}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-indigo-600 transition duration-200 ease-in-out">
                Cancel
            </a>
            <div>
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm
                hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 transition duration-200 ease-in-out">
                    Save
                </button>
            </div>
        </div>


    </form>
</x-layout>
