<div class="card mt-4 col-12 ">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $subtitle }}</h6>
    </div>
    <ul class="list-group list-group-flush">

        @if( is_a($items,'Illuminate\Support\Collection'))

            @forelse($items as ['title' => $title, 'href' => $href,'count'=>$count])
                <li class="list-group-item">
                    @if( $href )
                        <a href="{{ $href }}">
                            @endif
                            {{ $title }} ({{ $count }})
                            @if( $href )
                        </a>
                    @endif

                </li>
            @empty
                <li class="list-group-item">No Entries found</li>
            @endforelse
        @else
            {{ $items }}
        @endif
    </ul>
</div>
