$(document).ready(function() {
    loadCategories();
    loadInventory();

    $('#categoryFilter').change(function() {
        loadInventory();
    });

    function loadCategories() {
        $.getJSON('get_categories.php')
            .done(function(categories) {
                var options = '';
                categories.forEach(function(category) {
                    options += `<option value="${category.id}">${category.name}</option>`;
                });
                $('#categoryFilter').html(options);
            })
            .fail(function() {
                alert('Σφάλμα φόρτωσης κατηγοριών.');
            });
    }

    function loadInventory() {
        var selectedCategories = $('#categoryFilter').val();
        var queryString = selectedCategories ? '?category_ids=' + selectedCategories.join(',') : '';

        $.getJSON('get_inventory.php' + queryString)
            .done(function(items) {
                var rows = '';
                items.forEach(function(item) {
                    rows += `<tr>
                                <td>${item.name}</td>
                                <td>${item.category}</td>
                                <td>${item.quantity}</td>
                             </tr>`;
                });
                $('#inventoryTable tbody').html(rows);
            })
            .fail(function() {
                alert('Σφάλμα φόρτωσης ειδών.');
            });
    }
});
