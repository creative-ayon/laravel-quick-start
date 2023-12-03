<div>
   <!-- Page header -->
   <div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">{{ __('user.add_edit_delete_users') }}</div>

                <h2 class="page-title">{{  __('user.list_of_users') }}</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <span class="d-none d-sm-inline">
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addEditModal" wire:click='resetLabels'>{{ __('user.add_user') }}</button>
                    </span>

                    <span class="d-none d-sm-inline">
                        <input type="text" class="form-control" wire:model.live.debounce.300='search' placeholder="Search here">
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
  <!-- Page body -->
  <div class="page-body">
    <div class="container-xl">
      <div class="card">
        <div class="card-body">
          <div id="table-default" class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th><button class="table-sort" data-sort="sort-name">{{__('site.name')}}</button></th>
                  <th><button class="table-sort" data-sort="sort-email">{{__('site.email')}}</button></th>
                  <th><button class="table-sort" data-sort="sort-role">{{__('site.role')}}</button></th>
                  <th><button class="table-sort" data-sort="sort-date">{{__('site.create_date')}}</button></th>
                  <th>{{__('site.actions')}}</th>

                </tr>
              </thead>
              <tbody class="table-tbody">
                @foreach ($allUsers as $id => $user)
                <tr>
                  <td class="sort-name">{{$user->name}}</td>
                  <td class="sort-email">{{$user->email}}</td>
                    @php
									$userRoles = '';

									foreach ($user->roles->pluck('name') as $role) {

										$badge = 'badge bg-blue-lt';
										switch ($badge) {
											case $role=='Super Admin':
												$badge = 'badge bg-green-lt fs-5';
												break;
											case $role=='Admin':
												$badge = 'badge bg-cyan-lt fs-5';
												break;
											case $role=='Manager':
												$badge = 'badge bg-yellow-lt fs-5';
												break;
											case $role=='User':
												$badge = 'badge bg-purple-lt fs-5';
												break;
											default:
												$badge = 'badge bg-blue-lt fs-5';
												break;
										}

										$userRoles .= '<span class="'.$badge.'">' . $role . '</span>, ';
									}
									$userRoles = rtrim($userRoles, ', ');
					@endphp

                  <td class="sort-role">{!! $userRoles !!}</td>
                  <td class="sort-date" data-date="{{strtotime($user->created_at)}}">{{date('d M, Y', strtotime($user->created_at))}}</td>
                  <td class="text-center">
                    @if (!$user->hasRole('Super Admin'))

                    <button class="btn btn-primary mx-2 p-1 fs-6" wire:click='editUser({{ $user->id }})'><i class="ti ti-pencil"></i></button>
                    @endif
                  </td>
                @endforeach
                </tr>
              </tbody>
            </table>
            <div class="mt-4 me-2 d-flex justify-content-end">{{ $allUsers->links() }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>   
  @include('livewire.backend.user.add_edit_modal')      
</div>
@push('scripts')
<script src="{{asset('assets/dist/libs/list.js/dist/list.min.js?v=').env('APP_VERSION')}}" defer></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>  
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const list = new List('table-default', {
        sortClass: 'table-sort',
        listClass: 'table-tbody',
        valueNames: [ 'sort-name', 'sort-email', 'sort-role',
            { attr: 'data-date', name: 'sort-date' },            
        ]
    });
    })
  </script>
  <script>
    window.addEventListener('show-modal', event => {
        $('#addEditModal').modal('show');
    })
    window.addEventListener('hide-modal', event => {
        $('#addEditModal').modal('hide');
    });
    </script>
@endpush
