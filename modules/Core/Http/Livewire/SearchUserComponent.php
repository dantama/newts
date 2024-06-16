<?php

namespace Modules\Core\Http\Livewire;

use Livewire\Component;
use Modules\Account\Models\User;

class SearchUserComponent extends Component
{

    public $search = '';

    public function render()
    {
        return view('admin::livewire.search-users', [
            'users' => User::where('username', 'like', '%' . $this->search . '%')->get(),
        ]);
    }
}
