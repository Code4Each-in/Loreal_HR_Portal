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
                    <a href="" class="btn btn-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a href="" class="btn btn-danger">
                        <i class="bi bi-trash"></i>
                    </a>
                    <a href="#" class="btn btn-warning change-password-btn" data-toggle="modal" data-target="#changePasswordModal">
                        <i class="bi bi-key"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="modal-footer">
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
        $('.change-password-btn').click(function(e) {
            e.preventDefault();
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
