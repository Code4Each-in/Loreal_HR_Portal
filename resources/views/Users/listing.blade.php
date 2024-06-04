@section('title', 'Users')
@extends('layout.app')
@section('content')
<div class="create_btn">
<a class="btn btn-primary" id="createUser" data-toggle="modal" data-target="#userModal">Create User</a>
</div>

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
                <th>Role</th>
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
                <td>{{ optional($user->role)->name }}</td>

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
                    <!-- <div class="alert alert-danger" style="display:none"></div> -->
                    <div class="form-group">
                    <label for="role" class="form-label">Role<span class="text-danger">*</span></label>
                        <select name="role_id" class="form-select" id="role_id">
                            <option value="" selected>Select Role</option>
                            @foreach($all_roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <div id="role_id_error_up" class="text-danger error_ee"></div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="edit_form_id" id="edit_form_id" class="form-control">
                        <label for="firstname" class="form-label">First Name<span class="text-danger">*</span></label>
                        <input type="text" name="firstname" class="form-control" required>
                        <div id="firstname_error_up" class="text-danger error_ee"></div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="form-label">Last Name<span class="text-danger">*</span></label>
                        <input type="text" name="lastname" class="form-control" required>
                        <div id="lastname_error_up" class="text-danger error_ee"></div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                        <input type="number" name="phone" class="form-control" required>
                        <div id="phone_error_up" class="text-danger error_ee"></div>
                    </div>
                    <div class="form-group">
                        <label for="city" class="form-label">City<span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control" required>
                        <div id="city_error_up" class="text-danger error_ee"></div>
                    </div>
                    <div class="form-group">
                        <label for="state" class="form-label">State<span class="text-danger">*</span></label>
                        <input type="text" name="state" class="form-control" required>
                        <div id="state_error_up" class="text-danger error_ee"></div>
                    </div>
                    <div class="form-group">
                        <label for="zip" class="form-label">Zip<span class="text-danger">*</span></label>
                        <input type="number" name="zip" class="form-control" required>
                        <div id="zip_error_up" class="text-danger error_ee"></div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="form-label">Address<span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" required>
                        <div id="address_error_up" class="text-danger error_ee"></div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                        <div id="email_error_up" class="text-danger error_ee"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="updateForm" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--##user update modal-->

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm" method="POST" class="row g-3">
                    @csrf
                    <div class="alert alert-danger" style="display:none"></div>
                    <div class="form-group">
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
<!-- End of change password -->

<!-- Create User -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Create User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="Create_user" class="row g-3 needs-validation">
                    @csrf

                    <div class="form-group">
                        <label for="role" class="form-label">Role<span class="text-danger">*</span></label>
                        <select name="role_id" class="form-select" id="role">
                        <option value="" selected>Select Role</option>
                        @foreach($all_roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                        </select>
                        <div id="role_id_error" class="text-danger error_e"></div>
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="form-label">First Name<span class="text-danger">*</span></label>
                        <input type="text" name="firstname" class="form-control">
                        <div id="firstname_error" class="text-danger error_e"></div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="form-label">Last Name<span class="text-danger">*</span></label>
                        <input type="text" name="lastname" class="form-control">
                        <div id="lastname_error" class="text-danger error_e"></div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone<span class="text-danger">*</span></label>
                        <input type="number" name="phone" class="form-control">
                        <div id="phone_error" class="text-danger error_e"></div>
                    </div>
                    <div class="form-group">
                        <label for="city" class="form-label">City<span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control">
                        <div id="city_error" class="text-danger error_e"></div>
                    </div>
                    <div class="form-group">
                        <label for="state" class="form-label">State<span class="text-danger">*</span></label>
                        <input type="text" name="state" class="form-control">
                        <div id="state_error" class="text-danger error_e"></div>
                    </div>
                    <div class="form-group">
                        <label for="zip" class="form-label">Zip<span class="text-danger">*</span></label>
                        <input type="number" name="zip" class="form-control">
                        <div id="zip_error" class="text-danger error_e"></div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="form-label">Address<span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control">
                        <div id="address_error" class="text-danger error_e"></div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control">
                        <div id="email_error" class="text-danger error_e"></div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control">
                        <div id="password_error" class="text-danger error_e"></div>
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword" class="form-label">Confirm Password<span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" id="confirmpassword">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveuser" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--End of create user-->
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
    // Function to initialize DataTable
    function initializeDataTable() {
        $('#pagination').DataTable({
            searching: true,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 6] },
            ],
            language: {
                emptyTable: "No records found"
            }
        });
    }

    // Call the function to initialize DataTable initially
    initializeDataTable();

    // Use event delegation for status toggle
    $(document).on('click', '.status-toggle', function() {
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

    // Use event delegation for edit user data button
    $(document).on('click', '.edit-userdata-btn', function(e) {
        e.preventDefault();
        $('.error_ee').html('');
        var userId = $(this).data('user-id');
        vdata = {
            id: userId
        };
        $.ajax({
            type: 'post',
            url: "{{ url('users/edit') }}",
            data: vdata,
            success: function(response) {
                $('input[name="firstname"]').val(response.user.Fname);
                $('input[name="lastname"]').val(response.user.Lname);
                $('input[name="phone"]').val(response.user.phone);
                $('input[name="city"]').val(response.user.city);
                $('input[name="state"]').val(response.user.state);
                $('input[name="zip"]').val(response.user.zipcode);
                $('input[name="address"]').val(response.user.address);
                $('input[name="email"]').val(response.user.email);
                $('input[name="edit_form_id"]').val(response.user.id);
                
                var userRoleId = response.user.role_id;
                $('#role_id option').removeAttr('selected');
                $('#role_id option[value="' + userRoleId + '"]').attr('selected', 'selected'); 

                $('#editUserDataModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Use event delegation for delete user button
    $(document).on('click', '.delete-user-btn', function(e) {
        e.preventDefault();
        var userId = $(this).data('user-id');
        var data = {
            id: userId
        };
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

    // Use event delegation for change password button
    $(document).on('click', '.change-password-btn', function(e) {
        e.preventDefault();
        $('.alert-danger').css('display', 'none');
        var postid = $(this).data("id");
        $('#user_id').val(postid);
        $('#changePasswordModal').modal('show');
    });

    // Use event delegation for create user button
    $('#createUser').on('click', function() {
        $('.error_e').html('');
        $('.alert-danger').css('display', 'none');
        $('#Create_user')[0].reset();
        $('#userModal').modal('show');
    });

    // Use event delegation for save user button
    $(document).on('click', '#saveuser', function(e) {
        e.preventDefault();
        $('.error_e').html('');
        $.ajax({
            url: '{{ url("/save_user") }}',
            type: 'POST',
            data: $('#Create_user').serialize(),
            success: function(response) {
                $('#userModal').modal('hide');
                location.reload();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText);
                var validationErrors = errorMessage.errors;
                $.each(validationErrors, function(key, value) {
                    var html1 = '<p>' + value + '</p>';
                    $('#' + key + '_error').html(html1);
                });
            }
        });
    });

    // Use event delegation for update form button
    $(document).on('click', '#updateForm', function(e) {
        e.preventDefault();
        $('.error_ee').html('');
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
                'role_id': $("select[name=role_id]").val()
            },
            success: function(response) {
                $('#editUserDataModal').modal('hide');
                location.reload();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText);
                var validationErrors = errorMessage.errors;
                $.each(validationErrors, function(key, value) {
                    var html= '<p>'+ value +'</p>';
                    $('#' + key + '_error_up').html(html);
                });
            }
        });
    });

    // Use event delegation for change password form submit
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

    // Reset the change password modal when it's closed
    $('#changePasswordModal').on('hidden.bs.modal', function() {
        $('#changePasswordForm')[0].reset();
        $('.alert-danger').html('');
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
