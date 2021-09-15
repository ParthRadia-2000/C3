$(document).ready(function () {
    $("#wrapper").toggleClass("toggled");

    fetchDetails();

    $("#menu").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    $("#add").click(function () {
        var cData = {};
        cData["firstname"] = $("#AddEmployee #emp-fname").val();
        cData["lastname"] = $("#AddEmployee #emp-lname").val();
        cData["birth-date"] = $("#AddEmployee #emp-bdate").val();
        cData["email"] = $("#AddEmployee #emp-email").val();
        cData["join-date"] = $("#AddEmployee #emp-jdate").val();
        cData["department"] = $("#AddEmployee #emp-dept").val();
        cData["mobile"] = $("#AddEmployee #emp-mob").val();
        cData["creation-date"] = $("#AddEmployee #emp-createdon").val();
        cData["created-by"] = $("#AddEmployee #emp-createdby").val();
        cData["address"] = $("#AddEmployee #emp-add").val();

        $.ajax({
            type: 'POST',
            url: '../back/employee.php',
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
                    alert("EMPLOYE ADDED SUCCESSFULLY");
                    location.reload();
                }
                else {
                    alert("Not inserted");
                }
            }
        });
    });
    function fetchDetails() {
        $.ajax({
            type: 'POST',
            url: '../back/loademployee.php',
            success: function (response) {
                var a = response;
                if (a == 0) {
                    $('#table-data').append('<tr><td colspan="10">' + "No Employees Are Added" + '</td></tr>');
                    $('#table-data').css("text-align", "center");
                    $('#table-data').css("color", "red");
                    $('#table-data').css("font-size", "1.5em");
                    $('#table-data').css("font-weight", "bolder");
                }
                var details = jQuery.parseJSON(response);
                $.each(details, function (i, v) {
                    //alert(v.id);
                    $('#table-data').append('<tr><td id="info">' + '<svg xmlns="http://www.w3.org/2000/svg"  data-toggle="modal" data-target="#EditEmployee" class="icon icon-tabler icon-tabler-select" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="16" height="16" rx="2" /><path d="M9 11l3 3l3 -3" /></svg>'
                        + '</td><td>' + v.firstname + '</td><td>' + v.lastname + '</td><td>' +
                        v.email + '</td><td>' + v.dept + '</td><td>' + v.joindate +
                        '</td><td>' + v.dob + '</td><td>' + v.mob + '</td><td>' + v.add + '</td></tr>');
                });
            }
        });
    }
    $("#myTable").on('click', '.icon-tabler-select', function () {
        // get first name
        $name = $(this).closest('tr').find('td:nth-child(2)');
        $.each($name, function () {
            $val2 = ($(this).text());
        });
        $('#EditEmployee #edit-fname').val($val2);

        // get last name
        $lname = $(this).closest('tr').find('td:nth-child(3)');
        $.each($lname, function () {
            $val2 = ($(this).text());
        });
        $('#EditEmployee #edit-lname').val($val2);

        // get email
        $email = $(this).closest('tr').find('td:nth-child(4)');
        $.each($email, function () {
            $val2 = ($(this).text());
        });
        $('#EditEmployee #edit-email').val($val2);
        $('#EditEmployee #ref').val($val2);

        // get department
        $dept = $(this).closest('tr').find('td:nth-child(5)');
        $.each($dept, function () {
            $val2 = ($(this).text());
        });
        $('#EditEmployee #edit-dept').val($val2);

        // get mobile number
        $ph = $(this).closest('tr').find('td:nth-last-child(2)');
        $.each($ph, function () {
            $val2 = ($(this).text());
        });
        $('#EditEmployee #edit-mob').val($val2);

        // get first name
        $jdate = $(this).closest('tr').find('td:nth-last-child(4)');
        $.each($jdate, function () {
            $val2 = ($(this).text());
        });
        $('#EditEmployee #edit-jdate').val($val2);

        // get dob
        $dob = $(this).closest('tr').find('td:nth-last-child(3)');
        $.each($dob, function () {
            $val2 = ($(this).text());
        });
        $('#EditEmployee #edit-bdate').val($val2);

        // get address
        $add = $(this).closest('tr').find('td:nth-last-child(1)');
        $.each($add, function () {
            $val2 = ($(this).text());
        });
        $('#EditEmployee #edit-add').val($val2);
    });
    $("#save").click(function () {
        var uData = {};
        uData["fname"] = $("#EditEmployee #edit-fname").val();
        uData["lname"] = $("#EditEmployee #edit-lname").val();
        uData["email"] = $("#EditEmployee #edit-email").val();
        uData["dept"] = $("#EditEmployee #edit-dept").val();
        uData["mob"] = $("#EditEmployee #edit-mob").val();
        uData["jdate"] = $("#EditEmployee #edit-jdate").val();
        uData["bdate"] = $("#EditEmployee #edit-bdate").val();
        uData["add"] = $("#EditEmployee #edit-add").val();
        uData["ref"] = $("#EditEmployee #ref").val();
        if ($('#EditEmployee #delete').prop("checked") == true) {
            uData["delete"] = "1";
        }
        else {
            uData["delete"] = "0";
        }
        $.ajax({
            type: 'POST',
            url: '../back/updateemployee.php',
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