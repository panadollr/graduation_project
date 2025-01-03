<li class="nav-item dropdown">
    <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
        <i class="fa fa-history"></i>
        <span class="count"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" style="margin-top: -30px" aria-labelledby="notificationDropdown">
        <div class="notifications-list" style="max-height: 430px; overflow-y: auto;">
            <div class="dropdown-item py-3 border-bottom">
                <h6 class="mb-0 fw-medium float-start">Danh sách lịch sử hoạt động gần đây</h6>
                <a href="{{ route('admin.log.index') }}" class="btn btn-primary btn-sm float-end text-white" style="margin-left: 5px">Xem tất cả</a>
            </div>
            @forelse($logs as $log)
                <a class="dropdown-item preview-item py-3">
                    <div class="preview-thumbnail">
                        <i class="mdi mdi-information-outline m-auto text-primary"></i>
                    </div>
                    <div class="preview-item-content">
                        <h6 class="preview-subject fw-normal text-dark mb-1"><strong>{{ $log->user->name }}</strong> {{ $log->action }}</h6>
                        <p class="fw-light small-text mb-0"> {{ $log->created_at->diffForHumans() }}</p>
                    </div>
                </a>
            @empty
                <a class="dropdown-item py-3">
                    <p class="fw-light small-text mb-0 text-center">Không có hoạt động nào</p>
                </a>
            @endforelse
        </div>        
    </div>
    
</li>
