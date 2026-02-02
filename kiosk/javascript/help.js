document.addEventListener('DOMContentLoaded', function () {
    const guideButton = document.getElementById('guideButton');
    const aboutButton = document.getElementById('aboutButton');
    const devButton = document.getElementById('devButton');
    const modal = document.getElementById('modal');
    const closeModal = document.getElementById('closeModal');
    const guideContent = document.getElementById('guideContent');
    const aboutContent = document.getElementById('aboutContent');
    const devContent = document.getElementById('devContent');

    guideButton.addEventListener('click', function () {
        showContent(guideContent);
    });

    aboutButton.addEventListener('click', function () {
        showContent(aboutContent);
    });

    devButton.addEventListener('click', function () {
        showContent(devContent);
    });

    closeModal.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    function showContent(content) {
        guideContent.style.display = 'none';
        aboutContent.style.display = 'none';
        devContent.style.display = 'none';
        content.style.display = 'block';
        modal.style.display = 'flex';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const navTitles = document.querySelectorAll('.nav-title');
    const mainNavTitle = document.querySelector('.nav-titles');

    navTitles.forEach(function(navTitle) {
        navTitle.addEventListener('click', function() {
            const targetContent = navTitle.getAttribute('data-target');
            if (targetContent) {
                mainNavTitle.textContent = navTitle.textContent;
                document.querySelectorAll('.nav').forEach(function(content) {
                    content.style.display = 'none';
                });
                document.getElementById(targetContent).style.display = 'block';
            }
        });
    });
});


