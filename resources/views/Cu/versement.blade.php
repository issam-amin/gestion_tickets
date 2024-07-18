<x-layout>
<x-slot name="headings">
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <div class="text-xl font-bold text-gray-800 mb-4">Tableau de Commune Urbaine : {{$cu_name}}</div>
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col sm:flex-row sm:justify-between items-center">
            <div class="font-extrabold text-blue-900 mr-4 mb-4 sm:mb-0">Regisseur de : "{{$name}}"</div>
            <div class="font-extrabold text-red-500 ml-4 mb-4 sm:mb-0">L'année : {{$annee}}</div>
        </div>
        <x-button class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded" href="/Regisseur/{{$IDRegisseur}}/{{$annee}}">Voir Recap</x-button>

    </div>

</x-slot>

<form method="POST" action="/{{$typeRegisseur}}/{{$annee}}/{{$IDRegisseur}}">
    @csrf

    <div class="flex items-center gap-x-6 mt-40">
        <a href="/Cu/{{$cu_name}}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-indigo-600 transition duration-200 ease-in-out">
            Cancel
        </a>
        <div>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm
                hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 transition duration-200 ease-in-out">
                Save
            </button>
        </div>
    </div>
        <table class="table table-striped table-hover ">
            <thead>
            <tr>
                <th scope="row" colspan="7" class="text-center ">{{strtoupper($typeRegisseur)}} REGISSEURS</th>
            </tr>
            <tr class="text-center">
                <th scope="col">Mois</th>
                @foreach($values as $value)
                    <th scope="col">{{$value}}</th>
                @endforeach
                <th scope="col">Somme</th>
            </tr>
            </thead>
            <tbody>
            @php $i = 0; @endphp
            @php $total = array(); @endphp
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

                @php
                    $totalsum = [];
                    $valeurs = ['0.5', '1', '2', '5', '50'];
                @endphp

                @foreach($valeurs as $value)
                    <td class="px-6 py-4 border-b border-gray-300">
                        {{ $total[0]->{$value} ?? '0' }}
                        @php($totalsum[] = $total[0]->{$value} ?? 0)
                    </td>
                @endforeach


                <td class="px-6 py-4 border-b border-gray-300 ">
                    {{ array_sum($totalsum) }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    </form>
</x-layout>
