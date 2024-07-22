<x-layout>
    <x-slot name="headings">

        <p>Tableau de Commune Urbaine : {{$cu_name}}</p>
        <p class="text-center font-extrabold text-blue-900">Regisseur de :"{{$name}}"</p>
        <p>L'année: {{$annee}}</p>
        <x-button class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded" href="/Regisseur/{{$IDRegisseur}}/{{$annee}}">Voir Recap de chez TP</x-button>
    </x-slot>
    <form method="POST" action="/{{$typeRegisseur}}/{{$annee}}/{{$IDRegisseur}}">
        @csrf
        @php
            $totalsum = [];
            $valeurs = ['0.5', '1', '2', '5', '50'];
        @endphp
    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th scope="row" colspan="7" class="text-center text-red-500">CHEZ TP</th>
        </tr>
        <tr class="text-center">
            <th scope="col">Mois</th>
            @foreach($values as $value)
                <th scope="col">{{$value}}</th>
            @endforeach
            <th scope="col">MONTANT DES TICKETS REMIS</th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <th scope="row" class="text-center">Reprise chez Tp de l'année {{$annee-1}}</th>
            @for($i=0;$i<6;$i++)
                <td class="px-6 py-4 border-b border-gray-300 ">

                </td>
            @endfor
        </tr>
        <tr>
            <th scope="row" class="text-center">Reprise chez les regisseurs de l'année {{$annee-1}}</th>
            @for($i=0;$i<6;$i++)
                <td class="px-6 py-4 border-b border-gray-300 ">

                </td>
            @endfor
        </tr>
        <tr>
            <th scope="row" class="text-center">Total Des reprises</th>
            @for($i=0;$i<6;$i++)
                <td class="px-6 py-4 border-b border-gray-300 ">

                </td>
            @endfor
        </tr>

        @php $i = 0; @endphp

        @foreach($months as $month)
            <tr>
                <th scope="row" class="text-center mt-10">{{ $month }}</th>

                @foreach($values as $value)
                    <td class="px-6 py-4 border-b border-gray-300">
                        <input name="{{ $month . '[' . $value . ']' }}" class="block w-60 px-2 py-2 text-black bg-white border
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



            @foreach($valeurs as $value)
                <td class="px-6 py-4 border-b border-gray-300 text-center ">
                    {{ $total[0]->{$value} ?? '0' }}
                    @php($totalsum[] = $total[0]->{$value} ?? 0)
                </td>
            @endforeach


            <td class="px-6 py-4 border-b border-gray-300 text-center">
                {{ array_sum($totalsum) }}
            </td>
        </tr>
        </tbody>
    </table>
        <div class="flex items-center justify-between">
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

    </form>

</x-layout>
