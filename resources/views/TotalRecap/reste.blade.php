<x-layout>
    <x-slot name="headings">

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex justify-between">
            <div class="font-extrabold text-blue-900 mr-4 flex-1">Récape  {{ucfirst($typeRegisseur)}} de la region : " {{$region}} "</div>
            <div class="font-extrabold text-red-500 ml-4 flex-0.5 text-right">Année : {{$annee}}</div>
        </div>

    </x-slot>
    <div class="flex items-center gap-x-6 table-striped">
        <table class="table">
            <thead>
            <tr class="text-center">
                <th scope="col">#</th>
                @foreach($values as $value)
                    <th scope="col">{{ $value }}</th>
                @endforeach
                <th scope="col">SOMME</th>
            </tr>

            </thead>
            <tbody>
            @if($typeRegisseur=='chez_tp')
            <tr >

                <th scope="row" class="text-center">CHER_TP</th>
                @foreach($values as $value)
                    <td class="text-center py-4 border-b border-gray-300">
                        {{  number_format($table_total_tp [$value]  ?? 0 , 2, ',', ' ') }}
                    </td>

                @endforeach
                <td class="text-center py-4 border-b border-gray-300">
                    {{  number_format(array_sum($table_total_tp) ?? 0, 2, ',', ' ')}}
                </td>

            </tr>
            @endif

            <tr>
                <th scope="row" class="text-center">APPROVISIONNEMENT</th>
                @foreach($values as $value)
                    <td class="text-center py-4 border-b border-gray-300">
                        {{ number_format($table_total_app[$value]  ?? 0 , 2, ',', ' ') }}
                    </td>
                @endforeach
                <td class="text-center py-4 border-b border-gray-300">
                    {{ number_format(array_sum($table_total_app) ?? 0 , 2, ',', ' ')  }}
                </td>
            </tr>
            @if($typeRegisseur=='approvisionnement' || $typeRegisseur=='versement')
            <tr>
                <th scope="row" class="text-center">VERSEMENT</th>
                @foreach($values as $value)
                    <td class="text-center py-4 border-b border-gray-300">
                        {{  number_format($table_total_ver[$value]  ?? 0  , 2, ',', ' ') }}
                    </td>
                @endforeach
                <td class="text-center py-4 border-b border-gray-300">
                    {{ number_format(array_sum($table_total_ver) ?? 0  , 2, ',', ' ') }}
                </td>
            </tr>
            @endif
            <tr>
                <th scope="row" class="text-center">Reste</th>
                @foreach($values as $value)
                    <td class="text-center py-4 border-b border-gray-300">
                        {{  number_format($reste['total'][$value] ?? 0  , 2, ',', ' ') }}
                    </td>
                @endforeach
                <td class="text-center py-4 border-b border-gray-300">
                    {{  number_format(array_sum($reste['total']) ?? 0  , 2, ',', ' ')}}
                </td>
            </tr>

            </tbody>
        </table>

    </div>


</x-layout>
