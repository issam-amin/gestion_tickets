<x-layout>
    <x-slot name="headings">
        <div>Tableau de Commune Urbaine : {{$cu_name}}</div>
        <div class="flex flex-row justify-between mt-4">
            <div class="font-extrabold text-blue-900 mr-4">Regisseur de : "{{$name}}"</div>
            <div class="font-extrabold text-red-500 ml-4">L'année : {{$annee}}</div>
            <x-nav-link> Voir Recap</x-nav-link>
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
                <th scope="row" class="text-center">Reprise</th>
                @for($i = 0; $i < count($values); $i++)
                    <td class="px-6 py-4 border-b border-gray-300"></td>
                @endfor
                <td class="px-6 py-4 border-b border-gray-300"></td>
            </tr>

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
                @foreach($values as $value)
                    @php
                        $sum = 0;
                        foreach($months as $monthIndex => $month) {
                            $sum += isset($donnes[$monthIndex]) && isset($donnes[$monthIndex]->$value) ? $donnes[$monthIndex]->$value : 0;
                        }
                    @endphp
                    @php $total[] = $sum * doubleval($value) @endphp
                @endforeach
                <th scope="row" class="text-center">TOTAL</th>
                @foreach($total as $sum)
                    <td class="px-6 py-4 border-b border-gray-300">
                        {{ $sum }}
                    </td>
                @endforeach
                <td class="px-6 py-4 border-b border-gray-300 ">
                    {{ array_sum($total) }}
                </td>
            </tr>
            </tbody>
        </table>

        <div class="mt-1 flex items-center justify-between gap-x-6">
            <div class="flex items-center justify-content-between">
                <div>
                    <a href="#" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                </div>
                <div>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2
                     text-sm font-semibold text-white shadow-sm hover:bg-indigo-500
                     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                     focus-visible:outline-indigo-600">
                        SAVE
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-layout>
