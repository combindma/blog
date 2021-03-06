@extends('dashui::layouts.app')
@section('title', 'Tags')
@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div x-data="{ open: false }" @keydown.window.escape="open = false" class="mb-4 border-b border-gray-200">
            <div class="pb-8 sm:flex sm:items-center sm:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                        Tags articles
                    </h1>
                </div>
                <div class="mt-4 flex sm:mt-0 sm:ml-4">
                    <button @click="open=true" type="button" class="btn">
                        Ajouter un tag
                    </button>
                </div>
            </div>
            <div x-show="open" class="z-10 fixed inset-0 overflow-hidden">
                <div  class="absolute inset-0 overflow-hidden">
                    <div x-show="open"
                         x-transition:enter="ease-in-out duration-500"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in-out duration-500"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0" class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <section @click.away="open = false" class="absolute inset-y-0 right-0 pl-10 max-w-full flex sm:pl-16" aria-labelledby="slide-over-heading">
                        <div x-show="open"
                             x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                             x-transition:enter-start="translate-x-full"
                             x-transition:enter-end="translate-x-0"
                             x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                             x-transition:leave-start="translate-x-0"
                             x-transition:leave-end="translate-x-full"
                             class="bg-gray-500 bg-opacity-75 transition-opacity w-screen max-w-xl">
                            <div class="h-full divide-y divide-gray-200 flex flex-col bg-white shadow-xl overflow-y-scroll">
                                <div class="min-h-0 flex-1 flex flex-col overflow-y-scroll">
                                    <div class="py-6 px-4 bg-primary-700 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <h2 id="slide-over-heading" class="text-lg font-medium text-white">
                                                Ajouter un nouveau tag
                                            </h2>
                                            <div class="ml-3 h-7 flex items-center">
                                                <button @click="open=false" class="bg-primary-700 rounded-md text-primary-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                                    <span class="sr-only">Close panel</span>
                                                    <!-- Heroicon name: outline/x -->
                                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6 relative flex-1 px-4 py-6 sm:px-6">
                                        <form id="form-action" action="{{ route('blog::tags.store') }}" method="POST">
                                            @csrf
                                            <label class="form-label">Nom</label>
                                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                                        </form>
                                    </div>
                                </div>
                                <div class="shrink-0 px-4 py-4 flex justify-end">
                                    <button @click="open=false" type="button" class="btn-subtle">
                                        Annuler
                                    </button>
                                    <button onclick="document.getElementById('form-action').submit();" type="submit" class="btn ml-3">
                                        Enregistrer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        @include('dashui::components.alert')
        @if ($tags->isEmpty())
            @component('dashui::components.blank-state')
                @slot('icon')
                    <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                @endslot
                @slot('heading')
                    Liste vide
                @endslot
                Aucune tag trouv??
            @endcomponent
        @else
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nom
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Slug
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Position
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($tags as $tag)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $tag->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ ucfirst($tag->name) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $tag->slug }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $tag->order_column }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-3">
                                            @if (!$tag->deleted_at)
                                                <a href="{{ route('blog::tags.edit', $tag) }}" class="text-primary-600 hover:text-primary-900">
                                                    Modifier
                                                </a>
                                            @endif
                                            @if ($tag->deleted_at)
                                                <form action="{{ route('blog::tags.restore', $tag->id) }}" method="POST">
                                                    @csrf
                                                    <a href="javascript:" class="text-yellow-600 hover:text-yellow-900"
                                                       onclick='confirm("Etes-vous s??r de vouloir restaurer ce tag ?") && parentNode.submit();'>
                                                        Restaurer
                                                    </a>
                                                </form>
                                            @else
                                                <form action="{{ route('blog::tags.destroy', $tag) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="javascript:" class="text-red-600 hover:text-red-900" onclick='confirm("Etes-vous s??r de vouloir supprimer ce tag ?") && parentNode.submit();'>
                                                        Supprimer
                                                    </a>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
