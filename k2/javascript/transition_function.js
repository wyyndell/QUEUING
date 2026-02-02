// Container transition on the other container

//  Steps Function
function next(currentStep, nextStep) {
  document.getElementById(currentStep).classList.remove('active');
  document.getElementById(nextStep).classList.add('active');
}

function prev(currentStep, prevStep) {
  document.getElementById(currentStep).classList.remove('active');
  document.getElementById(prevStep).classList.add('active');
}


// Review-Transition " not working function "
document.addEventListener('DOMContentLoaded', function() {
  const reviewYesBtn = document.getElementById('review-yes');
  const reviewNoBtn = document.getElementById('review-no');
  const modal = document.getElementById('modal');
  const modalCard = document.getElementById('modal-card');
  const reviewSection = document.getElementById('review');

  function showReview() {
    reviewSection.style.display = 'flex';
    reviewSection.classList.add('show');
  }

  function showAndHide() {
    reviewSection.style.display = 'none';
    modal.style.display = 'flex';
    modalCard.style.display = 'block';
    modalCard.classList.add('animate');
  }

  reviewYesBtn.addEventListener('click', function() {
    showAndHide();
  });

  reviewNoBtn.addEventListener('click', function() {
    reviewSection.style.display = 'none';
  });

  window.showReview = showReview;
});



// Selection of services button funtion " Allow the user to select on services"
const btnPrimaryList = document.querySelectorAll('.btn-primary');
btnPrimaryList.forEach(btn => {
  btn.addEventListener('click', function() {
    // Deselect all other buttons first
    btnPrimaryList.forEach(b => {
      if (b !== this) {
        b.classList.remove('selected');
      }
    });

    // Toggle the selected class for the clicked button
    this.classList.toggle('selected');
  });
});


// Services function and animation of button 

 // Function to handle click events on .btn-secondary elements
const btnServiceList = document.querySelectorAll('.btn-secondary');
btnServiceList.forEach(btn => {
  btn.addEventListener('click', function() {
    // Toggle the selected class for the clicked button
    this.classList.toggle('selected');
  });
});

// Function to handle intersection observer animations
function animateOnScroll(entries, observer) {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('btn-animation');
      observer.unobserve(entry.target); // Stop observing once animated
    } else {
      entry.target.classList.remove('btn-animation'); // Remove animation class when scrolled out
    }
  });
}

// Service animation 
document.addEventListener('DOMContentLoaded', () => {
  const btnSecondaryList = document.querySelectorAll('.btn-secondary');

  const observerOptions = {
    root: null, // Use the viewport as the root
    rootMargin: '0px',
    threshold: 0.2 // Lower threshold for smoother entry
  };

  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('appear');
        entry.target.classList.remove('disappear');
      } else {
        entry.target.classList.remove('appear');
        entry.target.classList.add('disappear');
      }
    });
  }, observerOptions);

  btnSecondaryList.forEach(btn => {
    observer.observe(btn);
    // Ensure initial state is set correctly
    if (!btn.classList.contains('appear')) {
      btn.classList.add('disappear');
    }
  });
});


// Gender Function 
const btnGenderList = document.querySelectorAll('.btn-gender');
btnGenderList.forEach(btn => {
  btn.addEventListener('click', function() {
    // Deselect all other buttons first
    btnGenderList.forEach(b => {
      if (b !== this) {
        b.classList.remove('selected');
      }
    });

    // Toggle the selected class for the clicked button
    this.classList.toggle('selected');
  });
});

    // Gender and Info Animation
    document.addEventListener('DOMContentLoaded', () => {
      const labelList = document.querySelectorAll('.label');
      const btnGenderList = document.querySelectorAll('.btn-gender');
    
      const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.2
      };
    
      const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('appear');
          } else {
            entry.target.classList.remove('appear');
          }
        });
      };
    
      const labelObserver = new IntersectionObserver(observerCallback, observerOptions);
      const btnGenderObserver = new IntersectionObserver(observerCallback, observerOptions);
    
      labelList.forEach(label => {
        labelObserver.observe(label);
        if (!label.classList.contains('appear')) {
          label.classList.add('disappear');
        }
      });
    
      btnGenderList.forEach(btn => {
        btnGenderObserver.observe(btn);
        if (!btn.classList.contains('appear')) {
          btn.classList.add('disappear');
        }
      });
    });


// Type
document.addEventListener('DOMContentLoaded', () => {
  const btnTypeList = document.querySelectorAll('.btn-type-name');

  const observerOptions = {
    root: null, // Use the viewport as the root
    rootMargin: '0px',
    threshold: 0.2 // Adjust threshold as needed
  };

  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('appear');
        entry.target.classList.remove('disappear');
      } else {
        entry.target.classList.remove('appear');
        entry.target.classList.add('disappear');
      }
    });
  }, observerOptions);

  btnTypeList.forEach(btn => {
    observer.observe(btn);
    // Ensure initial state is set correctly
    if (!btn.classList.contains('appear')) {
      btn.classList.add('disappear');
    }

    // Handle button click for selection
    btn.addEventListener('click', function() {
      // Deselect all other buttons first
      btnTypeList.forEach(b => {
        if (b !== this) {
          b.classList.remove('selected');
        }
      });

      // Toggle the selected class for the clicked button
      this.classList.toggle('selected');
    });
  });
});


