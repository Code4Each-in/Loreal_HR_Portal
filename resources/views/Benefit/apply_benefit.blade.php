@section('title', 'Apply Benefits')
@section('sub-title', 'Apply Benefits')
@extends('layout.app')

@section('content')



<table class="table" id="benefits" style="width:100%">
    <thead>
        <tr>
            <th scope="col">Benefit</th>
            <th scope="col">Amount</th>
            <th scope="col">ACTION</th>
            

        </tr>
    </thead>
    <tbody>
        @if(session()->has('message'))
        <div id="successMessage" class="alert alert-success fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session()->get('message') }}
        </div>
        @endif

       @foreach($benefits as $val)
      
        <tr>
            <td scope="row">{{ $val->name }}</td>
            <td scope="row">{{ $val->amount }}</td>
            <td scope="row">
            <a href="" class="btn btn-primary apply" id="change_profile" data-id="{{ $val->id }}">Apply</a>
            </td>
        </tr>
        @endforeach 

    
    </tbody>
</table>

<!-- Update model -->


<div class="modal fade" id="detailmodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detail">Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="detail_form" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="alert alert-danger" style="display:none"></div>
                        <input type="hidden" name="benefit_id" id="benefit_id" value="">
                        <div class="form-group">
                           
                        <textarea id="detail" name="detail" rows="4" cols="60"></textarea>
                        </div>
                     
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-default">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End update model -->

  
@endsection
@section('js_scripts')
<script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //---------------------------------------------------------
             //  Data Table 
            $('#benefits').DataTable({
                searching: true,
                paging: true, // Ensure paging is enabled
                pageLength: 10, // Default number of rows per page
                lengthChange: true, // Option to change page length
                ordering: false,
                "aoColumnDefs": [
                    { "bSortable": false, "aTargets": [1] },
                ],
                language: {
                    emptyTable: "No records found"
                }
            });

            //------------------------------------------------------------------
            $('.apply').click(function(e){
                e.preventDefault();
                var benefit_id = $(this).data("id");
                $('#benefit_id').val(benefit_id);
                $
                $('#detailmodel').modal('show');
            });

            //----------------------------------------------------------------
            // Subnit Detail form
            $('#detail_form').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: '{{ url("sbt_detail") }}',
                    data: formData,
                    success: function(response) {
                      //  $('.alert-danger').html('');
                       // $('#changePasswordModal').modal('hide');
                       // location.reload();
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = JSON.parse(xhr.responseText);
                        displayErrors(errorMessage.message);
                    }
                });
            });
            function displayErrors(errors) {
        // Clear previous errors
        $('.alert-danger').html('');
        // Display each error
        $.each(errors, function(key, value) {
            $('.alert-danger').append(value);
        });
        // Show the error container
        $('.alert-danger').show();
    }
        });
    </script>
@endsection