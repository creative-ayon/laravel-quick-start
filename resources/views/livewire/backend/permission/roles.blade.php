<div>
	<div class="page-header d-print-none">
		<div class="container-xl">
			<div class="row g-2 align-items-center col-md-8">
				<div class="col">
                    <div class="page-pretitle">{{ __('permission.add_edit_delete_roles') }}</div>
					<h2 class="page-title">{{ __('permission.roles') }}</h2>
				</div>

				<div class="col-auto ms-auto d-print-none">
					<span class="d-none d-sm-inline">
						<input type="text" class="form-control" wire:model.live='search' placeholder="Search here">
					</span>
				</div>
			</div>
		</div>
	</div>

	<div class="page-body">
		<div class="container-xl">
			<div class="row row-deck row-cards">
				<div class="col-12 col-xxl-8 col-lg-8 col-md-12 col-sm-12">
					<div class="card">
						<div class="table-responsive">
							<table class="table card-table table-vcenter text-nowrap datatable fs-5">
								<thead>
									<tr>
										<th>#</th>
										<th>{{ __('permission.roles') }}</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@forelse ($roles as $id => $role)

									<tr>
										<td>{{ $roles->firstItem() + $id }}.</td>
										<td>{!! $role->name !!}</td>
										<td class="text-end">
											<button class="btn btn-primary mx-2 p-1 fs-6" wire:click='editDetails({{ $role->id }})'><i class="ti ti-pencil"></i></button>
										</td>
									</tr>

									@empty
									<tr><td colspan="3" class="text-center">{{ __('lang.no_data_found') }}</td></tr>
									@endforelse
								</tbody>
							</table>

							<div class="mt-4 float-right">{{ $roles->links() }}</div>

						</div>
					</div>
				</div>

				<div class="col-12 col-xxl-4 col-lg-4 col-md-12 col-sm-12 card">
					<div class="card-header">
						<h4 class="card-title">{{$formHeader == 1 ? trans('permission.add_role') : trans('permission.edit_role')}}</h4>
					</div>
					<form wire:submit.prevent='{{ $formName }}'>
						<div class="card-body">
							<div class="row">
								<div class="col-xl-12">
									<div class="row">
										<div class="col-md-6 col-xl-12">
											<div class="mb-1">
												<label class="form-label">{{ __('permission.enter_role_name') }}</label>
												<input type="text" class="form-control" wire:model='roleName' placeholder="Enter role" autofocus />
											</div>
											<div class="mb-3 text-danger">@error('roleName'){{ $message }}@enderror</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer text-end">
							<div class="d-flex">
								<button type="submit" class="btn btn-primary" wire:target='{{ $formName }}'> {{$btnLabel == 1 ? trans('permission.add_role') : trans('site.save_changes')}}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
