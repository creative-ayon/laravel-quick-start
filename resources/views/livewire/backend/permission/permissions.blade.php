<div>
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12 col-xxl-8 col-lg-8 col-md-12 col-sm-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable fs-5">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>{{ __('permission.permissions') }}</th>
                                    <th></th>
                                    <th>{{ __('permission.roles') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $id => $single)
    
                                @php
                                $badge = [
                                    'badge bg-blue-lt',
                                    'badge bg-azure-lt',
                                    'badge bg-indigo-lt',
                                    'badge bg-purple-lt',
                                    'badge bg-pink-lt',
                                    'badge bg-red-lt',
                                    'badge bg-orange-lt',
                                    'badge bg-yellow-lt',
                                    'badge bg-lime-lt',
                                    'badge bg-green-lt',
                                    'badge bg-teal-lt',
                                    'badge bg-cyan-lt',
                                ];
                                @endphp
    
                                @php
                                $allPermission = '';
                                @endphp
    
                                @foreach ($single->permissions as $permission)
                                @php
                                $allPermission .= '<span class="'.$badge[rand(0, 11)].' fs-5">'.$permission->name.' <span class="ps-1" style="cursor:pointer" wire:click="revokePermission('.$single->id.', '.$permission->id.')">x</span></span>';
                                @endphp
                                @endforeach
    
                                <tr>
                                    <td>{{ $id + 1 }}.</td>
                                    <td></td>
                                    <td>{!! strtoupper($single->name) !!}</td>
                                    <td></td>
                                    <td>
                                        <div class="btn-list">
                                            {!! $allPermission !!}
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        @if (sizeof($single->permissions) > 0)
                                        <button class="btn btn-primary p-1 fs-6 me-2" wire:click='editPermissions({{ $single->id }})'><i class="ti ti-pencil"></i></button>
                                        <button class="btn btn-danger p-1 fs-6" wire:click='confirmDeleteAllPermissions({{ $single->id }})'><i class="ti ti-trash"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    
            <div class="col-12 col-xxl-4 col-lg-4 col-md-12 col-sm-12 card">
                <div class="card-header">
                    <h4 class="card-title me-3">{{ __('permission.add_edit_permission') }}</h4>
                </div>
                <form wire:submit.prevent='{{ $formTarget }}'>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-md-6 col-xl-12">
                                        <div class="mb-1">
                                            <label class="form-label">{{ __('permission.select_role') }}</label>
                                            <select class="form-control" wire:model='role'>
                                                <option value="">-- {{ __('site.select') }} --</option>
                                                @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 text-danger">@error('role'){{ $message }}@enderror</div>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col-md-6 col-xl-12">
                                        <div class="mb-1">
                                            <label class="form-label d-flex mb-0">{{ __('permission.select_permission') }}
                                                {{-- <a href="javascript:void(0)" wire:click='syncData' class="ms-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                                                </svg></a> --}}
                                            </label>
                                            {{-- <small class="text-danger">* Sync permission list before selecting</small> --}}
    
                                            <div class="form-selectgroup mt-3">
                                                <label class="form-selectgroup-item">
                                                    <input type="checkbox" wire:model='all' class="form-selectgroup-input" />
                                                    <span class="form-selectgroup-label badge bg-indigo-lt">{{ __('permission.all_actions') }}</span>
                                                </label>
    
                                                @foreach ($dynamicRoutes as $dynamicRoute)
                                                    <label class="form-selectgroup-item">
                                                        <input type="checkbox" wire:model='permissions' class="form-selectgroup-input" id="{{ $dynamicRoute }}" value="{{ $dynamicRoute }}" />
                                                        <span class="form-selectgroup-label">{{ $dynamicRoute }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="mb-3 text-danger">@error('permissions'){{ $message }}@enderror</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary" id="permissionAddBtn" wire:target='{{ $formTarget }}'>{{$btnLabel == 1 ? trans('permission.add_permission') : trans('site.save_changes')}}</button>
    
                            <button type="button" class="btn btn-default ms-2" wire:click='resetAll'>{{ __('site.reset') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
