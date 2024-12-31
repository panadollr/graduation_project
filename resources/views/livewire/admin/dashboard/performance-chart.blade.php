<div class="card card-rounded">
    <div class="card-body">
      <div class="d-sm-flex justify-content-between align-items-start">
        <div>
          <h4 class="card-title card-title-dash">Biểu đồ Hiệu Suất</h4>
          <h5 class="card-subtitle card-subtitle-dash">Biểu đồ thể hiện hiệu suất bán hàng theo thời gian</h5>
        </div>
        <div id="performanceLine-legend"></div>
      </div>
      <div class="chartjs-wrapper mt-4">
        <canvas id="performanceLine" width=""></canvas>
      </div>
    </div>

    <script>
        const labels = @json($labels);
        const dataThisWeek = @json($dataThisWeek);
        const dataLastWeek = @json($dataLastWeek);
    </script>
  </div>