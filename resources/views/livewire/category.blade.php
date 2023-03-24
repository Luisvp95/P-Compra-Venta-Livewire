<div wire:init="loadCategories">
    <div class="container grid px-6 mx-auto"    >
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Categorias
        </h2>
        @if (session()->has('message'))
            <x-message />
        @endif

        <!---Table---->
        <x-table>
            <!--search-->
            <div class="px-6 py-4 flex items-center">
                <div class="flex items-center">
                    <span>Mostrar</span>
                    <select wire:model="cant"
                        class="mx-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>entradas</span>
                </div>
                <x-jet-input class="flex-1 mx-4" placeholder="buscar" type="text" wire:model="search" />
                {{-- @livewire('create-course') --}}
                <x-jet-danger-button wire:click="$set('open', true)">
                    Nuevo
                </x-jet-danger-button>
            </div>
            @if (count($categories))
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" wire:click="order('id')"
                                class="w-24 cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                                @if ($sort == 'id')

                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-1"></i>
                                @endif
                            </th>

                            <th scope="col" wire:click="order('name')"
                                class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                                @if ($sort == 'name')

                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-1"></i>
                                @endif
                            </th>
                            <th scope="col" wire:click="order('description')"
                                class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descripción
                                @if ($sort == 'description')

                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort float-right mt-1"></i>
                                @endif
                            </th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($categories as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $item->id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $item->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $item->description }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    {{-- @livewire('edit-courses', ['course' => $course], key($course->id)) --}}


                                    <a wire:click="edit({{ $item }})"
                                        class="font-bold text-white py-2 px-4 rounded cursor-pointer bg-green-600 hover:bg-green-500">
                                        Editar <i class="fas fa-edit"></i>
                                    </a>
                                    <a class="font-bold text-white py-2 px-4 ml-2 rounded cursor-pointer bg-red-600 hover:bg-red-500"
                                        wire:click="confirmDelete ({{ $item->id }})" wire:loading.attr="disabled">
                                        Eliminar <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                </div>
            </div>
                
                @if ($categories->hasPages())
                    <div class="px-6 py-3">
                        {{ $categories->links() }}
                    </div>
                @endif
            @else
                @if ($search)
                    <div class="px-6 py-4">
                        No existe ningun registro que coincida con la busqueda
                    </div>
                @else
                    <p class="py-20 text-center animate-ping">Cargando...</p>
                @endif

            @endif
            
        </x-table>
    </div>
    <x-jet-confirmation-modal wire:model="open_delete">
        <x-slot name="title">
            {{ __('Eliminar Categoria') }}
        </x-slot>

        <x-slot name="content">
            {{ __('¿Está seguro que desea eliminar la Categoria?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('open_delete', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete ({{ $open_delete }})" wire:loading.attr="disabled">
                {{ __('Eliminar') }}
            </x-jet-danger-button>
        </x-slot>  
    </x-jet-confirmation-modal>

    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            {{ isset( $this->category->id) ? 'Editar Categoria' : 'Crear Categoria' }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label value="Nombre" />
                <x-jet-input wire:model.difer="category.name" type="text" class="w-full"/>
                <x-jet-input-error for="category.name" />
            </div>
            <div class="mb-4">
                <x-jet-label value="Descripción" />
                <x-jet-input wire:model.difer="category.description" type="text" class="w-full"/>
                <x-jet-input-error for="category.description" />
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-danger-button wire:click="update" wire:loading.attr="disabled" class="disabled:opacity-25">
                {{ isset( $this->category->id) ? 'Actualizar' : 'Guardar' }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>

