@section('title', 'Create Benefits')
@section('sub-title', 'Create Benefits')
@extends('layout.app')

@section('content')
<form action="{{ route('employee_benefits.store') }}" method="POST">
    @csrf
    <div class="modal-body">

        <div class="row mb-3 mt-4">
            <label for="title" class="col-sm-3 col-form-label required">Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="name" id="name">
                @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
        </div>
        <div class="row mb-3 mt-4">
            <label for="grade_id" class="col-sm-3 col-form-label required">Grade <span class='asterisk'>*</span></label>
            <div class="col-sm-9">
                <select class="form-select" name="grade_id" id="grade_id">
                    <option value="" selected>Select Grade</option>
                    @foreach($all_grades as $grade)
                     {{ dump($grade) }}
                    <option value="{{ $grade }}">{{ $grade }}</option>
                    @endforeach
                </select>
                @if ($errors->has('grade_id'))
                <span class="text-danger">{{ $errors->first('grade_id') }}</span>
                @endif
            </div>
        </div>
        <div class="row mb-3 mt-4">
            <label for="amount" class="col-sm-3 col-form-label required">Amount</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="amount" id="amount">
                @if ($errors->has('amount'))
                <span class="text-danger">{{ $errors->first('amount') }}</span>
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
        <a href="{{ route('employee_benefits.index') }}" class="btn btn-primary">Back</a>

    </div>

</form>
@endsection