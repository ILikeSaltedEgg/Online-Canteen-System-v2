document.addEventListener("DOMContentLoaded", function () {
    // Dynamically add the about.css stylesheet
    const link = document.createElement("link");
    link.rel = "stylesheet";
    link.href = "../../Styles/about.css"; // Ensure the correct path
    document.head.appendChild(link);

    // Fetch the content from about.php
    fetch("about.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("Failed to fetch about.php");
            }
            return response.text();
        })
        .then(data => {
            // Create a temporary element to parse HTML
            let tempDiv = document.createElement("div");
            tempDiv.innerHTML = data;

            // Extract the about section
            let aboutSection = tempDiv.querySelector(".section"); // Use class selector
            if (aboutSection) {
                // Insert into the correct container in index.php
                const aboutContainer = document.getElementById("about-container");
                if (aboutContainer) {
                    aboutContainer.appendChild(aboutSection); // Append the extracted section
                } else {
                    console.error("About container not found in index.php.");
                }
            } else {
                console.error("About section not found in about.php.");
            }
        })
        .catch(error => console.error("Error loading about:", error));
});
