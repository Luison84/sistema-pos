 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Inventario / Productos</h1>
             </div><!-- /.col -->
             <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                     <li class="breadcrumb-item active">Inventario / Productos</li>
                 </ol>
             </div><!-- /.col -->
         </div><!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <div class="content">
     <div class="container-fluid">

         <!-- row para criterios de busqueda -->
         <div class="row">

             <div class="col-lg-12">

                 <div class="card card-info">
                     <div class="card-header">
                         <h3 class="card-title">CRITERIOS DE BÚSQUEDA</h3>
                         <div class="card-tools">
                             <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                 <i class="fas fa-minus"></i>
                             </button>
                             <button type="button" class="btn btn-tool text-danger" id="btnLimpiarBusqueda">
                                 <i class="fas fa-times"></i>
                             </button>
                         </div> <!-- ./ end card-tools -->
                     </div> <!-- ./ end card-header -->
                     <div class="card-body">

                         <div class="row">

                            <div class="col-lg-12 d-lg-flex">

                                <div style="width: 20%;" class="form-floating mx-1">
                                    <input 
                                            type="text" 
                                            id="iptCodigoBarras"
                                            class="form-control"
                                            data-index="2">
                                    <label for="iptCodigoBarras">Código de Barras</label>
                                </div>

                                <div style="width: 20%;" class="form-floating mx-1">
                                    <input 
                                            type="text" 
                                            id="iptCategoria"
                                            class="form-control"
                                            data-index="4">
                                    <label for="iptCategoria">Categoría</label>
                                </div>

                                <div style="width: 20%;" class="form-floating mx-1">
                                    <input 
                                            type="text" 
                                            id="iptProducto"
                                            class="form-control"
                                            data-index="5">
                                    <label for="iptProducto">Producto</label>
                                </div>

                                <div style="width: 20%;" class="form-floating mx-1">
                                    <input 
                                            type="text" 
                                            id="iptPrecioVentaDesde"
                                            class="form-control">
                                    <label for="iptPrecioVentaDesde">P. Venta Desde</label>
                                </div>

                                <div style="width: 20%;" class="form-floating mx-1">
                                    <input 
                                            type="text" 
                                            id="iptPrecioVentaHasta"
                                            class="form-control">
                                    <label for="iptPrecioVentaHasta">P. Venta Hasta</label>
                                </div>
                            </div>

                         </div>
                     </div> <!-- ./ end card-body -->
                 </div>

             </div>
             
         </div>

         <!-- row para listado de productos/inventario -->
         <div class="row">
             <div class="col-lg-12">
                 <table id="tbl_productos" class="table table-striped w-100 shadow">
                     <thead class="bg-info">
                         <tr style="font-size: 15px;">
                             <th></th>
                             <th>id</th>
                             <th>Codigo</th>
                             <th>Id Categoria</th>
                             <th>Categoría</th>
                             <th>Producto</th>
                             <th>P. Compra</th>
                             <th>P. Venta</th>
                             <th>Utilidad</th>
                             <th>Stock</th>
                             <th>Min. Stock</th>
                             <th>Ventas</th>
                             <th>Fecha Creación</th>
                             <th>Fecha Actualización</th>
                             <th class="text-cetner">Opciones</th>
                         </tr>
                     </thead>
                     <tbody class="text-small">
                     </tbody>
                 </table>
             </div>
         </div>
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->

 <script>
