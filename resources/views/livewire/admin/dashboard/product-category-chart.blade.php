       <div class="card card-rounded">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title card-title-dash">Top 4 danh mục bán chạy nhất</h4>
                        </div>
                        <div>
                            <canvas class="my-auto" id="doughnutChart"></canvas>
                        </div>
                        <div id="doughnutChart-legend" class="mt-5 text-center"></div>
                    </div>
                </div>
            </div>
        </div>

    @script
    <script>
        const labels = @json($chartData['labels']);
        if ($("#doughnutChart").length) {
            const doughnutChartCanvas =
                document.getElementById("doughnutChart");
            new Chart(doughnutChartCanvas, {
                type: "doughnut",
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [
                        {
                            data:@json($chartData['data']),
                            backgroundColor: [
                                "#1F3BB3",
                                "#FDD0C7",
                                "#52CDFF",
                                "#81DADA",
                                "#FF0000",
                            ],
                            borderColor: [
                                "#1F3BB3",
                                "#FDD0C7",
                                "#52CDFF",
                                "#81DADA",
                                "#FF0000"
                            ],
                        },
                    ],
                },
                options: {
                    cutout: 90,
                    animationEasing: "easeOutBounce",
                    animateRotate: true,
                    animateScale: false,
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1.4,
                    showScale: true,
                    legend: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                },
                plugins: [
                    {
                        afterDatasetUpdate: function (chart, args, options) {
                            const chartId = chart.canvas.id;
                            var i;
                            const legendId = `${chartId}-legend`;
                            const ul = document.createElement("ul");
                            for (
                                i = 0;
                                i < chart.data.datasets[0].data.length;
                                i++
                            ) {
                                ul.innerHTML += `
                  <li>
                    <span style="background-color: ${chart.data.datasets[0].backgroundColor[i]}"></span>
                    ${chart.data.labels[i]}
                  </li>
                `;
                            }
                            return document
                                .getElementById(legendId)
                                .appendChild(ul);
                        },
                    },
                ],
            });
        }
   </script>
   @endscript
