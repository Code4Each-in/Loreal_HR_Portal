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
                    <button class="btn btn-danger inactive-btn" data-user-id="{{ $user->id }}">Inactive</button>
                    @else
                    <button class="btn btn-success active-btn" data-user-id="{{ $user->id }}">Active</button>
                    @endif
                </td>
                <td>
                    <a href="" class="btn btn-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a href="" class="btn btn-danger">
                        <i class="bi bi-trash"></i>
                    </a>
                    <a href="" class="btn btn-warning">
                        <i class="bi bi-key"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('js_scripts')
<script>
   $(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.active-btn').click(function () {
        var userId = $(this).data('user-id');
        // Show confirmation dialog before activating the user
        if (confirm('Are you sure you want to activate this user?')) {
            activateUser(userId);
        }
    });

    $('.inactive-btn').click(function () {
        var userId = $(this).data('user-id');
        // Show confirmation dialog before deactivating the user
        if (confirm('Are you sure you want to deactivate this user?')) {
            deactivateUser(userId);
        }
    });

    function activateUser(userId) {
    $.ajax({
        url: '/users/' + userId + '/activate',
        type: 'POST',
        data: {_token: '{{ csrf_token() }}'},
        success: function (response) {
            if (response.status === 'success') {
                var btn = $('.active-btn[data-user-id="' + userId + '"]');
                btn.text('Inactive').removeClass('btn-success').addClass('btn-danger');

                // Reassign the event listener for inactive buttons
                btn.removeClass('active-btn').addClass('inactive-btn').off('click').click(function () {
                    var userId = $(this).data('user-id');
                    if (confirm('Are you sure you want to deactivate this user?')) {
                        deactivateUser(userId);
                    }
                });
            }
        },
        error: function () {
            alert('Failed to activate user');
        }
    });
}

function deactivateUser(userId) {
    $.ajax({
        url: '/users/' + userId + '/deactivate',
        type: 'POST',
        data: {_token: '{{ csrf_token() }}'},
        success: function (response) {
            if (response.status === 'success') {
                var btn = $('.inactive-btn[data-user-id="' + userId + '"]');
                btn.text('Active').removeClass('btn-danger').addClass('btn-success');

                // Reassign the event listener for active buttons
                btn.removeClass('inactive-btn').addClass('active-btn').off('click').click(function () {
                    var userId = $(this).data('user-id');
                    if (confirm('Are you sure you want to activate this user?')) {
                        activateUser(userId);
                    }
                });
            }
        },
        error: function () {
            alert('Failed to deactivate user');
        }
    });
}

});

</script>
@endsection
