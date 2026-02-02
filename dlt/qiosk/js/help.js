document.addEventListener('DOMContentLoaded', function () {
    const guideButton = document.getElementById('guideButton');
    const aboutButton = document.getElementById('aboutButton');
    const infoButton = document.getElementById('infoButton');
    const modal = document.getElementById('modal');
    const closeModal = document.getElementById('closeModal');
    const guideContent = document.getElementById('guideContent');
    const aboutContent = document.getElementById('aboutContent');
    const infoContent = document.getElementById('infoContent');

    guideButton.addEventListener('click', function () {
        showContent(guideContent);
    });

    aboutButton.addEventListener('click', function () {
        showContent(aboutContent);
    });

    infoButton.addEventListener('click', function () {
        showContent(infoContent);
    });

    closeModal.addEventListener('click', function () {
        modal.classList.remove('show');
    });

    function showContent(content) {
        guideContent.style.display = 'none';
        aboutContent.style.display = 'none';
        infoContent.style.display = 'none';
        content.style.display = 'block';
        modal.classList.add('show');
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const navTitles = document.querySelectorAll('.nav-title');
    const mainNavTitle = document.querySelector('.nav-titles');

    navTitles.forEach(function(navTitle) {
        navTitle.addEventListener('click', function() {
            const targetContent = navTitle.getAttribute('data-target');
            if (targetContent) {
                // Update the main nav title text
                mainNavTitle.textContent = navTitle.textContent;

                // Optional: Show the corresponding content
                document.querySelectorAll('.button-nav').forEach(function(content) {
                    content.style.display = 'none'; // Hide all content
                });
                document.getElementById(targetContent).style.display = 'block'; // Show the target content
            }
        });
    });

    // Close modal functionality
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('modal').style.display = 'none';
    });
});