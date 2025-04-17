document.addEventListener("DOMContentLoaded", function () {
    // Toggle bank details section
    const bankEnabledCheckbox = document.getElementById("payment_bank_enabled");
    const bankDetailsSection = document.getElementById("bank_details_section");

    bankEnabledCheckbox.addEventListener("change", function () {
        bankDetailsSection.style.display = this.checked ? "block" : "none";
    });

    // Toggle other payment method section
    const otherEnabledCheckbox = document.getElementById(
        "payment_other_enabled"
    );
    const otherPaymentSection = document.getElementById(
        "other_payment_section"
    );

    otherEnabledCheckbox.addEventListener("change", function () {
        otherPaymentSection.style.display = this.checked ? "block" : "none";
    });
});
