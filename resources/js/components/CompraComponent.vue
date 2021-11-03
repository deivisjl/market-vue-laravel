<template>
    <div>
        <div class="block-loading" v-if="loading"></div>
        <form method="POST" autocomplete="off" data-vv-scope="proveedor">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" class="control-label">Proveedor</label>
                        <div class="input-group">
                            <multiselect
                                    style="padding:0!important;border:none!important"
                                    class="form-control"
                                    ref='proveedor'
                                    data-vv-name="proveedor"
                                    v-validate="'required'"
                                    v-model="proveedor"
                                    :options="proveedores"
                                    placeholder="Buscar"
                                    label="nombre"
                                    track-by="id"
                                    :searchable="true"
                                    :loading="isLoading"
                                    @search-change="buscar_proveedor"
                                    @select="fijar_comprobante"
                                    :show-labels="false">
                                    <span slot="noResult">No se encontraron registros</span>
                                    </multiselect>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-primary text-light" style="cursor:pointer;">
                                        <li class="fas fa-plus"></li>
                                    </span>
                                </div>
                        </div>
                        <error-form :attribute_name="'proveedor.proveedor'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" class="control-label">No. comprobante</label>
                        <input type="text" class="form-control" name="comprobante" v-model="no_comprobante" ref="comprobante">
                        <error-form :attribute_name="'proveedor.comprobante'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" class="control-label">Forma de pago</label>
                        <select data-vv-name="forma_pago" v-model="forma_pago" class="form-control" v-validate="'required'">
                            <template v-for="item in formas_pagos">
                                <option :value="item.id">{{ item.nombre }}</option>
                            </template>
                        </select>
                        <error-form :attribute_name="'proveedor.forma_pago'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" class="control-label">Fecha comprobante</label>
                        <input type="date" class="form-control" name="fecha" v-model="fecha">
                        <error-form :attribute_name="'proveedor.fecha'" :errors_form="errors"></error-form>
                    </div>
                </div>
            </div>
        </form>
        <form method="POST" autocomplete="off" data-vv-scope="producto">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" class="control-label">Producto</label>
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
                        <label for="" class="control-label">Precio</label>
                        <input type="text" class="form-control" name="precio" v-model="precio" ref="precio" v-validate="'required'">
                        <error-form :attribute_name="'producto.precio'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" class="control-label">Cantidad</label>
                        <input type="text" class="form-control" name="cantidad" v-model="cantidad" v-validate="'required'">
                        <error-form :attribute_name="'producto.cantidad'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" class="control-label">&nbsp;</label>
                        <button type="submit" class="btn-block btn btn-primary btn-flat" @click.prevent="agregar('producto')" style="display:block">Agregar</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Precio total</th>
                            <th class="text-center">Cantidad total</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center"></th>
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
                            <td style="text-align:center"><button class="btn btn-danger btn-sm" @click="quitar(index)"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="float-right">Total Q. <span v-text="formatPrice(total)"></span></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-lg btn-block btn-flat" @click.prevent="guardar('proveedor')">Registrar compra</button>
            </div>
        </div>
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

                proveedor:'',
                proveedores:[],

                no_comprobante:'',

                forma_pago:'',
                formas_pagos:[],

                fecha:'',

                producto:null,
                productos:[],

                precio:'',
                cantidad:'',

                lista:[],
                total:0.00,
            }
        },
        mounted() {
            this.config_error()
            this.obtener_registros()
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
                                    Toastr.error('Debe agregar productos a la compra')
                                }
                            }
					});
            },
            registrar_producto(){
                this.loading = true

                let data = {
                    'lista':this.lista,
                    'proveedor':this.proveedor.id,
                    'forma_pago':this.forma_pago,
                    'no_comprobante':this.no_comprobante,
                    'fecha':this.fecha,
                    'total':this.total
                }

                axios.post(abs_path + '/compras',data)
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
                this.unidad_medida=null
                this.forma_pago=''
                this.producto=null
                this.precio=''
                this.cantidad=''
                this.proveedor=''
                this.fecha=''
                this.no_comprobante=''

                this.lista=[]
                this.total=0.00

                this.$validator.reset();
            },
            fijar_precio(producto){
                this.$refs.precio.focus();
            },
            fijar_comprobante(item){
                this.$refs.comprobante.focus();
            },
            buscar_proveedor(query){
            if(query < 2){
                    this.productos = []
                }else{
                    this.isLoading = true
                    axios.get(abs_path + '/buscar-proveedores-nombre/'+query)
                        .then(response => {
                            this.proveedores = response.data.data
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
                    axios.get(abs_path + '/buscar-productos-nombre/'+query)
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
                                if(this.precio == 0 || this.cantidad == 0)
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
                  proveedor:{
                      required:'El nombre del proveedor es requerido'
                  },
                  tipo_pago:{
                      required:'El tipo de pago es requerido'
                  },
                  no_comprobante:{
                      required:'El número de comprobante es requerido'
                  },
                  fecha:{
                      required:'La fecha es requerida',
                      date_format:'La fecha debe tener un formato válido'
                  },
                  producto:{
                      required:'El nombre del producto es requerido'
                  },
                  precio:{
                      required:'El precio es requerido',
                      decimal:'El precio puede tener decimales'
                  },
                  cantidad:{
                      required:'La cantidad es requerida',
                      numeric:'La cantidad es un número'
                  },
                  unidad_medida:{
                      required:'La unidad de medida es requerida'
                  },
                }
               }

              self.$validator.localize('es',dict);
          },
        }
    }
</script>
