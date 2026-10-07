{{-- resources/views/livewire/buscador-avisos.blade.php --}}
<div class="flex flex-col items-center justify-center space-y-4 mt-6">
    <div class="flex space-x-2">
        <input class="border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500" wire:model.live="busqueda" placeholder="Buscar aviso">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" wire:click="limpiar">Limpiar</button>
    </div>

    <div class="max-w-4xl mx-auto p-8">
        <div class="grid md:grid-cols-2 gap-4">
            @foreach ($avisos as $aviso)
                <x-tarjeta-post :post="$aviso" />
            @endforeach
        </div>
    </div>
</div>
