@extends('layout.menu')
@section('sidebar')
  @parent
  <div class="container">
    <div class="row">
      <div class="col-lg-11 col-md-11 ">
        </br></br>

        <form id="busqueda" class="form-inline">
        <div class="form-group">
          <table>
            <tr>
              <td class="col-lg-7 col-md-7 ">
                <label for="codigo">Codigo:</label>
                <input type="text" class="form-control" id="codigo" placeholder="Por ejemplo A-001">
                <button id="buscar" class="btn btn-default">Buscar</button>
              </td>
              <td class="col-lg-5 col-md-5 ">
                <label for="producto">Producto:</label>
                <select id="producto" name="producto" class="form-control">
                  @foreach($data as $rol)
                    <option value="{{$rol->id}}">{{$rol->nombre}}</option>
                  @endforeach
                </select>
              </td>
            </tr>
          </table>
        </div>
      </br></br>
        <div id="respuesta" class="col-lg-11 col-md-11 ">
        </div>
        </br></br>
      </form id="form2">
      </br></br>
      <div id="respuesta2" class="col-lg-11 col-md-11 ">
        <form class="form-group" action="index.html" method="post">

          <label for="stock">Existencia Actual</label>
          <input type="number" class="form-control" id="stock" disabled>

          <label for="und">Und Registrada</label>
          <input type="text" class="form-control" id="und" disabled>

          <label for="cantidad">Cantidad que Ingresa</label>
          <input type="number" class="form-control" id="cantidad">

          <label for="fecha">Cantidad que Ingresa</label>
          <input type="date" class="form-control" id="fecha">

          <input type="hidden" id="codigo2">
        </br>
          <button type="button" class="btn btn-success" id="guardar">Guardar</button>
        </form>
      </div>
        </br></br>
      </div>
    </div>
  </div>
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection
@section('scripts')
    <script>

      $('#producto').click(function(e){
        e.preventDefault();
        producto_id = $('#producto').val();
        token = $('meta[name="_token"]').attr('content');

        $.ajax({
          type:"GET",
          headers:{'X-CSRF-TOKEN':token},
          url:'select/'+producto_id,
          success:function(json){
            $('#codigo').empty();
            $('#codigo').attr("value",json[0]['codigo'])
            $('#stock').attr("placeholder",json[0]['stock']);
            $('#und').attr("placeholder",json[0]['und']);
            $('#codigo2').attr("value",json[0]['codigo'])
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status+"  "+thrownError);
          }
        });
      });

      $('#guardar').click(function(){
        codigo = $('#codigo2').val();
        cantidad = $('#cantidad').val();
        fecha = $('#fecha').val();

        $.ajax({
          type:'POST',
          url:'entrada',
          headers:{'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
          dataType:'json',
          data:{codigo:codigo,
                cantidad:cantidad,
                fecha:fecha
                },
          success:function(json){

            if(json[0]['codigo']=='Se requiere un codigo'){
              $('#respuesta').empty();
              $('#respuesta').append("<p class='bg-warning text-center'></br><strong>"+json[0]['codigo']+"</strong></br></br></p>");
            }else if(json[0]['cantidad']=='Se requiere una cantidad') {
              $('#respuesta').empty();
              $('#respuesta').append("<p class='bg-warning text-center'></br><strong>"+json[0]['cantidad']+"</strong></br></br></p>");
            }else{
              $('#respuesta').empty();
              $('#respuesta').append("<p class='bg-success text-center'></br><strong>Datos Registrados</strong></br></br></p>");
              $('#respuesta').fadeOut();
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status+"  "+thrownError+" "+codigo+" "+cantidad);
          }
        });
      });

      $('#buscar').click(function(e){
        e.preventDefault();
        route = "buscar";
        codigo = $("#codigo").val();

        $.ajax({
          type:"POST",
          url:route,
          headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
          dataType:'json',
          data:{codigo:codigo},
          success:function(json){
            if(json[0]=='0'){
              $('#respuesta').empty();
              $('#respuesta').append("<p class='bg-warning text-center'></br><strong>este codigo no existe</strong></br></br></p>");
            }else{
              $('#respuesta').empty();
              $('#producto > option[value="'+json[0]['id']+'"]').attr('selected', 'selected');
              $('#stock').attr("placeholder",json[0]['stock']);
              $('#und').attr("placeholder",json[0]['und']);
              $('#codigo2').attr("value",json[0]['codigo'])
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            if(xhr.status == '500' || thrownError == 'Internal Server Error' ){
              $('#respuesta').append("<p class='bg-warning text-center'></br><strong>Datos no encontrados ingrese un codigo valido</strong></br></br></p>");

            }else{
              $('#respuesta').append("<p class='bg-success text-center'></br><strong>Datos Encontrados</strong></br></br></p>");
              }
          }
        });
      });

    </script>
@endsection
