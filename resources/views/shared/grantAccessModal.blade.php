@section('grantAccessModal'.$project->id)
@if (isset($project))
<div class="bd-example">
  <div class="modal fade" id="grantAccessModal{{$project->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
          <h4 class="modal-title" id="exampleModalLabel">Access Control for {{$project->name}}</h4>
        </div>
        <div class="modal-body">
			<label class>Grant access permission to a user:</label>
			<form form action="{{url('/admin/permissions/grant')}}" method="POST" class="form-inline">
				{!! csrf_field() !!}
				<div class="form-group">
					<select class="form-control" name="userId">
						<?php $users = ViewService::getAllUsers(); ?>
						@if (isset($users) && count($users) > 0)
						@foreach ($users as $key=>$user)
						<option value="{{$user->id}}">{{$user->email}}</option>
						@endforeach
						@endif
					</select>
				</div>
				<input type="hidden" name="projectId" value={{$project->id}}>
				<button type="submit" class="btn btn-success" type="button">Grant access</button>
			</form>
		</div>
		<div class="modal-footer">
			<div class="table-responsive m-t-1">
				<table id="usersTable" class="table table-inverted table-sm table-bordered">
					<thead>
						<tr>
							<th class="text-xs-center">Name</th>
							<th class="text-xs-center">Email</th>
							<th class="text-xs-center"></th>
						</tr>
					</thead>
					<tbody class="text-xs-center">
					<?php $users = $project->users(); ?>
					@if (isset($users) && count($users) > 0)
					@foreach ($users as $key=>$user)
						<tr class="table-warning">
							<td>{{$user ? $user->name : 'N/A'}}</td>
							<td>{{$user ? $user->email : 'N/A'}}</td>
							<td>
								@if (isset($user))
								<form action="{{url('/admin/permissions/revoke')}}" method="POST">
									{!! csrf_field() !!}
									<input type="hidden" name="userId" value={{$user->id}}>
									<input type="hidden" name="projectId" value={{$project->id}}>
									<input type="submit" value="Revoke" class="btn btn-danger btn-sm">
								</form>
								@endif
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
			@endif
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection