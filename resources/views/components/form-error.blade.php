@props(['name'])
@error($name)
<p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
@enderror
