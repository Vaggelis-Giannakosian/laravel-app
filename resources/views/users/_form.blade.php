<div class="row">

    <div class="col-4">
        <img src="{{ $user->thumb ? $user->thumb->url() : '' }}" alt="" class="img-thumbnail img-fluid avatar">

        <div class="card mt-4">
            <div class="card-body">
                <h6><label for="avatar">Upload a different pic</label></h6>
                <input type="file" name="avatar" id="avatar" accept="image/*" class="form-control-file">
            </div>

        </div>

        <x-errors name="avatar"/>

    </div>

    <div class="col-8">

        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control" placeholder="Enter the name..." type="text" name="name" id="name"
                   value="{{ old('name', $user->name?? null) }}">
        </div>

        <x-errors name="name"/>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Save changes</button>
        </div>

    </div>

</div>
