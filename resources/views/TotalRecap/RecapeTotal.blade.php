<x-layout>
    <x-slot name="headings">



        <div class="font-extrabold text-blue-500 ml-4 mb-4 sm:mb-0">  {{ucfirst($typeRegisseur)}} de L'année : {{$annee}}</div>
        <x-button class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded" href="/total/{{$region}}/{{$typeRegisseur}}/{{$annee}}">Voir Recap</x-button>
    </x-slot>

    <form method="POST" action="#">
        @csrf

        <table class="table table-striped table-hover table-sm" style="width: 80%; margin: auto;">
            <thead>
            <tr>
                <th scope="row" colspan="8" class="text-center">{{ strtoupper($typeRegisseur) }} REGISSEURS</th>
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
                $somme = 0;
            @endphp
            @if($typeRegisseur=="chez_tp")
                <th scope="row" class="text-center" style=" color: #fc8181;">Reprise TP ({{$annee -1}})</th>
                @foreach($values as $value)
                    <td class="text-center py-4 border-b border-gray-300 " style=" color: #fc8181;">
                        {{  number_format($resteTP['total'][$value]  ?? 0, 2, ',', ' ')}}
                    </td>
                @endforeach
                <td class="px-6 py-4 border-b border-gray-300 font-extrabold" style=" color: #ff1a1a;">
                    {{number_format(array_sum($resteTP['total'])   ?? 0, 2, ',', ' ')}} </td>
            @endif
            @if($typeRegisseur=="approvisionnement" || $typeRegisseur=="chez_tp")
            <tr>
                <th scope="row" class="text-center" style=" color: #fc8181;">Reprise de l'Année Précédente ({{$annee -1}})</th>
                @foreach($values as $value)
                    <td class="text-center py-4 border-b border-gray-300 " style=" color: #fc8181;">
                        {{ number_format($reste['total'][$value]  ?? 0, 2, ',', ' ') }}
                    </td>
                @endforeach

                <td class="px-6 py-4 border-b border-gray-300 font-extrabold" style=" color: #ff1a1a;">
                    {{number_format(array_sum($reste['total'])   ?? 0, 2, ',', ' ')}}</td>
            </tr>
            @endif
            @foreach($table_mois as $mois => $values)
                <tr>
                    <th scope="row" class="text-center">{{ $mois }}</th>
                    @foreach($values as $key => $value)
                        <td class="px-6 py-4 border-b border-gray-300 text-center">
                            {{         number_format($value  ?? 0, 2, ',', ' ') }}
                        </td>
                        @php
                            $somme += $value;
                        @endphp
                    @endforeach
                    <td class="px-6 py-4 border-b border-gray-300 text-center">{{  number_format($somme  ?? 0, 2, ',', ' ')}}</td>
                    @php
                        $somme = 0;
                    @endphp
                </tr>
            @endforeach

            <tr>
                <th scope="row" class="text-center">TOTAL</th>
                @foreach($values as $key => $value)
                    <td class="px-6 py-4 border-b border-gray-300 text-center">
                        {{ number_format($table_total_mois[$key] ?? '0', 2, ',', ' ') }}
                    </td>
                @endforeach
                <td class="px-6 py-4 border-b border-gray-300 text-center">
                 {{number_format(array_sum($table_total_mois)   ?? 0, 2, ',', ' ')}}</td>
            </tr>
            </tbody>
        </table>
    </form>
</x-layout>

<style>
    table {
        width: 80%;
        margin: auto;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: center;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
</style>
