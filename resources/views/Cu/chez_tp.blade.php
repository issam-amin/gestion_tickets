<x-layout>
    <x-slot name="headings">

        <p>Tableau de Commune Urbaine : {{$cu_name}}</p>
        <p class="text-center font-extrabold text-blue-900">Regisseur de :  "{{$name}}"</p>
        <p>L'année: {{$annee}}</p>

    </x-slot>
    <form method="POST" action="">
        @csrf
    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th scope="row" colspan="6" class="text-center">{{strtoupper($typeRegisseur)}}</th>
        </tr>
        <tr class="text-center">
            <th scope="col">Mois</th>
            @foreach($values as $value)
                <th scope="col">{{$value}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>

        <tr>
            <th scope="row" class="text-center">Reste</th>
            @for($i=0;$i<5;$i++)
                <td class="px-6 py-4 border-b border-gray-300 ">
                </td>
            @endfor
        </tr>
            @foreach($months as $month)
        <tr>
            <th scope="row" class="text-center mt-10">{{$month}}</th>
            @for($i=0;$i<5;$i++)
                <td class="px-6 py-4 border-b border-gray-300">
                    <input class="block w-75 px-6 py-3 text-black bg-white border border-gray-200 rounded-full appearance-none
                    placeholder:text-gray-400 focus:border-blue-500 focus:outline-none
                    focus:ring-blue-500 sm:text-sm max-w-[220px]" placeholder="number" id="number" type="number">
                </td>
            @endfor

        </tr>
            @endforeach

        </tbody>
    </table>
    <div>
        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white
                        shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2
                         focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Update
        </button>
    </div>
    </form>

</x-layout>
