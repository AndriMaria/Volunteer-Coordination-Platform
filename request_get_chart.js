$(document).ready(function() {
    const ctt = document.getElementById('requestChart').getContext('2d');
    let chart;

    function fetchChartData(startDate, endDate) {
        $.ajax({
            url: 'request_get_chart.php',
            type: 'POST',
            data: { startDate, endDate },
            success: function(response) {
                const data = JSON.parse(response);
                if (chart) {
                    chart.destroy();
                }
                chart = new Chart(ctt, {
                    type: 'bar',
                    data: {
                        labels: ['Νέα Αιτήματα', 'Διεκπεραιωμένα Αιτήματα'],
                        datasets: [{
                            label: 'Ποσότητα Αιτημάτων',
                            data: [data.newRequests, data.completedRequests],
                            backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)'],
                            borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    }

    $('#dateRange').submit(function(e) {
        e.preventDefault();
        const startDate = $('#startDateRequest').val();
        const endDate = $('#endDateRequest').val();
        fetchChartData(startDate, endDate);
    });

    // Initial load
    fetchChartData('', '');
});