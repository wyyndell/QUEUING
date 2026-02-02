let inactivityTimer;
let lastGeneratedNumber = 0;

function resetTimer() {
    clearTimeout(inactivityTimer);
    inactivityTimer = setTimeout(hideModal, 340000); // 60000 milliseconds = 2 minute
}

// Function to generate a unique number for the day
function generateUniqueNumber() {
    const today = new Date().toISOString().slice(0, 10); // Get today's date in YYYY-MM-DD format
    const storedDate = localStorage.getItem('generatedDate');
    let count = parseInt(localStorage.getItem('generatedCount')) || 0;

    if (storedDate !== today) {
        // Reset count for a new day
        count = 0;
        localStorage.setItem('generatedDate', today);
    }

    count++;
    localStorage.setItem('generatedCount', count.toString());

    return count;
}

// Function to show modal and set client number
function showModal() {
    const randomNumber = generateUniqueNumber();
    document.getElementById('clientnumber').value = randomNumber;
    lastGeneratedNumber = randomNumber;
    document.getElementById('modalContainer').style.display = 'flex';
    resetTimer(); // Start the inactivity timer when modal is shown
}

// Function to hide modal
function hideModal() {
    document.getElementById('modalContainer').style.display = 'none';
}

// Event listener for button click
document.getElementById('click').addEventListener('click', showModal);

// Event listener for close button
document.getElementById('closeModal').addEventListener('click', hideModal);

// Event listener for clicking outside the modal
window.addEventListener('click', function(event) {
    const modal = document.getElementById('modalContainer');
    if (event.target === modal) {
        hideModal();
    }
});

// Web Speech API for voice recognition
window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

const recognition = new SpeechRecognition();
recognition.continuous = true;
recognition.interimResults = false;
recognition.lang = 'en-US';

recognition.onresult = (event) => {
    const transcript = Array.from(event.results)
        .map(result => result[0])
        .map(result => result.transcript)
        .join('')
        .toLowerCase();

    const modalIsActive = document.getElementById('modalContainer').style.display === 'flex';

    if (transcript.includes('hello')) {
        showModal();
    } else if (transcript.includes('sorry') && modalIsActive) {
        hideModal();
    }

    // Reset timer on voice interaction
    resetTimer();
};

recognition.onend = () => {
    recognition.start(); // Restart the recognition service when it ends
};

recognition.start();

// Reset the timer on any user interaction within the modal
document.getElementById('modalContainer').addEventListener('mousemove', resetTimer);
document.getElementById('modalContainer').addEventListener('keypress', resetTimer);

// Initialize the last generated number when the page loads
window.addEventListener('DOMContentLoaded', () => {
    const today = new Date().toISOString().slice(0, 10);
    const storedDate = localStorage.getItem('generatedDate');

    if (storedDate === today) {
        // If the stored date is today, retrieve the last generated number
        lastGeneratedNumber = parseInt(localStorage.getItem('generatedCount')) || 0;
    }
});