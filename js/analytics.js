$(document).ready(function () {
    $("#wrapper").toggleClass("toggled");
    $("#menu").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
});