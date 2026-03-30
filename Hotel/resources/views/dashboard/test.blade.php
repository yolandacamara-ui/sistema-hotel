<html>
<head>
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
<link rel="stylesheet" as="style" onload="this.rel='stylesheet'"
href="https://fonts.googleapis.com/css2?display=swap&family=Noto+Sans:wght@400;500;700;900&family=Work+Sans:wght@400;500;700;900"/>

<title>Coffee Dashboard</title>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="{{ asset('apexcharts.css') }}">
</head>

<body>

<div id="app">

<div class="p-10">

<h2 class="text-2xl font-bold mb-4">Ventas por Producto x Género</h2>

<select v-model="filtro_chart6" class="border p-2 rounded mb-5">

<option value="">Todos</option>

<option v-for="g in valores_chart6.genero" :value="g.nombre">
@{{ g.nombre }}
</option>

</select>

<evndchart
:series="chart6.series"
:options="chart6.opciones">
</evndchart>

</div>

</div>

<script src="{{ asset('apexcharts.js') }}"></script>
<script src="{{ asset('vue.js') }}"></script>
<script src="{{ asset('vue-apexcharts.js') }}"></script>

<script src="{{ asset('Columna.js') }}"></script>

<script>

Vue.use(VueApexCharts);

var app = new Vue({

el:'#app',

data:function(){
return{

valores_chart6:{
genero:[],
tendencias:[]
},

filtro_chart6:''

}
},

components:{
evndchart:VueApexCharts
},

watch:{

filtro_chart6:function(newValue){

var xhr6 = new XMLHttpRequest();
var self = this;

xhr6.open('POST','{{ url("/dashboard/ventas/productoxgenero") }}',true);

xhr6.onreadystatechange=function(){

if(this.readyState==4 && this.status==200){

let info = JSON.parse(this.responseText);

self.valores_chart6.genero = info.genero;
self.valores_chart6.tendencias = info.tendencias;

}

}

xhr6.setRequestHeader('Content-type','application/json');

xhr6.send(JSON.stringify({

genero:newValue,
_token:'{{csrf_token()}}'

}));

}

},

computed:{

chart6:function(){

var final={
series:[],
opciones:Columna()
}

final.opciones.xaxis.categories=[];

if(this.filtro_chart6==''){

for(i=0;i<this.valores_chart6.genero.length;i++){

final.series.push({

name:this.valores_chart6.genero[i].nombre,
data:[parseFloat(this.valores_chart6.genero[i].total)]

})

}

final.opciones.xaxis.categories.push('Ventas');

}

else{

var self=this;

let fg=this.valores_chart6.tendencias.filter(function(item){

return item.nombre==self.filtro_chart6

});

for(i=0;i<fg.length;i++){

final.series.push({

name:fg[i].nombre,
data:[parseFloat(fg[i].total)]

})

}

final.opciones.xaxis.categories.push('Ventas');

}

return final;

}

},

created(){

var xhr6 = new XMLHttpRequest();
var self=this;

xhr6.open('GET','{{ url("/dashboard/ventas/productoxgenero") }}',true);

xhr6.onreadystatechange=function(){

if(this.readyState==4 && this.status==200){

let info = JSON.parse(this.responseText);

self.valores_chart6.genero = info.genero;
self.valores_chart6.tendencias = info.tendencias;

}

}

xhr6.send();

}

})

</script>

</body>
</html>
