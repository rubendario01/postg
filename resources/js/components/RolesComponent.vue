<template>
    <main>
        <div class="box border-top border-secondary pt-2">
            <div class="d-flex justify-content-end mb-2">
                <button class="btn btn-secondary" @click="abrirModalNuevoRol()">
                    <i class="fas fa-plus"></i> Nuevo rol
                </button>
            </div>
            <!-- Tabla -->
            <div class="table-container">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(rol, index) in roles" :key="rol.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ rol.nombre }}</td>
                            <td>
                                <button class="btn btn-sm btn-info text-white" @click="editarRol(rol)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger text-white ml-2" @click="eliminarRol(rol)">
                                    <i class="fas fa-trash"></i>
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
        <div class="modal fade" id="modalNuevoRol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">NUEVO ROL</h4>
                        <button type="button" class="close" aria-hidden="true" @click="cerrarModalNuevoRol()">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input v-model="rol.nombre" type="text" name="nombre" id="nombre" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" @click="cerrarModalNuevoRol()">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="guardarRol()">Guardar</button>
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
                roles: [],
                rol: {
                    id:0,
                    nombre: '',
                    opcion:0,
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
            this.listarRoles(1);

        },
        methods: {
            cambiarPagina(page) {
                let me = this;
                me.pagination.current_page = page;
                me.listarRoles(page);
            },
            listarRoles(page) {
                let me=this;
                axios.get('/rol/listar?page='+page).then(response => {
                    me.roles = response.data.data;
                    me.pagination={total:response.data.total, 
                                current_page:response.data.current_page,
                                per_page: response.data.per_page,
                                last_page: response.data.last_page,
                                from: response.data.from,
                                to: response.data.to
                            }
                }).catch(error => {
                    console.error(error);
                });
            },
            guardarRol() {
                var exitoso=false;
                axios.post('/rol/guardar', this.rol).then(response => {
                    exitoso=true;
                    this.cerrarModalNuevoRol();
                    this.listarRoles(1);
                }).catch(error => {
                    console.error(error);
                })
                .finally(function(){
                    if(exitoso==true){
                        Swal.fire({
                            title:'Operación exitosa',
                            icon:'success',
                            position:'top-end',
                            timer:1500
                        });
                    }
                })
            },
            editarRol(rol) {
                this.rol.id = rol.id;
                this.rol.nombre = rol.nombre;
                this.rol.opcion = 1;
                $('#modalNuevoRol').modal('show');
                // Código para editar un rol
            },
            eliminarRol(rol) {
                // Código para eliminar un rol
                let url="/rol/eliminar";
                let me=this;
                var exitoso=false;
                me.rol.id = rol.id;
                axios.post(url, me.rol)
                .then((response)=>{
                    console.log(response);
                    exitoso=true;
                    me.listarRoles(1);
                })
                .catch(function(error){
                    console.log(error);
                })
                .finally(function(){
                    if(exitoso==true){
                        Swal.fire({
                            title:'Operación exitosa',
                            icon:'success',
                            position:'top-end',
                            timer:1500
                        });
                    }
                })
            
             
            },
            abrirModalNuevoRol() {
                this.rol = {
                    nombre: ''
                };
                $('#modalNuevoRol').modal('show');
            },
            cerrarModalNuevoRol() {
                $('#modalNuevoRol').modal('hide');
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
