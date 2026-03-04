$(document).ready(function() {
    const ctx = document.getElementById('offersChart').getContext('2d');
    let chart;

    function fetchChartData(startDate, endDate) {
        $.ajax({
            url: 'offers_request_get_chart.php',
            type: 'POST',
            data: { startDate, endDate },
            success: function(response) {
                const data = JSON.parse(response);
                if (chart) {
                    chart.destroy();
                }
                chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Νέες Προσφορές', 'Διεκπεραιωμένες Προσφορές'],
                        datasets: [{
                            label: 'Ποσότητα Προσφορών',
                            data: [data.newOffers, data.completedOffers],
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

    $('#dateRangeForm').submit(function(e) {
        e.preventDefault();
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        fetchChartData(startDate, endDate);
    });

    // Initial load
    fetchChartData('', '');
});
