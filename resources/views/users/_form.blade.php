<div class="row">

    <div class="col-4">
        <img src="" alt="" class="img-thumbnail img-fluid avatar">

        <div class="card mt-4">
            <div class="card-body">
                <label for="avatar"><h6>Upload a different pic</h6></label>
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
