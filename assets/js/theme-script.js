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

// Improved sidebar scrolling to center active menu item
$(document).ready(function () {
    // Wait a moment to ensure DOM is fully loaded
    setTimeout(function () {
        var $activeItem = $(".sidebar .active"); // your active menu item
        var $sidebar = $(".sidebar-inner.slimscroll"); // the scrollable container

        if ($activeItem.length) {
            var sidebarHeight = $sidebar.height();
            var itemOffsetTop =
                $activeItem.offset().top -
                $sidebar.offset().top +
                $sidebar.scrollTop();
            var itemHeight = $activeItem.outerHeight();

            // Calculate position to center the item
            var scrollTo = itemOffsetTop - sidebarHeight / 2 + itemHeight / 2;

            // Smooth scroll to the position
            $sidebar.animate(
                {
                    scrollTop: scrollTo,
                },
                300
            );
        }
    }, 300);
});
