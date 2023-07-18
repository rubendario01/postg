<template>
    <main>
        <div class="box border-top border-secondary pt-2">
            <div class="d-flex justify-content-end mb-2">
                <button class="btn btn-secondary" @click="nuevo()">
                    <i class="fas fa-plus"></i> Nuevo Docente
                </button>
            </div>
            <!-- Tabla -->
            <div class="table-container">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Paterno</th>
                            <th>Materno</th>
                            <th>Carnet</th>
                            <th>lugar nacimiento</th>
                            <th>Correo</th>
                            <th>telefono</th>
                            <!-- <th>Disponibilidad</th>
                            <th>Dirección</th>
                            <th>fecha nacimiento</th> -->
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in items_docentes" :key="item.id">
                            <td>#</td>
                            <td>{{  item.nombre}}</td>
                            <td>{{  item.paterno}}</td>
                            <td>{{  item.materno}}</td>
                            <td>{{  item.carnet}}</td>
                            <td>{{  item.lugar_nacimiento}}</td>
                            <td>{{  item.correo}}</td>
                            <td>{{  item.telefono}}</td>
                            <!-- <td>{{  item.disponibilidad}}</td>
                            <td>{{  item.direccion}}</td>
                            <td>{{  item.fecha_nacimiento}}</td> -->
                            <td>
                                <button @click="editar(item)" class="btn btn-primary btn-sm mx-1">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button @click="eliminar(item)" class="btn btn-danger btn-sm mx-1">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Card Pagination -->
            <!-- Card Pagination -->
            <div class="card-footer py-4">
                <nav>
                    <ul class="pagination justify-content-end mb-0">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#"
                                @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page"
                            :class="[page==isActived ? 'active' :'']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page)"
                                :v-text="page">{{ page }}</a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#"
                                @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Modal registro rol -->
        <div class="modal fade" id="nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 v-if="docente.accion==0" class="modal-title">NUEVO REGISTRO</h4>
                        <h4 v-else class="modal-title">MODIFICAR REGISTRO</h4>
                        <button @click="cerrarModal()" type="button" class="close" aria-hidden="true">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">


                                    <div>
                                        <label for="nombre">Nombre:</label>
                                        <input class="form-control" type="text" id="nombre" v-model="docente.nombre">
                                    </div>
                                    <div>
                                        <label for="paterno">Apellido Paterno:</label>
                                        <input class="form-control" type="text" id="paterno" v-model="docente.paterno">
                                    </div>
                                    <div>
                                        <label for="materno">Apellido Materno:</label>
                                        <input class="form-control" type="text" id="materno" v-model="docente.materno">
                                    </div>
                                    <div>
                                        <label for="carnet">Carnet:</label>
                                        <input class="form-control" type="text" id="carnet" v-model="docente.carnet">
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div>
                                        <label for="lugar_nacimiento">Lugar de Nacimiento:</label>
                                        <input class="form-control" type="text" id="lugar_nacimiento"
                                            v-model="docente.lugar_nacimiento">
                                    </div>
                                    <div>
                                        <label for="correo">Correo Electrónico:</label>
                                        <input class="form-control" type="email" id="correo" v-model="docente.correo">
                                    </div>
                                    <div>
                                        <label for="telefono">Teléfono:</label>
                                        <input class="form-control" type="text" id="telefono"
                                            v-model="docente.telefono">
                                    </div>
                                    <div>
                                        <label for="disponibilidad">Disponibilidad:</label>
                                        <input class="form-control" type="text" id="disponibilidad"
                                            v-model="docente.disponibilidad">
                                    </div>
                                    <div>
                                        <label for="direccion">Dirección:</label>
                                        <input class="form-control" type="text" id="direccion"
                                            v-model="docente.direccion">
                                    </div>
                                    <div>
                                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                                        <input class="form-control" type="date" id="fecha_nacimiento"
                                            v-model="docente.fecha_nacimiento">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button @click="cerrarModal()" type="button" class="btn btn-default">Cerrar</button>
                        <button v-if="docente.accion==0" @click="guardar()" type="button"
                            class="btn btn-primary">Guardar</button>
                        <button v-else @click="modificar()" type="button" class="btn btn-primary">Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import axios from 'axios';
    import Swal from 'sweetalert2';
    export default {
        data() {
            return {
                items_docentes: [],

                docente: {
                    id: 0,
                    nombre: '',
                    paterno: '',
                    materno: '',
                    carnet: '',
                    lugar_nacimiento: '',
                    correo: '',
                    telefono: '',
                    disponibilidad: '',
                    direccion: '',
                    fecha_nacimiento: '',
                    accion: 0,
                },


                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 2,


            };
        },
        created() {},
        mounted() {
            this.listarDocentes(1);

        },
        methods: {
            cambiarPagina(page) {
                let me = this;
                me.pagination.current_page = page;
                me.listarDocentes(page);
            },
            nuevo() {
                this.docente.accion = 0;
                this.limpiar();
                $('#nuevo').modal('show');
            },
            cerrarModal() {
                $('#nuevo').modal('hide');
            },

            guardar() {
                this.docente.accion = 0;
                axios.post('/docente/guardar', this.docente).then(response => {

                        Swal.fire({
                            title: 'Operación exitosa',
                            icon: 'success',
                            position: 'top-end',
                            timer: 1500
                        });
                        this.cerrarModal();
                        this.listarDocentes(1);
                    }).catch(error => {
                        console.error(error);
                    })
                    .finally(function () {})
            },

            modificar() {
                this.docente.accion = 1;
                axios.post('/docente/guardar', this.docente).then(response => {

                        Swal.fire({
                            title: 'Operación exitosa',
                            icon: 'success',
                            position: 'top-end',
                            timer: 1500
                        });
                        this.cerrarModal();
                        this.listarDocentes(1);
                    }).catch(error => {
                        console.error(error);
                    })
                    .finally(function () {})
            },

            eliminar(item) {
                this.docente.id=item.id;
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción eliminará el docente.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Lógica para eliminar la tarea
                        axios.post('/docente/eliminar', this.docente)
                        .then(response => {
                            this.listarDocentes(1);
                        })
                        .catch(error => {
                            console.error(error);
                        })
                        .finally(function () {

                        })
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Acción cancelada, no se hace nada.
                    }
                });
                    
            },
            editar(item) {
                this.docente.id = item.id;
                this.docente.nombre = item.nombre;
                this.docente.paterno = item.paterno;
                this.docente.materno = item.materno;
                this.docente.carnet = item.carnet;
                this.docente.lugar_nacimiento = item.lugar_nacimiento;
                this.docente.correo = item.correo;
                this.docente.telefono = item.telefono;
                this.docente.disponibilidad = item.disponibilidad;
                this.docente.direccion = item.direccion;
                this.docente.fecha_nacimiento = item.fecha_nacimiento;
                this.docente.accion = 1;
                console.log(this.docente);
                $('#nuevo').modal('show');
            },

            listarDocentes(page) {
                let me = this;
                axios.get('/docente/listar?page=' + page).then(response => {
                    me.items_docentes = response.data.data;
                    me.pagination = {
                        total: response.data.total,
                        current_page: response.data.current_page,
                        per_page: response.data.per_page,
                        last_page: response.data.last_page,
                        from: response.data.from,
                        to: response.data.to
                    }
                }).catch(error => {
                    console.error(error);
                });
            },

            limpiar() {
                this.docente.id = 0;
                this.docente.nombre = '';
                this.docente.paterno = '';
                this.docente.materno = '';
                this.docente.carnet = '';
                this.docente.lugar_nacimiento = '';
                this.docente.correo = '';
                this.docente.telefono = '';
                this.docente.disponibilidad = '';
                this.docente.direccion = '';
                this.docente.fecha_nacimiento = '';
            },

            // listarRoles(page) {
            //     let me=this;
            //     axios.get('/rol/listar?page='+page).then(response => {
            //         me.roles = response.data.data;
            //         me.pagination={total:response.data.total, 
            //                     current_page:response.data.current_page,
            //                     per_page: response.data.per_page,
            //                     last_page: response.data.last_page,
            //                     from: response.data.from,
            //                     to: response.data.to
            //                 }
            //     }).catch(error => {
            //         console.error(error);
            //     });
            // },
            // guardarRol() {
            //     var exitoso=false;
            //     axios.post('/rol/guardar', this.rol).then(response => {
            //         exitoso=true;
            //         this.cerrarModalNuevoRol();
            //         this.listarRoles(1);
            //     }).catch(error => {
            //         console.error(error);
            //     })
            //     .finally(function(){
            //         if(exitoso==true){
            //             Swal.fire({
            //                 title:'Operación exitosa',
            //                 icon:'success',
            //                 position:'top-end',
            //                 timer:1500
            //             });
            //         }
            //     })
            // },
            // editarRol(rol) {
            //     this.rol.id = rol.id;
            //     this.rol.nombre = rol.nombre;
            //     this.rol.opcion = 1;
            //     $('#modalNuevoRol').modal('show');
            //     // Código para editar un rol
            // },
            // eliminarRol(rol) {
            //     // Código para eliminar un rol
            //     let url="/rol/eliminar";
            //     let me=this;
            //     var exitoso=false;
            //     me.rol.id = rol.id;
            //     axios.post(url, me.rol)
            //     .then((response)=>{
            //         console.log(response);
            //         exitoso=true;
            //         me.listarRoles(1);
            //     })
            //     .catch(function(error){
            //         console.log(error);
            //     })
            //     .finally(function(){
            //         if(exitoso==true){
            //             Swal.fire({
            //                 title:'Operación exitosa',
            //                 icon:'success',
            //                 position:'top-end',
            //                 timer:1500
            //             });
            //         }
            //     })


            // },
            // abrirModalNuevoRol() {
            //     this.rol = {
            //         nombre: ''
            //     };
            //     $('#modalNuevoRol').modal('show');
            // },
            // cerrarModalNuevoRol() {
            //     $('#modalNuevoRol').modal('hide');
            // },

        },
        computed: {
            isActived: function () {
                return this.pagination.current_page;
            },
            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
        }
    }

</script>
