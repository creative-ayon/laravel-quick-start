<?php

namespace App\Livewire\Backend\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Users extends Component
{

    use WithPagination;

	protected $paginationTheme = 'bootstrap';

	public $name;
	public $email;
	public $role;
	public $header = '1';
	public $btnLabel = '1';
	public $target = 'addUser';
	public $userId;
	public $search;

    public $test;

    protected $listeners = [
		'deleteConfirmed' => 'deleteUser',
	];

	protected function rules()
	{
		return [
			'name' => 'required|min:3',
			'email' => 'required_without:phone|nullable|email|min:3|max:255|unique:users,email,' . $this->userId,
			'role' => 'required',
		];
	}

	protected $validationAttributes = [
		'name' => 'Name',
		'email' => 'Email',
		'role' => 'User role',
	];

	protected $messages = [
		'*.required' => ':attribute is required',
		'*.required_without' => ':attribute is required',
	];

	public function updated($propertyName)
	{
		$this->validateOnly($propertyName);
	}

	public function showModal()
	{
		$this->resetForm();
		$this->dispatch('show-modal');
	}

	public function hideModal()
	{
		$this->resetForm();
		$this->dispatch('hide-modal');
	}

	public function resetForm()
	{
		$this->reset();
		$this->resetErrorBag();
		$this->resetValidation();
	}

    public function editUser($id)
	{
		$this->showModal();

		$this->header = '2';
		$this->btnLabel = '2';
		$this->target = 'updateUser';

		$data = User::findOrFail($id);
		$this->userId = $id;
		foreach ($data->roles as $role) {
			$this->role = $role->name;
		}
		$this->name = $data->name;
		$this->email = $data->email;
	}

    public function updateUser()
	{
		$this->validate();

		try {
			User::where('id', $this->userId)->update([
				'name' => $this->name,
				'email' => $this->email,
			]);
			$user = User::findOrFail($this->userId);
			$user->syncRoles($this->role);		
			$this->hideModal();
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

    public function resetLabels()
	{
		$this->reset();
		$this->resetValidation();
	}

    public function render()
    {
        $searchInput = "%".$this->search."%";
		
		$allUsers = User::with('roles')
		->where(function($query) use ($searchInput) {
			$query->where('name', 'LIKE', $searchInput)
			->orWhere('email', 'LIKE', $searchInput);
        })
		->paginate(20);

		$allRoles = Role::where('id', '!=', 1)->get();
        
        return view('livewire.backend.user.users', compact('allUsers', 'allRoles'));
    }
}
