@if( $show )
    <span class="badge badge-{{ $type??'success' }}">
        {{ $message }}
    </span>
@endif
