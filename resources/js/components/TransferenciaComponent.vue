<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form class="form-horizontal" method="POST" autocomplete="off" data-vv-scope="datos">
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Tienda origen</label>
                        <div class="col-sm-8">
                            <span class="form-control" v-text="tienda_sesion.nombre"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Tienda destino</label>
                        <div class="col-sm-8">
                            <select name="destino" id="" class="form-control" v-model="tienda_destino" v-validate="'required'">
                                <template v-for="item in tiendas">
                                    <option :value="item.id">{{ item.nombre }}</option>
                                </template>
                            </select>
                            <error-form :attribute_name="'datos.destino'" :errors_form="errors"></error-form>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Quién solicitó traslado?</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="solicito_traslado" v-model="solicito_traslado" v-validate="'required'">
                            <error-form :attribute_name="'datos.solicito_traslado'" :errors_form="errors"></error-form>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Quién autorizó traslado?</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="autorizo_traslado" v-model="autorizo_traslado" v-validate="'required'">
                            <error-form :attribute_name="'datos.autorizo_traslado'" :errors_form="errors"></error-form>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Boleta de referencia</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="boleta_referencia" v-model="boleta_referencia" v-validate="'required'">
                            <error-form :attribute_name="'datos.boleta_referencia'" :errors_form="errors"></error-form>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Fecha</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="fecha" v-model="fecha" v-validate="'required'">
                            <error-form :attribute_name="'datos.fecha'" :errors_form="errors"></error-form>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Motivo del traslado</label>
                        <div class="col-sm-8">
                            <textarea name="motivo" class="form-control" v-model="motivo" v-validate="'required'"></textarea>
                            <error-form :attribute_name="'datos.motivo'" :errors_form="errors"></error-form>
                        </div>
                    </div>
                </form>
                <form action="" method="POST" autocomplete="off" data-vv-scope="producto">
                    <div class="form-group row">
                        <div class="col-sm-5">
                            <multiselect
                            ref='producto'
                            data-vv-name="producto"
                            v-validate="'required'"
                            v-model="producto"
                            :options="productos"
                            placeholder="Buscar producto"
                            label="nombre"
                            track-by="id"
                            :searchable="true"
                            :loading="isLoading"
                            @search-change="buscar_producto"
                            @select="fijar_cantidad"
                            :show-labels="false">
                            <span slot="noResult">No se encontraron registros</span>
                            </multiselect>
                            <error-form :attribute_name="'producto.producto'" :errors_form="errors"></error-form>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" v-model="cantidad" v-validate="'required'" name="cantidad" placeholder="Cantidad" ref="cantidad">
                            <error-form :attribute_name="'producto.cantidad'" :errors_form="errors"></error-form>
                        </div>
                        <div class="col-sm-3">
                            <button class="btn btn-primary btn-block btn-flat" @click.prevent="agregar('producto')">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody v-if="lista.length < 1">
                        <tr class="text-center">
                            <td colspan="5">No hay productos agregados</td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr v-for="(item,index) in lista">
                            <td style="text-align:center">{{ index + 1 }}</td>
                            <td>{{ item.producto.nombre }}</td>
                            <td style="text-align:center">{{ item.cantidad }}</td>
                            <td style="text-align:right">Q. {{ item.precio}}</td>
                            <td style="text-align:center"><button class="btn btn-outline-danger btn-sm" @click="quitar(index)"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <button class="btn btn-success btn-flat btn-block" @click.prevent="guardar('datos')">Transferir</button>
            </div>
        </div>
    </div>
</template>
<style>
 .multiselect{
     box-sizing: border-box;
 }
