<?php ?>
<link rel="stylesheet" href="{{asset('backtemplate/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backtemplate/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backtemplate/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<style>
    table.dataTable > tbody > tr.child ul.dtr-details > li {
        text-align: left !important;
    }

    table.dataTable tbody td.dtr-control, table.dataTable tbody td.middle {
        /*vertical-align: middle;*/
    }

    table.dataTable thead {
        text-transform: uppercase !important;
        /*color: white;*/
    }

    /*table.dataTable thead {*/
    .bgcolortable {
        text-transform: uppercase !important;
        /*color: white;*/
        color: white;
        background-color: #206A5D;
        /*background-image: linear-gradient(49deg, #FFFB7D 63%, #85FFBD 96%);*/


    }

</style>
