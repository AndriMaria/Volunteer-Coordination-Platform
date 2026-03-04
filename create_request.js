var items = [];
var categories = [];

// Fetch data from JSON
fetch('items_and_categories.json')
    .then(response => response.json())
    .then(data => {
        console.log('Data loaded:', data); // Debugging line
        items = data.items;
        categories = data.categories;
        populateCategories();
        populateItems();
    })
    .catch(error => console.error('Error loading JSON:', error));

function populateCategories() {
    var categorySelect = document.getElementById('category_select');
    categories.forEach(category => {
        var option = document.createElement('option');
        option.value = category.id;
        option.text = category.category_name || 'Χωρίς Όνομα'; // Default text if category name is empty
        categorySelect.add(option);
    });
}

function populateItems() {
    var categoryId = document.getElementById('category_select').value;
    var itemSelect = document.getElementById('item_name');
    itemSelect.innerHTML = '<option value="">Επιλέξτε Είδος</option>'; // Clear previous items

    if (categoryId) {
        items.forEach(item => {
            if (item.category === categoryId) {
                var option = document.createElement('option');
                option.value = item.name;
                option.text = item.name || 'Χωρίς Όνομα'; // Default text if item name is empty
                itemSelect.add(option);
            }
        });
    }
}

function createRequest() {
    var itemName = document.getElementById('item_name').value;
    var peopleCount = document.getElementById('people_count').value;
    if (itemName && peopleCount) {
        var requestList = document.getElementById('request_list');
        var li = document.createElement('li');
        li.classList.add('request-item');
        li.innerHTML = 'Είδος: ' + itemName + ', Πλήθος ατόμων: ' + peopleCount;
        requestList.appendChild(li);

        $.ajax({
            url: 'new_request.php',
            method: 'POST',
            data: {item_name: itemName, people_count: peopleCount},
            success: function(data){
                alert(data); // Display the result from PHP script
            }
        });

    } else {
        alert('Παρακαλώ συμπληρώστε όλα τα πεδία.');
    }
}


