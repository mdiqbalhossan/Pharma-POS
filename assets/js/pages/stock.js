$(document).ready(function () {
    $("#sort_by").change(function () {
        var sort_by = $(this).val();
        var url = window.location.href;
        window.location.href = url + "?sort_by=" + sort_by;
    });
});
