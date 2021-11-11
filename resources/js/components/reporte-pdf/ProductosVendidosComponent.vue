<template>
    <div>
        <div class="block-loading" v-if="loading"></div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" class="control-label">Desde</label>
                        <input type="date" class="form-control" v-model="valorFechaInicio">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" class="control-label">Hasta</label>
                        <input type="date" class="form-control" v-model="valorFechaFin">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" class="control-label">&nbsp;</label>
                        <button class="btn btn-primary btn-block btn-flat" @click.prevent="descargar()"><i class="fas fa-download"></i> Descargar</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align:center">
                    <span class="text-danger"><i class="far fa-file-pdf fa-7x"></i></span>
                </div>
            </div>
    </div>
</template>

<script>
import moment from 'moment'

export default {
        data(){
            return {
                loading:false,
                valorFechaInicio:null,
                valorFechaFin:null,
            }
        },
        mounted() {

        },
        created(){
            this.setear_fechas()
        },
        computed:{

        },
        methods:{
            setear_fechas()
            {
                this.valorFechaInicio = moment().subtract(6, 'months').format('YYYY-MM-DD');

                this.valorFechaFin = moment().add(1,'days').format('YYYY-MM-DD')
            },
            descargar()
            {
                this.loading = true

                let datos = {
                    'desde':this.valorFechaInicio,
                    'hasta':this.valorFechaFin
                }

                axios({
                        url:abs_path + '/pdf-productos-vendidos',
                        data:datos,
                        method:'POST',
                        responseType:'blob'
                    })
                    .then((r) => {
                        const blob = new Blob([r.data], {type: r.data.type});
                        const url = window.URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        let fileName = Date.now()+'.pdf';
                        link.setAttribute('download', fileName);
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                        window.URL.revokeObjectURL(url);

                    })
                    .catch((error) =>{
                        Toastr.error('Revisar el rango de fechas','Mensaje')
                    })
                    .finally(()=>{
                        this.loading = false
                    })
            }
        }
    }
</script>
