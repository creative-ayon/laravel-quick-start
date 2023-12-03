<div wire:ignore.self class="modal modal-blur fade" id="addEditModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{$header == 1 ? trans('user.add_user') : trans('user.edit_user')}}</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='resetLabels'></button>
			</div>

			<form wire:submit.prevent='{{ $target }}'>

			<input type="hidden" wire:model='userId' value="{{ $userId }}" />

			<div class="modal-body">
				<div class="row mb-1">
					<div class="col">
						<label class="form-label">{{ __('site.name') }} <span class="text-danger">*</span></label>
						<input type="text" class="form-control" wire:model='name' autofocus />
					</div>
				</div>
				<div class="text-danger mb-3">@error('name'){{ $message }}@enderror</div>

				<div class="row mb-1">
					<div class="col">
						<label class="form-label">{{ __('site.email') }} <span class="text-danger">*</span></label>
						<input type="text" class="form-control" wire:model='email'>
					</div>
				</div>
				<div class="text-danger mb-3">@error('email'){{ $message }}@enderror</div>
		
				<div class="mb-1">
					<label class="form-label">{{ __('site.role') }} <span class="text-danger">*</span></label>
					<div class="row g-2">
						<div class="col-auto">
							<div class="form-selectgroup">
								@foreach ($allRoles as $role)
								<label class="form-selectgroup-item">
									<input type="radio" wire:model='role' class="form-selectgroup-input" value="{{ $role->name }}" />
									<span class="form-selectgroup-label py-1 px-3 me-2">{{ $role->name }}</span>
								</label>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				<div class="text-danger mb-3">@error('role'){{ $message }}@enderror</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn me-auto" data-bs-dismiss="modal" wire:click='resetLabels'>{{ __('site.close') }}</button>
				<button type="submit" class="btn btn-primary" wire:target='{{ $target }}'>{{$btnLabel == 1 ? trans('site.add') : trans('site.edit')}}</button>
			</div>
		</form>
		</div>

	</div>
</div>
