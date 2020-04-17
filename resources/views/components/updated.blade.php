<p class="text-muted">
    {{ $type  }} {{ $date->diffForHumans()  }}
    @if( $name )
        by {{ $name }}
    @endif
</p>
