<x-layout>
    <x-slot name="headings">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <p class="text-xl font-bold text-gray-800 mb-4">Tableau de Commune Urbaine : {{$commune_Name}}</p>
            <p class="text-lg text-gray-600 mb-4">L'année: {{$annee}}</p>
        </div>
    </x-slot>

    <form method="POST" action="{{ url('/'.$typeRegisseur.'/'.$annee.'/'.($IDRegisseur??0).'/'.$commune_Name) }}">
        @csrf
        @php
            $totalsum = [];
        @endphp

        <div class="overflow-x-auto">
            <table class="table table-striped table-hover table-responsive-sm w-full">
                <thead>
                <tr>
                    <th colspan="{{ count($values) + 2 }}" class="text-center text-red-500 bg-gray-100">CHEZ TP</th>
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
                    <th scope="row" class="text-center">Reprise chez Tp de l'année {{$annee-1}}<br>(Reste de l'année
                        dernière)
                    </th>
                    @foreach($values as $value)
                        <td class="px-6 py-4 border-b border-gray-300 text-center">
                            {{number_format($resteTP[0]->{$value} ?? 0, 2, ',', ' ') ?? 0}}
                            {{-- {{ $resteTP->isNotEmpty() ? $resteTP[0]->{$value} : 0 }} --}}
                        </td>
                    @endforeach
                    <td class="px-6 py-4 border-b border-gray-300 text-center">
                        {{number_format($sommeTP ?? 0, 2, ',', ' ') }}
                    </td>
                </tr>

                <tr>
                    <th scope="row" class="text-center">Reprise chez les regisseurs de l'année {{$annee-1}}</th>

                    @foreach($values as $value)
                        <td class="px-6 py-4 border-b border-gray-300 text-center">
                            {{number_format($reste[$value]   ?? 0, 2, ',', ' ') }}

                        </td>
                    @endforeach
                    <td class="px-6 py-4 border-b border-gray-300 text-center">
                        {{ number_format($sommeAP  ?? 0, 2, ',', ' ')  }}
                    </td>
                </tr>

                <tr>
                    <th scope="row" class="text-center">Total Des reprises</th>
                    @foreach($values as $value)
                        <td class="px-6 py-4 border-b border-gray-300 text-center font-bold">
                             {{ number_format($reste[$value]+$resteTP[0]->{$value} ?? 0, 2, ',', ' ')?? 0}}
                        </td>
                    @endforeach
                    <td class="px-6 py-4 border-b border-gray-300 text-center font-bold ">
                        {{  number_format($sommeAP + $sommeTP ?? 0, 2, ',', ' ')}}
                    </td>
                </tr>

                @php $i = 0; @endphp
                @foreach($months as $month)
                    <tr>
                        <th scope="row" class="text-center">{{ $month }}</th>
                        @foreach($values as $value)
                            <td class="px-6 py-4 border-b border-gray-300">
                                <input name="{{ $month . '[' . $value . ']' }}"
                                       class="block w-full px-2 py-2 text-black bg-white border border-gray-200 rounded-full placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm text-center"
                                       value="{{$donnes[$i]->$value ?? 0}}"
                                       type="number">
                            </td>
                        @endforeach
                        <td class="px-6 py-4 border-b border-gray-300 text-center">{{ isset($donnes[$i]) ? $donnes[$i]->Somme : 0 }}</td>
                    </tr>
                    @php $i++; @endphp
                @endforeach

                <tr>
                    <th scope="row" class="text-center bg-gray-100">TOTAL</th>
                    @foreach($values as $value)
                        <td class="px-6 py-4 border-b border-gray-300 text-center">
                            {{ number_format($total_annuel->{$value} ?? '0', 2, ',', ' ') }}
                        </td>
                        <input type="hidden" name="total_annuel[{{ $value }}]"
                               value="{{ $total_annuel->{$value} ?? '0' }}">
                    @endforeach
                    <td class="px-6 py-4 border-b border-gray-300 text-center">
                        {{ $valeurtotal ?? 0 }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="/commune/{{$region}}"
               class="text-sm font-semibold leading-6 text-gray-900 hover:text-indigo-600 transition duration-200 ease-in-out">
                Cancel
            </a>
            <div>
                <button type="submit"
                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 transition duration-200 ease-in-out">
                    Save
                </button>
            </div>
        </div>
    </form>
</x-layout>
