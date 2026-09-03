{{-- resources/views/livewire/buscador-avisos.blade.php --}}
<div>
    <input wire:model.live="busqueda" placeholder="Buscar aviso">
    <button wire:click="limpiar">Limpiar</button>
    @foreach ($avisos as $aviso)
        <p>{{ $aviso->titulo }}</p>
    @endforeach

    <div class="max-w-4xl mx-auto p-8">
        <div class="grid md:grid-cols-2 gap-4">
            @foreach ($avisos as $aviso)
                <x-tarjeta-post :post="$aviso" />
            @endforeach
        </div>
    </div>
</div>
