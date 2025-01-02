<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">📜 Nhật ký hoạt động</h5>
        <div class="d-flex align-items-center gap-3">
            <div style="border: 2px solid #1E3BB3; border-radius: 8px; padding: 10px; background-color: #f9f9f9;">
                <label for="search" class="form-label mb-1 text-primary">Tìm kiếm hoạt động</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="background-color: #007bff; color: white;"><i class="fa fa-search"></i></span>
                    </div>
                    <input class="form-control me-2" type="text" style="width: 400px;" wire:model.live="search" placeholder="Nhập từ khóa...">
                </div>
            </div>
            
            <div style="border: 2px solid #1E3BB3; border-radius: 8px; padding: 10px; background-color: #f9f9f9;">
                <label for="filterStartDate" class="form-label mb-1">Từ ngày</label>
                <input 
                    type="date" 
                    id="filterStartDate" 
                    class="form-control" 
                    wire:model.live="filterStartDate" 
                    style="max-width: 200px;"
                >
            </div>
            <div style="border: 2px solid #1E3BB3; border-radius: 8px; padding: 10px; background-color: #f9f9f9;">
                <label for="filterEndDate" class="form-label mb-1">Đến ngày</label>
                <input 
                    type="date" 
                    id="filterEndDate" 
                    class="form-control" 
                    wire:model.live="filterEndDate" 
                    style="max-width: 200px;"
                >
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <table class="table table-bordered">
            <thead class="bg-light">
                <tr>                    
                    <th wire:click="sortBy('user_id')" style="cursor: pointer; width: 30%;">
                        Người dùng
                        @if($sortField === 'user_id')
                            <i class="mdi {{ $sortDirection === 'asc' ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                        @endif
                    </th>
                    <th style="width: 40%;">Hành động</th>
                    <th wire:click="sortBy('created_at')" style="cursor: pointer; width: 20%;">
                        Thời gian
                        @if($sortField === 'created_at')
                            <i class="mdi {{ $sortDirection === 'asc' ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="text-truncate" style="max-width: 200px;">
                            @if($log->user)
                                <strong>{{ $log->user->name }}</strong>
                                <span class="badge badge-sm 
                                    {{ $log->user->role === 'admin' ? 'badge-primary' : 
                                        ($log->user->role === 'employee' ? 'badge-success' : 'badge-secondary') }}" 
                                    style="margin-left: 8px;">
                                    {{ $log->user->role === 'user' ? 'Khách hàng' : 
                                        ($log->user->role === 'admin' ? 'Quản trị viên' : 'Nhân viên') }}
                                </span>
                                <br>
                                <small class="text-muted">{{ $log->user->email }}</small>
                            @else
                                Không xác định
                            @endif
                        </td>
                        <td class="text-truncate" style="max-width: 300px; font-weight: bold; color: #0056b3;">
                            <i class="mdi mdi-arrow-right-bold-circle-outline" style="font-size: 18px; color: #007bff;"></i> 
                            {{ $log->action }}
                        </td>
                        
                        <td>
                            <span data-bs-toggle="tooltip" title="{{ $log->created_at->toDateTimeString() }}">
                                {{ $log->created_at->format('d/m/Y H:i') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Không có hoạt động nào được ghi lại.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span class="text-muted">Hiển thị {{ $logs->firstItem() }} - {{ $logs->lastItem() }} của {{ $logs->total() }} mục</span>
        {{ $logs->links('vendor.pagination.simple') }}

    </div>
</div>
