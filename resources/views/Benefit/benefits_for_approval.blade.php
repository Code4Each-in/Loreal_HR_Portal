@section('title', 'Benefits For Approval')
@section('sub-title', 'Benefits For Approval')
@extends('layout.app')

@section('content')

<div class="tabs-design">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false" tabindex="-1">ALL</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false" tabindex="-1">Approved</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Pending</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Rejected</button>
        </li>
    </ul>
</div>


<table class="table" id="approval" style="width:100%">
    <thead>
        <tr>
            <th scope="col">User</th>
            <th scope="col">Benefit</th>
            <th scope="col">Amount</th>
            <th scope="col">Status</th>


        </tr>
    </thead>

</table>




@endsection
@section('js_scripts')

<script>
  var approval;
$(document).ready(function() {
    // DataTable initialization
    const baseUrl = "{{ url('/') }}";
    approval = $('#approval').DataTable({
            processing: true,
            serverSide: true,
            tooltip:true,
            ajax: "{{ route('approval_benefits.index') }}",
            paging: true, 
            pageLength: 10, 
            columns: [
                { name: 'User', 
                    render: function (data, type, row) {
                     //console.log(row.user_id);
                      return row.users[0].Fname ?? 'NA';    
                    }
                },
                { name: 'Benefit', 
                    render: function (data, type, row) {
                     
                      return row.employee_benefit[0].name ?? 'NA';    
                    }
                },
                { name: 'Amount', 
                    render: function (data, type, row) {
                      return row.employee_benefit[0].amount  ?? 'NA';    
                    }
                },
                {
                    name: 'Status',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                     if(row.status == 1){
                        var action = '';
                        action += '<div class="table-btndesign">';
                        action += '<a href="javascript:void(0)" class="btn btn-success">Approved</a>';
                       
                        action += '</div>';
                        return action;
                     }    if(row.status == 2){
                        var action = '';
                        action += '<div class="table-btndesign">';
                        action += '<a href="javascript:void(0)" id="approve" class="btn btn-success" data-userid="' + row.user_id + '" data-benefitID="' + row.benefit_id + '">Approve</a>';
                        action += '<a href="javascript:void(0)" id="reject" class="btn btn-danger" data-userid="' + row.user_id + '" data-benefitID="' + row.benefit_id + '">Reject</a>';
                        return action;
                     }
                     if(row.status == 3){
                        var action = '';
                        action += '<div class="table-btndesign">';
                        action += '<a href="javascript:void(0)" class="btn btn-danger">Rejected</a>';
                        return action;
                     }
              
                      
                    }
                }
            ],
            rowCallback: function (row, data) {
                $(row).addClass('row_status_'+data.id); // Add a CSS class to the row
            }
    });
  
  });
</script>

<script>
$(document).on("click", '#approve', function(event) { 
  var userid = $(this).data('userid');
  var benefitId = $(this).data('benefitid');
  vdata = {userid: userid, benefitId: benefitId};

  $.ajax({
    url: "{{ route('approve_benefit.index') }}",
    type : "POST",
    data: vdata,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success:function(data){
        if(data){
            var actionContainer = $(event.target).closest('.table-btndesign');
                actionContainer.find('#reject').remove(); // Remove the Reject button
                $(event.target).removeClass('btn-success').addClass('btn-secondary').text('Approved');
        }
       
   },
    error: function (request, status, error) {
        alert(request.responseText);
    }
   
  });
 
});
</script>

<script>
$(document).on("click", '#reject', function(event) { 
  var userid = $(this).data('userid');
  var benefitId = $(this).data('benefitid');
  vdata = {userid: userid, benefitId: benefitId};

  $.ajax({
    url: "{{ route('reject_benefit.index') }}",
    type : "POST",
    data: vdata,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success:function(data){
        if(data){
            var actionContainer = $(event.target).closest('.table-btndesign');
                actionContainer.find('#approve').remove(); // Remove the Approve button
                $(event.target).removeClass('btn-danger').addClass('btn-secondary').text('Rejected');
        }
       
   },
    error: function (request, status, error) {
        alert(request.responseText);
    }
   
  });
 
});
</script>

@endsection