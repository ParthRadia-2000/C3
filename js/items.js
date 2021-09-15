$(document).ready(function () {
    $("#wrapper").toggleClass("toggled");
    fetchItems();
    $("#menu").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    $("#AddItem #add").click(function () {
        var cData = {};
        cData["item_name"] = $("#AddItem #item-name").val();
        cData["item_price"] = $("#AddItem #price").val();
        cData["item_stdcost"] = $("#AddItem #stdcost").val();
        cData["item_taxcode"] = $("#AddItem #taxcode").val();
        cData["item_manager"] = $("#AddItem #manager").val();
        cData["item_sale"] = $("#AddItem input[name='radio-btn']:checked").val();
        cData["item_billtype"] = $("#AddItem input[name='rbtn']:checked").val();
        cData["item_size"] = $("#AddItem #size").val();
        cData["item_color"] = $("#AddItem #color").val();
        cData["item_condition"] = $("#AddItem #condition").val();
        cData["item_inventorytype"] = $("#AddItem #inventory").val();
        console.log(cData);
        $.ajax({
            type: 'POST',
            url: '../back/items.php',
            data: { "cData": cData },
            success: function (response) {
                var a = response;
                if (a == "inserted") {
                    alert("ITEM ADDED SUCCESSFULLY");
                    location.reload();
                }
                else if (a == "required") {
                    alert("ALL THE FIELDS ARE REQUIRED");
                }
                else {
                    alert("Not Inserted");
                }
            }
        });
    });

    function fetchItems() {
        $.ajax({
            type: 'POST',
            url: '../back/loaditem.php',
            success: function (response) {
                var details = jQuery.parseJSON(response);
                var a = response;
                if (a == 0) {
                    $('#table-data').append('<tr><td colspan="14">' + "No Items Are Added" + '</td></tr>');
                    $('#table-data').css("text-align", "center");
                    $('#table-data').css("color", "red");
                    $('#table-data').css("font-size", "1.5em");
                    $('#table-data').css("font-weight", "bolder");
                }
                else {
                    $.each(details, function (i, v) {
                        $('#table-data').append('<tr><td id="info">' + '<svg xmlns="http://www.w3.org/2000/svg"  data-toggle="modal" data-target="#EditItem" class="icon icon-tabler icon-tabler-select" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="16" height="16" rx="2" /><path d="M9 11l3 3l3 -3" /></svg>'
                            + '</td><td id="p-id">' + v.id + '</td><td>' +
                            v.itemname + '</td><td>' + v.price + '</td><td>' +
                            v.pmanager + '</td><td>' + v.cost + '</td><td>' + v.taxcode +
                            '</td><td>' + v.size + '</td><td>' + v.color + '</td><td>' + v.billtype +
                            '</td><td>' + v.condition + '</td><td>' + v.inventory + '</td><td>' + v.sale + '</td></tr>');
                    })
                }
            }
        });
    }
    // for update abd delete
    $("#myTable").on('click', '.icon-tabler-select', function () {
        // get inventory
        $invent = $(this).closest('tr').find('td:nth-last-child(2)');
        $.each($invent, function () {
            $val2 = ($(this).text());
        });
        $('#EditItem #edit_inventory').val($val2);

        // get id
        $id = $(this).closest('tr').find('td:nth-child(2)');
        $.each($id, function () {
            $val2 = ($(this).text());
        });
        $('#EditItem #edit-id').val($val2);

        // get name
        $name = $(this).closest('tr').find('td:nth-child(3)');
        $.each($name, function () {
            $val2 = ($(this).text());
        });
        $('#EditItem #edit-name').val($val2);

        // get price
        $price = $(this).closest('tr').find('td:nth-child(4)');
        $.each($price, function () {
            $val2 = ($(this).text());
        });
        $('#EditItem #edit-price').val($val2);

        //get cost
        $cost = $(this).closest('tr').find('td:nth-child(6)');
        $.each($cost, function () {
            $val2 = ($(this).text());
        });
        $('#EditItem #edit-stdcost').val($val2);

        // get tex code
        $texcode = $(this).closest('tr').find('td:nth-child(7)');
        $.each($texcode, function () {
            $val2 = ($(this).text());
        });
        $('#EditItem #edit-taxcode').val($val2);
        $('#EditItem #ref-name').val($val2);

        // get size
        $size = $(this).closest('tr').find('td:nth-child(8)');
        $.each($size, function () {
            $val2 = ($(this).text());
            $('#EditItem #edit-size').val($val2);
        });

        // get color
        $color = $(this).closest('tr').find('td:nth-child(9)');
        $.each($color, function () {
            $val2 = ($(this).text());
            $('#EditItem #edit-color').val($val2);
        });



        // get condition
        $condition = $(this).closest('tr').find('td:nth-last-child(3)');
        $.each($condition, function () {
            $val2 = ($(this).text());
            $('#EditItem #edit-condition').val($val2);
        });
    });
    $('#EditItem #edit').click(function () {
        var uData = {};

        uData["id"] = $('#EditItem #edit-id').val();
        uData["name"] = $('#EditItem #edit-name').val();
        uData["price"] = $('#EditItem #edit-price').val();
        uData["stdcost"] = $('#EditItem #edit-stdcost').val();
        uData["taxcode"] = $('#EditItem #edit-taxcode').val();
        uData["size"] = $('#EditItem #edit-size').val();
        uData["color"] = $('#EditItem #edit-color').val();
        uData["condition"] = $('#EditItem #edit-condition').val();
        uData["inventory"] = $('#EditItem #edit_inventory').val();
        if ($('#EditItem #delete').prop("checked") == true) {
            uData["delete"] = "1";
        }
        else {
            uData["delete"] = "0";
        }
        $.ajax({
            type: 'POST',
            url: '../back/items.php',
            data: { "uData": uData },
            success: function (response) {
                var a = response;

                if (a == "required") {
                    alert("ALL THE FIELDS ARE REQUIRED");
                }
                else if (a == 1) {
                    alert("ITEM UPDATED SUCCESSFULLY");
                    location.reload();
                }
                else if (a == 0) {
                    alert("ITEM DELETED SUCCESSFULLY")
                    location.reload();
                }
                else {
                    alert("Not updated");
                }
            }
        });
    });
});