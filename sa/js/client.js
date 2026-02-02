// Function to update the time and date every second
function updateTimeAndDate() {
  const dateElement = document.querySelector('.date');
  const yearElement = document.querySelector('.year');
  const timeElement = document.querySelector('.time');
  const dayElement = document.querySelector('.day');

  const now = new Date();

  // Format date and time
  const day = now.toLocaleDateString('en-US', { day: '2-digit' });
  const month = now.toLocaleDateString('en-US', { month: 'long' });
  const year = now.toLocaleDateString('en-US', { year: 'numeric' });

  // Update date and time elements
  dateElement.textContent = `${day} ${month}`;
  yearElement.textContent = year;
  timeElement.textContent = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
  dayElement.textContent = now.toLocaleDateString('en-US', { weekday: 'long' });
}

// Call updateTimeAndDate every second to keep time up-to-date
setInterval(updateTimeAndDate, 1000);

// Initial call to set initial time and date
updateTimeAndDate();



// review modal
// Function to open the modal
function openModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    displayUserData();
}

// Function to close the modal
function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}

// Function to display user input in the modal
function displayUserData() {
    var reviewData = document.getElementById("reviewData");
    reviewData.innerHTML = "";

    // Get form data
    var formData = new FormData(document.getElementById("dataForm"));

    // Display user input
    for (var pair of formData.entries()) {
        var p = document.createElement("p");
        p.textContent = pair[0].replace("_", " ") + ": " + pair[1];
        reviewData.appendChild(p);
    }
}



// Function to submit the form
function submitForm() {
    document.getElementById("dataForm").submit();
}

// Function to scroll to an element by its id
function scrollToElement(id) {
    var element = document.getElementById(id);
    if (element) {
        element.scrollIntoView();
    }
}

// Listen for the page load event
window.addEventListener('load', function() {
    // After the page fully loads, execute the scrolling function
    scrollToElement("office");
});





