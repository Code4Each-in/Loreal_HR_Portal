@extends('layout.app')
@section('content')
<div class="container">
    @if(session()->has('message'))
    <div id="successMessage" class="alert alert-success fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ session()->get('message') }}
    </div>
    @endif
    <table class="table dataTable" id="pagination" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Status</th>
                <th width="150px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->Fname }} {{ $user->Lname }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <button class="status-toggle btn {{ $user->status == 1 ? 'btn-danger' : 'btn-success' }}" data-user-id="{{ $user->id }}" data-status="{{ $user->status }}">
                        {{ $user->status == 1 ? 'Inactive' : 'Active' }}
                    </button>
                </td>
                <td>
                    <a href="" class="btn btn-primary edit-userdata-btn" data-toggle="modal" data-target="#editUserDataModal" data-user-id="{{ $user->id }}">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a href="#" class="btn btn-danger delete-user-btn" data-user-id="{{ $user->id }}">
                        <i class="bi bi-trash"></i>
                    </a>

                    <a href="#" class="btn btn-warning change-password-btn" data-id="{{ $user->id  }}" data-toggle="modal" data-target="#changePasswordModal">
                        <i class="bi bi-key"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Edit UserData Modal -->
<div class="modal fade" id="editUserDataModal" tabindex="-1" role="dialog" aria-labelledby="editUserDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserDataModalLabel">Update Your Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="update_form" class="row g-3 needs-validation">
                    @csrf
                    <div class="alert alert-danger" style="display:none"></div>
                    <div class="form-group">
                        <input type="hidden" name="edit_form_id" id="edit_form_id" class="form-control">
                        <label for="firstname" class="form-label">First Name<span class="text-danger">*</span></label>
                        <input type="text" name="firstname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="form-label">Last Name<span class="text-danger">*</span></label>
                        <input type="text" name="lastname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                        <input type="number" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="city" class="form-label">City<span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="state" class="form-label">State<span class="text-danger">*</span></label>
                        <input type="text" name="state" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="zip" class="form-label">Zip<span class="text-danger">*</span></label>
                        <input type="number" name="zip" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address" class="form-label">Address<span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="updateForm" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!--##user update modal-->

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="alert alert-danger" style="display:none"></div>
                        <label for="password">New Password<span class="text-danger">*</span></label>
                        <input type="hidden" name="user_id" id="user_id" class="form-control">
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password<span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 3000);
    });

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#pagination').DataTable({
            searching: true,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 5] },
            ],
            language: {
                emptyTable: "No records found"
            }
        });
        //for active and inactive user->status(0,1)
        $('.status-toggle').click(function() {
            var userId = $(this).data('user-id');
            var status = $(this).data('status');

            $.ajax({
                url: "{{ url('/toggle-user-status') }}",
                method: 'GET',
                data: {
                    userId: userId,
                    status: status
                },
                success: function(response) {
                    // console.log(response);userdata
                    if (response) {

                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText);
                    displayErrors(errorMessage.error);
                }
            });
        });

        //for edit to show the data of user
        $('.edit-userdata-btn').click(function(e) {
            e.preventDefault();
            var userId = $(this).data('user-id');
            // $('#user_id').val(userId);
            vdata = {
                id: userId
            };
            $.ajax({
                type: 'post',
                url: "{{ url('users/edit') }}",
                data: vdata,
                success: function(response)
                {

                    $('input[name="firstname"]').val(response.user.Fname);
                    $('input[name="lastname"]').val(response.user.Lname);
                    $('input[name="phone"]').val(response.user.phone);
                    $('input[name="city"]').val(response.user.city);
                    $('input[name="state"]').val(response.user.state);
                    $('input[name="zip"]').val(response.user.zipcode);
                    $('input[name="address"]').val(response.user.address);
                    $('input[name="email"]').val(response.user.email);
                    $('input[name="edit_form_id"]').val(response.user.id);

                    $('#editUserDataModal').modal('show');

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        //to update the data of user
        $('#updateForm').click(function(e) {

            e.preventDefault();
            $.ajax({
                type: 'post',
                url: "/users/update",
                data:
                {
                    'firstname': $("input[name=firstname]").val(),
                    'lastname': $("input[name=lastname]").val(),
                    'phone': $("input[name=phone]").val(),
                    'city': $("input[name=city]").val(),
                    'state': $("input[name=state]").val(),
                    'zip': $("input[name=zip]").val(),
                    'address': $("input[name=address]").val(),
                    'email': $("input[name=email]").val(),
                    'edit_form_id': $("input[name=edit_form_id]").val(),
                },
                success: function(response) {
                    $('#editUserDataModal').modal('hide');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText);
                    var validationErrors = errorMessage.errors;
                    var html = "<ul>";
                    $.each(validationErrors, function(key, value) {
                        console.log(value);

                        html += "<li>" + value + "</li>";
                    });
                    html += "</ul>";
                    $('.alert-danger').html(html);
                    $('.alert-danger').show();
                }
            });
        });

        //for deleting user detail
        $('.delete-user-btn').click(function(e) {
            e.preventDefault();
            var userId = $(this).data('user-id');
            data = {
                id: userId
            };
            console.log(data);
            // Display a confirmation dialog
            var confirmDelete = confirm("Are you sure you want to delete this user?");
            if (confirmDelete) {
                $.ajax({
                    type: 'DELETE',
                    url: "{{ url('/users/delete') }}",
                    data: data,
                    success: function(response) {
                        console.log(response.success);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });


        //for changing the password
        $('.change-password-btn').click(function(e) {
            e.preventDefault();
            var postid = $(this).data("id");
            //alert(postid);
            $('#user_id').val(postid);
            $('#changePasswordModal').modal('show');
        });
        $('#changePasswordForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '{{ url("/users/change-password") }}',
                data: formData,
                success: function(response) {
                    $('.alert-danger').html('');
                    $('#changePasswordModal').modal('hide');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText);
                    displayErrors(errorMessage.error);
                }
            });
        });
        $('#changePasswordModal').on('hidden.bs.modal', function() {
            // Reset the form fields
            $('#changePasswordForm')[0].reset();
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
</script>
@endsection
