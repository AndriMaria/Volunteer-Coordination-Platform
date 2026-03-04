document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById("itemsModal");
    var btn = document.getElementById("openItemsModal");
    var span = document.getElementsByClassName("close")[0];
    var addItemsBtn = document.getElementById("addItemsToList");
    var selectedItemsList = document.getElementById("selectedItemsList");

    // Άνοιγμα του modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // Κλείσιμο του modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Προσθήκη επιλεγμένων ειδών στη λίστα
    addItemsBtn.onclick = function() {
        var itemsSelect = document.getElementById("itemsSelect");
        var selectedOptions = Array.from(itemsSelect.selectedOptions);
        selectedOptions.forEach(function(option) {
            if (![...selectedItemsList.children].some(li => li.textContent === option.textContent)) {
                var li = document.createElement("li");
                li.textContent = option.textContent;
                li.setAttribute("data-id", option.value); // Προσθήκη data-id
                selectedItemsList.appendChild(li);
            }
        });
        modal.style.display = "none";
        updateHiddenField(); // Ενημέρωση κρυφού πεδίου
    }

    // Ενημέρωση κρυφού πεδίου με τα IDs των επιλεγμένων ειδών
    function updateHiddenField() {
        var selectedItems = [];
        document.querySelectorAll("#selectedItemsList li").forEach(function(item) {
            selectedItems.push(item.getAttribute("data-id"));
        });
        document.getElementById("items").value = JSON.stringify(selectedItems);
    }
});
