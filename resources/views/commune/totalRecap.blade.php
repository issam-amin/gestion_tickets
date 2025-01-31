<x-layout>
    <x-slot name="headings">

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex justify-between">
            <div class="font-extrabold text-blue-900 mr-4 flex-1">Récape de: "{{$commune_name}}"</div>
            <div class="font-extrabold text-red-500 ml-4 flex-0.5 text-right">Année : {{$selectedYear}}</div>
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

            <tr>
                <th scope="row" class="text-center">Approvisionnement</th>
                @foreach($values as $value)
                    <td class="text-center py-4 border-b border-gray-300">
                        {{  number_format($total_appro['total'][$value] ?? 0, 2, ',', ' ')}}
                    </td>
                @endforeach
                <td class="text-center py-4 border-b border-gray-300">
                    {{ number_format(array_sum($total_appro['total'])  ?? 0, 2, ',', ' ') }}
                </td>
            </tr>



            <tr>
                <th scope="row" class="text-center">Versement</th>
                @foreach($values as $value)
                    <td class="text-center py-4 border-b border-gray-300">
                        {{ number_format($total_ver['total'][$value] ?? 0, 2, ',', ' ')}}
                    </td>
                @endforeach
                <td class="text-center py-4 border-b border-gray-300">
                    {{ number_format(array_sum($total_ver['total'])  ?? 0, 2, ',', ' ') }}
                </td>
            </tr>


            <tr>
                <th scope="row" class="text-center">Reste</th>
                @foreach($values as $value)
                    <td class="text-center py-4 border-b border-gray-300">
                        {{ number_format($table_total[$value]  ?? 0, 2, ',', ' ') }}
                    </td>
                @endforeach
                <td class="text-center py-4 border-b border-gray-300">
                    {{ number_format(array_sum($table_total)  ?? 0, 2, ',', ' ') }}
                </td>
            </tr>

            </tbody>
        </table>

    </div>


</x-layout>
