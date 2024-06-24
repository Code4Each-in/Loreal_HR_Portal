@section('title', 'Salary Structure')
@section('sub-title', 'Salary Structure')
@extends('layout.app')

@section('content')

<section class="section profile">
  <div class="row">
    <div class="col-xl-4">

      <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
          <label class="custom-file-upload fas">
            <div class="img-wrap img-upload"><img for="photo-upload" src="{{ url('assets/img/emp_pic.jpg') }}"></div>
          </label>
                    @if(!empty($emp_data) && isset($emp_data[0]))
              <h2>
                  @if(isset($emp_data[0]->Fname)){{ $emp_data[0]->Fname ?? '' }}@endif 
                  @if(isset($emp_data[0]->Lname)) {{ $emp_data[0]->Lname }}@endif
              </h2>
          @endif
       
          <h3>Employee</h3>

        </div>
      </div>

    </div>

    <div class="col-xl-8">

      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">

            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
            </li>



          </ul>
          <div class="tab-content pt-2">

            <div class="tab-pane fade show active profile-overview" id="profile-overview">



              <h5 class="card-title">Profile Details</h5>

              <div class="row">
                <div class="col-lg-3 col-md-4 label ">Full Name</div>
                <div class="col-lg-9 col-md-8">
    @if(isset($emp_data[0]))
        @if($emp_data[0]->Fname){{ $emp_data[0]->Fname }} @endif
        @if($emp_data[0]->Lname) {{ $emp_data[0]->Lname }}@endif
  
    @endif
</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Phone</div>
                <div class="col-lg-9 col-md-8">@if(isset($emp_data[0]))   @if($emp_data[0]->phone){{ $emp_data[0]->phone }} @endif  @endif</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">City</div>
                <div class="col-lg-9 col-md-8">@if(isset($emp_data[0])) @if($emp_data[0]->city){{ $emp_data[0]->city }} @endif @endif</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">State</div>
                <div class="col-lg-9 col-md-8">@if(isset($emp_data[0])) @if($emp_data[0]->state){{ $emp_data[0]->state }} @endif @endif</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Zipcode</div>
                <div class="col-lg-9 col-md-8">@if(isset($emp_data[0])) @if($emp_data[0]->zipcode){{ $emp_data[0]->zipcode }} @endif @endif</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Email</div>
                <div class="col-lg-9 col-md-8">@if(isset($emp_data[0])) @if($emp_data[0]->email){{ $emp_data[0]->email }} @endif  @endif</div>
              </div>
              <div class="row">
                <div class="col-lg-3 col-md-4 label">Grade</div>
                <div class="col-lg-9 col-md-8">@if(isset($emp_data[0])) @if($emp_data[0]['user_detail'][0]['grade']){{ $emp_data[0]['user_detail'][0]['grade'] }} @endif  @endif</div>
              </div>
            </div>
          </div><!-- End Bordered Tabs -->

        </div>
      </div>

    </div>
  </div>
</section>
<div class="display_btn">
<a href="" class="btn btn-primary show_hide" id="show_hide">Show Formula and Calculation</a>
</div>

<table class="table" id="emp_table" style="width:100%">
  <thead>
    <tr>
      <th scope="col">Head Title</th>
      <th scope="col" id="formula">Formula</th>
      <th scope="col" id="calculation">Calculation </th>
      <th scope="col">Result</th>

    </tr>
  </thead>
  <tbody>
    @if(session()->has('message'))
    <div id="successMessage" class="alert alert-success fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      {{ session()->get('message') }}
    </div>
    @endif

    @foreach ($td_variables as $val) 

    <tr>
      <td scope="row"> {{$val['head_title']}}</td>
      <td class="formula">{{$val['formula']}}</td>
      <td class="calculation">{{$val['calculation']}}</td>
      <td>{{$val['amount']}}</td>
    </tr>
    @endforeach


  </tbody>
</table>




@endsection
@section('js_scripts')

<!-- <script>
  $(document).ready(function() {
    $('#emp_table').DataTable({
      searching: true,
      language: {
        emptyTable: "No records found"
      },
      "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [0]
      }, ],
    });
    $('#emp_table th#formula, #emp_table th#calculation').hide();
    $('#emp_table td.formula, #emp_table td.calculation').hide();
  });
</script>

<script>
  $(document).on("click", '#show_hide', function(e) { 
    e.preventDefault();
    var isHidden = $('#emp_table th#formula').is(':hidden');
    if (isHidden) {
      $('#emp_table th#formula, #emp_table th#calculation').show();
      $('#emp_table td.formula, #emp_table td.calculation').show();
      $(this).text('Hide Formula and Calculation');
    } else {
      $('#emp_table th#formula, #emp_table th#calculation').hide();
      $('#emp_table td.formula, #emp_table td.calculation').hide();
      $(this).text('Show Formula and Calculation');
    }
  });
  </script> -->

  <script>
  $(document).ready(function() {
    var table = $('#emp_table').DataTable({
      searching: true,
      language: {
        emptyTable: "No records found"
      },
      "columns": [
        null,
        { "visible": false },
        { "visible": false },
        null
      ],
      "order": []
    });

    $('#show_hide').on('click', function(e) { 
      e.preventDefault();
      var isHidden = !table.column(1).visible();
      table.column(1).visible(isHidden);
      table.column(2).visible(isHidden);
      $(this).text(isHidden ? 'Hide Formula and Calculation' : 'Show Formula and Calculation');
    });
  });
</script>
@endsection