document.addEventListener("DOMContentLoaded", function() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_items.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            var items = JSON.parse(xhr.responseText);
            var itemsSelect = document.getElementById("itemsSelect");
            items.forEach(function(item) {
                var option = document.createElement("option");
                option.value = item.id;
                option.textContent = item.name;
                itemsSelect.appendChild(option);
            });
        } else {
            console.error("Σφάλμα φόρτωσης των ειδών: " + xhr.statusText);
        }
    };
    xhr.onerror = function() {
        console.error("Σφάλμα δικτύου.");
    };
    xhr.send();
});
