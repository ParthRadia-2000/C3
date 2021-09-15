$(document).ready(function(){
    fetchTasks();

    function fetchTasks()
    {
        $.ajax({
            type:'POST',
            url:'../back/loademployeetasks.php',
            success: function(response){
                var details = jQuery.parseJSON(response);
                var a =response;
                if(a == 0){
                    $('#table-data').append('<tr><td colspan="5">'+ "You Don't Have Any Tasks" +'</td></tr>');
                    $('#table-data').css("text-align","center");
                    $('#table-data').css("color","red");
                    $('#table-data').css("font-size","1.5em");
                    $('#table-data').css("font-weight","bolder");
                }
                else
                { 
                    $.each(details, function(i,v){
                        $('#table-data').append('<tr><td id="info">'+ '<svg xmlns="http://www.w3.org/2000/svg"  data-toggle="modal" data-target="#solution" class="icon icon-tabler icon-tabler-select" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="16" height="16" rx="2" /><path d="M9 11l3 3l3 -3" /></svg>'
                       + '</td><td id="p-id">'+
                            v.task_id + '</td><td>' + v.title + '</td><td>'+
                            v.task_project_title + '</td><td>' + v.task_adate + '</td><td>' + v.description +
                            '</td></tr>');
                    })
                }
            }
        });
    }
    $("#myTable").on('click','.icon-tabler-select',function(){
        // get id
        $id=$(this).closest('tr').find('td:nth-child(2)');
        $.each($id, function(){
            $val=($(this).text());
        });
        $('#solution #id').val($val);

        // get title
        $title=$(this).closest('tr').find('td:nth-child(3)');
        $.each($title, function(){
            $val=($(this).text());
        });
        $('#solution #title').val($val);

        // get id
        $ptitle=$(this).closest('tr').find('td:nth-child(4)');
        $.each($ptitle, function(){
            $val=($(this).text());
        });
        $('#solution #p-title').val($val);
    });
});