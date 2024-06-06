@section('title', 'All Salary Head')
@section('sub-title', 'Master Salary Head')
@extends('layout.app')

@section('content')
<div class="create_btn">
  <a href="{{ url('master_salary_head') }}" class="btn btn-primary">Create Salary Head</a>
</div>

<table class="table" id="pagination">
  <thead>
    <tr>
      <th scope="col">Sr no</th>
      <th scope="col">Head Title</th>
      <th scope="col">Formula</th>
      <th scope="col">Amount</th>
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
    @foreach($allsalHead as $val)
    <?php $head_title = str_replace("_", " ", $val->head_title); ?> 
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $head_title }}</td>
      <td>{{ $val->formula }}</td>
      <td>{{ $val->amount }}</td>
      <td>
        <a href="{{ url('edit_salary_head/' . $val->id) }}" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
        <a href="" class="btn btn-danger delete" data-bs-toggle="modal" data-id="{{ $val->id }}" data-bs-target="#deletemodel"><i class="bi bi-trash"></i></a>

      </td>
    </tr>

    @endforeach
  </tbody>
</table>
<!--Delete  Modal -->
<form action="{{ url('delete_sal_head') }}" method="POST">
  @csrf
  <div class="modal fade" id="deletemodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<!-- End Delete Model -->

@endsection

@section('js_scripts')
<script>
  $(document).ready(function() {
    $('#pagination').DataTable({
      searching: true,
      language: {
        emptyTable: "No records found"
      },
      "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [4]
      }, ],
    });
  });
  setTimeout(function() {
    $('#successMessage').fadeOut('fast');
  }, 5000);
</script>

<script>
  $(document).ready(function() {
    $(document).on('click', '.delete', function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      $('#sal_head_id').val(id);
      $('#deletemodel').modal('show');
    });
  });
</script>

@endsection