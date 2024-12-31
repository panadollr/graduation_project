<div>
    <div class="row">
        <div class="col-sm-12">
          <div class="home-tab">
            <div class="d-sm-flex align-items-center justify-content-between border-bottom">
              <ul class="nav nav-tabs" role="tablist">
              </ul>
              <div>
                <div class="btn-wrapper">
                  <!-- Nút In -->
                  <a href="#" onclick="window.print(); return false;" class="btn btn-outline-dark">
                    <i class="icon-printer"></i> In
                  </a>
                
                  <!-- Nút Xuất -->
                  <a href="#" onclick="exportCSV(); return false;" class="btn btn-primary text-white me-0">
                    <i class="icon-download"></i> Xuất CSV
                  </a>
                </div>
                
                <script>
                  // Hàm xuất file CSV
                  function exportCSV() {
                    const csvContent = "data:text/csv;charset=utf-8,ID,Name,Quantity\n1,Product A,10\n2,Product B,20";
                    const encodedUri = encodeURI(csvContent);
                
                    const link = document.createElement("a");
                    link.setAttribute("href", encodedUri);
                    link.setAttribute("download", "data.csv");
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                  }
                </script>
              </div>
            </div>
            <div class="tab-content tab-content-basic">
              <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                
                <div class="row">
                  <div class="col-sm-12">
                    <div class="statistics-details d-flex align-items-center justify-content-between">
                      <div>
                        <p class="statistics-title">Sản phẩm</p>
                        <h3 class="rate-percentage">{{ $totalProducts }}</h3>
                      </div>
                      <div>
                        <p class="statistics-title">Danh mục</p>
                        <h3 class="rate-percentage">{{ $totalProducts }}</h3>
                      </div>
                      <div>
                        <p class="statistics-title">Đơn hàng</p>
                        <h3 class="rate-percentage">{{ $totalOrders }}</h3>
                      </div>
                      <div>
                        <p class="statistics-title">Đánh giá</p>
                        <h3 class="rate-percentage">{{ $totalOrders }}</h3>
                      </div>
                      <div>
                        <p class="statistics-title">Người dùng</p>
                        <h3 class="rate-percentage">{{ $totalUsers}}</h3>
                      </div>
                      <div>
                        <p class="statistics-title">Bài viết</p>
                        <h3 class="rate-percentage">{{ $totalUsers}}</h3>
                      </div>
                    </div>
                  </div>
                </div>                
               
                <div class="row">
                  <div class="col-lg-8 d-flex flex-column">
                    <div class="row">

                      <div class="col-12 grid-margin stretch-card">
                      @livewire('admin.dashboard.recent-orders')
                      </div>

                      <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                      @livewire('admin.dashboard.featured-products')
                      </div>

                      <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                      {{-- @livewire('admin.dashboard.revenue-chart') --}}
                      @livewire('admin.dashboard.recent-reviews')
                      </div>

                    </div>
                  </div>
                  <div class="col-lg-4 flex-column">
                    <div class="row flex-grow">
                      
                      <div class="col-12 grid-margin stretch-card">
                      @livewire('admin.dashboard.product-category-chart')
                      </div>

                      {{-- <div class="col-12 grid-margin stretch-card">
                      @livewire('admin.dashboard.top-selling-products')
                      </div> --}}

                      {{-- <div class="col-12 grid-margin stretch-card">
                        @livewire('admin.dashboard.top-rated-products')
                      </div> --}}

                    </div>
                  </div>
                </div>
            
               
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
