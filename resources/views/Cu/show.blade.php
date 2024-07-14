<x-layout>
    <x-slot name="headings">
        La Commune Urbaine :
    </x-slot>

    <h1></h1>

    @if ($nom)
        Mister: <strong>{{ $nom->cu_name }}</strong>
    @else
        <p>No user found with the given ID.</p>
    @endif

    @if ($regisseurs->isNotEmpty())
        <h2>Regisseurs:</h2>
        <ul>
            @foreach ($regisseurs as $regisseur)
                <li>{{ $regisseur->name }}</li> <!-- Adjust the field name to the actual column name in your Regisseur model -->
            @endforeach
        </ul>
    @else
        <p>No regisseurs found for this CU.</p>
    @endif
</x-layout>
