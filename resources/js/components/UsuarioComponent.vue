<template>
    <main>
        <div class="box border-top border-secondary pt-2">
            <div class="d-flex justify-content-end mb-2">
                <button class="btn btn-secondary" @click="abrirModalNuevoUsuario()">
                    <i class="fas fa-plus"></i> Nuevo usuario
                </button>
            </div>
            <!-- Tabla -->
            <div class="table-container">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Rol</th>
                            <!-- Agrega más columnas según tus necesidades -->
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(dato, indexUsuarios) in arrayUsuarios" :key="dato.id">
                            <td>{{ indexUsuarios+1 }}</td>
                            <td>{{ dato.name }}</td>
                            <td>{{ dato.role }}</td>
                            <!-- Agrega más columnas según tus necesidades -->
                            <td>
                                <button class="btn btn-sm btn-info text-white" @click="editar(dato)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger text-white ml-2" @click="eliminar(dato)">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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

        <!-- Modal registro usuarios -->
        <div class="modal fade" id="modalNuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">NUEVO USUARIO</h4>
                        <button type="button" class="close" aria-hidden="true"
                            @click="cerrarModalNuevoUsuario()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input v-model="usuario.nombre" type="text" name="nombre" id="nombre" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nombre">Contraseña</label>
                            <input v-model="usuario.password" type="password" name="nombre" id="nombre" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nombre">Repita contraseña</label>
                            <input v-model="usuario.password2" type="password" name="nombre" id="nombre" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="rol">Grupo - Rol</label>
                            <select v-model="usuario.id_rol" class="form-control" name="rol" id="">
                                <option value="">Seleccione una opción</option>
                                <option v-for="rol in roles" :key="rol.id" :value="rol.id">
                                    {{ rol.nombre }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" @click="cerrarModalNuevoUsuario()">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="guardarUsuario()">Guardar cambios</button>
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
                arrayUsuarios: [],
                roles: [],

                usuario: {
                    id: 0,
                    nombre: '',
                    password:'',
                    password2:'',
                    id_rol: 0,
                    opcion:0,// 0 guardar; 1 modificar
                },
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 2,
            }
        },
        mounted() {

            console.log('usuarios');

            this.getUsuarios(1);

        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }                
                var from = this.pagination.current_page - this.offset;
                if(from < 1){
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
        },
        methods: {
            cambiarPagina(page){
                let me=this;
                me.pagination.current_page=page;
                me.getUsuarios(page);
            },
            eliminar(user){
                let me= this;
                me.usuario.id = user.id;
                let url = '/usuario/eliminar'
                axios.post(url, me.usuario).then(function (response) {
                        console.log(response);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Acción completada',
                            text: 'La acción se completó correctamente.',
                        });
                        me.getUsuarios(1);

                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(function () {

                    })
            },
            getRoles() {
                let url = "/get_roles";
                let me = this;
                axios.get(url).then(function (response) {
                        me.roles = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(function () {

                    })
            },
            getUsuarios(page) {

                let url = "/get_usuarios?page="+page;
                let me = this;
                    
                        axios.get(url)
                        .then(function (response) {
                            me.arrayUsuarios = response.data.data;
                            me.pagination={total:response.data.total, 
                                current_page:response.data.current_page,
                                per_page: response.data.per_page,
                                last_page: response.data.last_page,
                                from: response.data.from,
                                to: response.data.to
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        })
                        .finally(() => {
                        })
                  
            },
            guardarUsuario() {
                let me = this;
                let url = "/set_usuario";
                if(this.usuario.password==this.usuario.password2){
                    axios.post(url, me.usuario).then(function (response) {
                            console.log(response);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Acción completada',
                                text: 'La acción se completó correctamente.',
                            });
                            me.cerrarModalNuevoUsuario();
                            me.getUsuarios(1);
                        })
                        .catch(function (error) {
                            console.log(error);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Error',
                                text: error.message,
                            });
                        })
                        .finally(function () {
    
                        })
                }else{
                    Swal.fire({
                        position:'center',
                        title:'Error',
                        icon:'error',
                        text:'Las contraseñas no coinciden',
                    });
                }
            },
            editar(user) {
                this.usuario.id=user.id;
                this.usuario.nombre= user.name;
                this.usuario.id_rol= user.id_rol;
                this.usuario.opcion = 1;
                this.abrirModalNuevoUsuario();
            },
            abrirModalNuevoUsuario() {
                this.getRoles();
                $('#modalNuevoUsuario').modal('show');
            },
            cerrarModalNuevoUsuario() {
                $('#modalNuevoUsuario').modal('hide');
            }

        }
    }

</script>

<style>
    .table-container .dataTables_length {
        display: flex;
        align-items: center;
    }

    .table-container .dataTables_length label,
    .table-container .dataTables_length select {

        margin-right: 5px;
    }

    .table-container .dataTables_filter label {

        color: black;
    }

    .table-container .dataTables_filter input[type="search"] {

        border: 1px solid rgb(204, 204, 204);
        margin-left: 10px;
        border-radius: 5px;
        font-size: 0.9rem;
        padding-left: 8px;

    }

    .table-container .dataTables_filter input[type="search"]:focus {
        border-color: 1px solid rgb(204, 204, 204);
    }

    .table-container .dataTables_length select {
        border: 1px solid rgb(204, 204, 204);
        margin-left: 10px;
        border-radius: 5px;
        font-size: 0.9rem;
        padding-left: 8px;
    }

</style>
