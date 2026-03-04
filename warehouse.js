$(document).ready(function() {
    loadCategories();
    loadItems();

    // Υποβολή φόρμας κατηγορίας
    $('#categoryForm').submit(function(e) {
        e.preventDefault();
        var categoryData = {
            categoryName: $('#categoryName').val(),
            categorySelect: $('#categorySelect').val()
        };
        $.post('manage_categories.php', categoryData)
            .done(function(response) {
                $('#message').text(response);
                loadCategories();
            })
            .fail(function() {
                $('#message').text('Σφάλμα κατά την ενημέρωση της κατηγορίας.');
            });
    });

    $('#itemForm').submit(function(e) {
        e.preventDefault();
        var itemData = {
            itemName: $('#itemName').val(),
            itemCategory: $('#itemCategory').val(),
            itemQuantity: $('#itemQuantity').val(),
            itemSelect: $('#itemSelect').val()
        };
        $.post('manage_items.php', itemData)
            .done(function(response) {
                showNotification(response); // Εμφάνιση μηνύματος επιτυχίας
                loadItems(); // Ανανεώνει τη λίστα ειδών
            })
            .fail(function() {
                showNotification('Σφάλμα κατά την ενημέρωση του είδους.', true); // Εμφάνιση μηνύματος σφάλματος
            });
    });



    // Επιλογή κατηγορίας και φόρτωση στοιχείων στη φόρμα
    $('#categorySelect').change(function() {
        var selectedCategory = $(this).val();
        if (selectedCategory) {
            $('#categoryName').val($('#categorySelect option:selected').text());
        } else {
            $('#categoryName').val('');
        }
    });

    // Επιλογή προϊόντος και φόρτωση στοιχείων στη φόρμα
    $('#itemSelect').change(function() {
        var selectedItem = $(this).val();
        if (selectedItem) {
            var itemData = $('#itemSelect option:selected').data();
            $('#itemName').val(itemData.name);
            $('#itemCategory').val(itemData.category);
            $('#itemQuantity').val(itemData.quantity);
        } else {
            $('#itemName').val('');
            $('#itemCategory').val('');
            $('#itemQuantity').val('');
        }
    });

    // Αφαίρεση επιλεγμένου προϊόντος
    $('#removeItemButton').click(function() {
        var selectedItem = $('#itemSelectForRemoval').val();
        if (selectedItem) {
            removeItem(selectedItem);
        } else {
            alert('Παρακαλώ επιλέξτε ένα είδος για αφαίρεση.');
        }
    });

    // Φόρτωση κατηγοριών
    function loadCategories() {
        $.getJSON('get_categories.php')
            .done(function(categories) {
                var categoryOptions = '<option value="">--Επιλέξτε--</option>';
                categories.forEach(function(category) {
                    categoryOptions += `<option value="${category.id}">${category.name}</option>`;
                });
                $('#categorySelect').html(categoryOptions);
                $('#itemCategory').html(categoryOptions);
                $('#categorySelectForItems').html(categoryOptions); // Νέα φόρμα επιλογής κατηγορίας
            })
            .fail(function() {
                $('#message').text('Σφάλμα φόρτωσης κατηγοριών.');
            });
    }

    // Φόρτωση προϊόντων
    function loadItems(categoryId = '') {
        var url = 'get_items.php';
        if (categoryId) {
            url += '?category=' + categoryId;
        }
        $.getJSON(url)
            .done(function(items) {
                var itemOptions = '<option value="">--Επιλέξτε--</option>';
                items.forEach(function(item) {
                    itemOptions += `<option value="${item.id}" data-name="${item.name}" data-category="${item.category_id}" data-quantity="${item.quantity}">${item.name}</option>`;
                });
                $('#itemSelect').html(itemOptions);
                $('#itemSelectForRemoval').html(itemOptions); // Νέα φόρμα επιλογής προϊόντος για αφαίρεση
            })
            .fail(function() {
                $('#message').text('Σφάλμα φόρτωσης ειδών.');
            });
    }

    // Αφαίρεση προϊόντος μέσω AJAX
    function removeItem(itemId) {
        $.ajax({
            url: 'remove_item.php',
            type: 'POST',
            data: { id: itemId },
            success: function(response) {
                showNotification('Το προϊόν αφαιρέθηκε επιτυχώς.');
                loadItems();
            },
            error: function() {
                showNotification('Σφάλμα κατά την αφαίρεση του προϊόντος.', true);
            }
        });
    }


    // Υποβολή φόρμας για φόρτωση JSON
    $('#jsonUploadForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'upload_json.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#message').text(response);
                loadCategories();
                loadItems();
            },
            error: function() {
                $('#message').text('Σφάλμα κατά τη φόρτωση των δεδομένων.');
            }
        });
    });

    // Φόρτωση προϊόντων κατά επιλογή κατηγορίας
    $('#categorySelectForItems').change(function() {
        var selectedCategory = $(this).val();
        loadItems(selectedCategory);
    });

    function showNotification(message, isError = false) {
        const popup = $('#notificationPopup');
        const messageBox = $('#notificationMessage');

        // Ορισμός μηνύματος
        messageBox.text(message);

        // Αν είναι σφάλμα, προσθέστε το κόκκινο background
        if (isError) {
            popup.addClass('error');
        } else {
            popup.removeClass('error');
        }

        // Εμφάνιση popup
        popup.addClass('show');

        // Απόκρυψη μετά από 3 δευτερόλεπτα
        setTimeout(function() {
            popup.removeClass('show');
        }, 3000);
    }



});
