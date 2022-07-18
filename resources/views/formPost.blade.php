@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-2">
            </div>
            <div class="col-8">
                <form action="/dashboard" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="mb-3">
                        <label for="" class="form-label">Post Title</label>
                        <input name="title" type="text" class="form-control" id="" aria-describedby="">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Post content</label>
                        <input type="textArea" name="contents" class="form-control" id="">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-2">
            </div>
        </div>
    </div>

@endsection
