
@section('title', 'Employee')
@section('sub-title', 'Employee')
@extends('layout.app')

@section('content')



@foreach($all_emp as $val)
  {{ $val->id }}

@endforeach



@endsection