<template>
    <div>
        <span v-text="getHora"></span>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                meses:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                hora:0,
                minutos:0,
                segundos:0,
                fecha:'',
                mes:0,
            }
        },
        created(){
            this.actualizar_tiempo();
        },
        mounted() {
            setInterval(this.actualizar_tiempo, 1000);
        },
        methods:{
            actualizar_tiempo(){

                var date = new Date(Date.now());
                    date.toLocaleString
                    this.hora = date.getHours();
                    this.minutos = date.getMinutes();
                    this.segundos = date.getSeconds();

                this.mes = date.getMonth();
                this.fecha = date.getDate() + " " + this.meses[date.getMonth()] +" "+ date.getFullYear();

                if(this.minutos < 10){
                    this.minutos = '0'+this.minutos;
                }
                if(this.segundos < 10){
                    this.segundos = '0'+this.segundos;
                }
            }
        },
        computed:{
            getHora(){
                return this.fecha + " " + this.hora + ":" + this.minutos + ":" + this.segundos;
            }
        },
    }
</script>
