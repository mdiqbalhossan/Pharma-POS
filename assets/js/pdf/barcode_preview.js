$(document).ready(function () {
    "use strict";
    // Print Barcode
    $(document).on("click", "#print_btn", function () {
        let container = $(".barcode-container");

        let printWindow = window.open("", "_blank");
        printWindow.document.write("<html><head><title>Barcode Print</title>");
        printWindow.document.write(
            `<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">`
        );
        printWindow.document.write(`<style>body{padding:15px;}</link>`);
        printWindow.document.write("</head><body>");
        printWindow.document.write(container.html());
        printWindow.document.write("</body></html>");
        printWindow.document.close();

        printWindow.onload = function () {
            printWindow.focus();
            printWindow.print();
        };

        // After print save or close then close the print window
        printWindow.onbeforeunload = function () {
            printWindow.close();
        };
    });
});
