$(document).ready(function () {
    fetchProjects();
    $('#AddProject #add').click(function () {
        var pData = {};

        pData['title'] = $('#AddProject #title').val();
        pData['description'] = $('#AddProject #description').val();
        pData['sdate'] = $('#AddProject #s-date').val();
        pData['edate'] = $('#AddProject #e-date').val();
        pData['createdon'] = $('#AddProject #createdon').val();
        pData['createdby'] = $('#AddProject #createdby').val();
        console.log(pData);

        $.ajax({
            type: 'POST',
            url: '../back/projects.php',
            data: { "pData": pData },
            success: function (response) {
                var a = response;

                if (a == "required") {
                    alert("ALL THE FIELDS ARE REQUIRED");
                }
                else if (a == "inserted") {
                    alert("PROJECT ADDED SUCCESSFULLY");
                    location.reload();
                }
                else {
                    alert("Not inserted");
                }
            }
        });
    });

    //for update and delete
    $("#myTable").on('click', '.icon-tabler-select', function () {
        // get id
        $id = $(this).closest('tr').find('td:nth-child(3)');
        $.each($id, function () {
            $val = ($(this).text());
        });
        $('#update #u-project-id').val($val);

        // get project title
        $title = $(this).closest('tr').find('td:nth-child(2)');
        $.each($title, function () {
            $val = ($(this).text());
        });
        $('#update #u-title').val($val);

        // get start date
        $sdate = $(this).closest('tr').find('td:nth-child(4)');
        $.each($sdate, function () {
            $val = ($(this).text());
        });
        $('#update #u-s-date').val($val);

        // get end date
        $edate = $(this).closest('tr').find('td:nth-child(5)');
        $.each($edate, function () {
            $val = ($(this).text());
        });
        $('#update #u-e-date').val($val);

        // get description
        $des = $(this).closest('tr').find('td:nth-child(8)');
        $.each($des, function () {
            $val = ($(this).text());
        });
        $('#update #u-description').val($val);
    });

    $('#update #edit').click(function () {
        var uData = {};

        uData["id"] = $('#update #u-project-id').val();
        uData["title"] = $('#update #u-title').val();
        uData["sdate"] = $('#update #u-s-date').val();
        uData["edate"] = $('#update #u-e-date').val();
        uData["description"] = $('#update #u-description').val();
        if ($('#update #delete').prop("checked") == true) {
            uData["delete"] = "1";
        }
        else {
            uData["delete"] = "0";
        }
        $.ajax({
            type: 'POST',
            url: '../back/projects.php',
            data: { "uData": uData },
            success: function (response) {
                var a = response;

                if (a == "required") {
                    alert("ALL THE FIELDS ARE REQUIRED");
                }
                else if (a == 1) {
                    alert("PROJECT UPDATED SUCCESSFULLY");
                    location.reload();
                }
                else if (a == 0) {
                    alert("DELETED SUCCESSFULLY")
                    location.reload();
                }
                else {
                    alert("Not updated");
                }
            }
        });
    });

    function fetchProjects() {
        $.ajax({
            type: 'POST',
            url: '../back/loadproject.php',
            success: function (response) {
                var details = jQuery.parseJSON(response);
                var a = response;
                if (a == 0) {
                    $('#table-data').append('<tr><td colspan="7">' + "YOU DON'T HAVE ANY PROJECT" + '</td></tr>');
                    $('#table-data').css("text-align", "center");
                    $('#table-data').css("color", "red");
                    $('#table-data').css("font-size", "1.5em");
                    $('#table-data').css("font-weight", "bolder");
                }
                else {
                    $.each(details, function (i, v) {
                        $('#table-data').append('<tr><td id="info">' + '<svg xmlns="http://www.w3.org/2000/svg"  data-toggle="modal" data-target="#update" class="icon icon-tabler icon-tabler-select" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="16" height="16" rx="2" /><path d="M9 11l3 3l3 -3" /></svg>'
                            + '</td><td>' +
                            v.title + '</td><td id="p-id">' + v.id + '</td><td>' + v.sdate + '</td><td>' +
                            v.edate + '</td><td>' + v.createdon + '</td><td>' + v.createdby +
                            '</td><td>' + v.description + '</td></tr>');
                    })
                }
            }
        });
    }
});