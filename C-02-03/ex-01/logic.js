document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('change-text-btn');
    const textDisplay = document.getElementById('text-display');
    
    button.addEventListener('click', function() {
        textDisplay.textContent = "JavaScript is Fun!";
    });
});
