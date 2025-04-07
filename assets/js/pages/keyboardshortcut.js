// POS Keyboard Shortcuts
document.addEventListener("DOMContentLoaded", function () {
    // Only enable shortcuts on POS page
    if (!document.querySelector(".pos-wrapper")) return;

    document.addEventListener("keydown", function (e) {
        // Don't trigger shortcuts when typing in input fields
        if (
            e.target.tagName === "INPUT" ||
            e.target.tagName === "TEXTAREA" ||
            e.target.tagName === "SELECT"
        )
            return;

        // Prevent default for ALL browser shortcuts (Ctrl, Alt, Meta combinations)
        if (e.ctrlKey) {
            e.preventDefault();
        }

        // Prevent default for function keys
        if (e.key.startsWith("F")) {
            e.preventDefault();
        }

        // Define shortcuts
        switch (true) {
            // Function key shortcuts
            case e.key === "F2": // Search products
                document.getElementById("search-medicine").focus();
                break;
            case e.key === "F3": // View orders
                document.querySelector('[data-bs-target="#orders"]').click();
                break;
            case e.key === "F4": // Reset POS
                document.getElementById("reset-pos").click();
                break;
            case e.key === "F8": // Hold order
                document.querySelector(".hold-order").click();
                break;
            case e.key === "F9": // Void order
                document.querySelector(".void-order").click();
                break;
            case e.key === "F10": // Payment
                document.getElementById("payment-btn").click();
                break;

            // Ctrl + key shortcuts
            case e.ctrlKey && e.key === "p": // Proceed to payment
                document.getElementById("payment-btn").click();
                break;
            case e.ctrlKey && e.key === "r": // Reset POS
                document.getElementById("reset-pos").click();
                break;
            case e.ctrlKey && e.key === "c": // Clear cart
                document.getElementById("clear-cart").click();
                break;
            case e.ctrlKey && e.key === "h": // Hold order
                document.querySelector(".hold-order").click();
                break;
            case e.ctrlKey && e.key === "v": // Void order
                document.querySelector(".void-order").click();
                break;
            case e.ctrlKey && e.key === "s": // Search products
                document.getElementById("search-medicine").focus();
                break;
            case e.ctrlKey && e.key === "n": // Add new customer
                document.querySelector('[data-bs-target="#create"]').click();
                break;
            case e.ctrlKey && e.key === "a": // View all categories
                document.querySelector("li#all a").click();
                break;
        }
    });
});

// Function to show keyboard shortcut modal
function showKeyboardShortcutModal() {
    const modal = document.getElementById("keyboard-shortcuts-modal");
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
}
