document.addEventListener('DOMContentLoaded', function() {
    // State to track the current transformation type
    let currentTransformIndex = 0;
    const transformTypes = ['uppercase', 'lowercase', 'sentence'];

    document.getElementById('recall').addEventListener('click', function() {
        // Get the current client_id
        const clientId = document.getElementById('id').innerText.trim();

        // Determine the current transformation type
        const transformType = transformTypes[currentTransformIndex];

        // Send an AJAX request to update the status with the current transformation type
        const formData = new FormData();
        formData.append('client_id', clientId);
        formData.append('transform_type', transformType);

        fetch('office_upper_status.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log(`Status updated to ${transformType} successfully.`);
            } else {
                console.error('Error updating status:', data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });

        // Update the transform index for the next click
        currentTransformIndex = (currentTransformIndex + 1) % transformTypes.length;
    });
});

