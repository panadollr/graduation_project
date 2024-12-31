<div class="row flex-grow">
  <div class="col-12 grid-margin stretch-card">
    <div class="card card-rounded">
      <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
          <div>
            <h4 class="card-title card-title-dash">Biểu đồ doanh thu</h4>
            <span class="card-subtitle card-subtitle-dash">Biểu đồ thể hiện doanh thu theo {{ $timeRange }}.</span>
          </div>
          <div>
              <select wire:model="timeRange" class="form-select">
                  <option value="day">Theo ngày</option>
                  <option value="week">Theo tuần</option>
                  <option value="month">Theo tháng</option>
              </select>
          </div>
        </div>
        <div class="d-sm-flex align-items-center mt-1 justify-content-between">
          <div class="d-sm-flex align-items-center mt-4 justify-content-between">
              <h2 class="me-2 fw-bold">{{ number_format($revenue, 0, ',', '.') }}đ</h2>
              <h4 class="text-success">
                  ({{ $growth >= 0 ? '+' : '' }}{{ number_format($growth, 2) }}%)
              </h4>
          </div>
          <div class="me-3">
            <div id="marketingOverview-legend"></div>
          </div>
        </div>
        <div class="chartjs-bar-wrapper mt-3">
          <canvas id="marketingOverview"></canvas>
        </div>
      </div>
    </div>
  </div>

  <script>
      const labels = @json($labels);
      const datasets = @json($data);
  </script>
</div>