$(document).ready(function () {
    // Prevent checkbox clicks from toggling accordion
    $(".group-select").on("click", function (e) {
        e.stopPropagation();
    });

    // Select all permissions
    $("#select-all-btn").click(function () {
        $(".permission-checkbox").prop("checked", true);
        updateGroupSelectors();
    });

    // Deselect all permissions
    $("#deselect-all-btn").click(function () {
        $(".permission-checkbox").prop("checked", false);
        updateGroupSelectors();
    });

    // Group select checkbox functionality
    $(".group-select").change(function () {
        var group = $(this).data("group");
        $("." + group + "-checkbox").prop("checked", $(this).prop("checked"));
    });

    // Update group selectors when individual permissions change
    $(".permission-checkbox").change(function () {
        updateGroupSelectors();
    });

    // Check if all permissions in a group are selected
    function updateGroupSelectors() {
        $(".group-select").each(function () {
            var group = $(this).data("group");
            var totalCheckboxes = $("." + group + "-checkbox").length;
            var checkedCheckboxes = $("." + group + "-checkbox:checked").length;

            $(this).prop(
                "checked",
                totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes
            );
            $(this).prop(
                "indeterminate",
                checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes
            );
        });
    }

    // Initialize group selectors
    updateGroupSelectors();
});
