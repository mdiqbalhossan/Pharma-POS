function loadJS(FILE_URL, async = true) {
    let scriptEle = document.createElement("script");

    scriptEle.setAttribute("src", FILE_URL);
    scriptEle.setAttribute("type", "text/javascript");
    scriptEle.setAttribute("async", async);

    document.body.appendChild(scriptEle);

    // success event
    scriptEle.addEventListener("load", () => {});
    // error event
    scriptEle.addEventListener("error", (ev) => {});
}

setTimeout(function () {
    $(".main-wrapper").append(
        '<div class="sidebar-settings nav-toggle" id="layoutDiv">' +
            '<div class="sidebar-content sticky-sidebar-one">' +
            '<div class="sidebar-header">' +
            '<div class="sidebar-theme-title">' +
            "<h5>Theme Customizer</h5>" +
            "<p>Customize & Preview in Real Time</p>" +
            "</div>" +
            '<div class="close-sidebar-icon d-flex">' +
            '<a class="sidebar-refresh me-2" onclick="resetData()">&#10227;</a>' +
            '<a class="sidebar-close" href="#">X</a>' +
            "</div>" +
            "</div>" +
            '<div class="sidebar-body p-0">' +
            '<form id="theme_color" method="post">' +
            '<div class="theme-mode mb-0">' +
            '<div class="theme-body-main">' +
            '<div class="theme-head">' +
            "<h6>Theme Mode</h6>" +
            "<p>Enjoy Dark & Light modes.</p>" +
            "</div>" +
            '<div class="row">' +
            '<div class="col-xl-6 ere">' +
            '<div class="layout-wrap">' +
            '<div class="d-flex align-items-center">' +
            '<div class="status-toggle d-flex align-items-center me-2">' +
            '<input type="radio" name="theme-mode" id="light_mode" class="check color-check stylemode lmode" value="light_mode" checked>' +
            '<label for="light_mode" class="checktoggles">' +
            '<img src="assets/img/theme/theme-img-01.jpg" alt="">' +
            '<span class="theme-name">Light Mode</span>' +
            "</label>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            '<div class="col-xl-6 ere">' +
            '<div class="layout-wrap">' +
            '<div class="d-flex align-items-center">' +
            '<div class="status-toggle d-flex align-items-center me-2">' +
            '<input type="radio" name="theme-mode" id="dark_mode" class="check color-check stylemode" value="dark_mode">' +
            '<label for="dark_mode" class="checktoggles">' +
            '<img src="assets/img/theme/theme-img-02.jpg" alt="">' +
            '<span class="theme-name">Dark Mode</span>' +
            "</label>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</form>" +
            '<form id="template_direction" method="post">' +
            '<div class="theme-mode border-0">' +
            '<div class="theme-head">' +
            "<h6>Direction</h6>" +
            "<p>Select the direction for your app.</p>" +
            "</div>" +
            '<div class="row">' +
            '<div class="col-xl-6 ere">' +
            '<div class="layout-wrap">' +
            '<div class="d-flex align-items-center">' +
            '<div class="status-toggle d-flex align-items-center me-2">' +
            '<input type="radio" name="direction" id="ltr" class="check direction" value="ltr" checked>' +
            '<label for="ltr" class="checktoggles">' +
            '<a href="../template/index.html"><img src="assets/img/theme/theme-img-01.jpg" alt=""></a>' +
            '<span class="theme-name">LTR</span>' +
            "</label>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            '<div class="col-xl-6 ere">' +
            '<div class="layout-wrap">' +
            '<div class="d-flex align-items-center">' +
            '<div class="status-toggle d-flex align-items-center me-2">' +
            '<input type="radio" name="direction" id="rtl" class="check direction" value="rtl">' +
            '<label for="rtl" class="checktoggles">' +
            '<a href="../template-rtl/index.html" target="_blank"><img src="assets/img/theme/theme-img-03.jpg" alt=""></a>' +
            '<span class="theme-name">RTL</span>' +
            "</label>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</form>" +
            '<form id="layout_mode" method="post">' +
            '<div class="theme-mode border-0 mb-0">' +
            '<div class="theme-head">' +
            "<h6>Layout Mode</h6>" +
            "<p>Select the primary layout style for your app.</p>" +
            "</div>" +
            '<div class="row">' +
            '<div class="col-xl-6 ere">' +
            '<div class="layout-wrap">' +
            '<div class="d-flex align-items-center">' +
            '<div class="status-toggle d-flex align-items-center me-2">' +
            '<input type="radio" name="layout" id="default_layout" class="check layout-mode" value="default">' +
            '<label for="default_layout" class="checktoggles">' +
            '<img src="assets/img/theme/theme-img-01.jpg" alt="">' +
            '<span class="theme-name">Default</span>' +
            "</label>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            '<div class="col-xl-6 ere">' +
            '<div class="layout-wrap">' +
            '<div class="d-flex align-items-center">' +
            '<div class="status-toggle d-flex align-items-center me-2">' +
            '<input type="radio" name="layout" id="box_layout" class="check layout-mode" value="box">' +
            '<label for="box_layout" class="checktoggles">' +
            '<img src="assets/img/theme/theme-img-07.jpg" alt="">' +
            '<span class="theme-name">Box</span>' +
            "</label>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            '<div class="col-xl-6 ere">' +
            '<div class="layout-wrap">' +
            '<div class="d-flex align-items-center">' +
            '<div class="status-toggle d-flex align-items-center me-2">' +
            '<input type="radio" name="layout" id="collapse_layout" class="check layout-mode" value="collapsed">' +
            '<label for="collapse_layout" class="checktoggles">' +
            '<img src="assets/img/theme/theme-img-05.jpg" alt="">' +
            '<span class="theme-name">Collapsed</span>' +
            "</label>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            '<div class="col-xl-6 ere">' +
            '<div class="layout-wrap">' +
            '<div class="d-flex align-items-center">' +
            '<div class="status-toggle d-flex align-items-center me-2">' +
            '<input type="radio" name="layout" id="horizontal_layout" class="check layout-mode" value="horizontal">' +
            '<label for="horizontal_layout" class="checktoggles">' +
            '<img src="assets/img/theme/theme-img-06.jpg" alt="">' +
            '<span class="theme-name">Horizontal</span>' +
            "</label>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            '<div class="col-xl-6 ere">' +
            '<div class="layout-wrap">' +
            '<div class="d-flex align-items-center">' +
            '<div class="status-toggle d-flex align-items-center me-2">' +
            '<input type="radio" name="layout" id="modern_layout" class="check layout-mode" value="modern">' +
            '<label for="modern_layout" class="checktoggles">' +
            '<img src="assets/img/theme/theme-img-04.jpg" alt="">' +
            '<span class="theme-name">Modern</span>' +
            "</label>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</form>" +
            '<form id="nav_color" method="post">' +
            '<div class="theme-mode">' +
            '<div class="theme-head">' +
            "<h6>Navigation Colors</h6>" +
            "<p>Setup the color for the Navigation</p>" +
            "</div>" +
            '<div class="row">' +
            '<div class="col-xl-4 ere">' +
            '<div class="layout-wrap">' +
            '<div class="d-flex align-items-center">' +
            '<div class="status-toggle d-flex align-items-center me-2">' +
            '<input type="radio" name="nav_color" id="light_color" class="check nav-color" value="light">' +
            '<label for="light_color" class="checktoggles">' +
            '<span class="theme-name">Light</span>' +
            "</label>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            '<div class="col-xl-4 ere">' +
            '<div class="layout-wrap">' +
            '<div class="d-flex align-items-center">' +
            '<div class="status-toggle d-flex align-items-center me-2">' +
            '<input type="radio" name="nav_color" id="grey_color" class="check nav-color" value="grey">' +
            '<label for="grey_color" class="checktoggles">' +
            '<span class="theme-name">Grey</span>' +
            "</label>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            '<div class="col-xl-4 ere">' +
            '<div class="layout-wrap">' +
            '<div class="d-flex align-items-center">' +
            '<div class="status-toggle d-flex align-items-center me-2">' +
            '<input type="radio" name="nav_color" id="dark_color" class="check nav-color" value="dark">' +
            '<label for="dark_color" class="checktoggles">' +
            '<span class="theme-name">Dark</span>' +
            "</label>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            '<div class="sidebar-footer">' +
            '<div class="row">' +
            '<div class="col-xl-6">' +
            '<div class="footer-preview-btn">' +
            '<button type="button" class="btn btn-secondary w-100" onclick="resetData()">Reset</button>' +
            "</div>" +
            "</div>" +
            '<div class="col-xl-6">' +
            '<div class="footer-reset-btn">' +
            '<a href="#" class="btn btn-primary w-100">Buy Now</a> ' +
            "</form>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>"
    );

    loadJS("assets/js/theme-settings.js", true);
}, 1000);

