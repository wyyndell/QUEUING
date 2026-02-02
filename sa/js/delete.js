// Add event listener to all delete buttons
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const serviceId = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this service?')) {
                // Send AJAX request to delete service
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert(xhr.responseText);
                        // Reload the page after successful deletion
                        location.reload();
                    } else {
                        alert('Failed to delete service.');
                    }
                };
                xhr.send('delete_id=' + serviceId);
            }
        });
    });

    // Add event listener to all update buttons
    document.querySelectorAll('.update-btn').forEach(button => {
        button.addEventListener('click', function() {
            const serviceId = this.getAttribute('data-id');
            // Prompt user for new service name
            const newServiceName = prompt('Enter the new service name:');
            if (newServiceName !== null) {
                // Send AJAX request to update service
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'update.php', true); // Update 'your_update_script.php' with the actual filename
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert(xhr.responseText);
                        // Reload the page after successful update
                        location.reload();
                    } else {
                        alert('Failed to update service.');
                    }
                };
                xhr.send('update_id=' + serviceId + '&new_service_name=' + encodeURIComponent(newServiceName));
            }
        });
    });


    document.querySelectorAll('.update-admin-btn').forEach(button => {
    button.addEventListener('click', function() {
        const adminUsername = this.getAttribute('data-username');
        const newFname = prompt('Enter the new first name:');
        const newLname = prompt('Enter the new last name:');
        if (newFname !== null && newLname !== null) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_personnel.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    // Reload the page after successful update
                    location.reload();
                } else {
                    alert('Failed to update personnel.');
                }
            };
            // Send form data including username
            xhr.send('new_fname=' + encodeURIComponent(newFname) + '&new_lname=' + encodeURIComponent(newLname) + '&username=' + encodeURIComponent(adminUsername));
        }
    });
});
