<template>
    <main>
        <div class="box border-top border-secondary pt-2">
            <div class="d-flex justify-content-end mb-2">
                <button class="btn btn-secondary" @click="nuevo()">
                    <i class="fas fa-plus"></i> Nueva experiencia
                </button>
            </div>
            <!-- Tabla -->
            <div class="table-container">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>

                            <th>#</th>
                            <th>Empresa</th>
                            <th>Cargo</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
            
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in items_experiencias" :key="item.id">
                            <td>{{  item.id}}</td>
                            <td>{{  item.empresa}}</td>
                            <td>{{  item.cargo}}</td>
                            <td>{{  item.fecha_inicio}}</td>
                            <td>{{  item.fecha_fin}}</td>
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
                        <h4 v-if="experiencia.accion==0" class="modal-title">NUEVO REGISTRO</h4>
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
                                        <label for="empresa">Empresa:</label>
                                        <input class="form-control" type="text" id="empresa" v-model="experiencia.empresa">
                                    </div>
                                    <div>
                                        <label for="cargo">Cargo:</label>
                                        <input class="form-control" type="text" id="cargo" v-model="experiencia.cargo">
                                    </div>
                                    <div>
                                        <label for="fecha_inicio">Fecha Inicio:</label>
                                        <input class="form-control" type="date" id="fecha_inicio" v-model="experiencia.fecha_inicio">
                                    </div>
                                    <div>
                                        <label for="fecha_fin">Fecha Fin:</label>
                                        <input class="form-control" type="date" id="fecha_fin" v-model="experiencia.fecha_fin">
                                    </div>
                               
                                    <div>
                                        <label for="id_docente">Docente:</label>
                                        <select class="form-control" id="id_docente" v-model="experiencia.id_docente">
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
                        <button v-if="experiencia.accion==0" @click="guardar()" type="button"
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
                items_experiencias: [],
                items_docentes: [],

                experiencia: {
                    id: 0,
                    empresa:'',
                    cargo:'',
                    fecha_inicio:'',
                    fecha_fin:'',
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
            this.listarExperiencias(1);

        },
        methods: {
            cambiarPagina(page) {
                let me = this;
                me.pagination.current_page = page;
                me.listarExperiencias(page);
            },
            nuevo() {
                this.experiencia.accion = 0;
                this.listarDocentes();
                this.limpiar();
                $('#nuevo').modal('show');
            },
            cerrarModal() {
                $('#nuevo').modal('hide');
            },

            guardar() {
                this.experiencia.accion = 0;
                axios.post('/experiencia/guardar', this.experiencia).then(response => {

                        Swal.fire({
                            title: 'Operación exitosa',
                            icon: 'success',
                            position: 'top-end',
                            timer: 1500
                        });
                        this.cerrarModal();
                        this.listarExperiencias(1);
                    }).catch(error => {
                        console.error(error);
                    })
                    .finally(function () {})
            },

            modificar() {
                this.experiencia.accion = 1;
                axios.post('/experiencia/guardar', this.experiencia).then(response => {

                        Swal.fire({
                            title: 'Operación exitosa',
                            icon: 'success',
                            position: 'top-end',
                            timer: 1500
                        });
                        this.cerrarModal();
                        this.listarExperiencias(1);
                    }).catch(error => {
                        console.error(error);
                    })
                    .finally(function () {})
            },

            eliminar(item) {
                this.experiencia.id=item.id;
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción eliminará la experiencia.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Lógica para eliminar la tarea
                        axios.post('/experiencia/eliminar', this.experiencia)
                        .then(response => {
                            this.listarExperiencias(1);
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
                this.experiencia.id = item.id;
                this.experiencia.empresa = item.empresa;
                this.experiencia.cargo = item.cargo;
                this.experiencia.fecha_inicio = item.fecha_inicio;
                this.experiencia.fecha_fin = item.fecha_fin;
                this.experiencia.id_docente = item.id_docente;
                this.experiencia.accion = 1;
                console.log(this.experiencia);
                $('#nuevo').modal('show');
            },

            listarExperiencias(page) {
                let me = this;
                axios.get('/experiencia/listar?page=' + page).then(response => {
                    me.items_experiencias = response.data.data;
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
                axios.get('/experiencia/listar_docentes').then(response => {
                    me.items_docentes = response.data;
                    
                }).catch(error => {
                    console.error(error);
                });
            },

            limpiar() {
                this.experiencia.id = 0;
                this.experiencia.empresa = '';
                this.experiencia.cargo = '';
                this.experiencia.fecha_inicio = '';
                this.experiencia.fecha_fin = '';
                this.experiencia.id_docente = 0;
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
