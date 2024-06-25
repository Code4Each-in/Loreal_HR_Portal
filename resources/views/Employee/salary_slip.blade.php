@section('title', 'Salary Slip')
@section('sub-title', 'Salary Slip')
@extends('layout.app')

@section('content')

<table class="table" id="emp_table">
  <thead>

    <tr>
      <th scope="col">Month</th>
      <th scope="col">Year</th>
      <th scope="col">Action</th>

    </tr>

  </thead>
  <tbody>
    @foreach($salary as $val)
  
    <tr>
      <td> <?php 
          
       $dateObj   = DateTime::createFromFormat('!m', $val['month'] );
        $monthName = $dateObj->format('F');  echo $monthName; ?>
        </td>
      <td>{{ $val['year'] }} </td>
      <td><a class="btn btn-primary" id="createUser" data-toggle="modal" data-target="#userModal">Download</a></td>
    </tr>
   @endforeach
  </tbody>
</table>

@endsection

@section('js_scripts')

@endsection



