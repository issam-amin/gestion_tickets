<x-layout>
    <x-slot name="headings">

        <p>Tableau de Commune Urbaine : {{$cu_name}}</p>
        <p class="text-center font-extrabold text-blue-900">Regisseur de :  "{{$name}}"</p>
        <p>L'année: {{$annee}}</p>

    </x-slot>
    <form method="POST" action="/{{$typeRegisseur}}/{{$annee}}/{{$IDRegisseur}}">
        @csrf
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
        <div>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white
                            shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2
                            focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Save
            </button>
        </div>
    </form>
</x-layout>
