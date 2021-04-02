@extends('admin.layouts.app')
@section('title', 'Articles')
@section('content')
    <div class="bg-white border-l border-gray-200">
        <div class="border-b border-gray-200 px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl font-semibold leading-6 text-gray-900 sm:truncate">
                        Blog
                    </h1>
                </div>
                <div class="flex ml-4">
                    <a href="{{ route('admin::posts.create') }}" class="btn">
                        Ajouter un article
                    </a>
                </div>
            </div>
            @include('admin.components.alert')
        </div>

        @include('admin.posts.filter')

        <div class="shadow">
            @if ($posts->isEmpty())
                <div class="max-w-screen-xl h-screen w-full align-bottom pb-4 text-left overflow-hidden transform transition-all sm:my-8 sm:align-middle">
                    <div class="px-4 py-4 sm:px-6 lg:px-8">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                            <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-headline">
                                Liste vide
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Aucun article trouvé
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <div class="align-middle inline-block min-w-full">
                        <div class="border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Titre
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date publication
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Action</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($posts as $post)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $post->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if (empty($post->thumb_url()))
                                                        <span class="inline-flex items-center justify-center h-10 w-10 bg-gray-500">
                                                            <span class="font-medium leading-none text-white">{{ strtoupper(substr($post->title, 0,2)) }}</span>
                                                        </span>
                                                    @else
                                                        <img class="h-10 w-10 object-cover" src="{{ $post->thumb_url() }}">
                                                    @endif
                                                </div>
                                                <div class="ml-4 max-w-xs overflow-hidden">
                                                    <div class="text-sm font-medium text-gray-900 truncate">
                                                        {{ ucfirst($post->title) }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ empty($post->getCategoriesNames())?'Sans catégorie':$post->getCategoriesNames() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="max-w-xs">
                                                <p class="text-sm text-gray-900"><span class="font-medium">{{ ucfirst(optional($post->author)->name) }}</span> - {{ $post->reading_time??'5 min' }}</p>
                                                <p class="text-sm text-gray-500 truncate">{{ ucfirst($post->description) }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if ($post->is_published)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Publié</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Non publié</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $post->published_at->ago() }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @include('admin.posts.menu-action', ['post' => $post])
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="bg-white border-t border-gray-200 px-4 py-4 sm:px-6">
                                {{ $posts->appends(request()->except('page'))->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
