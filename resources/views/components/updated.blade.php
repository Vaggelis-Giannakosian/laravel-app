<p class="text-muted">
    {{ $type  }} {{ $date->diffForHumans()  }}
    @if( $name )
        @if($userId)
            by <a href="{{ route('users.show',['user'=>$userId]) }}">{{ $name }}</a>
        @else
            by {{ $name }}
        @endif
    @endif
</p>
