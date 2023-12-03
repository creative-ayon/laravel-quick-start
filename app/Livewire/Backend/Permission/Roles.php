<?php

namespace App\Livewire\Backend\Permission;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Roles extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $roleName;
    public $formHeader = '1';
    public $formName = 'addRole';
    public $btnLabel = '1';
    public $roleId;
    public $search;
    protected $guard_name = 'web';

    protected $listeners = [
        'deleteConfirmed' => 'deleteRole',
    ];

    public function rules()
    {
        $ruleArray = [];
        $ruleArray['roleName'] = 'required|min:3|unique:roles,name,' . $this->roleId;
        return $ruleArray;
    }

    protected $validationAttributes = [
        'roleName' => 'Role',
    ];

    protected $messages = [
        'required' => ':attribute is required',
        'unique' => ':attribute exists',
        'min' => ':attribute must be more 3 characters',
    ];

    public function updated($fields)
    {
        return $this->validateOnly($fields);
    }

    public function addRole()
    {
        $this->validate();

        try {
            Role::create([
                'name' => $this->roleName,
                'guard_name' => $this->guard_name,
                'created_at' => now(),
            ]);
            $this->reset();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:error', [
                'type' => 'error',
                'title' => '',
                'text' => 'Something went wrong! ' . $e->getMessage(),
                'showBtn' => true,
                'timer' => false,
            ]);
        }
    }

    public function render()
    {
        $roles = Role::where('id', '!=', 1)->where('name', 'like', '%' . trim($this->search) . '%')->paginate(10);

        return view('livewire.backend.permission.roles', ['roles' => $roles]);

    }

    public function confirmDelete($id)
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Delete role?',
            'text' => '',
            'id' => $id,
        ]);
    }

    public function deleteRole($id)
    {
        Role::find($id)->delete();

        $this->dispatchBrowserEvent('swal:success', [
            'type' => 'success',
            'title' => 'Role deleted',
            'text' => '',
            'showBtn' => false,
            'timer' => 1500,
        ]);
    }

    public function editDetails($id)
    {
        $this->reset();
        $this->formHeader = '2';
        $this->formName = 'updateRole';
        $this->btnLabel = '2';

        $master = Role::findOrFail($id);
        $this->roleName = $master->name;
        $this->roleId = $id;
    }

    public function updateRole()
    {
        try {
            Role::findOrFail($this->roleId)->update([
                'name' => $this->roleName,
            ]);
            
            $this->reset();

        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:error', [
                'type' => 'error',
                'title' => '',
                'text' => 'Something went wrong! ' . $e->getMessage(),
                'showBtn' => true,
                'timer' => false,
            ]);
        }
    }



}
