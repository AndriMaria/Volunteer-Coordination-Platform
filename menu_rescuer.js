document.addEventListener("DOMContentLoaded", function() {
    var itemsContainer = document.getElementById("items-container");
    var loadItemSelect = document.getElementById("load-item-select");
    var loadItemQuantity = document.getElementById("load-item-quantity");
    var loadButton = document.getElementById("load-button");
    var unloadItemSelect = document.getElementById("unload-item-select");
    var unloadButton = document.getElementById("unload-button");
    var categorySelect = document.getElementById("category-select");

    var baseLat = 38.289182; // Latitude of the base
    var baseLon = 21.795689; // Longitude of the base

    // Ανάκτηση θέσης marker από localStorage
    var savedPosition = localStorage.getItem('markerPosition');
    var latLng = savedPosition ? JSON.parse(savedPosition) : { lat: 38.2766684, lon: 21.7514926 };
    var rescuerLat = latLng.lat;
    var rescuerLon = latLng.lon;

    // Υπολογισμός απόστασης
    function getDistance(lat1, lon1, lat2, lon2) {
        var R = 6371000; // Radius of the Earth in meters
        var dLat = (lat2 - lat1) * Math.PI / 180;
        var dLon = (lon2 - lon1) * Math.PI / 180;
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var distance = R * c; // in meters
        return distance;
    }

    // Ενημέρωση κατάστασης κουμπιών
    function updateButtonState() {
        var distance = getDistance(rescuerLat, rescuerLon, baseLat, baseLon);
        console.log("Απόσταση από τη βάση: " + distance + " μέτρα"); // Για διαγνωστικούς σκοπούς
        if (distance <= 100) {
            loadButton.disabled = false;
            unloadButton.disabled = false;
        } else {
            loadButton.disabled = true;
            unloadButton.disabled = true;
        }
    }

    // Ενημέρωση των συντεταγμένων του διασώστη όταν μετακινείται το marker
    function updateRescuerCoordinates(lat, lon) {
        rescuerLat = lat;
        rescuerLon = lon;
        localStorage.setItem('markerPosition', JSON.stringify({ lat: lat, lon: lon }));
        updateButtonState(); // Ενημέρωση της κατάστασης των κουμπιών
    }

    // Λήψη και εμφάνιση των αντικειμένων του διασώστη
    function updateRescuerItems() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_rescuer_items.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.error) {
                        itemsContainer.innerHTML = "<p>" + response.error + "</p>";
                    } else {
                        var html = "<table border='1'><tr><th>Item ID</th><th>Name</th><th>Quantity</th></tr>";
                        unloadItemSelect.innerHTML = ""; // Clear previous options

                        response.forEach(function(item) {
                            html += "<tr><td>" + item.item_id + "</td><td>" + item.name_item + "</td><td>" + item.quantity + "</td></tr>";
                            var option = document.createElement("option");
                            option.value = item.item_id;
                            option.text = item.name_item;
                            unloadItemSelect.add(option);
                        });

                        html += "</table>";
                        itemsContainer.innerHTML = html;
                    }
                } else {
                    itemsContainer.innerHTML = "<p>Σφάλμα κατά την ανάκτηση των αντικειμένων του διασώστη.</p>";
                }
            }
        };
        xhr.send();
    }

    // Φόρτωση αντικειμένων
    function loadItem() {
        var itemId = loadItemSelect.value;
        var quantity = loadItemQuantity.value;
        if (itemId && quantity) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "load_items.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            alert(response.error);
                        } else {
                            updateRescuerItems();
                            updateButtonState(); // Ενημέρωση της κατάστασης των κουμπιών
                        }
                    } else {
                        alert("Σφάλμα κατά τη φόρτωση του είδους.");
                    }
                }
            };
            xhr.send("item_id=" + encodeURIComponent(itemId) + "&quantity=" + encodeURIComponent(quantity));
        } else {
            alert("Παρακαλώ επιλέξτε είδος και εισάγετε ποσότητα.");
        }
    }

    // Εκφόρτωση αντικειμένων
    function unloadItem() {
        var itemId = unloadItemSelect.value;
        if (itemId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "unload_items.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            alert(response.error);
                        } else {
                            updateRescuerItems();
                            updateButtonState(); // Ενημέρωση της κατάστασης των κουμπιών
                        }
                    } else {
                        alert("Σφάλμα κατά την εκφόρτωση του είδους.");
                    }
                }
            };
            xhr.send("item_id=" + encodeURIComponent(itemId));
        } else {
            alert("Παρακαλώ επιλέξτε είδος για εκφόρτωση.");
        }
    }

    // Ενημέρωση των κατηγοριών
    function updateCategories() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_categories.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.error) {
                        categorySelect.innerHTML = "<option>Σφάλμα φόρτωσης κατηγοριών</option>";
                    } else {
                        categorySelect.innerHTML = "<option value=''>Επιλέξτε κατηγορία</option>";
                        response.forEach(function(category) {
                            var option = document.createElement("option");
                            option.value = category.id;
                            option.text = category.name;
                            categorySelect.add(option);
                        });
                    }
                } else {
                    categorySelect.innerHTML = "<option>Σφάλμα φόρτωσης κατηγοριών</option>";
                }
            }
        };
        xhr.send();
    }

    // Ενημέρωση των διαθέσιμων αντικειμένων ανάλογα με την κατηγορία
    function updateAvailableItems() {
        var categoryId = categorySelect.value;
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_items.php", true); // Fetch all items
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.error) {
                        loadItemSelect.innerHTML = "<option>Σφάλμα φόρτωσης ειδών</option>";
                    } else {
                        loadItemSelect.innerHTML = "<option value=''>Επιλέξτε είδος</option>";
                        response.forEach(function(item) {
                            if (item.category_id == categoryId) {
                                var option = document.createElement("option");
                                option.value = item.id;
                                option.text = item.name + " (" + item.quantity + ")";
                                loadItemSelect.add(option);
                            }
                        });
                    }
                } else {
                    loadItemSelect.innerHTML = "<option>Σφάλμα φόρτωσης ειδών</option>";
                }
            }
        };
        xhr.send();
    }

    categorySelect.addEventListener("change", function() {
        updateAvailableItems();
    });

    loadButton.addEventListener("click", function() {
        loadItem();
    });

    unloadButton.addEventListener("click", function() {
        unloadItem();
    });

    // Ενημέρωση της αρχικής κατάστασης των κουμπιών
    updateCategories();
    updateRescuerItems();
    updateButtonState();
});
