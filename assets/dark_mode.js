document.addEventListener("DOMContentLoaded", function() {
    const toggleButton = document.getElementById("darkModeToggle");

    // Check if dark mode is saved in cookies
    if (document.cookie.includes("darkmode=true")) {
        document.body.classList.add("light-mode");
    }

    toggleButton.addEventListener("click", function() {
        document.body.classList.toggle("light-mode");
        
        // Store preference in a cookie
        if (document.body.classList.contains("light-mode")) {
            document.cookie = "darkmode=true; path=/";
        } else {
            document.cookie = "darkmode=false; path=/";
        }
    });
});
