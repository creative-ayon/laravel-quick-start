<?php

namespace App\Livewire\Backend\Permission;



use Livewire\Component;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class Permissions extends Component
{

    use LivewireAlert;
        
    public $role;
	public $permissions = [];
	public $all = false;
	public $guard_name = 'web';
	public $roleId;
	public $btnLabel = '1';
	public $formTarget = 'addPermissions';

    public $delRoleId;

	protected $listeners = [
		'deleteConfirmed' => 'deletePermissions',
	];

	protected $rules = [
		'role' => 'required',
		'permissions' => 'required',
	];

	protected $messages = [
		'*.required' => ':attribute is required',
	];

	protected $validationAttributes = [
		'role' => 'Role',
		'permissions' => 'Permissions',
	];

	public function updated($propertyName)
	{
		$this->validateOnly($propertyName);
	}

	public function resetForm()
	{
		$this->reset();
		$this->resetErrorBag();
		$this->resetValidation();
	}

	public function resetAll()
	{
		$this->resetForm();
	}

	public function addPermissions()
	{
		$this->validate();
		$role = Role::find($this->role);
		foreach ($this->permissions as $permission) {
			$newPermission = Permission::updateOrCreate([
				'name' => $permission,
				'guard_name' => $this->guard_name,
			]);
			$role->givePermissionTo($newPermission);
		}
		$this->alert('success', 'Permission Added Successfully!');
		$this->resetForm();
	}

	public function editPermissions($id)
	{
		$this->resetForm();
		$this->formTarget = 'updatePermissions';
		$this->btnLabel = '2';
		$data = Role::where('id', $id)->with('permissions')->first();
		$this->role = $data->id;
		$this->roleId = $data->id;
		$this->permissions = $data->permissions->pluck('name');
	}

	public function updatePermissions()
	{
		$this->validate();
		$role = Role::find($this->roleId);
		$role->syncPermissions($this->permissions);
		$this->alert('success', 'Permission Updated Successfully!');
		$this->resetForm();
	}

	public function updatedAll($value)
	{   
		if ($value){
			$dynamicRoutes = $this->getAllRoutes();
			$this->permissions = $dynamicRoutes;
		}else{
			$this->permissions = [];
		}
	}

	public function getAllRoutes()
	{
		$dynamicRoutes = [];
		$routeCollection = Route::getRoutes();
		foreach ($routeCollection as $value) {
			if ($value->getName()){
				$dynamicRoutes[] = $value->getName();
			}
		}
		return $dynamicRoutes;
	}

	public function render()
	{
		$roles = Role::where('id', '!=', 1)->get();
		$dynamicRoutes = $this->getAllRoutes();

		return view('livewire.backend.permission.permissions', ['roles' => $roles, 'dynamicRoutes' => $dynamicRoutes]);
	}

	public function revokePermission($roleId, $permissionId)
	{
		$role = Role::find($roleId);
		$permission = Permission::find($permissionId);

		$role->revokePermissionTo($permission->name);
		$this->render();
	}

	public function confirmDeleteAllPermissions($roleId)
	{

        $this->roleId = $roleId;

        $this->alert('question', 'Are you sure?', [
            'icon' => 'warning',
            'position' => 'center',
            'toast' => false,
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'allowOutsideClick' => false,
            'timer' => null,
            'onConfirmed' => 'deleteConfirmed',

        ]);
	}

	public function deletePermissions()
	{
        $role = Role::find($this->roleId);
		$allPermissions = $role->permissions->pluck('name')->toArray();
		$role->revokePermissionTo($allPermissions);
		$this->alert('success', 'Permission Deleted Successfully!');
		$this->render();
	}
    
    

}
