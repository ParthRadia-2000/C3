$(document).ready(function () {
    $("#wrapper").toggleClass("toggled");
    //fetchContracts();
    $("#menu").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    //toggle options for modals
    $('#sales #title1').click(function () {
        var cname = $('#sales #title1 i').attr("class");
        if (cname == "fa fa-angle-down") {
            $('#sales #title1 i').removeClass("fa fa-angle-down");
            $('#sales #title1 i').addClass("fa fa-angle-right");
            $('#sales .content1').hide();
        }
        else {
            $('#sales #title1 i').removeClass("fa fa-angle-right");
            $('#sales #title1 i').addClass("fa fa-angle-down");
            $('#sales .content1').show();
        }
    });
    $('#sales .content2').hide();
    $('#sales #title2').click(function () {
        var cname = $('#sales #title2 i').attr("class");
        if (cname == "fa fa-angle-right") {
            $('#sales #title2 i').removeClass("fa fa-angle-right");
            $('#sales #title2 i').addClass("fa fa-angle-down");
            $('#sales .content2').show();
        }
        else {
            $('#sales #title2 i').removeClass("fa fa-angle-down");
            $('#sales #title2 i').addClass("fa fa-angle-right");
            $('#sales .content2').hide();
        }
    });
    $('#sales .content3').hide();
    $('#sales #title3').click(function () {
        var cname = $('#sales #title3 i').attr("class");
        if (cname == "fa fa-angle-right") {
            $('#sales #title3 i').removeClass("fa fa-angle-right");
            $('#sales #title3 i').addClass("fa fa-angle-down");
            $('#sales .content3').show();
        }
        else {
            $('#sales #title3 i').removeClass("fa fa-angle-down");
            $('#sales #title3 i').addClass("fa fa-angle-right");
            $('#sales .content3').hide();
        }
    });
});