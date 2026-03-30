@extends('app.punto')
 @section('contenidoCoffeeShop')
        <!-- Seccion de la gestion de la orden -->
        <div  class="gap-1 px-6 flex flex-1 justify-center py-5 ">
          <div class="layout-content-container flex flex-col max-w-[920px] flex-1">
            <div v-if="!extras" class="flex flex-wrap justify-between gap-3 p-4"><p class="text-[#181511] tracking-light text-[32px] font-bold leading-tight min-w-72">New Order</p></div>
            <!-- lista de los tipos de productos -->
            <div v-if="!extras" class="pb-3">
  
              <div class="flex border-b border-[#e6e1db] px-4 gap-8">
                <a v-for="tipo in tipos_productos"
                @click.prevent="categoria_seleccionada=tipo.id"
                 class="flex flex-col items-center justify-center  text-[#181511] pb-[13px] pt-4" 
                 :class="{'border-b-[#181511]':tipo.id==categoria_seleccionada,'border-b-[3px]':tipo.id==categoria_seleccionada}"
                 href="#">
                  <p class="text-[#181511] text-sm font-bold leading-normal tracking-[0.015em]">@{{tipo.nombre}}</p>
                </a>  
              </div>
            </div>
            <h3 v-if="!extras" class="text-[#181511] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">@{{nom_tipo}}</h3>
            <div v-if="!extras" v-for="producto in productos_seleccionados" class="p-4">
              <div class="flex items-stretch justify-between gap-4 rounded-lg">
                <div class="flex flex-[2_2_0px] flex-col gap-4">
                  <div class="flex flex-col gap-1">
                    <p class="text-[#897961] text-sm font-normal leading-normal">@{{producto.tipo}}</p>
                    <p class="text-[#181511] text-base font-bold leading-tight">@{{producto.nombre}} - $@{{producto.precio}}</p>
                    <p class="text-[#897961] text-sm font-normal leading-normal">@{{producto.descripcion}}</p>
                  </div>
                  <button @click="agregar_orden(producto)"
                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-8 px-4 flex-row-reverse bg-[#f4f3f0] text-[#181511] text-sm font-medium leading-normal w-fit"
                  >
                    <span class="truncate">Agregar a la orden</span>
                  </button>
                </div>
                <div
                  class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-lg flex-1"
                  :style="dame_foto(producto.foto)"
                ></div>
              </div>
            </div>
          </div>
          <div v-if="!extras" class="layout-content-container flex flex-col w-[360px]">
            <h2 class="text-[#181511] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Order Summary</h2>
            
            <div v-for="(producto,indice) in orden"
             class="flex items-center gap-4 bg-white px-4 min-h-[72px] py-2 justify-between">
              <div class="flex flex-col justify-start">
                <p class="text-[#181511] text-base font-medium leading-normal line-clamp-1">@{{producto.nombre}}</p>
                <p class="text-[#897961] text-sm font-normal leading-normal line-clamp-2">@{{producto.descripcion}}</p>
              </div>
              <div class="shrink-0"><p class="text-[#181511] text-base font-normal leading-normal">$@{{producto.precio}}</p></div>
              <button @click="eliminar_orden(indice)" class="flex items-center justify-center w-9 h-9 rounded-md bg-white border border-[#e6e1db] hover:bg-[#fff7f0]" aria-label="Eliminar item">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 256 256"><path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path></svg>
              </button>
    
              <div class="flex flex-col gap-2 mt-2">
                  <label class="text-xs text-[#897961]">
                    Check-in
                    <input 
                      type="date"
                      v-model="producto.check_in"
                      @change="validar_fechas(producto)"

                      class="form-input w-full h-9 mt-1 rounded-md border border-[#e6e1db]"
                    />
                  </label>

                  <label class="text-xs text-[#897961]">
                    Check-out
                    <input 
                      type="date"
                      v-model="producto.check_out"
                     @change="validar_fechas(producto)"

                      class="form-input w-full h-9 mt-1 rounded-md border border-[#e6e1db]"
                    />
                  </label>
            </div>



              <div class="flex flex-col  items-start gap-2">
                <p class="text-sm text-[#897961] min-w-[72px]">Extras</p>
              <button @click="lanzar_extra(indice)" class="flex items-center gap-2 px-3 h-9 rounded-md bg-[#f4f3f0] hover:bg-[#e6e1db]" aria-label="Configurar adicionales">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 -960 960 960" fill="#5f6368"><path d="M427-120v-225h60v83h353v60H487v82h-60Zm-307-82v-60h247v60H120Zm187-166v-82H120v-60h187v-84h60v226h-60Zm120-82v-60h413v60H427Zm166-165v-225h60v82h187v60H653v83h-60Zm-473-83v-60h413v60H120Z"></path></svg>
              </button>
              </div>
            </div>
            <div class="@container">
            </div>
            <div class="px-4">
              <hr class="border-t border-[#e6e1db] my-2" />
            </div>
            <h2 class="text-[#181511] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Loyalty Program</h2>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <input
                  placeholder="Search Customer"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#181511] focus:outline-0 focus:ring-0 border border-[#e6e1db] bg-white focus:border-[#e6e1db] h-14 placeholder:text-[#897961] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex px-4 py-3">
              <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 flex-1 bg-[#f4f3f0] text-[#181511] text-sm font-bold leading-normal tracking-[0.015em] gap-2"
              >
                <svg  class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#5f6368"><path d="m523.5-263 139.54-140Q674-414 679-427.4q5-13.41 5-28.6 0-31.93-22.54-54.46Q638.93-533 607-533q-20.36 0-40.18 13T523-478q-24-29-43.29-42T440-533q-31.93 0-54.46 22.54Q363-487.93 363-456q0 15.19 5 28.6 5 13.4 15.96 24.4L523.5-263ZM863-404 557-97q-9 8.5-20.25 12.75T514.25-80Q503-80 492-84.5T472-97L98-472q-8-8-13-18.96-5-10.95-5-23.04v-306q0-24.75 17.63-42.38Q115.25-880 140-880h307q12.07 0 23.39 4.87Q481.7-870.25 490-862l373 373q9.39 9 13.7 20.25 4.3 11.25 4.3 22.5t-4.5 22.75Q872-412 863-404ZM516-138l306-307-375-375H140v304l376 378ZM245-664q21 0 36.5-15.5T297-716q0-21-15.5-36.5T245-768q-21 0-36.5 15.5T193-716q0 21 15.5 36.5T245-664Zm236 185Z"/></svg>
                <span class="truncate">Apply Loyalty Points</span>
              </button>
            </div>
            <div class="flex px-4 py-3">
              <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 flex-1 bg-[#f4f3f0] text-[#181511] text-sm font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate">Enroll New Customer</span>
              </button>
            </div>
            <h2 class="text-[#181511] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Total</h2>
            <div class="flex items-center gap-4 bg-white px-4 min-h-14 justify-between">
              <p class="text-[#181511] text-base font-normal leading-normal flex-1 truncate">Subtotal</p>
              <div class="shrink-0"><p class="text-[#181511] text-base font-normal leading-normal">$@{{order_summary.subtotal}}</p></div>
            </div>
            <div class="flex items-center gap-4 bg-white px-4 min-h-14 justify-between">
              <p class="text-[#181511] text-base font-normal leading-normal flex-1 truncate">Tax (6%)</p>
              <div class="shrink-0"><p class="text-[#181511] text-base font-normal leading-normal">$@{{order_summary.impuesto}}</p></div>
            </div>
            <div class="flex items-center gap-4 bg-white px-4 min-h-14 justify-between">
              <p class="text-[#181511] text-base font-normal leading-normal flex-1 truncate">Total</p>
              <div class="shrink-0"><p class="text-[#181511] text-base font-normal leading-normal">$@{{order_summary.total}}</p></div>
            </div>
            <h2 class="text-[#181511] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Payment Method</h2>
            <div class="flex flex-wrap gap-3 p-4">
              <label
                class="text-sm font-medium leading-normal flex items-center justify-center rounded-lg border border-[#e6e1db] px-4 h-11 text-[#181511] has-[:checked]:border-[3px] has-[:checked]:px-3.5 has-[:checked]:border-[#ec9213] relative cursor-pointer"
              >
                Cash
                <input type="radio" class="invisible absolute" name="2c3d8e51-4e73-4539-bd2d-1d3678c37bc8" />
              </label>
              <label
                class="text-sm font-medium leading-normal flex items-center justify-center rounded-lg border border-[#e6e1db] px-4 h-11 text-[#181511] has-[:checked]:border-[3px] has-[:checked]:px-3.5 has-[:checked]:border-[#ec9213] relative cursor-pointer"
              >
                Card
                <input type="radio" class="invisible absolute" name="2c3d8e51-4e73-4539-bd2d-1d3678c37bc8" />
              </label>
              <label
                class="text-sm font-medium leading-normal flex items-center justify-center rounded-lg border border-[#e6e1db] px-4 h-11 text-[#181511] has-[:checked]:border-[3px] has-[:checked]:px-3.5 has-[:checked]:border-[#ec9213] relative cursor-pointer"
              >
                Mobile Pay
                <input type="radio" class="invisible absolute" name="2c3d8e51-4e73-4539-bd2d-1d3678c37bc8" />
              </label>
            </div>
            <div class="flex px-4 py-3">
              <button 
                @click="enviar"
                :disabled="procesar_orden"
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 flex-1 bg-[#ec9213] text-[#181511] text-sm font-bold leading-normal tracking-[0.015em]"
              >
              <svg v-if="procesar_orden" class="w-10 h-10" fill="hsl(228, 97%, 42%)" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><circle cx="12" cy="2.5" r="1.5" opacity=".14"/><circle cx="16.75" cy="3.77" r="1.5" opacity=".29"/><circle cx="20.23" cy="7.25" r="1.5" opacity=".43"/><circle cx="21.50" cy="12.00" r="1.5" opacity=".57"/><circle cx="20.23" cy="16.75" r="1.5" opacity=".71"/><circle cx="16.75" cy="20.23" r="1.5" opacity=".86"/><circle cx="12" cy="21.5" r="1.5"/><animateTransform attributeName="transform" type="rotate" calcMode="discrete" dur="0.75s" values="0 12 12;30 12 12;60 12 12;90 12 12;120 12 12;150 12 12;180 12 12;210 12 12;240 12 12;270 12 12;300 12 12;330 12 12;360 12 12" repeatCount="indefinite"/></g></svg>
                <span v-else class="truncate">Complete Order</span>
              </button>

                          <!-- Eliminar reservaciones -->
              <button 
                @click="limpiar_orden"
                class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 flex-1 bg-red-500 text-white text-sm font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate">Eliminar reservaciones</span>
              </button>

            </div>
          </div>
        </div>
        <!-- Seccion de la gestion de la orden -->  

         
      </div>

       <!-- configuracion de los extras del producto --> 
        
       <div v-if="extras" class="px-40 flex flex-1 justify-center py-5">
        @{{producto_seleccionado}}
          <div class="layout-content-container flex flex-col w-[512px] max-w-[512px] py-5 max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4">
              <p class="text-[#181511] tracking-light text-[32px] font-bold leading-tight min-w-72">Servicios</p>
            </div>
            <div v-for="te in categoria_extras">
            <h3 class="text-[#181511] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">@{{te.nombre}}</h3>
              <div class="flex flex-wrap gap-3 p-4">
                <label @click="agregar_extra(extr)" v-for="extr in dame_extras(te.id)" class="text-sm font-medium leading-normal flex items-center justify-center rounded-lg border border-[#e6e1db] px-4 h-11 text-[#181511] has-[:checked]:border-[3px] has-[:checked]:px-3.5 has-[:checked]:border-[#ec9213] relative cursor-pointer">
                  @{{extr.nombre}} (+$@{{extr.precio}})
                  <input type="radio" class="invisible absolute" name="44eb06a9-8655-41c3-b4b8-00ae39927731">
                </label>
              </div>
            </div>
            
            <p class="text-[#897961] text-sm font-normal leading-normal pb-3 pt-1 px-4">Total Customization Cost: $1.30</p>

            <div class="flex px-4 py-3 justify-end">
              <div class="flex flex-wrap gap-3 p-4">
              <button @click="extras=false"class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#ec9213] text-[#181511] text-sm font-bold leading-normal tracking-[0.015em]">
                <span class="truncate">Cancelar</span>
              </button>

              <button class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#ec9213] text-[#181511] text-sm font-bold leading-normal tracking-[0.015em]">
                <span class="truncate">Confirm Customization</span>
              </button>
            </div>
            </div>

          </div>
        </div>

       <!-- configuracion de los extras del producto -->
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script>
        var app = new Vue({
            el: '#app'
            ,data:function(){
                return {  //Variables de estado
                    productos:[ ]
                    ,orden:[]
                    ,usuario:{
                      nombre:'Manager'
                      ,id:0
                      ,email:'manager@coffeesop.com.mx'
                      ,telefono:''
                      ,foto:''
                    }
                    ,extra:<?php echo json_encode($extras);?>
                    ,categoria_extras:<?php echo json_encode($categoria_extras);?>
                    ,tamanios:[]
                    ,tipos_productos:<?php echo json_encode($tipos);?>
                    ,metodos_pago:[]
                    ,categoria_seleccionada:1
                    ,impuesto:.16
                    ,extras:false
                    ,producto_seleccionado:-1
                    ,procesar_orden:false
                };
            }
            ,methods:{
              dame_foto:function(){
                    let foto = '/imagenes/habitacion.jpg'; // ruta pública desde /public
                    return `
                      background-image: url('${foto}');
                      background-size: cover;
                      background-position: center;
                      background-repeat: no-repeat;
                    `;
                  }
                  ,limpiar_orden:function(){
                  if(this.orden.length === 0){
                    alert('No hay reservaciones que eliminar');
                    return;
                  }

                  if(confirm('¿Seguro que deseas eliminar todas las reservaciones?')){
                    this.orden = [];
                    this.extras = false;
                    this.producto_seleccionado = -1;
                  }
                }
                // producto es la referencia de habitacion
                //Recibe el producto (habitación) que estás editando.
                ,validar_fechas:function(producto){
                  // Primero valida que ambas fechas existan
                if(!producto.check_in || !producto.check_out){
                  return;
                }
                // Activa estado de validación
                producto.validando = true;

                // Hace una petición al backend
                fetch('/api/validar-disponibilidad', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document
                      .querySelector('meta[name="csrf-token"]')
                      .getAttribute('content')
                  },
                  //Envía un POST con:
                  body: JSON.stringify({
                    habitacion_id: producto.id, //id de habitación
                    check_in: producto.check_in, //fecha entrada
                    check_out: producto.check_out //fecha salida
                  })
                })
                .then(res => res.json())
                // Regresa al frontend
                .then(data => {
                  producto.validando = false;
                  // Si el backend responde:
                  if(!data.disponible){
                    alert(' La habitación NO está disponible en esas fechas'); //Si no está disponible → muestra alerta
                    producto.check_out = ''; //Borra la fecha de salida
                  }
                })
                .catch(() => {
                  producto.validando = false;
                  alert(' Error al validar disponibilidad');
                });
              }

              // Modificado

              ,agregar_orden:function(item){
                //this.orden.push(item);
                this.orden.push({
                  id:item.id
                  ,nombre:item.nombre
                  ,precio:item.precio
                  ,descripcion:item.descripcion
                  ,check_in: ''
                  ,check_out: ''
                  ,validando:false
                  ,extras:[]
                });
              }
              ,eliminar_orden:function(indice){
                this.orden.splice(indice,1);
              }
              ,enviar:function(){
                    console.log('Vamos a enviar');
                    var self = this;
                    this.procesar_orden=true;
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '/api/guardar_orden', true);
                    xhr.setRequestHeader("Content-Type", "application/json");
                    //////////////////////////////////////////////////////////////
                    
                    xhr.onreadystatechange = function() {
                      //Valida si la peticion ya se termino 
                        if (this.readyState == 4){
                        //Valida si el backend funciono correctamente
                        self.procesar_orden=false;
                        if(this.status ==200){
                          alert('Se guardo la reservacion');
                          self.limpiar_orden();
                            /*info=JSON.parse(this.responseText);
                            for(j=0;j<info.length;j++){
                            self.productos.push(info[j]);
                            }
                            
                            //self.zombies=info;
                            //console.log(this.responseText);*/
                          
                        }
                        else{
                            alert('Algo salio mal, contactar administrador y esperar su respuesta')
                        }
                        }
                    }
                   //////////////////////////////////////////////////////////////////////
                    xhr.setRequestHeader('Content-type','application/json');
                    xhr.send(JSON.stringify(this.orden)); 
              }

              ,dame_extras:function(idcategoria_servicios){
                return this.extra.filter(function(item){
                  return item.idcategoria_servicios==idcategoria_servicios;
                })
              }

              ,lanzar_extra:function(indice){
                  this.extras=true;
                  this.producto_seleccionado=indice;
              }
              ,agregar_extra:function(ext){
                this.orden[this.producto_seleccionado].extras.push(ext);
              }
              ,limpiar_orden:function(){
                this.orden.splice(0,this.orden.length);
              }
            }
            ,computed:{
              total:function(){
                return 0;
              }
              ,productos_seleccionados:function(){
                var self=this;
                return this.productos.filter(function(item){
                  return item.tipo==self.categoria_seleccionada;
                });
              }
              ,nom_tipo:function(){
                var self=this;
                let fg=this.tipos_productos.findIndex(function(item){
                  return item.id==self.categoria_seleccionada
                });
                if(fg==-1)
                return '';
                else{
                  return this.tipos_productos[fg].nombre;
                }
              }
              ,order_summary:function(){
                let tt={
                  subtotal:0
                  ,impuestos:0
                  ,total:0
                }

                tt.subtotal=this.orden.reduce(function(t1,item){
                  t1=t1+parseFloat(item.precio);
                  return t1;
                },0);

                tt.impuesto=tt.subtotal*parseFloat(this.impuesto);
                tt.total=tt.subtotal+tt.impuesto;

                return tt;
              }
              
            }
            ,created(){
              var self=this;
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', "{{ route('productos') }}", true);
                    xhr.onreadystatechange = function() {
                      //Valida si la peticion ya se termino 
                        if (this.readyState == 4){
                        //Valida si el backend funciono correctamente
                        if(this.status ==200){
                            info=JSON.parse(this.responseText);
                            for(j=0;j<info.length;j++){
                             self.productos.push(info[j]);
                            }
                            
                           // self.zombies=info;
                           // console.log(this.responseText);
                           
                        }
                        else{
                            alert('Algo salio mal, contactar administrador y esperar su respuesta')
                        }
                        }
                    }
                    xhr.send(); 

                    
                    }
           });
        </script>
  
 @endsection