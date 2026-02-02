document.addEventListener('DOMContentLoaded', function() {
    const customServicesButton = document.getElementById('custom-services');
    const customModalContainer = document.getElementById('custom-modalContainer');
    const customModalCloseButton = document.getElementById('custom-modalClose');
    const customAddButton = document.getElementById('custom-addButton');
    const customAddServices = document.getElementById('custom-addServices');
    const submitServicesButton = document.getElementById('submitServicesButton');

    let isInputFocused = false;

    // Function to fetch services from the server
    function fetchServices() {
        if (isInputFocused) return; // Do not fetch services if an input field is focused

        fetch('office_fetch_services.php')
            .then(response => response.json())
            .then(data => {
                const customModalContent = document.querySelector('.custom-modal-content');
                customModalContent.innerHTML = ''; // Clear previous services

                // Populate modal with fetched services
                data.forEach(service => {
                    const customServiceHeader = document.createElement('div');
                    customServiceHeader.classList.add('custom-modal-header');
                    customServiceHeader.innerHTML = `
                        <h4>${service.services}</h4>
                        <button class="custom-forward-button" aria-label="Delete">Delete</button>
                    `;
                    customModalContent.appendChild(customServiceHeader);

                    // Event listener for delete button
                    customServiceHeader.querySelector('.custom-forward-button').addEventListener('click', function() {
                        if (confirm('Are you sure you want to delete this service?')) {
                            deleteService(service.services);
                        }
                    });
                });

                // Re-add Add button and input fields
                customModalContent.appendChild(customAddServices);
                customModalContent.appendChild(submitServicesButton);

                // Update submit button visibility after adding content
                updateSubmitButtonVisibility();
            })
            .catch(error => console.error('Error fetching services:', error));
    }

    // Function to delete a service
    function deleteService(service) {
        fetch('office_delete_service.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ service })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchServices(); // Refresh services list after deletion
            } else {
                console.error('Error deleting service:', data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Function to add a new service
    function addService(service) {
        fetch('office_add_service.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ service })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchServices(); // Refresh services list after adding
            } else {
                console.error('Error adding service:', data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Function to check if there are visible input fields with content
    function checkInputFields() {
        const inputs = customAddServices.querySelectorAll('input[type="text"]');
        for (let i = 0; i < inputs.length; i++) {
            if (inputs[i].value.trim() !== '') {
                return true; // Found non-empty input, show the button
            }
        }
        return false; // No non-empty inputs found, hide the button
    }

    // Function to update submit button visibility based on input fields
    function updateSubmitButtonVisibility() {
        if (checkInputFields()) {
            submitServicesButton.style.display = 'block';
        } else {
            submitServicesButton.style.display = 'none';
        }
    }

    // Event listener for Add button to create a new input field
    customAddButton.addEventListener('click', function() {
        const newCustomAddContainer = document.createElement('div');
        newCustomAddContainer.classList.add('custom-add-container');
        newCustomAddContainer.innerHTML = `
            <input type="text" placeholder="Service Name" class="add-service">
            <button class="custom-add-close-button" aria-label="Close">&times;</button>
        `;

        // Event listener to remove input field on close button click
        newCustomAddContainer.querySelector('.custom-add-close-button').addEventListener('click', function() {
            newCustomAddContainer.classList.add('fade-out');
            setTimeout(function() {
                newCustomAddContainer.remove();
                updateSubmitButtonVisibility(); // Update submit button visibility after removing input field
            }, 500);
        });

        // Event listener to handle input change
        newCustomAddContainer.querySelector('input').addEventListener('input', function() {
            updateSubmitButtonVisibility(); // Update submit button visibility on input change
        });

        // Event listener to track input focus state
        newCustomAddContainer.querySelector('input').addEventListener('focus', function() {
            isInputFocused = true;
        });

        newCustomAddContainer.querySelector('input').addEventListener('blur', function() {
            isInputFocused = false;
        });

        // Insert new input field before Add button
        customAddServices.insertBefore(newCustomAddContainer, customAddButton);
        setTimeout(function() {
            newCustomAddContainer.classList.add('show');
            updateSubmitButtonVisibility(); // Update submit button visibility after adding input field
        }, 100);
    });

    // Event listener for Submit button to add new services
    submitServicesButton.addEventListener('click', function() {
        const serviceInputs = customAddServices.querySelectorAll('input[type="text"]');
        const servicesToAdd = [];

        serviceInputs.forEach(input => {
            if (input.value.trim() !== '') {
                servicesToAdd.push(input.value.trim());
            }
        });

        // Add each service sequentially
        const addPromises = servicesToAdd.map(service => addService(service));

        // After all services are added, refresh the modal
        Promise.all(addPromises)
            .then(() => {
                fetchServices(); // Refresh services list
                // Clear input fields after successful addition
                serviceInputs.forEach(input => {
                    input.value = '';
                });
                updateSubmitButtonVisibility(); // Update submit button visibility after clearing inputs
                // Hide the input fields after submission
                customAddServices.querySelectorAll('.custom-add-container').forEach(container => {
                    container.remove();
                });
                // Reset the focus state
                isInputFocused = false;
            })
            .catch(error => console.error('Error adding services:', error));
    });


    // Fetch services initially and at intervals
    fetchServices();
    setInterval(fetchServices, 10000); // 10 seconds for interval fetch

    // Event listener for Services button to display modal
    customServicesButton.addEventListener('click', function() {
        customModalContainer.style.display = 'flex';
    });

    // Event listener for Modal close button to hide modal
    customModalCloseButton.addEventListener('click', function() {
        customModalContainer.style.display = 'none';
    });
});

