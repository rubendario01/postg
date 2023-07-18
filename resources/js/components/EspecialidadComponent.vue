<template>
    <main>
        <div class="box border-top border-secondary pt-2">
            <div class="d-flex justify-content-end mb-2">
                <button class="btn btn-secondary" @click="nuevo()">
                    <i class="fas fa-plus"></i> Nueva especialidad
                </button>
            </div>
            <!-- Tabla -->
            <div class="table-container">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>

                            <th>#</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Pais</th>
                            <th>Ciudad</th>
                            <th>Fecha</th>
                            <th>Docente</th>
                        
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in items_especialidades" :key="item.id">
                            <td>{{  item.id}}</td>
                            <td>{{  item.nombre}}</td>
                            <td>{{  item.tipo}}</td>
                            <td>{{  item.pais}}</td>
                            <td>{{  item.ciudad}}</td>
                            <td>{{  item.fecha}}</td>
                            <td>{{  item.nombre_docente}}</td>
    
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
                        <h4 v-if="especialidad.accion==0" class="modal-title">NUEVO REGISTRO</h4>
                        <h4 v-else class="modal-title">MODIFICAR REGISTRO</h4>
                        <button @click="cerrarModal()" type="button" class="close" aria-hidden="true">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-12">

                                    <div>
                                        <label for="nombre">Nombre:</label>
                                        <input class="form-control" type="text" id="nombre" v-model="especialidad.nombre">
                                    </div>
                                    <div>
                                        <label for="tipo">Tipo:</label>
                                        <input class="form-control" type="text" id="tipo" v-model="especialidad.tipo">
                                    </div>
                                    <div>
                                        <label for="ciudad">Ciudad:</label>
                                        <input class="form-control" type="text" id="ciudad" v-model="especialidad.ciudad">
                                    </div>
                                    <div>
                                        <label for="pais">Pais:</label>
                                        <input class="form-control" type="text" id="pais" v-model="especialidad.pais">
                                    </div>
                                    <div>
                                        <label for="fecha">Fecha:</label>
                                        <input class="form-control" type="date" id="fecha" v-model="especialidad.fecha">
                                    </div>
                                    <div>
                                        <label for="id_docente">Docente:</label>
                                        <select class="form-control" id="especialidad" v-model="especialidad.id_docente">
                                            <option  value="" selected disabled>Selecciona Docente</option>
                                            <option v-for = "item in items_docentes" :key= "item.id" :value="item.id" v-text="item.nombre +' '+item.paterno+' '+ item.materno"></option>
                                        </select>
                                    </div>
                                </div>
                              
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button @click="cerrarModal()" type="button" class="btn btn-default">Cerrar</button>
                        <button v-if="especialidad.accion==0" @click="guardar()" type="button"
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
                items_especialidades: [],
                items_docentes: [],

                especialidad: {
                    id: 0,
                    nombre: '',
                    tipo: '',
                    pais: '',
                    ciudad: '',
                    fecha: '',
                    id_docente: '',
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
            this.listarEspecialidades(1);

        },
        methods: {
            cambiarPagina(page) {
                let me = this;
                me.pagination.current_page = page;
                me.listarEspecialidades(page);
            },
            nuevo() {
                this.especialidad.accion = 0;
                this.listarDocentes();
                this.limpiar();
                $('#nuevo').modal('show');
            },
            cerrarModal() {
                $('#nuevo').modal('hide');
            },

            guardar() {
                this.especialidad.accion = 0;
                axios.post('/especialidad/guardar', this.especialidad).then(response => {

                        Swal.fire({
                            title: 'Operación exitosa',
                            icon: 'success',
                            position: 'top-end',
                            timer: 1500
                        });
                        this.cerrarModal();
                        this.listarEspecialidades(1);
                    }).catch(error => {
                        console.error(error);
                    })
                    .finally(function () {})
            },

            modificar() {
                this.especialidad.accion = 1;
                axios.post('/especialidad/guardar', this.especialidad).then(response => {

                        Swal.fire({
                            title: 'Operación exitosa',
                            icon: 'success',
                            position: 'top-end',
                            timer: 1500
                        });
                        this.cerrarModal();
                        this.listarEspecialidades(1);
                    }).catch(error => {
                        console.error(error);
                    })
                    .finally(function () {})
            },

            eliminar(item) {
                this.especialidad.id=item.id;
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción eliminará la especialidad.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Lógica para eliminar la tarea
                        axios.post('/especialidad/eliminar', this.especialidad)
                        .then(response => {
                            this.listarEspecialidades(1);
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
                this.especialidad.id = item.id;
                this.especialidad.nombre = item.nombre;
                this.especialidad.pais = item.pais;
                this.especialidad.ciudad = item.ciudad;
                this.especialidad.fecha = item.fecha;
                this.especialidad.tipo = item.tipo;
                this.especialidad.id_docente = item.id_docente;
                this.especialidad.accion = 1;
                console.log(this.especialidad);
                $('#nuevo').modal('show');
            },

            listarEspecialidades(page) {
                let me = this;
                axios.get('/especialidad/listar?page=' + page).then(response => {
                    me.items_especialidades = response.data.data;
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
            
            listarDocentes() {
                let me = this;
                axios.get('/especialidad/listar_docentes').then(response => {
                    me.items_docentes = response.data;
                    
                }).catch(error => {
                    console.error(error);
                });
            },

            limpiar() {
                this.especialidad.id = 0;
                this.especialidad.nombre = '';
                this.especialidad.tipo = '';
                this.especialidad.pais = '';
                this.especialidad.ciudad = '';
                this.especialidad.fecha = '';
                this.especialidad.id_docente = 0;
            },

        
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
