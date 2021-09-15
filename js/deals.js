$(document).ready(function () {
    $("#wrapper").toggleClass("toggled");
    $("#menu").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    fetchnewdeals();
    fetchprogressdeals();
    fetchwondeal();
    fetchlostdeal();
    $('#new #save-new').click(function () {
        var nData = {};
        nData["client"] = $('#new #client').val();
        nData["com"] = $('#new #company').val();
        nData["deal"] = $('#new #deal').val();
        nData["amount"] = $('#new #amount').val();
        nData["prob"] = $('#new #probability').val();
        nData["res"] = $('#new #responsible').val();
        nData["sdate"] = $('#new #sdate').val();
        nData["dtype"] = $('#new #dtype').val();

        $.ajax({
            type: 'POST',
            url: '../back/deals.php',
            data: { "nData": nData },
            success: function (response) {
                var a = response;
                if (a == "inserted") {
                    alert("DEAL CREATED SUCCESSFULLY");
                    location.reload();
                }
            }
        });
    });

    $('#progress #save-progress').click(function () {
        var pData = {};
        pData["client"] = $('#progress #p-client').val();
        pData["com"] = $('#progress #p-company').val();
        pData["deal"] = $('#progress #p-deal').val();
        pData["amount"] = $('#progress #p-amount').val();
        pData["prob"] = $('#progress #p-probability').val();
        pData["res"] = $('#progress #p-responsible').val();
        pData["sdate"] = $('#progress #p-sdate').val();
        pData["dtype"] = $('#progress #p-dtype').val();

        $.ajax({
            type: 'POST',
            url: '../back/deals.php',
            data: { "pData": pData },
            success: function (response) {
                var a = response;
                if (a == "inserted") {
                    alert("DEAL CREATED SUCCESSFULLY");
                    location.reload();
                }
            }
        });
    });

    $('#won #save-won').click(function () {
        var wData = {};
        wData["client"] = $('#won #w-client').val();
        wData["com"] = $('#won #w-company').val();
        wData["deal"] = $('#won #w-deal').val();
        wData["amount"] = $('#won #w-amount').val();
        wData["prob"] = $('#won #w-probability').val();
        wData["res"] = $('#won #w-responsible').val();
        wData["sdate"] = $('#won #w-sdate').val();
        wData["dtype"] = $('#won #w-dtype').val();

        $.ajax({
            type: 'POST',
            url: '../back/deals.php',
            data: { "wData": wData },
            success: function (response) {
                var a = response;
                if (a == "inserted") {
                    alert("DEAL CREATED SUCCESSFULLY");
                    location.reload();
                }
            }
        });
    });

    $('#lost #save-lost').click(function () {
        var lData = {};
        lData["client"] = $('#lost #l-client').val();
        lData["com"] = $('#lost #l-company').val();
        lData["deal"] = $('#lost #l-deal').val();
        lData["amount"] = $('#lost #l-amount').val();
        lData["prob"] = $('#lost #l-probability').val();
        lData["res"] = $('#lost #l-responsible').val();
        lData["sdate"] = $('#lost #l-sdate').val();
        lData["dtype"] = $('#lost #l-dtype').val();

        $.ajax({
            type: 'POST',
            url: '../back/deals.php',
            data: { "lData": lData },
            success: function (response) {
                var a = response;
                if (a == "inserted") {
                    alert("DEAL CREATED SUCCESSFULLY");
                    location.reload();
                }
            }
        });
    });

    function fetchprogressdeals() {
        $.ajax({
            type: 'POST',
            url: '../back/fetchprogressdeals.php',
            success: function (response) {
                var details = jQuery.parseJSON(response);
                $.each(details, function (i, v) {
                    $('#div-progress #board-column #content-progress').append(
                        '<div class="card" style="margin-top:5px;">' +
                        '<div class="card-header" id="card-header">' + v.dname + '</div>' +
                        '<div class="card-body">' +
                        '<div class="card-title" id="setid">' + 'Id: ' + v.did + '</div>' +
                        '<div class="card-title">' + 'Client: ' + v.dclient + '</div>' +
                        '<div class="card-title">' + 'Company: ' + v.dcompany + '</div>' +
                        '<div class="card-title">' + 'Amount: ' + v.damount + '</div>' +
                        '<div class="card-title">' + 'Starting Date: ' + v.dsdate + '</div>' +
                        '<div class="card-title">' + 'Responsible Person: ' + v.dresponsible + '</div>' +
                        '<!--<a data-toggle="modal" href="#update" class="card-link" data-update-id=cardid style="cursor:pointer;">Update</a>-->' +
                        '<!--<a href="#" class="card-link" style="cursor:pointer;">Delete</a>-->' +
                        '</div>' +
                        '</div>');
                })
                var sum = 0;
                $.each(details, function (i, v) {
                    //console.log(v.damount);
                    sum = sum + parseFloat(v.damount);
                })
                $('#board-value-progress span').append(sum);
            }
        });
    }

    function fetchwondeal() {
        $.ajax({
            type: 'POST',
            url: '../back/fetchwondeals.php',
            success: function (response) {
                var details = jQuery.parseJSON(response);
                $.each(details, function (i, v) {
                    $('#div-win #board-column #content-win').append(
                        '<div class="card" style="margin-top:5px;">' +
                        '<div class="card-header">' + v.dname + '</div>' +
                        '<div class="card-body">' +
                        '<div class="card-title" id="setid">' + 'Id: ' + v.did + '</div>' +
                        '<div class="card-title">' + 'Client: ' + v.dclient + '</div>' +
                        '<div class="card-title">' + 'Company: ' + v.dcompany + '</div>' +
                        '<div class="card-title">' + 'Amount: ' + v.damount + '</div>' +
                        '<div class="card-title">' + 'Starting Date: ' + v.dsdate + '</div>' +
                        '<div class="card-title">' + 'Responsible Person: ' + v.dresponsible + '</div>' +
                        '<!--<a href="#" class="card-link" style="cursor:pointer;">Update</a>-->' +
                        '<!--<a href="#" class="card-link" style="cursor:pointer;">Delete</a>-->' +
                        '</div>' +
                        '</div>');
                })
                var sum = 0;
                $.each(details, function (i, v) {
                    sum = sum + parseFloat(v.damount);
                })
                $('#board-value-win span').append(sum);
            }
        });
    }
    //NEW
    function fetchnewdeals() {
        $.ajax({
            type: 'POST',
            url: '../back/fetchnewdeals.php',
            success: function (response) {
                var details = jQuery.parseJSON(response);
                $.each(details, function (i, v) {
                    $('#div-new #board-column #content-new').append(
                        '<div class="card" style="margin-top:5px;">' +
                        '<div class="card-header" id="card-header-new">' + v.dname + '</div>' +
                        '<div class="card-body">' +
                        '<div class="card-title id="new-id" >' + 'Id: ' + v.did + '</div>' +
                        '<div class="card-title" id="new-client">' + 'Client: ' + v.dclient + '</div>' +
                        '<div class="card-title" id="new-company">' + 'Company: ' + v.dcompany + '</div>' +
                        '<div class="card-title" id="new-amount">' + 'Amount: ' + v.damount + '</div>' +
                        '<div class="card-title" id="new-sdate">' + 'Starting Date: ' + v.dsdate + '</div>' +
                        '<div class="card-title" id="new-res">' + 'Responsible Person: ' + v.dresponsible + '</div>' +
                        '<!--<a href="#" id="update-new" class="card-link" style="cursor:pointer;">Update</a>-->' +
                        '<!--<a href="#" class="card-link" style="cursor:pointer;">Delete</a>-->' +
                        '</div>' +
                        '</div>');
                })
                var sum = 0;
                $.each(details, function (i, v) {
                    //console.log(v.damount);
                    sum = sum + parseFloat(v.damount);
                })
                $('#board-value-new span').append(sum);
            }
        });
    }

    function fetchlostdeal() {
        $.ajax({
            type: 'POST',
            url: '../back/fetchlostdeals.php',
            success: function (response) {
                var details = jQuery.parseJSON(response);
                $.each(details, function (i, v) {
                    $('#div-lost #board-column #content-lost').append(
                        '<div class="card" style="margin-top:5px;">' +
                        '<div class="card-header">' + v.dname + '</div>' +
                        '<div class="card-body">' +
                        '<div class="card-title">' + 'Id: ' + v.did + '</div>' +
                        '<div class="card-title">' + 'Client: ' + v.dclient + '</div>' +
                        '<div class="card-title">' + 'Company: ' + v.dcompany + '</div>' +
                        '<div class="card-title">' + 'Amount: ' + v.damount + '</div>' +
                        '<div class="card-title">' + 'Starting Date: ' + v.dsdate + '</div>' +
                        '<div class="card-title">' + 'Responsible Person: ' + v.dresponsible + '</div>' +
                        '<!--<a href="#" class="card-link" style="cursor:pointer;" data-toggle="modal" data-target="#update">Update</a>-->' +
                        '<!--<a href="#" class="card-link" style="cursor:pointer;">Delete</a>-->' +
                        '</div>' +
                        '</div>');
                })
                var sum = 0;
                $.each(details, function (i, v) {
                    //console.log(v.damount);
                    sum = sum + parseFloat(v.damount);
                })
                $('#board-value-lost span').append(sum);
            }
        });
    }
    /*$('#update').on('show.bs.modal', function() {
        /*var dealid = $(e.relatedTarget).data('update-id');
        $(e.currentTarget).find('input[name="dtype"]').val(dealid);
        var getid = $('#div-new #board-column #content-new #card-header-new').text();
        console.log(getid);
    });*/
    $('#div-new #board-column #content-new').click(function () {
        var a = $('#div-new #board-column #content-new #new-sdate').html();
        console.log(a);
    });
});
