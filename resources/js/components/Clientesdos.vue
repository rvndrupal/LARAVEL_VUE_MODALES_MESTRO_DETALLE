<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">

            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Clientes
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <button type="button" @click="cargarPdf()" class="btn btn-info">
                            <i class="icon-doc"></i>&nbsp;Reporte
                        </button>
                    </div>
                    <!-- Listado-->
                    <!-- Se muestra la tabla del proveedor la que se va a ocultar -->
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nom">Nombre</option>
                                      <option value="ap">Apellido paterno</option>
                                      <option value="am">Apellido Materno</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarCliente(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarCliente(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Apellido Patero</th>
                                        <th>Apellido Materno</th>
                                        <th>Total</th>
                                        <th>Cursos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="cliente in arrayCliente" :key="cliente.id">
                                        <td>
                                            <button type="button" @click="verCliente(cliente.id)" class="btn btn-success btn-sm">
                                            <i class="icon-eye">Ver</i>
                                            </button> &nbsp;
                                            <button type="button" @click="pdfIngreso(ingreso.id)" class="btn btn-info btn-sm">
                                            <i class="icon-doc">Pdf</i>
                                            </button> &nbsp;
                                            <!-- <template v-if="ingreso.estado=='Registrado'">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarIngreso(ingreso.id)">
                                                    <i class="icon-trash"></i>
                                                </button>
                                            </template> -->
                                        </td>
                                        <td v-text="cliente.nom"></td>
                                        <td v-text="cliente.ap"></td>
                                        <td v-text="cliente.am"></td>
                                        <td v-text="cliente.total"></td>
                                        <template v-for="cli in cliente.cursos" :ker="cli.id">
                                            <p v-text="cli.nombre"> </p>
                                        </template>




                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                    <!-- Se muestra la tabla del proveedor la que se va a ocultar -->
                    <!--Fin Listado-->






                    <!-- Detalle-->
                    <template v-else-if="listado==0">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nombre(*)</label>
                                    <input type="text" class="form-control" v-model="nombre_curso">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Descripción(*)</label>
                                <input type="text" class="form-control" v-model="descripcion_curso">
                            </div>


                        </div>



                        <!-- Empieza la de articulo -->
                        <div class="form-group row border">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="abrirModal()" class="btn btn-success form-control btnagregar">Agregar Curso<i class="icon-plus"></i></button>
                                    <!-- Agrega la funcion para agregar detalle -->
                                </div>
                            </div>
                        </div>





                        <!-- Esto es la tabla a la que se le agregan los resultados -->
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Cursos</th>
                                            <th>Descripción</th>

                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayCursos.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.articulo">
                                            </td>
                                            <td>
                                                <input v-model="detalle.precio" type="number" value="3" class="form-control">
                                            </td>
                                            <td>
                                                <input v-model="detalle.cantidad" type="number" value="2" class="form-control">
                                            </td>
                                            <td>
                                                {{detalle.precio*detalle.cantidad}}
                                            </td>
                                        </tr>
                                        <!-- <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Parcial:</strong></td>
                                            <td>$ {{ total }}Parcial=(total-totalImpuesto).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Impuesto:</strong></td>
                                            <td>$ {{totalImpuesto=((total*impuesto)/(1+impuesto)).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ {{total=calcularTotal}}</td>
                                        </tr> -->
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                NO hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Esto es la tabla a la que se le agregan los resultados -->

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarIngreso()">Registrar Compra</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- Fin Detalle-->







                    <!-- Ver ingreso -->
                    <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Proveedor</label>
                                    <p v-text="proveedor"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Fecha</label>
                                    <p v-text="fecha_hora"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Impuesto</label>
                                <p v-text="impuesto"></p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo Comprobante</label>
                                    <p v-text="tipo_comprobante"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Serie Comprobante</label>
                                    <p v-text="serie_comprobante"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Número Comprobante</label>
                                    <p v-text="num_comprobante"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Artículo</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.articulo">
                                            </td>
                                            <td v-text="detalle.precio">
                                            </td>
                                            <td v-text="detalle.cantidad">
                                            </td>
                                            <td>
                                                {{detalle.precio*detalle.cantidad}}
                                            </td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Total Parcial:</strong></td>
                                            <td>$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Total Impuesto:</strong></td>
                                            <td>$ {{totalImpuesto=((total*impuesto)).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ {{total}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="4">
                                                NO hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>

                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- fin ver ingreso -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>



            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterioA">
                                        <option value="nombre">Nombre</option>
                                        <option value="descripcion">Descripción</option>
                                        </select>
                                        <input type="text" v-model="buscarA" @keyup.enter="listarCursos(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarCursos(buscarA,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="curso in arrayCursos" :key="curso.id">
                                            <td>
                                                <button type="button" @click="agregarDetalleModal(curso)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>

                                            <td v-text="curso.nombre"></td>
                                            <td v-text="curso.descripcion"></td>

                                            <!-- <td>
                                                <div v-if="articulo.condicion">
                                                    <span class="badge badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Desactivado</span>
                                                </div>

                                            </td> -->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    import vSelect from 'vue-select';  //para el combo select
    export default {
        props : ['ruta'],
        data (){
            return {
                ingreso_id: 0,
                idproveedor:0,
                proveedor:'',
                fecha_hora:'',
                nom : '',
                ap : '',
                am : '',
                total : '',
                nombre_curso :'',
                descripcion_curso :'',
                tipo_comprobante : 'BOLETA',
                serie_comprobante : '',
                num_comprobante : '',
                impuesto: 0.18,
                total:0.0,
                totalImpuesto: 0.0,
                totalParcial: 0.0,
                arrayCliente : [],
                arrayClienteCurso : [],
                arrayProveedor: [],
                arrayCursos : [],
                listado:1,  //se muestra el listado con esta
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorIngreso : 0,
                errorMostrarMsjIngreso : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nom',
                buscar : '',
                criterioA:'nombre',
                buscarA: '',
                arrayArticulo: [],
                idarticulo: 0,
                codigo: '',
                articulo: '',
                precio: 0,
                cantidad:0
            }
        },
        components: {
            vSelect  //del combo
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            // calcularTotal: function(){ //calculos de los totales.
            //     var resultado=0.0;
            //     for(var i=0;i<this.arrayDetalle.length;i++){
            //         resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)
            //     }
            //     return resultado;
            // }
        },
        methods : {

            listarCliente(page,buscar,criterio){
                let me=this;
                var url='http://localhost/laravel_vue_modal/public/clientes2/index?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCliente = respuesta.clientes2.data;
                    me.pagination= respuesta.pagination;

                })
                .catch(function (error) {
                    console.log(error);
                });
            },
        //     cargarPdf(){
        //         window.open(this.ruta + '/ingreso/listarPdf','_blank');
        //     },
        //     selectProveedor(search,loading){
        //         let me=this;
        //         loading(true)

        //         var url= this.ruta + '/proveedor/selectProveedor?filtro='+search;
        //         axios.get(url).then(function (response) {
        //             let respuesta = response.data;
        //             q: search
        //             me.arrayProveedor=respuesta.proveedores;
        //             loading(false)
        //         })
        //         .catch(function (error) {
        //             console.log(error);
        //         });
        //     },
        //     getDatosProveedor(val1){
        //         let me = this;
        //         me.loading = true;
        //         me.idproveedor = val1.id;
        //     },
        //     buscarArticulo(){
        //         let me=this;
        //         var url= this.ruta + '/articulo/buscarArticulo?filtro=' + me.codigo;

        //         axios.get(url).then(function (response) {
        //             var respuesta= response.data;
        //             me.arrayArticulo = respuesta.articulos;

        //             if (me.arrayArticulo.length>0){
        //                 me.articulo=me.arrayArticulo[0]['nombre'];
        //                 me.idarticulo=me.arrayArticulo[0]['id'];
        //             }
        //             else{
        //                 me.articulo='No existe artículo';
        //                 me.idarticulo=0;
        //             }
        //         })
        //         .catch(function (error) {
        //             console.log(error);
        //         });
        //     },
        //     pdfIngreso(id){
        //         window.open(this.ruta + '/ingreso/pdf/'+ id + ',' + '_blank');
        //     },
        //     cambiarPagina(page,buscar,criterio){
        //         let me = this;
        //         //Actualiza la página actual
        //         me.pagination.current_page = page;
        //         //Envia la petición para visualizar la data de esa página
        //         me.listarIngreso(page,buscar,criterio);
        //     },
        //     encuentra(id){
        //         var sw=0;
        //         for(var i=0;i<this.arrayDetalle.length;i++){
        //             if(this.arrayDetalle[i].idarticulo==id){
        //                 sw=true;
        //             }
        //         }
        //         return sw;
        //     },
        //     eliminarDetalle(index){
        //         let me = this;
        //         me.arrayDetalle.splice(index, 1);
        //     },


            // agregarCurso(data =[]){
            //     let me=this;
            //     if(me.encuentra(data['id'])){
            //             swal({
            //                 type: 'error',
            //                 title: 'Error...',
            //                 text: 'Ese artículo ya se encuentra agregado!',
            //                 })
            //         }
            //         else{
            //            me.arrayDetalle.push({
            //                 idarticulo: data['id'],
            //                 articulo: data['nombre'],
            //                 cantidad: 1,
            //                 precio: 1
            //             });
            //         }
            // },
            listarCursos (buscar,criterio){
                let me=this;
                var url='http://localhost/laravel_vue_modal/public/listar/cursos?buscar= &buscar='+ buscar + '&criterio='+ criterio;
                //   var url='http://localhost/laravel_vue_modal/public/clientes2/index?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCursos = respuesta.cursos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
        //     registrarIngreso(){
        //         if (this.validarIngreso()){
        //             return;
        //         }

        //         let me = this;

        //         axios.post(this.ruta + '/ingreso/registrar',{
        //             'idproveedor': this.idproveedor,
        //             'tipo_comprobante': this.tipo_comprobante,
        //             'serie_comprobante' : this.serie_comprobante,
        //             'num_comprobante' : this.num_comprobante,
        //             'impuesto' : this.impuesto,
        //             'total' : this.total,
        //             'data': this.arrayDetalle  // Manda todos los detalles de detalle ingreso

        //         }).then(function (response) {
        //             me.listado=1;
        //             me.listarIngreso(1,'','num_comprobante');
        //             me.idproveedor=0;
        //             me.tipo_comprobante='BOLETA';
        //             me.serie_comprobante='';
        //             me.num_comprobante='';
        //             me.impuesto=0.18;
        //             me.total=0.0;
        //             me.idarticulo=0;
        //             me.articulo='';
        //             me.cantidad=0;
        //             me.precio=0;
        //             me.arrayDetalle=[];

        //         }).catch(function (error) {
        //             console.log(error);
        //         });
        //     },
        //     validarIngreso(){
        //         this.errorIngreso=0;
        //         this.errorMostrarMsjIngreso =[];

        //         if (this.idproveedor==0) this.errorMostrarMsjIngreso.push("Seleccione un Proveedor");
        //         if (this.tipo_comprobante==0) this.errorMostrarMsjIngreso.push("Seleccione el comprobante");
        //         if (!this.num_comprobante) this.errorMostrarMsjIngreso.push("Ingrese el número de comprobante");
        //         if (!this.impuesto) this.errorMostrarMsjIngreso.push("Ingrese el impuesto de compra");
        //         if (this.arrayDetalle.length<=0) this.errorMostrarMsjIngreso.push("Ingrese detalles"); //valida el array de los detalles.

        //         if (this.errorMostrarMsjIngreso.length) this.errorIngreso = 1;

        //         return this.errorIngreso;
        //     },
            mostrarDetalle(){
                let me=this;
                me.listado=0;

                // me.idproveedor=0;
                // me.tipo_comprobante='BOLETA';
                // me.serie_comprobante='';
                // me.num_comprobante='';
                // me.impuesto=0.18;
                // me.total=0.0;
                // me.idarticulo=0;
                // me.articulo='';
                // me.cantidad=0;
                // me.precio=0;
                // me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=1;
            },
        //     verIngreso(id){
        //         let me=this;
        //         me.listado=2;

        //         //Obtener los datos del ingreso
        //         var arrayIngresoT=[];
        //         var url= this.ruta + '/ingreso/obtenerCabecera?id=' + id;

        //         axios.get(url).then(function (response) {
        //             var respuesta= response.data;
        //             arrayIngresoT = respuesta.ingreso;

        //             me.proveedor = arrayIngresoT[0]['nombre'];
        //             me.fecha_hora=arrayIngresoT[0]['fecha_hora'];
        //             me.tipo_comprobante=arrayIngresoT[0]['tipo_comprobante'];
        //             me.serie_comprobante=arrayIngresoT[0]['serie_comprobante'];
        //             me.num_comprobante=arrayIngresoT[0]['num_comprobante'];
        //             me.impuesto=arrayIngresoT[0]['impuesto'];
        //             me.total=arrayIngresoT[0]['total'];
        //         })
        //         .catch(function (error) {
        //             console.log(error);
        //         });

        //         //Obtener los datos de los detalles
        //         var urld= this.ruta + '/ingreso/obtenerDetalles?id=' + id;

        //         axios.get(urld).then(function (response) {
        //             //console.log(response);
        //             var respuesta= response.data;
        //             me.arrayDetalle = respuesta.detalles;
        //         })
        //         .catch(function (error) {
        //             console.log(error);
        //         });
        //     },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            },
            abrirModal(){
                this.listarCursos();
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios Cursos';
            },
        //     desactivarIngreso(id){
        //        swal({
        //         title: 'Esta seguro de anular este ingreso?',
        //         type: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Aceptar!',
        //         cancelButtonText: 'Cancelar',
        //         confirmButtonClass: 'btn btn-success',
        //         cancelButtonClass: 'btn btn-danger',
        //         buttonsStyling: false,
        //         reverseButtons: true
        //         }).then((result) => {
        //         if (result.value) {
        //             let me = this;

        //             axios.put(this.ruta + '/ingreso/desactivar',{
        //                 'id': id
        //             }).then(function (response) {
        //                 me.listarIngreso(1,'','num_comprobante');
        //                 swal(
        //                 'Anulado!',
        //                 'El ingreso ha sido anulado con éxito.',
        //                 'success'
        //                 )
        //             }).catch(function (error) {
        //                 console.log(error);
        //             });


        //         } else if (
        //             // Read more about handling dismissals
        //             result.dismiss === swal.DismissReason.cancel
        //         ) {

        //         }
        //         })
        //     },
        },
        mounted() {
            this.listarCliente(1,this.buscar,this.criterio);
            this.listarCursos(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
