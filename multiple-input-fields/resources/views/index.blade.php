<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Action</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" />
</head>
<body>
<div class="container d-flex justify-content-center pt-5">
    <div class="col-md-6">
        <h2 class="text-center pb-3">Edit Action</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('actions.update', $action->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- This is important for PUT requests -->
            <div class="mb-3">
                <label for="name" class="form-label">Action Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $action->name) }}" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('actions.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
</body>
</html>