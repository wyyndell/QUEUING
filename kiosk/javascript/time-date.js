//   time and Date 
  function updateTimeAndDate() {
            const dateElement = document.querySelector('.date');
            const yearElement = document.querySelector('.year');
            const timeElement = document.querySelector('.time');
            const dayElement = document.querySelector('.day');
        
            const now = new Date();
            
            const day = now.toLocaleDateString('en-US', { day: '2-digit' });
            const month = now.toLocaleDateString('en-US', { month: 'long' });
            const year = now.toLocaleDateString('en-US', { year: 'numeric' });
        
            dateElement.textContent = `${day} ${month}`;
            yearElement.textContent = year;
            timeElement.textContent = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
            dayElement.textContent = now.toLocaleDateString('en-US', { weekday: 'long' });
        }
        
        // Call updateTimeAndDate every second to keep time up-to-date
        setInterval(updateTimeAndDate, 1000);
        
        // Initial call to set initial time and date
        updateTimeAndDate();

