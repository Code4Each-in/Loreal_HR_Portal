
@section('title', 'Employee')
@section('sub-title', 'Employee')
@extends('layout.app')

@section('content')

<table class="table">
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
  <td>{{ $val->Fname }} {{ $val->Lname }}</td>
  <td>{{ $val->post[0]->grade }}</td>
  <td>{{ $val->post[0]->base_pay }}</td>
  <td>
  <button type="button" class="btn btn-primary salary-btn" data-id="{{ $val->id }}" data-bs-toggle="modal" data-bs-target="#basicModal">Salary</button>
  </td>
</tr>
@endforeach
  </tbody>
</table>
     <!-- Basic Modal -->
 
    <div class="modal fade" id="basicModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Basic Modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="append_emp_detail">
          
          </div>
        </div>
      </div>
    </div><!-- End Basic Modal-->

    @section('js_scripts')
    <script>
$(document).ready(function(){
  $('.salary-btn').on('click', function () {
    var id = $(this).attr("data-id");
    var name = $(this).closest('tr').find('.emp-name').text();
    
    // Now you have the employee ID and name, you can use them as needed
    vdata = {id:id, "_token": "{{ csrf_token() }}"};
    $.ajax({
      url: "{{ url('get_emp_data')}}",
      type: "post",
      dataType: "html",
      data: vdata,
      success:function(data){
        $('#append_emp_detail').html(data);
      }
    });
  });
});
</script>

    @endsection



@endsection