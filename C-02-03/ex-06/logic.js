document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-button');
    
    const savedTheme = localStorage.getItem('theme');
    
    console.log(localStorage);

    if (savedTheme === 'dark') {
        document.body.classList.remove('light-mode');
        document.body.classList.add('dark-mode');
        themeToggle.textContent = 'Light';
    }
    
    themeToggle.addEventListener('click', function() {
        if (document.body.classList.contains('dark-mode')) {
            document.body.classList.remove('dark-mode');
            document.body.classList.add('light-mode');
            themeToggle.textContent = 'Dark';
            localStorage.setItem('theme', 'light');

            console.log(localStorage);
        } else {
            document.body.classList.remove('light-mode');
            document.body.classList.add('dark-mode');
            themeToggle.textContent = 'Light';
            console.log(localStorage); 
            localStorage.setItem('theme', 'dark');
        }
    });
});
