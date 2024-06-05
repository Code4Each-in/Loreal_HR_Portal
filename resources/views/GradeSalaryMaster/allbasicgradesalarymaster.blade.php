@section('title', ' Grade Salary Master')
@section('sub-title', ' Grade Salary Master')
@extends('layout.app')

@section('content')
<div class="create_btn">
    <a href="{{ url('basic_grade') }}" class="btn btn-primary">Create Basic Salary</a>
</div>

<table class="table" id="pagination">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Head Title</th>
            <th scope="col">Formula</th>
            <th scope="col">Amount</th>
            <th scope="col">Grade</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(session()->has('error'))
        <div id="successMessage" class="alert alert-danger fade show" role="alert">
            <i class="bi bi-x-circle me-1"></i>
            {{ session()->get('error') }}
        </div>
        @endif
        @if(session()->has('message'))
        <div id="successMessage" class="alert alert-success fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session()->get('message') }}
        </div>
        @endif
        @foreach($allbasicgradesal as $val)
        <?php $head_title = str_replace("_", " ", $val['head_title']); ?>
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $head_title }}</td>
            <td>{{ $val['formula'] }}</td>
            <td>{{ $val['amount'] }}</td>
            <td>{{ $val['grade']['grade'] }}</td>
            <td>
                <a href="{{ url('edit_basic_salary/' . $val['id']) }}" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                <a href="#" class="btn btn-danger delete-btn" data-id="{{ $val['id'] }}"><i class="bi bi-trash"></i></a>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!--Delete  Modal -->
<form action="{{ url('delete_basic_sal') }}" method="POST">
    @csrf
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                    <input type="hidden" name="sal_head_id" id="sal_head_id" value="">
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
<!-- End of Delete Model -->
@endsection

@section('js_scripts')
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 5000);

        $('#pagination').DataTable({
            searching: true,
            language: {
                emptyTable: "No records found"
            },
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [5]
            }, ],
        });

        $('.delete-btn').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#sal_head_id').val(id);
            $('#deleteModal').modal('show');
        });

    });
</script>
@endsection