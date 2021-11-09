<template>
    <div>
        <div class="block-loading" v-if="loading"></div>
        <div style="margin-bottom:85px"></div>
        <div class="row">
            <div class="col-md-12">
                <apexchart type="bar" width="450px" :options="chartOptions" :series="chartSeries"></apexchart>
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
                chartSeries:[],
                etiquetas:[],
            }
        },
        mounted() {

        },
        created(){
            this.setear_fechas()
            this.mostrar()
        },
        computed:{
            chartOptions(){
                let option = {}
                 option = {
                        plotOptions: {
                            bar: {
                                horizontal: true,
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: this.etiquetas
                        }
                    }
                return option
            }
        },
        methods:{
            setear_fechas()
            {
                this.valorFechaInicio = moment().subtract(6, 'months').format('YYYY-MM-DD');
                this.valorFechaFin = moment().add(1,'days').format('YYYY-MM-DD')
            },
            mostrar()
            {
                this.loading = true

                axios.post(abs_path+'/grafico-producto-por-agotarse')
                    .then((r) =>{
                        this.chartSeries = [{data: r.data.data.series}]
                        this.etiquetas = r.data.data.etiquetas
                    })
                    .catch((error) => {
                        if(error.response && error.response.status == 423)
                        {
                            Toastr.error(error.response.data.error,'Mensaje');
                        }
                        else
                        {
                            Toastr.error(error,'Mensaje');
                        }
                    })
                    .finally(()=>{
                        this.loading = false
                    })
            },
        }
    }
</script>
