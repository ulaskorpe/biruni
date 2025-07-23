@php

    $contents = \Spatie\QueryBuilder\QueryBuilder::for(\App\Models\Content::class)
    ->with([
        'content_categories',
        'main_image',
        'uri',
        'content_type'
    ])
    ->when(request()->input('search'), function ($query, $search) {
        $query->where(function (Builder $q) use ($search) {
            $q->where('name','like','%'.$search.'%')->orWhere('sku','like','%'.$search.'%');
        });
    })
    ->when($category,function($query) use ($category) {
        $query->whereHas('content_categories',function($cat) use ($category) {
            $cat->where('id',$category->id);
        });
    })
    ->when($contentType,function($query) use ($contentType) {
        $query->where('content_type_id',$contentType->id);
    })
    ->defaultSort('-start_date')
    ->allowedSorts('name','created_at')
    ->paginate(30)->withQueryString();
    
@endphp

<section class="content-section">
    <div class="container">
        <div class="row g-3 g-xl-5 row-cols-1 row-cols-md-2 row-cols-lg-{{$columnCount}}">
            @foreach ($contents as $key => $content)
            <div class="col">
                @if ($cardLayout)
                <x-cards.dynamic-card :content="$content" :card-layout="$cardLayout"/>
                @else
                <x-cards.content-card :content="$content" :use-date="$useDate"/>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    <div class="mt-5 mt-xl-7">
        {{ $contents->links() }}
    </div>
</section>