<x-layout>
    <x-slot:headings>
        Commune Rurale page
    </x-slot:headings>
<div CLASS="flex justify-content-lg-between">

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Selectionner la commune rurale
        </button>
        <ul class="dropdown-menu dropdown-menu-dark">
            @foreach($Communes  as $Commune)
                <li><a class="dropdown-item" href="/Cr/{{ $Commune['cr_name'] }}">{{$Commune->cr_name}}</a></li>
            @endforeach
        </ul>
    </div>



</div>
</x-layout>
