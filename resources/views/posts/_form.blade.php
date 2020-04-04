<div class="form-group">
    <label for="title">Title</label>
    <input class="form-control" placeholder="Enter the title..." type="text" name="title" id="title" value="{{ old('title', $post->title?? null) }}">
</div>


@error('title')
<div class="alert alert-danger">{{ $message }}</div>
@enderror


<div class="form-group">
    <label for="content">Content</label>
    <textarea class="form-control" name="content" id="content" cols="30" rows="10" placeholder="Write the content here...">{{ old('content', $post->content??null) }}</textarea>
</div>


@error('content')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
