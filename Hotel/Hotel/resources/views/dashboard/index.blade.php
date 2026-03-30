
<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Work+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <title>Cofee Dashboard</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="{{ asset('apexcharts.css') }}">
  </head>
  <body>
    <div class="relative flex h-auto min-h-screen w-full flex-col bg-white group/design-root overflow-x-hidden" style='font-family: "Work Sans", "Noto Sans", sans-serif;'>
      <div id="app" class="layout-container flex h-full grow flex-col">
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f4f3f0] px-10 py-3">
          <div class="flex items-center gap-4 text-[#181511]">
            <div class="size-4">
              <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M42.4379 44C42.4379 44 36.0744 33.9038 41.1692 24C46.8624 12.9336 42.2078 4 42.2078 4L7.01134 4C7.01134 4 11.6577 12.932 5.96912 23.9969C0.876273 33.9029 7.27094 44 7.27094 44L42.4379 44Z"
                  fill="currentColor"
                ></path>
              </svg> 
            </div>
            <h2 class="text-[#181511] text-lg font-bold leading-tight tracking-[-0.015em]">Coffee Shop</h2>
          </div>
          <div class="flex flex-1 justify-end gap-8">
            <div class="flex items-center gap-9">
              <a class="text-[#181511] text-sm font-medium leading-normal" href="#">Dashboard</a>
              <a class="text-[#181511] text-sm font-medium leading-normal" href="#">Menu</a>
              <a class="text-[#181511] text-sm font-medium leading-normal" href="#">Orders</a>
              <a class="text-[#181511] text-sm font-medium leading-normal" href="#">Customers</a>
              <a class="text-[#181511] text-sm font-medium leading-normal" href="#">Reports</a>
            </div>
            <button
              class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 bg-[#f4f3f0] text-[#181511] gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-2.5"
            >
              <div class="text-[#181511]" data-icon="Bell" data-size="20px" data-weight="regular">
                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                  <path
                    d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06ZM128,216a24,24,0,0,1-22.62-16h45.24A24,24,0,0,1,128,216ZM48,184c7.7-13.24,16-43.92,16-80a64,64,0,1,1,128,0c0,36.05,8.28,66.73,16,80Z"
                  ></path>
                </svg>
              </div>
            </button>
            <div
              class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
              style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCiWzftYojm6n802x2Ii1YpfttBNrsLyT7QtPoMWw-v8AJgjAPIH8gvcar6Ssi3uVkJLQKNVEm6K3LaTmgGYXBx1WZ5xNm08RCWbs7wMVhlzN_0PvQAflkGMIBynOl44EKyNJnBT0U6u6ELwqFlXupon0xegknFwutU04uVXhuDePbpXH9nyj8U7VzscyAz2XthKOAGcSB1D2ZmVG8SDdMKmzHD10rLwu271OoxLyrvnqFR2BrlRQNSatzfBXmtSFTTv4HTKOWxH5E");'
            ></div>
          </div>
        </header>
        <div class="px-40 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4">
              <div class="flex min-w-72 flex-col gap-3">
                <p class="text-[#181511] tracking-light text-[32px] font-bold leading-tight">Consola Ecommerce</p>
                <p class="text-[#897961] text-sm font-normal leading-normal">Overview of key performance indicators for your coffee shop.</p>
              </div>
            </div>            
            <h2 class="text-[#181511] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Indicadores de ventas</h2>
            <p class="text-[#897961] px-4 text-sm font-normal leading-normal">Últimos 3 meses.</p>
            <div class="flex flex-wrap gap-4 px-4 py-6">
              <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#e6e1db] p-6">
                <div class="flex items-start justify-between">
                  <div class="flex flex-col gap-2">
                    <p class="text-[#181511] text-base font-medium leading-normal">Ventas totalesss</p>
                    <p class="text-[#181511] tracking-light text-[32px] font-bold leading-tight truncate">$@{{total_ventas}}</p>
                    <div class="flex gap-1">
                      <p class="text-[#897961] text-base font-normal leading-normal">Promedio diario</p>
                      <p class="text-[#078810] text-base font-medium leading-normal">$1,250</p>
                    </div>
                  </div>
                  <div class="flex items-center">
                    @{{filtro_chart1}}
                    <select v-model="filtro_chart1" class="custom-select h-9 cursor-pointer rounded-md border border-[#e6e1db] bg-white px-3 py-1 text-xs font-semibold text-[#897961] focus:border-[#897961] focus:ring-0">
                      <option value="">Todos</option>
                      <option v-for="producto in productos" :value="producto.id">@{{producto.nombre}}</option>
                      
                    </select>
                  </div>
                </div>
                <div class="flex min-h-[180px] flex-1 flex-col gap-8 py-4">
                  <div>
                    <!--Aqui va la grafica-->
                    <!--<evndchart :series="valores" :options="configuracion"></evndchart>-->
                    <evndchart :series="chart1.series" :options="chart1.opciones"></evndchart>
                  </div>
                </div>
              </div>
              <!-- CANAL ---------------------------------------------->
              <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#e6e1db] p-6">
                <p class="text-[#181511] text-base font-medium leading-normal">Ventas por canal</p>
                <p class="text-[#181511] tracking-light text-[32px] font-bold leading-tight truncate">250</p>
                <!--aqui agregue el select-->
                <div class="flex items-center">
                  @{{filtro_chart2}}
                    <select v-model="filtro_chart2" class="custom-select h-9 cursor-pointer rounded-md border border-[#e6e1db] bg-white px-3 py-1 text-xs font-semibold text-[#897961] focus:border-[#897961] focus:ring-0">
                      <option value="">Todos</option>
                      <option v-for="canal in canales" :value="canal">@{{canal}}</option>
                    </select>
                  </div>
                <div class="flex gap-1">
                  <p class="text-[#897961] text-base font-normal leading-normal">Capuchino</p>
                  <p class="text-[#078810] text-base font-medium leading-normal">20</p>
                </div>
                <!-- Segunada Grafica -->
                <div>
                  <!--<evndchart :series="valores1" :options="configuracion1"></evndchart>-->
                    <evndchart :series="chart2.series" :options="chart2.opciones"></evndchart>
                </div>
              </div>
              <!-- CANAL ---------------------------------------------->
              <!-- 3 Ventas por categiria -->
              <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#e6e1db] p-6">
                <p class="text-[#181511] text-base font-medium leading-normal">Ventas por categoria</p>
                <p class="text-[#181511] tracking-light text-[32px] font-bold leading-tight truncate">250</p>
                <!--aqui agregue el select-->
                <div class="flex items-center">
                  @{{filtro_chart3}}
                    <select v-model="filtro_chart3" class="custom-select h-9 cursor-pointer rounded-md border border-[#e6e1db] bg-white px-3 py-1 text-xs font-semibold text-[#897961] focus:border-[#897961] focus:ring-0">
                      <option value="">Todos</option>
                      <option v-for="categoria in categorias" :value="categoria.id">@{{categoria.nombre}}</option>
                    </select>
                  </div>
                <div class="flex gap-1">
                  <p class="text-[#897961] text-base font-normal leading-normal">Capuchino</p>
                  <p class="text-[#078810] text-base font-medium leading-normal">20</p>
                </div>
                <!-- Segunada Grafica -->
                <div>
                  <!--<evndchart :series="valores1" :options="configuracion1"></evndchart>-->
                    <evndchart :series="chart3.series" :options="chart3.opciones"></evndchart>
                    
                </div>
              </div>
              <!-- /3 Ventas por -->
              <!-- 4 Ventas de productos x Genero -->
              <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#e6e1db] p-6">
                <p class="text-[#181511] text-base font-medium leading-normal">Ventas por categoria</p>
                <p class="text-[#181511] tracking-light text-[32px] font-bold leading-tight truncate">250</p>
                <!--aqui agregue el select-->
                <div class="flex items-center">
                  @{{filtro_chart6}}
                    <select v-model="filtro_chart6" class="custom-select h-9 cursor-pointer rounded-md border border-[#e6e1db] bg-white px-3 py-1 text-xs font-semibold text-[#897961] focus:border-[#897961] focus:ring-0">
                      <option value="">Todos</option>
                      <option v-for="genero in generos" :value="genero">@{{genero}}</option>
                    </select>
                  </div>
                <div class="flex gap-1">
                  <p class="text-[#897961] text-base font-normal leading-normal">Capuchino</p>
                  <p class="text-[#078810] text-base font-medium leading-normal">20</p>
                </div>
                <!-- Segunada Grafica -->
                <div>
                  <!--<evndchart :series="valores1" :options="configuracion1"></evndchart>-->
                    <evndchart :series="chart6.series" :options="chart6.opciones"></evndchart>
                    
                </div>
              </div>
              <!-- /4 Ventas por -->
            </div>
            <h2 class="text-[#181511] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Analisis Demografico</h2>
            <div class="flex flex-wrap gap-4 px-4 py-6">
              <!-- Grafica 1 -->
              <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#e6e1db] p-6">
                <p class="text-[#181511] text-base font-medium leading-normal">Usuario x genero</p>
                <select v-model="filtro_chart4.idedad" class="custom-select h-9 cursor-pointer rounded-md border border-[#e6e1db] bg-white px-3 py-1 text-xs font-semibold text-[#897961] focus:border-[#897961] focus:ring-0">
                      <option value="">Todas las Edades</option>
                      <option v-for="edad in edades" :value="edad.id">@{{edad.nombre}}</option>
                </select>
                <select v-model="filtro_chart4.idocupacion" class="custom-select h-9 cursor-pointer rounded-md border border-[#e6e1db] bg-white px-3 py-1 text-xs font-semibold text-[#897961] focus:border-[#897961] focus:ring-0">
                      <option value="">Todas las Ocupaciones</option>
                      <option v-for="ocupacion in ocupaciones" :value="ocupacion.id">@{{ocupacion.nombre}}</option>
                </select>
                <evndchart :series="chart4.series" :options="chart4.opciones"></evndchart>
              </div>
              <!-- Grafica 2 -->
              <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#e6e1db] p-6">
                <p class="text-[#181511] text-base font-medium leading-normal">Usuario x Edades</p>
                <select v-model="filtro_chart5.genero" class="custom-select h-9 cursor-pointer rounded-md border border-[#e6e1db] bg-white px-3 py-1 text-xs font-semibold text-[#897961] focus:border-[#897961] focus:ring-0">
                      <option value="">Todas los Generos</option>
                      <option v-for="genero in generos" :value="genero">@{{genero}}</option>
                </select>
                <select v-model="filtro_chart5.idocupacion" class="custom-select h-9 cursor-pointer rounded-md border border-[#e6e1db] bg-white px-3 py-1 text-xs font-semibold text-[#897961] focus:border-[#897961] focus:ring-0">
                      <option value="">Todas las Ocupaciones</option>
                      <option v-for="ocupacion in ocupaciones" :value="ocupacion.id">@{{ocupacion.nombre}}</option>
                </select>
                <evndchart :series="chart5.series" :options="chart5.opciones"></evndchart>
                Grafica 2
              </div>
            </div>
            <div class="flex flex-wrap gap-4 px-4 py-6">
<div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#e6e1db] p-6 relative">
<div class="flex items-start justify-between">
<div class="flex flex-col gap-2">
<div class="h-5 w-48 animate-pulse rounded bg-[#e6e1db]"></div>
<div class="mt-2 h-10 w-32 animate-pulse rounded bg-[#e6e1db]"></div>
</div>
<div class="flex items-center">
<div class="h-9 w-24 animate-pulse rounded-md bg-[#e6e1db]"></div>
</div>
</div>
<div class="mt-1 flex gap-2">
<div class="h-4 w-20 animate-pulse rounded bg-[#e6e1db]"></div>
<div class="h-4 w-12 animate-pulse rounded bg-[#e6e1db]"></div>
</div>
<div class="flex min-h-[180px] flex-1 flex-col gap-8 py-4">
<div class="relative h-[148px] w-full">
<div class="flex h-full items-end justify-between gap-4 px-2">
<div class="h-[30%] w-full animate-pulse rounded-t bg-[#f4f3f0]"></div>
<div class="h-[60%] w-full animate-pulse rounded-t bg-[#f4f3f0]"></div>
<div class="h-[45%] w-full animate-pulse rounded-t bg-[#f4f3f0]"></div>
<div class="h-[80%] w-full animate-pulse rounded-t bg-[#f4f3f0]"></div>
<div class="h-[55%] w-full animate-pulse rounded-t bg-[#f4f3f0]"></div>
<div class="h-[70%] w-full animate-pulse rounded-t bg-[#f4f3f0]"></div>
<div class="h-[40%] w-full animate-pulse rounded-t bg-[#f4f3f0]"></div>
</div>
</div>
<div class="flex justify-around">
<div class="h-3 w-8 animate-pulse rounded bg-[#e6e1db]"></div>
<div class="h-3 w-8 animate-pulse rounded bg-[#e6e1db]"></div>
<div class="h-3 w-8 animate-pulse rounded bg-[#e6e1db]"></div>
<div class="h-3 w-8 animate-pulse rounded bg-[#e6e1db]"></div>
<div class="h-3 w-8 animate-pulse rounded bg-[#e6e1db]"></div>
<div class="h-3 w-8 animate-pulse rounded bg-[#e6e1db]"></div>
<div class="h-3 w-8 animate-pulse rounded bg-[#e6e1db]"></div>
</div>
</div>
</div>
<div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#e6e1db] p-6 relative bg-white/50">
<div class="flex items-start justify-between">
<div class="flex flex-col gap-2">
<p class="text-[#181511] text-base font-medium leading-normal">Customer Traffic Projection</p>
<div class="mt-2 h-10 w-24 animate-pulse rounded bg-[#e6e1db]"></div>
</div>
<div class="flex items-center">
<select class="custom-select h-9 cursor-not-allowed rounded-md border border-[#e6e1db] bg-white px-3 py-1 text-xs font-semibold text-[#897961]/50 focus:outline-none">
<option>Loading...</option>
</select>
</div>
</div>
<div class="flex gap-1">
<div class="h-4 w-28 animate-pulse rounded bg-[#e6e1db]"></div>
</div>
<div class="flex min-h-[180px] flex-1 items-center justify-center py-4">
<div class="flex h-[148px] w-full flex-col justify-center gap-4">
<div class="h-2 w-full animate-pulse rounded bg-[#f4f3f0]"></div>
<div class="h-2 w-3/4 animate-pulse rounded bg-[#f4f3f0]"></div>
<div class="h-2 w-5/6 animate-pulse rounded bg-[#f4f3f0]"></div>
<div class="h-2 w-1/2 animate-pulse rounded bg-[#f4f3f0]"></div>
<div class="h-2 w-2/3 animate-pulse rounded bg-[#f4f3f0]"></div>
</div>
</div>
</div>
</div>
            
            
            
          </div>
        </div>
      </div>
    </div>
    <script src="{{ asset('apexcharts.js') }}"></script>
    <script src="{{ asset('vue.js') }}"></script>
    <script src="{{ asset('vue-apexcharts.js') }}"></script>
    <!--  este script nosotros mismo lo creamos, da referencias a la grafica de columnas -->
    <script src="{{ asset('Columna.js') }}"></script>
    <script src="{{ asset('Pie.js') }}"></script>
    <script>
      Vue.use(VueApexCharts);
      var app = new Vue({
        el: '#app'
        ,data:function(){
          return{
            total_ventas:0
            // es un arreglo
            /*valores_chart1:{
              productos:[],
              tendencias:[]
            }*/
            , valores_chart1:[]
            ,valores_chart2:{
              canales:[]
              ,tendencias:[]
            }
            ,valores_chart3:{
              categorias:[]
              ,tendencias:[]
            }
            ,valores_chart6:{
              genero:[]
              ,tendencias:[]
            }
            ,valores_chart4:[]
            ,valores_chart5:[] //Demograficos
            ,canales:<?php echo json_encode($canales)?>
            ,productos:<?php echo json_encode($productos)?>
            ,categorias:<?php echo json_encode($categorias)?>
            ,ocupaciones:<?php echo json_encode($ocupaciones)?>
            ,edades:<?php echo json_encode($edades)?>
            ,generos:<?php echo json_encode($generos)?>
            ,filtro_chart1: ''
            ,filtro_chart2: ''
            ,filtro_chart3: ''
            ,filtro_chart6: ''
            ,filtro_chart4:{
              idocupacion:0
              ,idedad:0
            }
            ,filtro_chart5:{
              idocupacion:0
              ,genero:0
            }
          }
        }
        ,components:{
          //evnd(evndchart) es un nombre, puedes poner la que tu quieras
          evndchart: VueApexCharts, //VueApexCharts nombre de la libreria
          }
          ,watch:{
            filtro_chart1:{
              handler:function(newValue){
                var xhr1 = new XMLHttpRequest();
            var self = this;
              xhr1.open('POST', '{{ url("/dashboard/ventas") }}', true);
              xhr1.onreadystatechange = function(){
                if(this.readyState == 4){
                  if(this.status == 200){
                    info = JSON.parse(this.responseText);
                    //self.valores_chart1 = info;
                    self.valores_chart1.splice(0,self.valores_chart1.length);
                    
                    for(i=0;i<info.tendencias.length;i++){
                      self.valores_chart1.push({
                      name: info.tendencias[i].fecha,
                      data: [info.tendencias[i].total]
                    });
                    }
                    //console.log('Aqui esta la info',info)
                    }
                  }
                }
              
              //xhr1.send();
              xhr1.setRequestHeader('Content-type','application/json');
                      xhr1.send(JSON.stringify({
                        idhabitacion:newValue
                        //,idocupacion:newValue.idocupacion
                        ,_token:'{{csrf_token()}}'
                      }));
              }
            },
            filtro_chart4:{
              handler:function(newValue){
                //Peticion Asincronan
                  var xhr4 = new XMLHttpRequest();
                  var self=this;
                    xhr4.open('POST', '{{ url("/dashboard/demograficos/genero") }}', true);
                    //
                    xhr4.onreadystatechange = function() {
                      //Valida si la peticion ya se termino 
                        if (this.readyState == 4){
                        //Valida si el backend funciono correctamente
                        self.procesar_orden=false;
                        if(this.status ==200){
                          self.valores_chart4.splice(0,self.valores_chart4.length);
                          info3=JSON.parse(this.responseText);
                          for(i=0;i<info3.length;i++){
                            self.valores_chart4.push(info3[i])
                          }
                            //console.log('Datos para el chart2',info2);
                          //self.valores_chart3=info3;
                          
                          }
                        }
                      }
                      //xhr4.send();
                      xhr4.setRequestHeader('Content-type','application/json');
                      xhr4.send(JSON.stringify({
                        idedad:newValue.idedad
                        ,idocupacion:newValue.idocupacion
                        ,_token:'{{csrf_token()}}'
                      }));
              }
              ,deep:true
            }
            ,filtro_chart5:{
              handler:function(newValue){
                //Peticion Asincronan
                  var xhr5 = new XMLHttpRequest();
                  var self=this;
                    xhr5.open('POST', '{{ url("dashboard/demograficos/edad") }}', true);
                    //
                    xhr5.onreadystatechange = function() {
                      //Valida si la peticion ya se termino 
                        if (this.readyState == 4){
                        //Valida si el backend funciono correctamente
                        self.procesar_orden=false;
                        if(this.status ==200){
                          self.valores_chart5.splice(0,self.valores_chart5.length);
                          info3=JSON.parse(this.responseText);
                          for(i=0;i<info3.length;i++){
                            self.valores_chart5.push(info3[i])
                          }
                            //console.log('Datos para el chart2',info2);
                          //self.valores_chart3=info3;
                          
                          }
                        }
                      }
                      //xhr4.send();
                      xhr5.setRequestHeader('Content-type','application/json');
                      xhr5.send(JSON.stringify({
                        genero:newValue.genero
                        ,idocupacion:newValue.idocupacion
                        ,_token:'{{csrf_token()}}'
                      }));
              }
              ,deep:true
            }
            
            ,filtro_chart6:{
              handler:function(newValue){
                var xhr6 = new XMLHttpRequest();
                var self = this;
            
                xhr6.open('POST', '{{ url("/dashboard/ventas/productoxgenero") }}', true);
            
                xhr6.onreadystatechange = function(){
                  if(this.readyState == 4){
                    if(this.status == 200){
                      info3 = JSON.parse(this.responseText);
                      self.valores_chart6 = info3;
                    }
                  }
                }
            
                xhr6.setRequestHeader('Content-type','application/json');
                xhr6.send(JSON.stringify({
                  genero: newValue,
                  _token:'{{csrf_token()}}'
                }));
              }
            }
          }
          ,computed: {
            /*chart1:function(){
              final={
                series:this.valores
                ,opciones:Columna() // Columna() da referencia a Columna.js
              }
              
              //xaxis sale de la libreria que creamos en Columnas.js como lo modi
              //xaxis: {
                //categories: [],
              //},
              
              //final.opciones.xaxis.categories.push('Ventas');
              //return final;
            }*/
            //////////////////////////////////
            chart1:function(){
              final={
                series:this.valores_chart1
                ,opciones:Columna() // Columna() da referencia a Columna.js
              }
              /*
              xaxis sale de la libreria que creamos en Columnas.js como lo modi
              xaxis: {
                categories: [],
              },
               */
              final.opciones.xaxis.categories.push('Ventas');
              return final;
            }
            /////////////////////////////////
            ,chart2:function(){
              //valores_chart2
              final={
                series:[]
                ,opciones:Columna()
              }
              if(this.filtro_chart2==''){
                //La informacion la voy a tomar de los canales
                /*
                name: info.tendencias[i].fecha,
                data: [info.tendencias[i].total]
                 */
                for(i=0;i<this.valores_chart2.canales.length;i++){
                  final.series.push({
                    name:this.valores_chart2.canales[i].canal
                    ,data:[this.valores_chart2.canales[i].total]
                  })
                }
                final.opciones.xaxis.categories.push('Ventas');
              }
              else{
                //La informacion la voy a tomar de las tendencias
                //1. filtro mis tendencias
                self2=this;
                let fg=this.valores_chart2.tendencias.filter(function(item){
                  return item.canal==self2.filtro_chart2
                });
                for(i=0;i<fg.length;i++){
                  final.series.push({
                    name:fg[i].fecha
                    ,data:[fg[i].total]
                  });
                }
                final.opciones.xaxis.categories.push('Ventas');
              }
              return final;
            }
            ,chart3:function(){
              //valores_chart3
              final={
                series:[]
                ,opciones:Columna()
              }
              if(this.filtro_chart3==''){
                //categorias
                for(i=0;i<this.valores_chart3.categorias.length;i++){
                  final.series.push({
                    name:this.valores_chart3.categorias[i].nombre
                    ,data:[this.valores_chart3.categorias[i].total]
                  })
                }
                final.opciones.xaxis.categories.push('Ventas');
              }
              else{
                //La informacion la voy a tomar de las tendencias
                //1. filtro mis tendencias
                self2=this;
                let fg=this.valores_chart3.tendencias.filter(function(item){
                  return item.id==self2.filtro_chart3
                });
                for(i=0;i<fg.length;i++){
                  final.series.push({
                    name:fg[i].fecha
                    ,data:[fg[i].total]
                  });
                }
                final.opciones.xaxis.categories.push('Ventas');
              }
              return final;
            }
            ,chart4:function(){
              //valores_chart3
              final={
                series:[]
                ,opciones:Pie()
              }
              for(i=0;i<this.valores_chart4.length;i++){
                final.series.push(this.valores_chart4[i].total)
                final.opciones.labels.push(this.valores_chart4[i].genero)
              }
              return final;
            }
            ,chart5:function(){
              //valores_chart3
              final={
                series:[]
                ,opciones:Pie()
              }
              for(i=0;i<this.valores_chart5.length;i++){
                final.series.push(this.valores_chart5[i].total)
                final.opciones.labels.push(this.valores_chart5[i].nombre)
              }
              return final;
            }
            ,chart6:function(){

              final={
                series:[],
                opciones:Columna()
              }
              console.log('Aqui estan los valores ',this.valores_chart6)
              for(i=0;i<this.valores_chart6.length;i++){
                  final.series.push({
                    name:this.valores_chart6[i].nombre,
                    data:[this.valores_chart6[i].total]
                  })
                  
                }
                final.opciones.xaxis.categories.push('Ventas');
              return final
            }
          }
          
          ,created(){
            // ASINCRONAN 
            var xhr1 = new XMLHttpRequest();
            var self = this;
              xhr1.open('GET', '{{ url("/dashboard/ventas") }}', true);
              xhr1.onreadystatechange = function(){
                if(this.readyState == 4){
                  if(this.status == 200){
                    info = JSON.parse(this.responseText);
                    self.valores_chart1.splice(0,self.valores_chart1.length);
                    //self.valores_chart1 = info;
                    
                    for(i=0;i<info.tendencias.length;i++){
                      self.valores_chart1.push({
                      name: info.tendencias[i].fecha,
                      data: [info.tendencias[i].total]
                    });
                    }
                    //console.log('Aqui esta la info',info)
                    }
                  }
                }
              
              xhr1.send();
              //
              // ASINCRONAN de canales
            var xhr2 = new XMLHttpRequest();
            var self=this;
              xhr2.open('GET', '{{ url("/dashboard/ventas/canal") }}', true);
              //
              xhr2.onreadystatechange = function() {
                //Valida si la peticion ya se termino 
                  if (this.readyState == 4){
                  //Valida si el backend funciono correctamente
                  self.procesar_orden=false;
                  if(this.status ==200){
                    info2=JSON.parse(this.responseText);
                      console.log('Datos para el chart2',info2);
                    self.valores_chart2=info2;
                    
                    }
                  }
                }
                xhr2.send();
                //
                //------------------------------------ ASINCRONAN de categoria (3)
            var xhr3 = new XMLHttpRequest();
            var self=this;
              xhr3.open('GET', '{{ url("/dashboard/ventas/categoria") }}', true);
              //
              xhr3.onreadystatechange = function() {
                //Valida si la peticion ya se termino 
                  if (this.readyState == 4){
                  //Valida si el backend funciono correctamente
                  self.procesar_orden=false;
                  if(this.status ==200){
                    info3=JSON.parse(this.responseText);
                      //console.log('Datos para el chart2',info2);
                    self.valores_chart3=info3;
                    
                    }
                  }
                }
                xhr3.send();
                //---------------------------------------------------------------------
                //------------------------------------ ASINCRONAN de Genero (4)
            var xhr4 = new XMLHttpRequest();
            var self=this;
              xhr4.open('GET', '{{ url("/dashboard/demograficos/genero") }}', true);
              //
              xhr4.onreadystatechange = function() {
                //Valida si la peticion ya se termino 
                  if (this.readyState == 4){
                  //Valida si el backend funciono correctamente
                  self.procesar_orden=false;
                  if(this.status ==200){
                    info3=JSON.parse(this.responseText);
                    for(i=0;i<info3.length;i++){
                      self.valores_chart4.push(info3[i])
                    }
                      //console.log('Datos para el chart2',info2);
                    //self.valores_chart3=info3;
                    
                    }
                  }
                }
                xhr4.send();
                //---------------------------------------------------------------------
                //------------------------------------ ASINCRONAN de Edad (5)
            var xhr5 = new XMLHttpRequest();
            var self=this;
              xhr5.open('GET', '{{ url("/dashboard/demograficos/edad") }}', true);
              //
              xhr5.onreadystatechange = function() {
                //Valida si la peticion ya se termino 
                  if (this.readyState == 4){
                  //Valida si el backend funciono correctamente
                  self.procesar_orden=false;
                  if(this.status ==200){
                    info3=JSON.parse(this.responseText);
                    for(i=0;i<info3.length;i++){
                      self.valores_chart5.push(info3[i])
                    }
                      //console.log('Datos para el chart2',info2);
                    //self.valores_chart3=info3;
                    
                    }
                  }
                }
                xhr5.send();
                //---------------------------------------------------------------------categoria (3)
                
            var xhr6 = new XMLHttpRequest();
            var self=this;
              xhr6.open('GET', '{{ url("/dashboard/ventas/productoxgenero") }}', true);
              //
              xhr6.onreadystatechange = function() {
                //Valida si la peticion ya se termino 
                  if (this.readyState == 4){
                  //Valida si el backend funciono correctamente
                  self.procesar_orden=false;
                  if(this.status ==200){
                    info3=JSON.parse(this.responseText);
                      //console.log('Datos para el chart2',info2);
                    self.valores_chart6=info3;
                    
                    }
                  }
                }
                xhr6.send();
          }
        }
      )
    </script>
  </body>
</html>
