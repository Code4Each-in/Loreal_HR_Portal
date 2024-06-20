@section('title', 'Employees')
@section('sub-title', 'Employees')
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
@endsection

@section('js_scripts')
<script>
  var pendingCatalogsTable;
$(document).ready(function() {
    // DataTable initialization
    const baseUrl = "{{ url('/') }}";
    pendingCatalogsTable = $('#emp_table').DataTable({
            processing: true,
            serverSide: true,
            tooltip:true,
            ajax: "{{ route('emp_listing') }}",
            paging: true, // Enable server-side pagination
            pageLength: 10, // Initial number of entries per page
            columns: [
                { name: 'Name', 
                    render: function (data, type, row) {
                     
                      return row.Fname ?? 'NA';    
                    }
                },
                { name: 'Grade', 
                    render: function (data, type, row) {
                      return row.user_detail[0].grade ?? 'NA';    
                    }
                },
                { name: 'Base Pay', 
                    render: function (data, type, row) {
                      return row.user_detail[0].base_pay ?? 'NA';    
                    }
                },
                {
                    name: 'Action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                    return `<a href="${baseUrl}/salary_struc/${row.id}" class="btn btn-primary salary-btn55">Salary Structure</a>`;
                }
                }


            ],
            rowCallback: function (row, data) {
                $(row).addClass('row_status_'+data.id); // Add a CSS class to the row
            }
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