$(document).ready(function() {

    var table;

    $.ajax({
        url: "ajax/productos.ajax.php",
        type: "POST",
        data: {
            'accion': 1
        }, //1: LISTAR PRODUCTOS
        dataType: 'json',
        success: function(respuesta) {
            console.log("respuesta", respuesta);
        }
    });

    /*===================================================================*/
    // CARGA DEL LISTADO CON EL PLUGIN DATATABLE JS
    /*===================================================================*/
    table = $("#tbl_productos").DataTable({
        dom: 'Bfrtip',
        buttons: [{
                text: 'Agregar Producto',
                className: 'addNewRecord',
                action: function(e, dt, node, config) {
                    //EVENTO PARA LEVENTAR LA VENTA MODAL
                    alert('nuevo Boton')
                }
            },
            'excel', 'print', 'pageLength'
        ],
        pageLength: [5, 10, 15, 30, 50, 100],
        pageLength: 10,
        ajax: {
            url: "ajax/productos.ajax.php",
            dataSrc: '',
            type: "POST",
            data: {
                'accion': 1
            }, //1: LISTAR PRODUCTOS
        },
        responsive: {
            details: {
                type: 'column'
            }
        },
        columnDefs: [{
                targets: 0,
                orderable: false,
                className: 'control'
            },
            {
                targets: 1,
                visible: false
            },
            {
                targets: 3,
                visible: false
            },
            {
                targets: 9,
                createdCell: function(td, cellData, rowData, row, col){
                    if(parseFloat(rowData[9]) <= parseFloat(rowData[10])){
                        $(td).parent().css('background','#FF5733')
                    }
                }
            },
            {
                targets: 11,
                visible: false
            },
            {
                targets: 12,
                visible: false
            },
            {
                targets: 13,
                visible: false
            },
            {
                targets: 14,
                orderable: false,
                render: function(datqa, type, full, meta) {
                    return "<center>" +
                        "<span class='btnEditarProducto text-primary px-1' style='cursor:pointer;'>" +
                        "<i class='fas fa-pencil-alt fs-5'></i>" +
                        "</span>" +
                        "<span class='btnAumentarStock text-success px-1' style='cursor:pointer;'>" +
                        "<i class='fas fa-plus-circle fs-5'></i>" +
                        "</span>" +
                        "<span class='btnDisminuirStock text-warning px-1' style='cursor:pointer;'>" +
                        "<i class='fas fa-minus-circle fs-5'></i>" +
                        "</span>" +
                        "<span class='btnEliminarProducto text-danger px-1' style='cursor:pointer;'>" +
                        "<i class='fas fa-trash fs-5'></i>" +
                        "</span>" +
                        "</center>"
                }
            }

        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }
    });

    /*===================================================================*/
    // EVENTOS PARA CRITERIOS DE BUSQUEDA (CODIGO, CATEGORIA Y PRODUCTO)
    /*===================================================================*/
    $("#iptCodigoBarras").keyup(function(){
        table.column($(this).data('index')).search(this.value).draw();
    })

    $("#iptCategoria").keyup(function(){
        table.column($(this).data('index')).search(this.value).draw();
    })

    $("#iptProducto").keyup(function(){
        table.column($(this).data('index')).search(this.value).draw();
    })

    $("#iptPrecioVentaDesde, #iptPrecioVentaHasta").keyup(function(){
        table.draw();
    })

    $.fn.dataTable.ext.search.push(

        function(settings, data, dataIndex){

            var precioDesde = parseFloat($("#iptPrecioVentaDesde").val());
            var precioHasta = parseFloat($("#iptPrecioVentaHasta").val());

            var col_venta = parseFloat(data[7]);

            if((isNaN(precioDesde) && isNaN(precioHasta)) ||
                (isNaN(precioDesde) && col_venta <=  precioHasta) ||
                (precioDesde <= col_venta && isNaN(precioHasta)) ||
                (precioDesde <= col_venta && col_venta <= precioHasta)){
                    return true;
            }

            return false;
        }
    )

    $("#btnLimpiarBusqueda").on('click',function(){
        
        $("#iptCodigoBarras").val('')
        $("#iptCategoria").val('')
        $("#iptProducto").val('')
        $("#iptPrecioVentaDesde").val('')
        $("#iptPrecioVentaHasta").val('')

        table.search('').columns().search('').draw();
    })



})
 </script>