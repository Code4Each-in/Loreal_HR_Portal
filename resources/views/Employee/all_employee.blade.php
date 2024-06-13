@section('title', 'Employee')
@section('sub-title', 'Employee')
@extends('layout.app')

@section('content')

<table class="table" id="emp_table">
  <thead>

    <tr>
      <th scope="col">Name</th>
      <th scope="col">Grade</th>
      <th scope="col">Base Pay</th>
      <th>Action</th>
    </tr>

  </thead>
  <tbody>

    @foreach ($all_emp as $val)

    <tr>
      <td>{{ $val['Fname'] ?? '' }} {{ $val['Lname'] ?? '' }}</td>
      <td>{{ $val['post'][0]['grade'] ?? '' }}</td>

      <td> {{ $val['post'][0]['base_pay'] ?? '' }} </td>
      <td>
        <a href="{{ url('salary_struc/'.$val['id']) }} " class="btn btn-primary salary-btn55">Salary Structure</a>
        <!-- <a type="button" class="btn btn-primary salary-btn" data-id="{{ $val['id'] }}" data-grade="{{ $val['post'][0]['grade'] ?? '' }}" data-bs-toggle="modal" data-bs-target="#basicModal5">Salary</a> -->
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
<!-- Basic Modal -->

<div class="modal fade bd-example-modal-lg" id="basicModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Basic Modal</h5>
        <div class="show_hide_btn">
          <button class="btn btn-primary" id="show_btn">Show Details</button>
          <button class="btn btn-primary" id="hide_btn">Hide Details</button>
        </div>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="append_emp_detail">
        <table class='table'>
          <thead>
            <tr>
              <th scope='col'>Head Title</th>
              <th scope='col' id='show_formula' style='display:none;'>Formula</th>
              <th scope='col' id='show_cal' style='display:none;'>Calculation</th>
              <th scope='col'>Result</th>
            </tr>
          </thead>
          <tbody id="append_salary_structure">



          </tbody>
        </table>


      </div>
    </div>
  </div>
</div><!-- End Basic Modal-->

@section('js_scripts')
<script>
  $(document).ready(function() {
    $('#emp_table').DataTable({
      searching: true,
      language: {
        emptyTable: "No records found"
      },
      "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [3]
      }, ],
    });

    $('.salary-btn').on('click', function() {
      $('#show_formula').hide();
      $('.show_formula').hide();
      $('#show_cal').hide();
      $('.show_cal').hide();
      var id = $(this).attr("data-id");
      var grade = $(this).data("grade");

      // Now you have the employee ID and name, you can use them as needed
      vdata = {
        id: id,
        grade: grade,
        "_token": "{{ csrf_token() }}"
      };
      $.ajax({
        url: "{{ url('get_emp_data')}}",
        type: "post",
        dataType: "html",
        data: vdata,
        success: function(data) {
          var data = JSON.parse(data);
          $("#append_salary_structure").empty();
          $.each(data, function(index, val) {
            var tr = $("<tr>");
            tr.append("<td>" + val.head_title + "</td>");
            tr.append("<td style='display:none' class='show_formula'>" + val.formula + "</td>");
            tr.append("<td style='display:none'  class='show_cal'>" + val.calculation + "</td>");
            tr.append("<td>" + val.amount + "</td>");
            // Append the table row to an existing table body
            $("#append_salary_structure").append(tr);
            $("#basicModal").modal('show');
          });


        }
      });
    });
  });
</script>

<script>
  $(document).on('click', '#show_btn', function() {
    $('#show_formula').show();
    $('.show_formula').show();
    $('#show_cal').show();
    $('.show_cal').show();
  });

  $(document).on('click', '#hide_btn', function() {
    $('#show_formula').hide();
    $('.show_formula').hide();
    $('#show_cal').hide();
    $('.show_cal').hide();
  });
</script>

<script>
  $('.salary-btn55').on('click', function() {

    $('#show_formula').hide();
    $('.show_formula').hide();
    $('#show_cal').hide();
    $('.show_cal').hide();
    var id = $(this).attr("data-id");
    var grade = $(this).data("grade");

    // Now you have the employee ID and name, you can use them as needed
    vdata = {
      id: id,
      grade: grade,
      "_token": "{{ csrf_token() }}"
    };
    $.ajax({
      url: "{{ url('get_emp_data')}}",
      type: "post",
      dataType: "html",
      data: vdata,
      success: function(data) {
        var data = JSON.parse(data);
        $("#append_salary_structure").empty();
        $.each(data, function(index, val) {
          var tr = $("<tr>");
          tr.append("<td>" + val.head_title + "</td>");
          tr.append("<td style='display:none' class='show_formula'>" + val.formula + "</td>");
          tr.append("<td style='display:none'  class='show_cal'>" + val.calculation + "</td>");
          tr.append("<td>" + val.amount + "</td>");
          // Append the table row to an existing table body
          $("#append_salary_structure").append(tr);
          $("#basicModal").modal('show');
        });


      }
    });
  });
</script>


@endsection



@endsection