$(document).ready(function () {
    $("#wrapper").toggleClass("toggled");
    fetchCustomers();
    $("#menu").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    $('#AddCustomer #add').click(function () {
        var cData = {};
        cData["customer_name"] = $('#AddCustomer #c-name').val();
        cData["salesrep"] = $('#AddCustomer #salesrep').val();
        cData["status"] = $('#AddCustomer #status').val();
        cData["phone"] = $('#AddCustomer #phone').val();
        cData["email"] = $('#AddCustomer #email').val();
        cData["industry"] = $('#AddCustomer #industry').val();
        cData["address"] = $('#AddCustomer #address').val();

        $.ajax({
            type: 'POST',
            url: '../back/customers.php',
            data: { "cData": cData },
            success: function (response) {
                var a = response;
                if (a == "email") {
                    alert("PLEASE ENTER VALID EMAIL ADDRESS");
                }
                else if (a == "mobile") {
                    alert("PLEASE ENTER VALID MOBILE NUMBER");
                }
                else if (a == "required") {
                    alert("ALL THE FIELDS ARE REQUIRED");
                }
                else if (a == "inserted") {
                    alert("CUSTOMER ADDED SUCCESSFULLY");
                    location.reload();
                }
                else {
                    alert("Not inserted");
                }
            }
        });
    });
    function fetchCustomers() {
        $.ajax({
            type: 'POST',
            url: '../back/loadcustomer.php',
            success: function (response) {
                var details = jQuery.parseJSON(response);
                var a = response;
                if (a == 0) {
                    $('#table-data').append('<tr><td colspan="8">' + "YOU DON'T HAVE ANY CUSTOMER " + '</td></tr>');
                    $('#table-data').css("text-align", "center");
                    $('#table-data').css("color", "red");
                    $('#table-data').css("font-size", "1.5em");
                    $('#table-data').css("font-weight", "bolder");
                }
                else {
                    $.each(details, function (i, v) {
                        $('#table-data').append('<tr><td id="info">' + '<svg xmlns="http://www.w3.org/2000/svg"  data-toggle="modal" data-target="#EditCustomer" class="icon icon-tabler icon-tabler-select" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="16" height="16" rx="2" /><path d="M9 11l3 3l3 -3" /></svg>'
                            + '</td><td id="cname">' +
                            v.cname + '</td><td>' + v.email + '</td><td>' +
                            v.phone + '</td><td>' + v.status + '</td><td>' + v.industry +
                            '</td><td>' + v.salesrep + '</td><td>' + v.address + '</td></tr>');
                    })
                }
            }
        });
    }
    // for update and delete
    $("#myTable").on('click', '.icon-tabler-select', function () {
        // get name
        $name = $(this).closest('tr').find('td:nth-child(2)');
        $.each($name, function () {
            $val2 = ($(this).text());
        });
        $('#EditCustomer #edit-c-name').val($val2);

        // get email
        $email = $(this).closest('tr').find('td:nth-child(3)');
        $.each($email, function () {
            $val2 = ($(this).text());
        });
        $('#EditCustomer #edit-email').val($val2);
        $('#EditCustomer #ref-name').val($val2);

        // get phone number
        $phone = $(this).closest('tr').find('td:nth-child(4)');
        $.each($phone, function () {
            $val2 = ($(this).text());
        });
        $('#EditCustomer #edit-phone').val($val2);

        //get status
        $status = $(this).closest('tr').find('td:nth-child(5)');
        $.each($status, function () {
            $val2 = ($(this).text());
        });
        $('#EditCustomer #edit-status').val($val2);

        // get industry
        $industry = $(this).closest('tr').find('td:nth-child(6)');
        $.each($industry, function () {
            $val2 = ($(this).text());
        });
        $('#EditCustomer #edit-industry').val($val2);

        // get addaress
        $add = $(this).closest('tr').find('td:nth-child(8)');
        $.each($add, function () {
            $val2 = ($(this).text());
            $('#EditCustomer #edit-address').val($val2);
        });

    });
    $("#save").click(function () {
        var uData = {};
        uData["name"] = $("#EditCustomer #edit-c-name").val();
        uData["email"] = $("#EditCustomer #edit-email").val();
        uData["phone"] = $("#EditCustomer #edit-phone").val();
        uData["status"] = $("#EditCustomer #edit-status").val();
        uData["industry"] = $("#EditCustomer #edit-industry").val();
        uData["address"] = $("#EditCustomer #edit-address").val();
        uData["ref-name"] = $("#EditCustomer #ref-name").val();
        if ($('#EditCustomer #delete').prop("checked") == true) {
            uData["delete"] = "1";
        }
        else {
            uData["delete"] = "0";
        }
        $.ajax({
            type: 'POST',
            url: '../back/updatecustomer.php',
            data: { "uData": uData },
            success: function (response) {
                var a = response;
                if (a == 1) {
                    alert("UPDATED SUCCESSFULLY");
                    location.reload();
                }
                else if (a == "email") {
                    alert("PLEASE ENTER VALID EMAIL ADDRESS");
                }
                else if (a == "mobile") {
                    alert("PLEASE ENTER VALID MOBILE NUMBER");
                }
                else if (a == "required") {
                    alert("ALL THE FIELDS ARE REQUIRED");
                }
                else if (a == 0) {
                    alert("DELETED SUCCESSFULLY");
                    location.reload();
                }
                else {
                    alert("NO ACTIONS PERFORMED");
                }
            }
        });
    });
});