@section('title', 'Employee Benefits')
@section('sub-title', 'Employee Benefits')
@extends('layout.app')

@section('content')
<div  class="create_btn">
<a href="{{ route('employee_benefits.create') }}" class="btn btn-primary">Create Benefits</a>
</div>


<table class="table" id="pagination" style="width:100%">
    <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Grade</th>
            <th scope="col">Amount</th>
            <th scope="col">Action</th>

        </tr>
    </thead>
    <tbody>
        @if(session()->has('message'))
        <div id="successMessage" class="alert alert-success fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session()->get('message') }}
        </div>
        @endif

        @foreach($employeeBenefits as $val)
        <tr>
            <td scope="row">{{ $val->name}} </td>
            <td scope="row">{{ $val->grade->grade  }} </td>
            <td scope="row">{{ $val->amount}} </td>

            <td>
               <a href="#" class="btn btn-primary update" data-id="{{$val->id}}"><i class="bi bi-pencil"></i></a>
                <a href="" class="btn btn-danger delete" data-id ="{{$val->id}}"><i class="bi bi-trash"></i></a>

            </td>
        </tr>

        @endforeach
    </tbody>
</table>

<!-- Update model -->


<div class="modal fade" id="updatemodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">UPDATE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <div class="alert alert-danger" style="display:none"></div>
                        <input type="hidden" name="emp_benefit_id" id="emp_benefit_id" value="">
                        <div class="form-group">
                            <label for="edit_name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="edit_name" name="name">
                            @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="edit_grade" class="col-form-label">Grade:</label>
                            <select class="form-select" name="grade_id" id="edit_grade">
                                <option value="" selected>Select Grade</option>
                                @foreach($all_grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                                @endforeach
                            </select>
                            <div>
                                @if ($errors->has('grade_id'))
                                <span class="text-danger">{{ $errors->first('grade_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_amount" class="col-form-label">Amount:</label>
                            <input type="text" class="form-control" id="edit_amount" name="amount">
                            @if ($errors->has('amount'))
                            <span class="text-danger">{{ $errors->first('amount') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End update model -->

           <!--Delete  Modal -->
           
            <div class="modal fade" id="deletemodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <form action="{{ route('employee_benefits.delete') }}" method="POST">
                            @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                           
                            <input type="hidden" name="id" id="benefit_id" value="">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are You want to delete
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">DELETE</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        <!-- End Delete Model -->
@endsection
@section('js_scripts')
<script>
    $(document).ready(function(){
         $('#pagination').DataTable({
            searching: true,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 1] },
            ],
            language: {
                emptyTable: "No records found"
            }
        });

        $('.delete').click(function(e){
            console.log("here");
            e.preventDefault();
            var id = $(this).data('id');
            // console.log(id, "id");
          $('#benefit_id').val(id);
         $val =  $('#benefit_id').val();
          console.log($val, "val");
          $('#deletemodel').modal('show');
          console.log("here after show");
        });


         // Handle the update button click
        $('.update').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: "{{ route('employee_benefits.edit', ':id') }}".replace(':id', id),
                type: "GET",
                success: function(data) {
                    var data = JSON.parse(data);
                    $('#emp_benefit_id').val(data.id);
                    $('#edit_name').val(data.name);
                    $('#edit_grade').val(data.grade_id);
                    $('#edit_amount').val(data.amount);
                    $('#updateForm').attr('data-id', data.id);
                    $('#updatemodel').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Handle form submission for update
        $('#updateForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#emp_benefit_id').val();  // Get the employee benefit ID
            var formData = $(this).serialize();

            $.ajax({
                type: 'PUT', // Use PUT method for resource update
                url: "{{ route('employee_benefits.update', ':id') }}".replace(':id', id),
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#updatemodel').modal('hide');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText);
                    displayErrors(errorMessage.errors);
                }
            });
        });



    });


    function displayErrors(errors) {
        // Clear previous errors
        $('.alert-danger').html('');
        // Display each error
        $.each(errors, function(key, value) {
            $('.alert-danger').append('<li>' + value + '</li>');
        });
        // Show the error container
        $('.alert-danger').show();
    }

    setTimeout(function() {
        $('#successMessage').fadeOut('fast');
    }, 2000);

   

</script>
@endsection
