<div class="block overflow-x-auto">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex" aria-label="Tabs">
            <a href="{{ route('blog::posts.index') }}" class="@if(empty(request('status'))) tab-v2--selected @else tab-v2 @endif">
                Tous les articles
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'published']) }}" class="@if(request('status') === 'published') tab-v2--selected @else tab-v2 @endif">
                Publiés
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'featured']) }}" class="@if(request('status') === 'featured') tab-v2--selected @else tab-v2 @endif">
                Mis en avant
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'deleted']) }}" class="@if(request('status') === 'deleted') tab-v2--selected @else tab-v2 @endif">
                Supprimés
            </a>
        </nav>
    </div>
</div>
