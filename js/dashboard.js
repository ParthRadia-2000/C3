$(document).ready(function () {
    var calendar = $('#calender-content').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        eventResize: true,
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        selectHelper: true,
        select: function (start, end) {
            $('#modalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
            $('#modalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
            $('#modalAdd').modal();
            $("#modalAdd #add-event").click(function () {
                var cData = {};
                cData['event-name'] = $('#modalAdd #title').val();
                cData['event-color'] = $('#modalAdd #color').val();
                //alert(cData['event-color']);
                cData['event-start'] = $('#modalAdd #start').val();
                cData['event-end'] = $('#modalAdd #end').val();
                cData['event-creator'] = $('#modalAdd #event-creator').val()
                if (cData['event-name'] == "" || cData['event-color'] == "") {
                    alert("All the fields are required");
                }
                else {
                    $.ajax({
                        url: "../back/insert.php",
                        type: "POST",
                        data: { "cData": cData },
                        success: function (response) {
                            var a = response;
                            if (a == 1) {
                                calendar.fullCalendar('refetchEvents');
                                alert("Event Added Successfully");
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        },
        events: '../back/load.php',
        eventRender: function (event, element) {
            element.bind('click', function () {
                $('#eventEdit #id').val(event.id);
                $('#eventEdit #title-edit').val(event.title);
                $('#eventEdit #color').val(event.color);
                $('#eventEdit').modal();
                $('#eventEdit #edit-event').click(function () {
                    var cData = {};
                    if ($('#eventEdit #delete').prop("checked") == true) {
                        cData['event-delete'] = "1";
                    }
                    else {
                        cData['event-delete'] = "0";
                    }
                    cData['event-id'] = $('#eventEdit #id').val();
                    cData['event-name'] = $('#eventEdit #title-edit').val();
                    cData['event-color'] = $('#eventEdit #color').val();
                    //cData['event-delete'] = $('#eventEdit #delete').val();
                    if (cData['event-name'] == "" || cData['event-color'] == "") {
                        alert("All the fields are required");
                    }
                    else {
                        $.ajax({
                            url: "../back/update.php",
                            type: "POST",
                            data: { "cData": cData },
                            success: function (response) {
                                var a = response;
                                if (a == 1) {
                                    calendar.fullCalendar('refetchEvents');
                                    alert("Event Updated Successfully");
                                    window.location.reload();
                                }
                                else {
                                    calendar.fullCalendar('refetchEvents');
                                    alert("Event Deleted Successfully");
                                    window.location.reload();
                                }
                            }
                        });
                    }
                });
            });
        },
        eventDrop: function (date, allDay) {

        },
        eventResize: function (event, delta, revertFunc) {
            alert("resized");
        },
    });
    $("#menu").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    //list view
    $(".move-list").click(function () {
        $(".move-calender").removeClass("active");
        $(".move-list").addClass("active");
        $("#calender-content").hide();
        $("#list-content").show();
    });
    //calender view
    $(".move-calender").click(function () {
        $(".move-list").removeClass("active");
        $(".move-calender").addClass("active");
        $("#list-content").hide();
        $("#calender-content").show();
    });
});