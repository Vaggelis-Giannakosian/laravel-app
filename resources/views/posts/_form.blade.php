<p>
    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="{{ old('title', $post->title?? null) }}">
</p>


@error('title')
<div class="alert alert-danger">{{ $message }}</div>
@enderror


<p>
    <label for="content">Content</label>
    <textarea name="content" id="content" cols="30" rows="10" placeholder="Write the content here...">{{ old('content', $post->content??null) }}</textarea>
</p>


@error('content')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