let type = $(".notification_type").val();
let message = $(".notification_message").val();

if (type == "success") {
    showNotification("Success", type, message);
}

if (type == "error") {
    showNotification("Error", type, message);
}

if (type == "info") {
    showNotification("Info", type, message);
}

if (type == "warning") {
    showNotification("Warning", type, message);
}

function showNotification(title, type, message) {
    new Notify({
        status: type,
        title: title,
        text: message,
        effect: "fade",
        speed: 300,
        customClass: "",
        customIcon: "",
        showIcon: true,
        showCloseButton: true,
        autoclose: true,
        autotimeout: 10000,
        notificationsGap: null,
        notificationsPadding: null,
        type: "outline",
        position: "right top",
        customWrapper: "",
    });
}

/**
 * Show notification for POS
 */
function showPOSNotification(title, type, message) {
    new Notify({
        status: type,
        title: title,
        text: message,
        effect: "fade",
        speed: 300,
        customClass: "",
        customIcon: "",
        showIcon: true,
        showCloseButton: true,
        autoclose: true,
        autotimeout: 1000,
        notificationsGap: null,
        notificationsPadding: null,
        type: "outline",
        position: "right bottom",
        customWrapper: "",
    });
}

$(document).ready(function () {
    var $activeItem = $(".sidebar .active"); // your active menu item
    var $sidebar = $(".sidebar"); // or the scrollable container if different
    if ($activeItem.length) {
        var sidebarHeight = $sidebar.height();
        var itemOffsetTop = $activeItem.position().top;
        var itemHeight = $activeItem.outerHeight();
        var scrollTop = itemOffsetTop - sidebarHeight / 2 + itemHeight / 2;

        $sidebar.scrollTop(scrollTop);
    }
});

$(document).ready(function () {
    const today = new Date().toISOString().split("T")[0];
    const hasModalShown = localStorage.getItem("hasModalShown");
    let lowStockProduct = $("#low_stock_product").val();
    let nearExpiredProduct = $("#near_expired_product").val();
    if (lowStockProduct > 0 || nearExpiredProduct > 0) {
        if (hasModalShown !== today) {
            setTimeout(function () {
                $("#low-stock-modal").modal("show");
                $("#low-stock-modal").addClass("animated fadeInDown");
                localStorage.setItem("hasModalShown", today);
            }, 5000);
        }
    }
});
