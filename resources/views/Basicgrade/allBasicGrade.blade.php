@section('title', 'All Salary Head')
@section('sub-title', 'All Salary Head')
@extends('layout.app')

@section('content')

<table class="table  table-striped">
    <thead>
        <tr>
            <th scope="col">Grade</th>
            <th scope="col">Basic Salary</th>
            <th scope="col">Action</th>

        </tr>
    </thead>
    <tbody>
        @if(session()->has('message'))
        <div class="alert alert-success fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session()->get('message') }}
        </div>
        @endif

        @foreach($basic_grades as $val)
        <tr>
            <th scope="row">{{ $val-> grade}} </th>
            <td>{{ $val-> basic_salary}}</td>

            <td>
            <a href="#" class="btn btn-primary update" data-id="{{$val->id}}"><i class="bi bi-pencil"></i></a>
                <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletemodel-{{$val-> id}}"><i class="bi bi-trash"></i></a>

            </td>
        </tr>


                <!--Delete  Modal -->
                <form action="{{ url('deleteBasicGrade') }}" method="POST">
            @csrf
            <div class="modal fade" id="deletemodel-{{$val-> id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                            <input type="hidden" name="sal_head_id" value="{{$val-> id}}">
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

        
        @endforeach
    </tbody>
</table>

<!-- Update model -->


            <div class="modal fade" id="deletemodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                            <input type="hidden" name="sal_head_id" value="{{$val-> id}}">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are You want to delete
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
        


<!-- End update model -->
@endsection
@section('js_scripts')
<script>
    $(document).ready(function(){
        $('.update').click(function(e){
            e.preventDefault(); 
            var id = $(this).data('id'); 
            $('#deletemodel').modal('show'); 
           
        });
    });
</script>

@endsection