$(document).ready(function(){
    // Add input field with animation when the button is clicked
    $('#addServiceButton').click(function(){
        var selectedOffice = $('select[name="admin_username"]').val();
        var newInputField = $('<div class="form-row p-1" style="display: none;"><div class="col"><input class="form-control" type="text" name="services[]" placeholder="Service"><input type="hidden" name="offices[]" value="' + selectedOffice + '"></div></div>');
        $('#servicesContainer').append(newInputField);
        newInputField.slideDown(); // Slide down animation
    });
});





        // Wait for the document to be fully loaded         for control buttons Add, View,
        document.addEventListener('DOMContentLoaded', function() {
            // Get the button element
            var toggleButton = document.getElementById('offices_toggle');

            // Get the content-data element
            var contentData = document.querySelector('.content-data.hidden1');

            // Add click event listener to the button
            toggleButton.addEventListener('click', function() {

                // Toggle the visibility of the content-data element
                contentData.classList.toggle('hidden1');
            });
        });

        // Wait for the document to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Get the button element
            var toggleButton = document.getElementById('services_toggle');

            // Get the content-data element
            var contentData = document.querySelector('.content-data');

            // Add click event listener to the button
            toggleButton.addEventListener('click', function() {

                // Toggle the visibility of the content-data element
                contentData.classList.toggle('hidden');
            });
        });


        // Wait for the document to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Get the button element
            var toggleButton = document.getElementById('view_toggle');

            // Get the content-data element
            var contentData = document.querySelector('.content-data.hidden2');

            // Add click event listener to the button
            toggleButton.addEventListener('click', function() {

                // Toggle the visibility of the content-data element
                contentData.classList.toggle('hidden2');
            });
        });


        // Wait for the document to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Get the button element
            var chatButton = document.getElementById('chatButton');

            // Get the content-data element
            var contentData = document.querySelector('.content-data.chat');

            // Add click event listener to the button
            chatButton.addEventListener('click', function() {

                // Toggle the visibility of the content-data element
                contentData.classList.toggle('chat');
            });
        });


        // Wait for the document to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Get the button element
            var closeButton = document.getElementById('closeButton');

            // Get the content-data element
            var contentData = document.querySelector('.content-data.chat');

            // Add click event listener to the button
            closeButton.addEventListener('click', function() {

                // Toggle the visibility of the content-data element
                contentData.classList.toggle('chat');
            });
        });


        $(document).ready(function(){
        // When an office is selected, load corresponding records
        $('#admin_office').change(function(){
            var selectedOffice = $(this).val();
            $.ajax({
                url: 'get_records.php',
                type: 'POST',
                data: { selected_office: selectedOffice },
                dataType: 'html',
                success: function(data){
                    $('#records_table').html(data);
                }
            });
        });
    });
