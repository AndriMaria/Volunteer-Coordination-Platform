function fetchRequests() {
    $.ajax({
        url: 'fetch_requests.php',
        method: 'GET',
        success: function(data) {
            var requests = JSON.parse(data);
            var requestList = document.getElementById('request_list');

            requestList.innerHTML = ''; // Clear the list first

            requests.forEach(request => {
                var li = document.createElement('li');
                li.classList.add('request-item');

                // Check and convert 'null' strings back to null for display purposes
                if (request.acceptance_date === 'null') {
                    request.acceptance_date = 'N/A';
                }
                if (request.completion_date === 'null') {
                    request.completion_date = 'N/A';
                }

                li.innerHTML = `
                    Είδος: ${request.item_name}, Πλήθος ατόμων: ${request.people_count}
                    <div class="request-details">
                        Ημερομηνία Αιτήματος: ${request.request_date}<br>
                        Κατάσταση: ${request.status_request}<br>
                        Ημερομηνία Αποδοχής: ${request.acceptance_date}<br>
                        Ημερομηνία Ολοκλήρωσης: ${request.completion_date}
                    </div>
                `;

                requestList.appendChild(li);
            });
        }
    });
}

document.addEventListener('DOMContentLoaded', fetchRequests); // Fetch requests on page load