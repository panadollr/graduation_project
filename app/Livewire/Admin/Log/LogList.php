<?php

namespace App\Livewire\Admin\Log;

use App\Models\Log;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class LogList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $filterStartDate;
    public $filterEndDate;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    #[Title('Lịch sử hoạt động')] 
    public function render()
    {
        $logs = Log::query()
            ->with('user')
            ->when($this->search, function ($query) {
                $query->where('action', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                        });
            })
            ->when($this->filterStartDate, function ($query) {
                $query->whereDate('created_at', '>=', $this->filterStartDate);
            })
            ->when($this->filterEndDate, function ($query) {
                $query->whereDate('created_at', '<=', $this->filterEndDate);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.log.log-list', [
            'logs' => $logs,
        ])->extends('admin.app');
    }
}
