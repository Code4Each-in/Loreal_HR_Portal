@section('title', 'Grade Listing')
@section('sub-title', 'Grade Listing')
@extends('layout.app')

@section('content')
<div  class="create_btn">
<a href="{{ url('create_grade') }}" class="btn btn-primary">Create Grade</a>
</div>


<table class="table" id="pagination" style="width:100%">
    <thead>
        <tr>
            <th scope="col">Grade</th>
            <!-- <th scope="col">Basic Salary</th> -->
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

        @foreach($basic_grades as $val)
        <tr>
            <th scope="row">{{ $val-> grade}} </th>
            <!-- <td>{{ $val-> basic_salary}}</td> -->

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
                        <form id="updateForm"  method="post">
                            @csrf
                        <div class="form-group">
                        <div class="alert alert-danger" style="display:none"></div>
                            <label for="recipient-name" class="col-form-label">Grade:</label>
                            <input type="hidden" name="sal_head_id" id="sal_head_id" value="">


                            <input type="text" class="form-control" id="edit_grade" name="grade">
                            @if ($errors->has('grade'))
                            <span class="text-danger">{{ $errors->first('grade') }}</span>
                            @endif
                        </div>
                        <!-- <div class="form-group">
                            <label for="message-text" class="col-form-label">Basic Salary:</label>
                            <input type="text" class="form-control" id="edit_basic_salary" name="basic_salary">
                            @if ($errors->has('basic_salary'))
                            <span class="text-danger">{{ $errors->first('basic_salary') }}</span>
                            @endif
                        </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">UPDATE</button>
                        </div>
                        </form>


                    </div>
                </div>
            </div>
<!-- End update model -->

           <!--Delete  Modal -->
           <form action="{{ url('deleteBasicGrade') }}" method="POST">
            @csrf
            <div class="modal fade" id="deletemodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                            <input type="hidden" name="sal_head_id" id="head_id" value="">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are You want to delete
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">DELETE</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- End Delete Model -->
@endsection
@section('js_scripts')
<script>
    $(document).ready(function(){
         $('#pagination').DataTable({
            searching: true,
            language: {
                emptyTable: "No records found"
            }
        });
        $('.update').click(function(e){
            e.preventDefault();
            var id = $(this).data('id');

            var token = "{{ csrf_token() }}";
            var vdata = {id:id, _token: token};

            $.ajax({
                url : "{{ url('editBasicGrade')}}",
                type : "post",
                data: vdata,
                success:function(data){
                    var data = JSON.parse(data);
                    $('#sal_head_id').val(data.id);
                    $('#edit_grade').val(data.grade);
                    // $('#edit_basic_salary').val(data.basic_salary);
                    $('#updatemodel').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        });
    });
</script>

<script>
    $(document).ready(function(){
        $('#updateForm').on('submit', function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "{{ url('updateBasicGrade') }}",
                data: formData,
                success: function(response){
                    // Handle success response
                    $('.alert-danger').html('');
                   $("#updatemodel").modal('hide');
                  location.reload();


                },
                error: function(xhr, status, error){
                    // Handle error
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
</script>

<script>
    setTimeout(function() {
        $('#successMessage').fadeOut('fast');
    }, 2000);
</script>

<script>
    $(document).ready(function(){
        $('.delete').click(function(e){
            e.preventDefault();
            var id = $(this).data('id');
          $('#head_id').val(id);
          $('#deletemodel').modal('show');





        });
    });
</script>






@endsection
