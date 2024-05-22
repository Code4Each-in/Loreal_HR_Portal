@extends('layout.app')
@section('content')
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
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
                    @if ($user->status == 1)
                    <button class="btn btn-danger">Inactive</button>
                    @else
                    <button class="btn btn-success">Active</button>
                    @endif
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
                <form action="" method="POST" id="update_form">
                    @csrf
                    <input type="hidden" name="id" class="form-control">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" name="firstname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" name="lastname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="number" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" name="state" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="zip">Zip</label>
                        <input type="number" name="zip" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="updateForm" class="btn btn-primary" data-user-id="{{ $user->id }}">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.change-password') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="hidden" name="user_id" id="user_id" class="form-control">
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
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
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //for edit to show the data of user
        $('.edit-userdata-btn').click(function(e) {
            e.preventDefault();
            var userId = $(this).data('user-id');
            vdata = {
                id: userId
            };
            $.ajax({
                type: 'post',
                url: "{{ url('users/edit') }}",
                data: vdata,
                success: function(response) {
                    console.log(response);
                    // Populate form fields with the received data
                    $('input[name="firstname"]').val(response.user.Fname);
                    $('input[name="lastname"]').val(response.user.Lname);
                    $('input[name="phone"]').val(response.user.phone);
                    $('input[name="city"]').val(response.user.city);
                    $('input[name="state"]').val(response.user.state);
                    $('input[name="zip"]').val(response.user.zipcode);
                    $('input[name="address"]').val(response.user.address);
                    $('input[name="email"]').val(response.user.email);
                    $('input[name="id"]').val(response.user.id);

                    $('#editUserDataModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // //to update the data of user
        // $('#updateForm').click(function(e) {

        //     e.preventDefault();
        //      var form = $('#update_form')[0];
        //     var formData = $("#update_form").serialize();
        //     // var url = $(this).attr('action');
        //     console.log(formData, 'pppppp');
        //     var userId = $(this).data('user-id');
        //     // var data = formData.user + '&id=' + userId;
        //     // console.log(data);
        //     $.ajax({
        //         type: 'post', // Change the request type to PUT
        //         url: "{{ url('users/update') }}",
        //         data: {
        //             formData:formData,
        //             id:userId
        //         },
        //         success: function(response) {
        //             // Update the table fields with new data
        //             // var userId = response.user.id;
        //             userRow.find('.user-firstname').text(response.user.Fname);
        //             userRow.find('.user-lastname').text(response.user.Lname);
        //             userRow.find('.user-phone').text(response.user.phone);
        //             userRow.find('.user-email').text(response.user.email);
        //             $('#editUserDataModal').modal('hide');

        //         },
        //         error: function(xhr, status, error) {
        //             console.error(xhr.responseText);
        //         }
        //     });
        // });

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
                url: '{{ route("user.change-password") }}',
                data: formData,
                success: function(response) {
                    $('#changePasswordModal').modal('hide');
                    alert(response.success);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
