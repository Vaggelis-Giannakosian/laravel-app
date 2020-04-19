@error($name)
    <div class="alert alert-danger" role="alert">
        {{ $message }}
    </div>
@enderror

{{--        @if($errors->any())--}}
{{--            <div>--}}
{{--                <ul>--}}
{{--                    @foreach($errors->all() as $error)--}}
{{--                        <li>--}}
{{--                            {{ $error }}--}}
{{--                        </li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        @endif--}}
