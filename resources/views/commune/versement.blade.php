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

    <form method="POST" action="/{{$typeRegisseur}}/{{$annee}}/{{$IDRegisseur}}/{{$commune_Name}}">
        @csrf

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                <tr>
                    <th colspan="{{ count($values) + 2 }}" class="text-center text-red-500 bg-gray-100">{{ strtoupper($typeRegisseur) }} REGISSEURS</th>
                </tr>
                <tr class="text-center bg-gray-50">
                    <th scope="col">Mois</th>
                    @foreach($values as $value)
                        <th scope="col">{{ $value }}</th>
                    @endforeach
                    <th scope="col">Somme</th>
                </tr>
                </thead>
                <tbody>
                @php $i = 0; @endphp
                @foreach($months as $month)
                    <tr>
                        <th scope="row" class="text-center">{{ $month }}</th>
                        @foreach($values as $value)
                            <td class="px-6 py-4 border-b border-gray-300">
                                <input name="{{ $month . '[' . $value . ']' }}" class="block w-full px-3 py-2 text-black bg-white border border-gray-200 rounded-md placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm text-center"
                                       value="{{ isset($donnes[$i]) && isset($donnes[$i]->$value) ? $donnes[$i]->$value : 0 }}" type="number">
                            </td>
                        @endforeach
                        <td class="px-6 py-4 border-b border-gray-300 text-center">{{ isset($donnes[$i]) ? number_format($donnes[$i]->Somme ?? 0, 2, ',', ' ') : 0 }}</td>
                    </tr>
                    @php $i++; @endphp
                @endforeach

                <tr>
                    <th scope="row" class="text-center bg-gray-100">TOTAL</th>
                    @foreach($values as $value)
                        <td class="px-6 py-4 border-b border-gray-300 text-center">
                            {{ number_format($total_annuel->{$value} ?? 0, 2, ',', ' ') }}
                        </td>
                        <input type="hidden" name="total_annuel[{{ $value }}]" value="{{ $total_annuel->{$value} ?? '0' }}">
                    @endforeach
                    <td class="px-6 py-4 border-b border-gray-300 text-center text-red-600 font-bold">
                        {{ $valeurtotal}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="/commune/{{$commune_Name}}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-indigo-600 transition duration-200 ease-in-out">
                Cancel
            </a>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 transition duration-200 ease-in-out">
                Save
            </button>
        </div>
    </form>
</x-layout>