// Help 

const guideWrapper = document.querySelector('.guide-wrapper');
    const guideModal = document.querySelector('.guide-modal');

    // Function to toggle modal visibility
    function toggleInformation(event) {
      const isClickedInsideGuide = guideWrapper.contains(event.target); // Check if clicked inside .guide-wrapper

      if (!isClickedInsideGuide) {
        guideWrapper.classList.remove('active'); // Remove 'active' class if clicked outside
      } else {
        guideWrapper.classList.toggle('active'); // Toggle 'active' class if clicked inside
      }
    }

    // Event listener to close modal when clicking outside of it
    document.addEventListener('click', function(event) {
      toggleInformation(event);
    });


    function proceedToNextPage() {
      window.location.href = 'offices.html';
    }


    // Office 
    document.addEventListener('DOMContentLoaded', () => {
      const btnPrimaryList = document.querySelectorAll('.btn-primary');
    
      const observerOptions = {
        root: null, // Use the viewport as the root
        rootMargin: '0px',
        threshold: 0.2 // Adjust threshold as needed
      };
    
      const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('appear');
            entry.target.classList.remove('disappear');
          } else {
            entry.target.classList.remove('appear');
            entry.target.classList.add('disappear');
          }
        });
      }, observerOptions);
    
      btnPrimaryList.forEach(btn => {
        observer.observe(btn);
        // Ensure initial state is set correctly
        if (!btn.classList.contains('appear')) {
          btn.classList.add('disappear');
        }
      });
    });
    

    

    // Client number
    document.addEventListener('DOMContentLoaded', function() {
      const inputs = document.querySelectorAll('.line-number');
  
      inputs.forEach((input, index) => {
          input.addEventListener('input', function(e) {
              // Ensure only one digit is entered
              this.value = this.value.replace(/\D/g, '').slice(0, 1);
  
              // Move to the next input if the current one is filled
              if (this.value.length === 1 && index < inputs.length - 1) {
                  inputs[index + 1].focus();
              }
          });
  
          input.addEventListener('keydown', function(e) {
              if (e.key === 'Backspace') {
                  // Prevent default behavior of backspace
                  e.preventDefault();
  
                  if (this.value === '' && index > 0) {
                      inputs[index - 1].focus();
                  } else {
                      // Clear the current input if it is not empty
                      this.value = '';
                  }
              }
          });
      });
  });

  //Review Function

  // document.addEventListener('DOMContentLoaded', function() {
  //   const reviewYesBtn = document.getElementById('review-yes');
  //   const modal = document.getElementById('modal');
  //   const modalCard = document.getElementById('modal-card');
  //   const reviewSection = document.getElementById('review');
  
  //   function showReview() {
  //     reviewSection.style.display = 'flex';
  //     reviewSection.classList.add('show');
  //   }
  
  //   // Function to show modal and hide review section
  //   function showAndHide() {
  //     reviewSection.style.display = 'none'; // Hide the review section
  //     modal.style.display = 'flex'; // Show the modal container
  //     modalCard.style.display = 'block'; // Show the modal card
  //     modalCard.classList.add('animate'); // Trigger animation
  //   }
  
  //   // Event listener for "Yes" button
  //   reviewYesBtn.addEventListener('click', function() {
  //     showAndHide();
  //   });
  
  //   // Event listener for "No" button (if needed)
  //   const reviewNoBtn = document.getElementById('review-no');
  //   reviewNoBtn.addEventListener('click', function() {
  //     reviewSection.style.display = 'none'; // Hide the review section
  //   });
  
  //   // For debugging, ensure the showReview function is called when the submit button is clicked
  //   window.showReview = showReview;
  // });
  



  // Tooltip
  document.addEventListener('DOMContentLoaded', function() {
    const tooltip = document.querySelector('.guide-wrapper .tooltip-guide');
    setInterval(() => {
        tooltip.classList.toggle('show');
    }, 5000); // 5000 milliseconds = 5 seconds
});


// Click sound
  document.addEventListener('DOMContentLoaded', function() {
    const context = new (window.AudioContext || window.webkitAudioContext)();

    function playClickSound() {
      const oscillator = context.createOscillator();
      const gainNode = context.createGain();

      oscillator.connect(gainNode);
      gainNode.connect(context.destination);

      oscillator.type = 'square'; // Square wave for a click sound
      oscillator.frequency.setValueAtTime(1000, context.currentTime); // Frequency around 1kHz
      oscillator.start(context.currentTime);
      oscillator.stop(context.currentTime + 0.05); // Short click

      gainNode.gain.setValueAtTime(0.1, context.currentTime); // Volume
      gainNode.gain.exponentialRampToValueAtTime(0.001, context.currentTime + 0.05); // Quick fade out
    }

    const buttons = document.querySelectorAll('button');

    buttons.forEach(button => {
      button.addEventListener('click', function() {
        playClickSound();
      });
    });
  });

  function ToggleZoom() {
    // Your existing ToggleZoom function logic here
  }

  function showServices() {
    // Your existing showServices function logic here
  }
    
    

