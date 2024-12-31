<?php

namespace App\Livewire\Admin;

use App\Models\Log;
use Livewire\Component;

class Notification extends Component
{
    public $logs = [];
    public function mount()
    {
        $this->fetchLogs();
    }

    public function fetchLogs()
    {
        $this->logs = Log::with('user')->latest()->take(5)->get();
    }

    public function render()
    {
        return view('livewire.admin.notification');
    }
}
