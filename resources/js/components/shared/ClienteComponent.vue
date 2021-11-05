<template>
    <div>
        <div class="block-loading" v-if="loading"></div>
        <!--  -->
        <div class="card-body">
            <form method="POST" autocomplete="off" @submit.prevent="validar">
                <div class="form-group">
                    <label for="">Nombres</label>
                    <input type="text" class="form-control" name="nombre" v-validate="'required'" v-model="nombre">
                    <error-form :attribute_name="'nombre'" :errors_form="errors"></error-form>
                </div>
                <div class="form-group">
                    <label for="">Apellidos</label>
                    <input type="text" class="form-control" name="apellido" v-validate="'required'" v-model="apellido">
                    <error-form :attribute_name="'apellido'" :errors_form="errors"></error-form>
                </div>
                <div class="form-group">
                    <label for="">Nit</label>
                    <input type="text" class="form-control" name="nit" v-model="nit">
                    <error-form :attribute_name="'nit'" :errors_form="errors"></error-form>
                </div>
                <div class="form-group">
                    <label for="">Teléfono</label>
                    <input type="text" class="form-control" name="telefono" v-validate="'numeric'" v-model="telefono">
                    <error-form :attribute_name="'telefono'" :errors_form="errors"></error-form>
                </div>
                <div class="form-group">
                    <label for="">Dirección</label>
                    <textarea class="form-control" name="direccion" v-validate="'required'" v-model="direccion"></textarea>
                    <error-form :attribute_name="'direccion'" :errors_form="errors"></error-form>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-flat float-right">Guardar</button>
                </div>
            </form>
        </div>
        <!--  -->
    </div>
</template>

<script>
    export default {
        data(){
            return{
                loading: false,

                nombre:'',
                apellido:'',
                telefono:'',
                nit:'',
                direccion:''
            }
        },
        mounted() {
            this.config_error()
        },
        methods:{
            validar(){
                this.$validator.validateAll().then((result) =>{
                            if(result)
                            {
                                this.guardar_cliente()
                            }
					});
            },
            guardar_cliente(){
                this.loading = true

                let data = {
                    'nombre':this.nombre,
                    'apellido':this.apellido,
                    'nit':this.nit,
                    'telefono':this.nit,
                    'direccion':this.direccion
                }

                axios.post(abs_path + '/guardar-nuevo-cliente',data)
                    .then(response =>{
                        Toastr.success(response.data.data,'Mensaje');
                        this.limpiar_vista()
                    })
                    .catch(error =>{
                        Toastr.error(error.response.data.error,'Error')
                    })
                    .finally(()=>{
                        this.loading = false
                    })
            },
            limpiar_vista(){
                this.nombre=''
                this.apellido=''
                this.nit=''
                this.direccion=''
                this.telefono=''
                this.$validator.reset();
            },
            config_error(){
            let self = this
               let dict = {
                custom:{
                    nombre:{
                        required:'El nombre es requerido'
                    },
                    apellido:{
                        required:'El apellido es requerido'
                    },
                    telefono:{
                        required:'El teléfono es requerido',
                        numeric:'El teléfono es un número'
                    },
                    nit:{
                        required:'El nit es requerido'
                    },
                    direccion:{
                        required:'La dirección es requerida'
                    },
                }
               }

              self.$validator.localize('es',dict);
          },
        }
    }
</script>
