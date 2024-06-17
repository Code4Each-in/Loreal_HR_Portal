@extends('layout.app')
@section('title', 'Roles')
@section('sub-title', 'Roles')
@section('content')

<!-- Buttons to trigger modals -->
 <div class="create_btn">
<button class="btn btn-primary1 " onClick="openroleModal()" href="javascript:void(0)">Add Role</button>
</div>
@if(session()->has('message'))
<div id="successMessage" class="alert alert-success fade show" role="alert">
    <i class="bi bi-check-circle me-1"></i>
    {{ session()->get('message') }}
</div>
@endif

<!-- Role Table -->
<table class="table  dashboard" id="role_table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($roleData as $roles)
        <tr>
            <td>{{ $roles->name }}</td>
            <td>
                <a href="" class="btn btn-primary edit-userdata-btn" data-bs-toggle="modal" data-bs-target="#editRoleModal" onClick="editRole('{{ $roles->id }}')" data-user-id="">
                    <i class="bi bi-pencil"></i>
                </a>
                <a href="#" class="btn btn-danger delete-user-btn" data-user-id="" onClick="deleteRole('{{ $roles->id }}')">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!--start: Add role Modal -->
<div class="modal fade" id="addRole" tabindex="-1" aria-labelledby="role" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="role">Add Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="addRoleForm" action="">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger" style="display:none"></div>

                    <div class="row mb-3">
                        <label for="role_name" class="col-sm-3 col-form-label required">First Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="role_name" id="role_name">
                        </div>
                    </div>

                    <label class="mb-2" for="permission">Permissions:</label>
                    @forelse($pages as $page)
                    <div class="row mb-4 permission_cont_row">
                        <div class="col">
                            <label class="form-check-label permissionLabel" for=""> {{$page->name}}</label>
                        </div>
                        @forelse($page->module as $val)
                        <div class="form-check col">
                            <label class="form-check-label" for="{{'listing_page_'.$val->id}}">
                                {{$val->module_name}}</label>
                            <input class="form-check-input" name="role_permissions[]" type="checkbox" id="{{'listing_page_'.$val->id}}" value="{{$val->id}}">
                        </div>
                        @empty
                        @endforelse
                    </div>
                    @empty
                    @endforelse
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onClick="addRole()" href="javascript:void(0)">Save</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
<!--end: Add department Modal -->

<!--start: Edit department Modal -->
<div class="modal fade" id="editRole" tabindex="-1" aria-labelledby="editRoleLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleLabel">Edit role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="editRoleForm" action="">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger" style="display:none"></div>

                    <div class="row mb-3">
                        <label for="edit_role_name" class="col-sm-3 col-form-label required">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="edit_role_name" id="edit_role_name">
                        </div>
                    </div>
                    <input type="hidden" class="form-control" name="role_id" id="hidden_role_id" value="">
                    <label class="mb-2" for="permission">Permissions:</label>
                    @forelse($pages as $page)
                    <div class="row mb-4 permission_cont_row">
                        <div class="col">
                            <label class="form-check-label permissionLabel" for=""> {{$page->name}}</label>
                        </div>
                        @forelse($page->module as $val)
                        <div class="form-check col">
                            <label class="form-check-label" for="{{'role_permissions_'.$val->id}}">
                                {{$val->module_name}}</label>
                            <input class="form-check-input" name="role_permissions[]" type="checkbox" id="{{'role_permissions_'.$val->id}}" value="{{$val->id}}">
                        </div>
                        @empty
                        @endforelse
                    </div>
                    @empty
                    @endforelse
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary update_btn" onClick="updateRole()" href="javascript:void(0)">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end: Edit role Modal -->
<!--Delete  Modal -->
<form id="delete_form" method="POST">
    @csrf
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                    <input type="hidden" name="role_id" id="role_id" value="">

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are You Sure you  want to delete Role ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="delete_btn" class="btn btn-primary">DELETE</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End of Delete Model -->

@endsection

@section('js_scripts')
<script>
$(document).ready(function() {
    $('#role_table').DataTable({
      searching: true,
      language: {
        emptyTable: "No records found"
      },
      "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [1]
      }, ],
    });
});
</script>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#successMessage').fadeOut("slow");
        }, 2000);
  
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    function openroleModal() {
        $('#role_name').val('');
        $('#addRole').modal('show');
    }

    function addRole() {
        $.ajax({
            type: 'POST',
            url: "{{ url('/add/role') }}",
            data: $('#addRoleForm').serialize(),
            cache: false,
            success: (data) => {
                if (data.errors) {
                    $('.alert-danger').html('');
                    $.each(data.errors, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<li>' + value + '</li>');
                    });
                } else {
                    $('.alert-danger').html('');
                    $("#addRoleModal").modal('hide');
                    location.reload();
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    function editRole(id) {
        $('#hidden_role_id').val(id);
        $.ajax({
            type: "POST",
            url: "{{ url('/edit/role') }}",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                if (res.role != null) {
                    $('#editRole').modal('show');
                    $('#edit_role_name').val(res.role.name);
                }
                $('input[type=checkbox]').prop('checked', false);
                if (res.RolePermission != null) {
                    $.each(res.RolePermission, function(key, value) {
                        $('#role_permissions_' + value.module_id).prop('checked', true);
                    });
                }
            }
        });
    }

    function updateRole() {
        $.ajax({
            type: "POST",
            url: "{{ url('/update/role') }}",
            data: $('#editRoleForm').serialize(),
            dataType: 'json',
            success: (res) => {
                if (res.errors) {
                    $('.alert-danger').html('');
                    $.each(res.errors, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<li>' + value + '</li>');
                    });
                } else {
                    $('.alert-danger').html('');
                    $("#editRoleModal").modal('hide');
                    location.reload();
                }
            }
        });
    }

    function deleteRole(id) {
        $('#role_id').val(id);
        $("#deleteModal").modal('show');
    }

  

    $("#delete_form").submit(function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        $.ajax({
            type: "POST",
            url: "{{ url('/delete/role') }}",
            data: $('#delete_form').serialize(),
            dataType: 'json',
            success: (res) => {
                if (res.success) {
                    $("#deleteModal").modal('hide');
                    location.reload(); 
                } else {
                    alert('An error occurred: ' + res.message);
                }
            },
            error: (xhr, status, error) => {
                alert('An AJAX error occurred: ' + error);
            }
        });
    });
</script>
@endsection