</style>
<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components:{
            Multiselect
        },
        props:{
            registro:{}
        },
        data(){
            return{
                isLoading: false, //multiselect
                loading: false,

                tienda_sesion:[],
                tiendas:[],

                boleta_referencia:'',
                tienda_destino:'',
                solicito_traslado:'',
                autorizo_traslado:'',
                fecha:'',
                motivo:'',

                producto:null,
                productos:[],

                precio:'',
                cantidad:'',

                lista:[],
            }
        },
        mounted() {
            this.config_error()
            this.obtener_registros()
            if(this.registro){
                this.tienda_sesion = this.registro
            }
        },
        created(){

        },
        methods:{
            guardar(scope){
                this.$validator.validateAll(scope).then((result) => {
                            if(result)
                            {
                                if(this.lista.length > 0)
                                {
                                    this.registrar_producto()
                                }
                                else
                                {
                                    Toastr.error('Debe agregar productos a la transferencia')
                                }
                            }
					});
            },
            registrar_producto(){
                this.loading = true
                console.log(this.tienda_sesion)
                let data = {
                    'lista':this.lista,
                    'boleta_referencia':this.boleta_referencia,
                    'tienda_origen_id':this.tienda_sesion.id,
                    'tienda_destino_id':this.tienda_destino,
                    'solicito_traslado':this.solicito_traslado,
                    'autorizo_traslado':this.autorizo_traslado,
                    'motivo':this.motivo,
                    'fecha':this.fecha,
                }

                axios.post(abs_path + '/guardar-transferencia',data)
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

                this.boleta_referencia=''
                this.producto=null
                this.cantidad=''
                this.tienda_destino=''
                this.solicito_traslado=''
                this.autorizo_traslado=''
                this.fecha=''
                this.motivo=''

                this.lista=[]

                this.$validator.reset();
            },
            fijar_cantidad(producto){
                this.$refs.cantidad.focus();
            },
            buscar_producto(query){
                if(query < 2){
                    this.productos = []
                }else{
                    this.isLoading = true
                    axios.get(abs_path + '/buscar-producto-transferencia/'+query)
                        .then(response => {
                            this.productos = response.data.data
                            this.isLoading = false
                        }).
                        catch(error =>{
                            this.isLoading = false
                        });
                }
            },
            agregar(scope){
                this.$validator.validateAll(scope).then((result) => {
                            if(result)
                            {
                                if(this.cantidad <= 0)
                                {
                                    Toastr.error('Debe ingresar cantidades válidas','Error')
                                }
                                else
                                {
                                    this.agregar_lista()
                                }
                            }
					});
            },
            agregar_lista(){

                let data = {
                    'producto':this.producto,
                    'precio':this.producto.precio,
                    'cantidad':this.cantidad,
                }

                 this.lista.push(data)
                 this.cantidad = '';
                 this.producto = '';
                 this.productos = [];

                 this.$validator.reset();
            },
            formatPrice(value) {
                return  parseFloat(value).toFixed(2);
            },

            isNumeric(value){
                 return !isNaN(parseFloat(value)) && isFinite(value)
            },
            quitar(index){
                this.lista.splice(index,1)
            },
            obtener_registros(){
                this.loading = true
                Promise.all([this.obtener_tienda_destino()])
                    .then(data =>{
                        this.loading = false
                    })
                    .catch(error =>{
                        this.loading = false
                    })
            },
            obtener_tienda_destino(){
                return new Promise((resolve,reject) =>{
                    axios.get(abs_path+'/listar-tiendas')
                        .then(response =>{
                            this.tiendas = response.data.data
                            resolve()
                        })
                        .catch(error =>{
                            reject(error)
                        })
                })
            },
            config_error(){
            let self = this
               let dict = {
                custom:{
                    boleta_referencia:{
                        required:'El número de boleta es requerido',
                    },
                    tienda_destino:{
                        required:'La tienda destino es requerida',
                    },
                    solicito_traslado:{
                        required:'Quién solicito traslado es requerido',
                    },
                    autorizo_traslado:{
                        required:'Quién autorizó traslado es requerido',

                    },
                    fecha:{
                        required:'La fecha es requerida',
                        date_format:'La fecha debe tener un formato válido'
                    },
                    motivo:{
                        required:'El motivo del traslado es requerido',
                    },
                    producto:{
                        required:'El producto es requerido'
                    },
                    precio:{
                        required:'El precio es requerido',
                        decimal:'El precio puede tener decimales'
                    },
                    cantidad:{
                        required:'La cantidad es requerida',
                        numeric:'La cantidad es un número'
                    },
                }
               }

              self.$validator.localize('es',dict);
          },
        }
    }
</script>
