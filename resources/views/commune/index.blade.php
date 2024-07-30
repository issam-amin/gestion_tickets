<x-layout>
    <x-slot:headings>
      Page de la  Commune   {{ucwords($Communes[0]['region'])}}
    </x-slot:headings>
<div CLASS="flex justify-content-lg-between">

    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Selectionner la commune {{$Communes[0]['region']}}
        </button>

        <ul class="dropdown-menu dropdown-menu-light">
            @foreach($Communes  as $Commune)
                <li><a class="dropdown-item" href={{"/commune/".$Commune['region']."/".$Commune->id}}>{{ucwords($Commune->name)}}</a></li>
            @endforeach
        </ul>
    </div>



</div>
</x-layout>
