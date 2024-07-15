<x-layout>
    <x-slot name="headings">
        Tableau de Commune Urbaine : {{$cu_name}}<br>
      <p class="text-center font-extrabold text-blue-900">Regisseur de :  "{{$name}}"</p>


    </x-slot>

    <table class="table table-striped table-hover ">
        <thead>

        <tr>
            <th scope="row" colspan="6" class="text-center">APPROVISIONNEMENT REGISSEURS</th>
        </tr>
        <tr>
            <th scope="col">Mois</th>
            <th scope="col">0.5</th>
            <th scope="col">1</th>
            <th scope="col">2</th>
            <th scope="col">5</th>
            <th scope="col">50</th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <th scope="row">Reste</th>
            @for($i=0;$i<5;$i++)
                <td class="px-6 py-4 border-b border-gray-300">
                </td>
            @endfor
        </tr>
            @foreach($months as $month)
        <tr>
            <th scope="row">{{$month}}</th>
            @for($i=0;$i<5;$i++)
                <td class="px-6 py-4 border-b border-gray-300">
                    <input id="number" type="number" placeholder="number" min="0" class="w-full px-3 py-2 border border-gray-900 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                </td>
            @endfor

        </tr>
            @endforeach

        </tbody>
    </table>
    <div>
        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white
                        shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Update
        </button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const menuButton = document.getElementById('menu-button');
            const dropdownMenu = document.getElementById('dropdown-menu');

            menuButton.addEventListener('click', () => {
                dropdownMenu.classList.toggle('hidden');
            });

            window.addEventListener('click', (e) => {
                if (!menuButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        });
    </script>
</x-layout>
