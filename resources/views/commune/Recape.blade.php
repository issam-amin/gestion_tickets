<x-layout>
    <x-slot name="headings">

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex justify-between">
            <div class="font-extrabold text-blue-900 mr-4 flex-1">Récape de: "{{$name}}"</div>
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

                </tr>

                </thead>
                <tbody>

                @php
                    $approvisionnementTotals = [];
                    $versementTotals = [];
                @endphp

                @foreach($total as $sum)
                    @if($sum->type == 'approvisionnement')
                        @php
                            foreach ($values as $value) {
                                if (!isset($approvisionnementTotals[$value])) {
                                    $approvisionnementTotals[$value] = 0;
                                }
                                $approvisionnementTotals[$value] += $sum->{$value} ?? 0;
                            }
                        @endphp
                        <tr>
                            <th scope="row" class="text-center">Approvisionnement</th>
                            @foreach($values as $value)
                                <td class="text-center py-4 border-b border-gray-300">
                                    {{number_format( ( $sum->{$value} ?? 0 ) ?? 0, 2, ',', ' ')}}
                                </td>
                            @endforeach
                        </tr>
                    @elseif($sum->type == 'versement')
                        @php
                            foreach ($values as $value) {
                                if (!isset($versementTotals[$value])) {
                                    $versementTotals[$value] = 0;
                                }
                                $versementTotals[$value] += $sum->{$value} ?? 0;
                            }
                        @endphp
                        <tr>
                            <th scope="row" class="text-center">Versement</th>
                            @foreach($values as $value)
                                <td class="text-center py-4 border-b border-gray-300">
                                    {{   number_format( ($sum->{$value} ?? 0) ?? 0, 2, ',', ' ')}}
                                </td>
                            @endforeach
                        </tr>
                    @endif
                @endforeach

                <tr>
                    <th scope="row" class="text-center">Reste</th>
                    @foreach($values as $value)
                        <td class="text-center py-4 border-b border-gray-300">
                            {{ number_format(($approvisionnementTotals[$value] ?? 0) - ($versementTotals[$value] ?? 0) ?? 0, 2, ',', ' ') }}
                        </td>
                    @endforeach
                </tr>

                </tbody>
            </table>

        </div>


</x-layout>
