@section('title', 'Basic Grade')
@section('sub-title', 'Basic Grade')
@extends('layout.app')

@section('content')
<form action="{{ url('storegrade') }}" method="POST">
    @csrf
    <div class="modal-body">

        <div class="row mb-3 mt-4">
            <label for="title" class="col-sm-3 col-form-label required">Grade</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="grade" id="grade">
                @if ($errors->has('grade'))
                <span class="text-danger">{{ $errors->first('grade') }}</span>
                @endif
            </div>
        </div>
    </div>
    <!-- <div id="only_amt">
        <div class="row mb-3 mt-4">
            <label for="title" class="col-sm-3 col-form-label required">Basic</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="basic_salary" id="title">
                @if ($errors->has('basic_salary'))
                <span class="text-danger">{{ $errors->first('basic_salary') }}</span>
                @endif
            </div>
        </div>
    </div> -->

    <div class="modal-footer back-btn">

        <button type="submit" class="btn btn-default">Save</button>
        <a href="{{ url('grade_listing') }}" class="btn btn-primary">Back</a>

    </div>

</form>
@endsection
