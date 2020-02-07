@extends('adminlte::page')

@section('title', 'Company List')

@section('content')
<h1>Company Management</h1>

<div class="panel panel-default panel-main">
	<div class="panel panel-default">
		<div class="panel-heading"><strong>Company Management</strong></div>
		<div class="panel-body">
			@if (session()->has('a_text'))
			<div class="alert alert-{{ session()->get('a_type') }} alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>{{ session()->get('a_text') }}</strong>
			</div>
			@endif
			<div class="table-responsive" >
				<table id="tCompanyList" class="table table-hover table-bordered" >
					<thead>
						<tr>
								<th>Company ID</th>
								<th>Company Description</th>
								<th>Created by</th>
								<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($companies as $company)
						<tr>
								<td>{{ $company->id }}</td>
								<td>{{ $company->company_descr }}</td>
								<td>@if($company->createdby ?? ''){{ $company->createdby->name }}@endif</td>
								<td>
									<form method="post" action="{{ route('company.delete', [], false) }}" onsubmit="return confirm('Are you sure you want to delete?')">
										@csrf
										<button type="button" class="btn btn-np" title="Edit"
												data-toggle="modal"
												data-target="#editCompany"
												data-id="{{$company->id}}"
												data-compdescr="{{$company->company_descr}}"
												>
												<i class="fas fa-edit"></i>
										</button>
										<button type="submit" class="btn btn-np" title="Delete">
												<i class="fas fa-trash-alt"></i>
										</button>
										<input type="hidden" name="inputid" value="{{$company->id}}">
									</form>
								</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
			<strong style="margin-bottom: 5px;">Add New Company</strong><br>
			<form action="{{ route('company.store', [], false) }}" method="post">
				@csrf
				<div class="row" style="margin-bottom: 5px;">
					<div class="col-md-8">
						<div class="row">
							<div class="col-md-3">
								<label for="inputcomp">Company ID</label>
							</div>
							<div class="col-md-9">
								<input type="text" id="inputcomp" name="inputcomp" placeholder="company code" value="{{ old('inputcomp') }}" required autofocus>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label for="inputdescr">Company Description</label>
							</div>
							<div class="col-md-9">
								<input type="text" id="inputdescr" name="inputdescr" placeholder="company description" value="{{ old('inputdescr') }}" required autofocus>
							</div>
						</div>
					</div>
				</div>
		</div>
		<div class="panel-footer">
							<button type="submit" class="btn btn-primary">Add</button>
			</form>
		</div>
	</div>
</div>

<!-- edit Psubarea -->
<div id="editCompany" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="{{ route('company.update') }}" method="POST">
            @csrf
						<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit</h4>
            </div>
						<div class="modal-body">
							<input type="text" class="form-control hidden" id="eid" name="eid" value="">
							<div class="form-group">
										<label for="compid">Company Code</label>
										<input type="text" class="form-control" id="eid" name="eid" value="" disabled>
								</div>
								<div class="form-group">
										<label for="editdescr">Company Descr</label>
										<input type="text" class="form-control" id="editdescr" name="editdescr" value="" required autofocus>
								</div>
						</div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">SAVE</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form>
        </div>
    </div>
</div>

@stop

@section('js')
<script type="text/javascript">

$(document).ready(function() {
    $('#tCompanyList').DataTable({
        "responsive": "true",
        "order" : [[0, "asc"]]
    });
});

function populate(e){
		var ps_id = $(e.relatedTarget).data('id');
    var ps_comp = $(e.relatedTarget).data('compdescr');
    $('input[name=eid]').val(ps_id);
    $('input[name=editdescr]').val(ps_comp);
    }

$('#editCompany').on('show.bs.modal', function(e) {
    populate(e);
});

</script>
@stop
