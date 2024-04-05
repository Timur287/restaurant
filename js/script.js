function openModal(dialogId, values) {
    let dialog = document.getElementById(dialogId);
    dialog.showModal();

    for (let inputId in values) {
        let input = document.getElementById(inputId);
        if (input) {
            input.value = values[inputId];
        } else {
            console.error("Элемент с идентификатором " + inputId + " не найден");
        }
    }
}

function showDefaultData() {
    let currentDate = new Date();
    currentDate.setHours(currentDate.getHours() + 3);
    document.getElementById('selected_date').value = currentDate.toISOString().slice(0, 10);
    showData();
}

function showData() {
    let selectedDate = document.getElementById('selected_date').value;
    $.ajax({
        url: 'get_reservations.php',
        type: 'POST',
        data: {selected_date: selectedDate},
        success: function(response) {
            $('#reservationsContainer').html(response);
        },
    });
}

function setDepartureTime(arrive_id, departure_id) {
    let arrivalTime = document.getElementById(arrive_id).value;
    let arrivalDate = new Date(arrivalTime);
    arrivalDate.setHours(26, 59);
    document.getElementById(departure_id).value = arrivalDate.toISOString().slice(0, 16);
}

document.addEventListener('DOMContentLoaded', function() {
    let current_page = window.location.pathname;
    let navLinks = document.querySelectorAll('.navbar-item-inner .flexbox-left a');
    navLinks.forEach(function(link) {
        if (link.pathname === current_page) {
            link.classList.add('current');
        }
    });
});

$('.input-file input[type=file]').on('change', function(){
    let file = this.files[0];
    $(this).next().html(file.name);
});

function showDishOptions() {
    document.getElementById("addDishButton").style.display = "none";
    document.getElementById("dishOptions").style.display = "block";
    document.getElementById("addAnotherDishButton").style.display = "none";
}
let totalPrice = 0;

function addSelectedDish() {
    let select = document.getElementById('dishSelect');
    let selectedOption = select.options[select.selectedIndex];
    let selectedDishId = selectedOption.getAttribute('data-id');
    let selectedDishName = selectedOption.text;
    let selectedDishCost = parseFloat(selectedOption.getAttribute('data-cost'));

    totalPrice += selectedDishCost;

    let selectedDishesContainer = document.getElementById('selectedDishes');
    let selectedDishInput = document.createElement('input');
    selectedDishInput.value = selectedDishId;
    selectedDishInput.name = 'dish_id[]';
    selectedDishInput.readOnly = true;
    selectedDishInput.hidden = true;
    selectedDishesContainer.appendChild(selectedDishInput);

    let selectedDishDiv = document.createElement('div');
    selectedDishDiv.textContent = selectedDishName;
    selectedDishesContainer.appendChild(selectedDishDiv);

    document.getElementById('totalCost').innerText = 'Общая стоимость: ' + totalPrice.toFixed(2);
    document.getElementById('dishOptions').style.display = 'none';
    document.getElementById('addAnotherDishButton').style.display = 'block';
}
