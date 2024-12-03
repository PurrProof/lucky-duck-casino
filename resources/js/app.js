import "./bootstrap";

document.addEventListener("DOMContentLoaded", () => {
    setupNotifications();
    setupTabs();
    activateTabFromHash();
    setupUserLinks();
});

function setupNotifications() {
    const deleteButtons = document.querySelectorAll(".notification .delete");
    deleteButtons.forEach((button) => {
        const notification = button.parentNode;
        button.addEventListener("click", () => {
            notification.remove();
        });
    });
}

function setupTabs() {
    const tabs = document.querySelectorAll(".tabs ul li");
    const tabContents = document.querySelectorAll(".tab-content");

    tabs.forEach((tab, index) => {
        tab.addEventListener("click", () => {
            activateTab(tabs, tabContents, index);
        });
    });
}

function activateTab(tabs, tabContents, index) {
    // Deactivate all tabs and hide all content
    tabs.forEach((tab) => tab.classList.remove("is-active"));
    tabContents.forEach((content) => (content.style.display = "none"));

    // Activate the clicked tab and its corresponding content
    tabs[index].classList.add("is-active");
    tabContents[index].style.display = "";
}

function activateTabFromHash() {
    const hash = window.location.hash;
    if (hash) {
        const targetTab = document.querySelector(
            `.tabs ul li a[href="${hash}"]`
        );
        if (targetTab) {
            const tabs = document.querySelectorAll(".tabs ul li");
            const tabContents = document.querySelectorAll(".tab-content");

            const targetIndex = Array.from(tabs).findIndex(
                (tab) => tab.querySelector("a") === targetTab
            );

            if (targetIndex !== -1) {
                activateTab(tabs, tabContents, targetIndex);
            }
        }
    }
}

function setupUserLinks() {
    document.querySelectorAll(".user-link").forEach((link) => {
        link.addEventListener("click", (event) => {
            event.preventDefault();

            const login = link.dataset.login;
            const phone = link.dataset.phone;

            // Populate the form fields
            document.querySelector("#login").value = login;
            document.querySelector("#phone").value = phone;
        });
    });
}
