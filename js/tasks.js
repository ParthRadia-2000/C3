$(document).ready(function () {
    fetchTasks();
    $('#AddTask #add').click(function () {
        var cData = {};
        cData["title"] = $('#AddTask #title').val();
        cData["description"] = $('#AddTask #description').val();
        cData["sdate"] = $('#AddTask #sdate').val();
        cData["edate"] = $('#AddTask #edate').val();
        var t_project = $('#AddTask #task-project').val();
        cData["receiver"] = $('#AddTask #receiver').val();
        cData["status"] = $('#AddTask #status').val();
        cData["adate"] = $('#AddTask #adate').val();
        cData["sender"] = $('#AddTask #sender').val();

        $t_project_id = t_project.substr(0, t_project.indexOf(' '));
        $t_project_title = t_project.substr(t_project.indexOf(' ') + 1);
        cData["t_project_id"] = $t_project_id;
        cData["t_project_title"] = $t_project_title
        $.ajax({
            type: 'POST',
            url: '../back/tasks.php',
            data: { "cData": cData },
            success: function (response) {
                var a = response;

                if (a == "required") {
                    alert("ALL THE FIELDS ARE REQUIRED");
                }
                else if (a == "inserted") {
                    alert("TASK ADDED SUCCESSFULLY");
                    location.reload();
                }
                else {
                    alert("Not inserted");
                }
            }
        });
    });

    $("#myTable").on('click', '.icon-tabler-select', function () {
        // get id
        $id = $(this).closest('tr').find('td:nth-child(2)');
        $.each($id, function () {
            $val = ($(this).text());
        });
        $('#update #u-id').val($val);

        // get id
        $pid = $(this).closest('tr').find('td:nth-child(6)');
        $.each($pid, function () {
            $val = ($(this).text());
        });
        $('#update #u-p-id').val($val);

        // get title
        $title = $(this).closest('tr').find('td:nth-child(3)');
        $.each($title, function () {
            $val = ($(this).text());
        });
        $('#update #u-title').val($val);

        // get start date
        $sdate = $(this).closest('tr').find('td:nth-child(4)');
        $.each($sdate, function () {
            $val = ($(this).text());
        });
        $('#update #u-sdate').val($val);

        // get end date
        $edate = $(this).closest('tr').find('td:nth-child(5)');
        $.each($edate, function () {
            $val = ($(this).text());
        });
        $('#update #u-edate').val($val);

        // get receiver
        $receiver = $(this).closest('tr').find('td:nth-child(8)');
        $.each($receiver, function () {
            $val = ($(this).text());
        });
        $('#update #u-receiver').val($val);

        // get description
        $description = $(this).closest('tr').find('td:nth-child(12)');
        $.each($description, function () {
            $val = ($(this).text());
        });
        $('#update #u-description').val($val);

    });
    $('#update #edit').click(function () {
        var uData = {};

        uData["task_id"] = $('#update #u-id').val();
        uData["project_id"] = $('#update #u-p-id').val();
        uData["task_title"] = $('#update #u-title').val();
        uData["description"] = $('#update #u-description').val();
        uData["sdate"] = $('#update #u-sdate').val();
        uData["edate"] = $('#update #u-edate').val();
        uData["receiver"] = $('#update #u-receiver').val();

        if ($('#update #delete').prop("checked") == true) {
            uData["delete"] = "1";
        }
        else {
            uData["delete"] = "0";
        }
        $.ajax({
            type: 'POST',
            url: '../back/tasks.php',
            data: { "uData": uData },
            success: function (response) {
                var a = response;

                if (a == "required") {
                    alert("ALL THE FIELDS ARE REQUIRED");
                }
                else if (a == 1) {
                    alert("TASK UPDATED SUCCESSFULLY");
                    location.reload();
                }
                else if (a == 0) {
                    alert(" TASK DELETED SUCCESSFULLY")
                    location.reload();
                }
                else {
                    alert("Not updated");
                }
            }
        });
    });

    function fetchTasks() {
        $.ajax({
            type: 'POST',
            url: '../back/loadtasks.php',
            success: function (response) {
                var a = response;
                var details = jQuery.parseJSON(a);

                if (a == 0) {
                    $('#table-data').append('<tr><td colspan="10">' + "YOU DON'T HAVE ANY TASK" + '</td></tr>');
                    $('#table-data').css("text-align", "center");
                    $('#table-data').css("color", "red");
                    $('#table-data').css("font-size", "1.5em");
                    $('#table-data').css("font-weight", "bolder");
                }
                else {
                    $.each(details, function (i, v) {
                        $('#table-data').append('<tr><td id="info">' + '<svg xmlns="http://www.w3.org/2000/svg"  data-toggle="modal" data-target="#update" class="icon icon-tabler icon-tabler-select" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="16" height="16" rx="2" /><path d="M9 11l3 3l3 -3" /></svg>'
                            + '</td><td id="p-id">' + + v.task_id + '</td><td>' +
                            v.title + '</td><td>' + v.sdate + '</td><td>' +
                            v.edate + '</td><td id="p-id">' + v.task_project_id + '</td><td>' + v.task_project_title +
                            '</td><td>' + v.task_receiver + '</td><td>' + v.task_status + '</td><td>' + v.task_adate + '</td><td>' + v.task_sender + '</td><td>' + v.description + '</td></tr>');
                    })
                }
            }
        });
    }
});