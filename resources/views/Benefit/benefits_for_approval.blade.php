@section('title', 'Benefits For Approval')
@section('sub-title', 'Benefits For Approval')
@extends('layout.app')

@section('content')

<div class="tabs-design">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all_approval" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false" tabindex="-1">ALL</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="all_approved" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false" tabindex="-1" data-id="1">Approved</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="all_pending" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1" data-id="2">Pending</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="all_rejected" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1" data-id="3">Rejected</button>
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
<!-- Your DataTable initialization script -->
<script>
var approval;

$(document).ready(function() {
    // DataTable initialization
    const baseUrl = "{{ url('/') }}";
    var ajaxUrl = "{{ route('approval_benefits.index') }}";

    approval = $('#approval').DataTable({
        processing: true,
        serverSide: true,
        tooltip: true,
        ajax: ajaxUrl, // Initial AJAX URL
        paging: true,
        pageLength: 10,
        columns: [
            {
                name: 'User',
                render: function(data, type, row) {
                    return row.users[0].Fname ?? 'NA';
                }
            },
            {
                name: 'Benefit',
                render: function(data, type, row) {
                    return row.employee_benefit[0].name ?? 'NA';
                }
            },
            {
                name: 'Amount',
                render: function(data, type, row) {
                    return row.employee_benefit[0].amount ?? 'NA';
                }
            },
            {
                name: 'Status',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (row.status == {{ config('app.APPROVED') }}) {
                            var action = '<div class="table-btndesign">' +
                                '<a href="javascript:void(0)" class="btn btn-success">Approved</a>' +
                                '</div>';
                            return action;
                        }
                        else if (row.status == {{ config('app.PENDING') }}) {
                        var action = '<div class="table-btndesign">' +
                            '<a href="javascript:void(0)" id="approve" class="btn btn-success" data-userid="' + row.user_id + '" data-benefitID="' + row.benefit_id + '">Approve</a>' +
                            '<a href="javascript:void(0)" id="reject" class="btn btn-danger" data-userid="' + row.user_id + '" data-benefitID="' + row.benefit_id + '">Reject</a>' +
                            '</div>';
                        return action;
                    } else if (row.status == {{ config('app.REJECTED') }}) {
                        var action = '<div class="table-btndesign">' +
                            '<a href="javascript:void(0)" class="btn btn-danger">Rejected</a>' +
                            '</div>';
                        return action;
                    }
                    return '';
                }
            }
        ],
        rowCallback: function(row, data) {
            $(row).addClass('row_status_' + data.id); // Add a CSS class to the row
        }
    });

    // Event listener for clicking the button to change AJAX URL
    //------------------------------------------------------------------
    // All Approved Approval
    $('#all_approved').click(function() {
        ajaxUrl = "{{ route('approval_benefits.index') }}?status=1"; 
        approval.ajax.url(ajaxUrl).load(); 
    });

    //------------------------------------------------------------------
    // all pending approval
    $('#all_pending').click(function() {
        ajaxUrl = "{{ route('approval_benefits.index') }}?status=2"; 
        approval.ajax.url(ajaxUrl).load(); 
    });
    //------------------------------------------------------------------
  // all rejected approval
    $('#all_rejected').click(function() {
        ajaxUrl = "{{ route('approval_benefits.index') }}?status=3"; 
        approval.ajax.url(ajaxUrl).load(); 
    });
    //------------------------------------------------------------------
   // all approval whether it is approves , rejected or pending 
    $('#all_approval').click(function() {
        ajaxUrl = "{{ route('approval_benefits.index') }}"; 
        approval.ajax.url(ajaxUrl).load(); 
    });
    //------------------------------------------------------------------

});

</script>


<script>
$(document).on("click", '#approve', function(event) { 
  var userid = $(this).data('userid');
  var benefitId = $(this).data('benefitid');
  
  // Ask for confirmation
  if (confirm('ARE YOU SURE YOU WANT TO APPROVE THIS REQUEST ?')) {
    var vdata = { userid: userid, benefitId: benefitId };

    $.ajax({
      url: "{{ route('approve_benefit.index') }}",
      type: "POST",
      data: vdata,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data) {
          var actionContainer = $(event.target).closest('.table-btndesign');
          actionContainer.find('#reject').remove(); // Remove the Reject button
          $(event.target).removeClass('btn-success').addClass('btn-success').text('Approved');
        }
      },
      error: function(request, status, error) {
        alert(request.responseText);
      }
    });
  }
});
</script>


<script>
$(document).on("click", '#reject', function(event) { 
  var userid = $(this).data('userid');
  var benefitId = $(this).data('benefitid');
  
  // Ask for confirmation
  if (confirm("ARE YOU SURE YOU WANT TO REJECT THIS APPROVAL ?")) {
    var vdata = {userid: userid, benefitId: benefitId};

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
              $(event.target).removeClass('btn-danger').addClass('btn-danger').text('Rejected');
          }
      },
      error: function (request, status, error) {
          alert(request.responseText);
      }
    });
  }
});
</script>


<!-- <script>
 $('#all_approved').click(function(){
 // var querySearch =  $(location).attr('href')
 // alert("Formatted url is: " + querySearch + "?approved");
  var currentUrl = window.location.href;
            var newUrl = currentUrl + (currentUrl.indexOf('?') === -1 ? '?' : '&') + 'status=approved';
            window.location.href = newUrl;
 });
  </script> -->

@endsection