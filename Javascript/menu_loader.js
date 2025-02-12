document.addEventListener("DOMContentLoaded", function () {

    // Dynamically add the menu.css stylesheet
    const link = document.createElement("link");
    link.rel = "stylesheet";
    link.href = "../../Styles/menu.css"; // Correct the path to your CSS file
    document.head.appendChild(link);

    // Fetch the menu content from menu.php
    fetch("menu.php")
        .then(response => response.text())
        .then(data => {
            // Create a temporary element to parse HTML
            let tempDiv = document.createElement("div");
            tempDiv.innerHTML = data;

            // Extract the menu section from the response
            let menuSection = tempDiv.querySelector("#menu-items");
            if (menuSection) {
                // Insert the menu content into the parent container
                const menuContainer = document.getElementById("menu-container");
                if (menuContainer) {
                    menuContainer.innerHTML = menuSection.outerHTML;
                } else {
                    console.error("Menu container not found on the page.");
                }
            } else {
                console.error("Menu section not found in menu.php.");
            }
        })
        .catch(error => console.error("Error loading menu:", error));
});
