@section('title', 'Grade Listing')
@section('sub-title', 'Grade Listing')
@extends('layout.app')

@section('content')
<?php

use App\Http\Controllers\BasicGradeController;
?>
<div class="create_btn">
    <a href="{{ url('create_grade') }}" class="btn btn-primary">Create Grade</a>
</div>


<table class="table" id="pagination" style="width:100%">
    <thead>
        <tr>
            <th scope="col">Grade</th>
            <th> Head Title</th>
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
            <td scope="row">{{ $val[0]-> grade}} </td>
            <td>
                <?php
                $head_title = BasicGradeController::head_title($val[0]->grade);
                echo $head_title;
                ?>
            </td>
            <td>
                <a href="{{ url('edit_grade/'.$val[0]->grade) }}" class="btn btn-primary update" data-id="{{$val[0]->id}}"><i class="bi bi-pencil"></i></a>
                <a class="btn btn-danger delete" id="delete_btn" data-id="{{$val[0]->grade}}"><i class="bi bi-trash"></i></a>
                <a href="{{ url('basic_grade_salary_master_listing/' . $val[0]->grade) }}" class="btn btn-primary">Grade Salary Master</a>
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
                    <div class="form-group">
                        <div class="alert alert-danger" style="display:none"></div>
                        <label for="recipient-name" class="col-form-label">Grade:</label>
                        <input type="hidden" name="sal_head_id" id="sal_head_id" value="">


                        <input type="text" class="form-control" id="edit_grade" name="grade">
                        @if ($errors->has('grade'))
                        <span class="text-danger">{{ $errors->first('grade') }}</span>
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
                    Are You sure you want to delete Grade ?
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
    $(document).ready(function() {
        $('#pagination').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [2],
                    orderable: false
                } // Changed from [3] to [2] since you have 3 columns (0, 1, 2)
            ],
            language: {
                emptyTable: "No records found"
            }
        });
    });




    $('#updateForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: "{{ url('updateBasicGrade') }}",
            data: formData,
            success: function(response) {
                // Handle success response
                $('.alert-danger').html('');
                $("#updatemodel").modal('hide');
                location.reload();


            },
            error: function(xhr, status, error) {
                // Handle error
                var errorMessage = JSON.parse(xhr.responseText);
                displayErrors(errorMessage.errors);
            }
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

    $(document).on("click", '#delete_btn', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('#head_id').val(id);
        $('#deletemodel').modal('show');
    });
</script>

@endsection