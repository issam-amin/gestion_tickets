<x-layout>
    <x-slot name="headings">

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex justify-between">
            <div class="font-extrabold text-blue-900 mr-4 flex-1">Récape de TP : "{{$name}}"</div>
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
                <tr >
                            <th scope="row" class="text-center">CHER_TP</th>
                            @foreach($values as $value)
                                <td class="text-center py-4 border-b border-gray-300">
                                    {{ $chezTp->first()->{$value}  ?? 0 }}
                                </td>

                            @endforeach
                            <td class="text-center py-4 border-b border-gray-300">
                                {{ $sumTP ?? 0 }}
                            </td>

                        </tr>

                        <tr>
                            <th scope="row" class="text-center">CHER_REG</th>
                            @foreach($values as $value)
                                <td class="text-center py-4 border-b border-gray-300">
                                    {{ $chezREG->first()->{$value}  ?? 0 }}
                                </td>
                            @endforeach
                            <td class="text-center py-4 border-b border-gray-300">
                                {{ $sumREG ?? 0 }}
                            </td>
                        </tr>


                <tr>
                    <th scope="row" class="text-center">Reste</th>
                    @foreach($values as $value)
                        <td class="text-center py-4 border-b border-gray-300">
                            {{ $resteTP[$value] ?? 0 }}
                        </td>
                    @endforeach
                    <td class="text-center py-4 border-b border-gray-300">
                        {{ array_sum($resteTP) ?? 0 }}
                    </td>
                </tr>

                </tbody>
            </table>

        </div>


</x-layout>
