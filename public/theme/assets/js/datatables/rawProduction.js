"use strict";

table = $("#datatable").DataTable({
    searchDelay: 500,
    processing: true,
    'language':{ 
        "loadingRecords": "&nbsp;",
        "processing": "Loading..."
     },
     "sort":false,
    serverSide: true,
    ajax: {
        url: AjaxRoute,
    },
    columns: [
        {
            className:      'dt-control',
            orderable:      false,
            data:           null,
            defaultContent: `<i class='fa fs-2 fa-plus-circle text-success' ></i>`
        },
        { data: 'voucher' },
    ],
    'scrollCollapse': true,
    "scrollY": "45vh",
    "scrollX": true,
    "fnInitComplete":function(){
        $('#progress_placeholder').slideUp();
        $('#datatable-card').slideDown();
    }
});

$('#datatable tbody').on('click', 'td.dt-control', function () {
    alert('fired');
    var tr = $(this).closest('tr');
    var row = table.row( tr );
 
    if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        row.child( format(row.data()) ).show();
        tr.addClass('shown');
    }
} );

function toggleRow()
{
    alert('fired');
    console.log($(this));
    var tr = $(this).closest('tr');
    var row = table.row( tr );
    console.log('fired');   
    console.log(tr);
 
    if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        row.child( format(row.data()) ).show();
        tr.addClass('shown');
    }
}

function format ( rowData ) {
    var div = $('<div/>')
        .addClass( 'loading' )
        .text( 'Loading...' );
 
    $.ajax( {
        url: '/api/staff/details',
        data: {
            name: rowData.name
        },
        dataType: 'json',
        success: function ( json ) {
            div
                .html( json.html )
                .removeClass( 'loading' );
        }
    } );
 
    return div;
}

