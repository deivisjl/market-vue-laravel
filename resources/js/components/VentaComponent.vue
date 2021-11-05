<template>
    <div>
        <div class="row mb-2">
            <div class="col-sm-8">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <form method="POST" autocomplete="off" data-vv-scope="producto">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Producto</label>
                                            <multiselect
                                                ref='producto'
                                                data-vv-name="producto"
                                                v-validate="'required'"
                                                v-model="producto"
                                                :options="productos"
                                                placeholder="Buscar"
                                                label="nombre"
                                                track-by="id"
                                                :searchable="true"
                                                :loading="isLoading"
                                                @search-change="buscar_producto"
                                                @select="fijar_precio"
                                                :show-labels="false">
                                                <span slot="noResult">No se encontraron registros</span>
                                                </multiselect>
                                    <error-form :attribute_name="'producto.producto'" :errors_form="errors"></error-form>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Precio</label>
                                            <input type="text" class="form-control" name="precio" v-validate="'required|decimal'" v-model="precio" ref="precio">
                                            <error-form :attribute_name="'producto.precio'" :errors_form="errors"></error-form>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Cantidad</label>
                                            <input type="text" class="form-control" name="cantidad" v-validate="'required|numeric'" v-model="cantidad">
                                            <error-form :attribute_name="'producto.cantidad'" :errors_form="errors"></error-form>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">&nbsp;</label>
                                        <button class="btn btn-primary btn-block btn-flat" style="display:block" @click.prevent="agregar('producto')">Agregar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Detalle de la venta</h3>
                        </div>
                        <div class="card-body  p-0">
                            <table class="table table-hovered">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">No.</th>
                                        <th style="text-align:center">Producto</th>
                                        <th style="text-align:center">Precio</th>
                                        <th style="text-align:center">Cantidad</th>
                                        <th style="text-align:center">Subtotal</th>
                                        <th style="text-align:center"></th>
                                    </tr>
                                </thead>
                                <tbody v-if="lista.length < 1">
                                    <tr class="text-center">
                                        <td colspan="6">No hay productos agregados</td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr v-for="(item,index) in lista">
                                        <td style="text-align:center">{{ index + 1 }}</td>
                                        <td>{{ item.producto.nombre }}</td>
                                        <td style="text-align:right">Q. {{ item.precio}}</td>
                                        <td style="text-align:center">{{ item.cantidad }}</td>
                                        <td style="text-align:right">Q. {{ item.subtotal }}</td>
                                        <td style="text-align:center"><button class="btn btn-outline-danger btn-sm" @click="quitar(index)"><i class="fas fa-trash-alt"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--  -->
            </div>
            <div class="col-sm-4">
                <div class="card  card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Resumen de venta</h3>
                    </div>
                    <div class="card-body">
                        <form action="" autocomplete="off" data-vv-scope="cliente">
                            <div class="form-group">
                                <label for="">Cliente</label>
                                <div class="input-group">
                                    <multiselect
                                            style="padding:0!important;border:none!important"
                                            class="form-control"
                                            ref='cliente'
                                            data-vv-name="cliente"
                                            v-validate="'required'"
                                            v-model="cliente"
                                            :options="clientes"
                                            placeholder="Buscar"
                                            label="nombre"
                                            track-by="id"
                                            :searchable="true"
                                            :loading="isLoading"
                                            @search-change="buscar_cliente"
                                            :show-labels="false">
                                            <span slot="noResult">No se encontraron registros</span>
                                            </multiselect>
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-primary text-light" @click.prevent="agregar_cliente()" style="cursor:pointer">
                                                <li class="fas fa-plus"></li>
                                            </span>
                                        </div>
                                </div>
                                <error-form :attribute_name="'cliente.cliente'" :errors_form="errors"></error-form>
                            </div>
                            <div class="form-group">
                                <label for="">Forma de pago</label>
                                <select name="forma_pago" v-model="forma_pago" class="form-control" v-validate="'required'">
                                     <template v-for="item in formas_pagos">
                                        <option :value="item.id">{{ item.nombre }}</option>
                                    </template>
                                </select>
                                <error-form :attribute_name="'cliente.forma_pago'" :errors_form="errors"></error-form>
                            </div>
                            <table style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td class="text-danger"><h3>TOTAL</h3></td>
                                        <td class="float-right"><h3>Q. <span v-text="formatPrice(total)"></span></h3></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" class="btn btn-success btn-block btn-lg btn-flat" @click.prevent="guardar('cliente')">Finalizar venta</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal" tabindex="-1" data-backdrop="static" id="registrarCliente">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="far fa-times-circle"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <cliente-component v-if="form_modal"></cliente-component>
                </div>
                </div>
            </div>
        </div>
        <!--  -->
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components:{
            Multiselect
        },
        data(){
            return{
                isLoading: false, //multiselect
                loading: false,
                form_modal:false,

                producto:null,
                productos:[],

                precio:'',
                cantidad:'',

                forma_pago:'',
                formas_pagos:[],

                cliente:'',
                clientes:[],

                lista:[],
                total:0.00,
            }
        },
        mounted() {
            this.config_error()
            this.obtener_registros()

            $('#registrarCliente').on('hidden.bs.modal', function (e) {
                    this.form_modal = false
                    events.$emit('cerrar_modal')
            })
            events.$on('cerrar_modal', this.event_cerrar_modal)
        },
        beforeDestroy()
        {
            events.$off('cerrar_modal',this.event_cerrar_modal)
        },
        methods:{
            event_cerrar_modal(data){
                this.form_modal = false
            },
            agregar_cliente()
            {
                this.form_modal = true
                $('#registrarCliente').appendTo("body").modal('show');
            },
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
                                    Toastr.error('Debe agregar productos a la compra')
                                }
                            }
					});
            },
            registrar_producto(){
                this.loading = true

                let data = {
                    'lista':this.lista,
                    'cliente':this.cliente.id,
                    'forma_pago':this.forma_pago,
                    'total':this.total
                }

                axios.post(abs_path + '/ventas',data)
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
                this.forma_pago=''
                this.producto=null
                this.precio=''
                this.cantidad=''
                this.cliente=''

                this.lista=[]
                this.total=0.00

                this.$validator.reset();
            },
            fijar_precio(producto){
                this.precio = producto.precio
                this.$refs.precio.focus();
            },
            buscar_cliente(query){
            if(query < 2){
                    this.productos = []
                }else{
                    this.isLoading = true
                    axios.get(abs_path + '/buscar-clientes-nombre/'+query)
                        .then(response => {
                            this.clientes = response.data.data
                            this.isLoading = false
                        }).
                        catch(error =>{
                            this.isLoading = false
                        });
                }
            },
            buscar_producto(query){
                if(query < 2){
                    this.productos = []
                }else{
                    this.isLoading = true
                    axios.get(abs_path + '/productos-por-nombre/'+query)
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
                                if(this.precio <= 0 || this.cantidad <= 0)
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
                var subtotal = parseFloat(this.precio * this.cantidad).toFixed(2)
                this.total = parseFloat(this.total) + parseFloat(subtotal)

                let data = {
                    'producto':this.producto,
                    'precio':parseFloat(this.precio).toFixed(2),
                    'cantidad':this.cantidad,
                    'subtotal': parseFloat(subtotal).toFixed(2),
                    'compra':parseFloat(this.producto.compra * this.cantidad)
                }

                 this.lista.push(data)
                 this.precio = '';
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

                this.total = parseFloat(this.total) - parseFloat(this.lista[index].subtotal )
                this.lista.splice(index,1)
            },
            obtener_registros(){
                this.loading = true
                Promise.all([this.obtener_tipo_pago()])
                    .then(data =>{
                        this.loading = false
                    })
                    .catch(error =>{
                        this.loading = false
                    })
            },
            obtener_tipo_pago(){
                return new Promise((resolve,reject) =>{
                    axios.get(abs_path+'/obtener-forma-pago')
                        .then(response =>{
                            this.formas_pagos = response.data.data
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
                  cliente:{
                      required:'El nombre del cliente es requerido'
                  },
                  forma_pago:{
                      required:'La forma de pago es requerida'
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
