//consultar Producto con php crudo y blade
@foreach ($productos as $producto)
<tr>
  <td id="id">{{ $producto->id }}</td>
  <td>{{ $producto->codigo }}</td>
  <td>{{ $producto->nombre }}</td>
  <td>{{ $producto->und }}</td>
  <td>{{ $producto->stock }}</td>
  <td>
    <button id="eliminar" class="btn btn-warning">Eliminar</button>
    <button id="modificar" class="btn btn-danger">Modificar</button>
  </td>
</tr>
@endforeach


//reg entrada.blade.php

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



      </form id="form2">
      </br></br>
      <div id="respuesta" class="col-lg-11 col-md-11 ">
        <form class="form-group" action="index.html" method="post">

          <label for="stock">Existencia</label>
          <input type="number" class="form-control" id="stock" disabled>

          <label for="und">Und</label>
          <input type="text" class="form-control" id="und" disabled>

          <label for="persona">Persona que recibe:</label>
          <input type="text" class="form-control" id="receptor">

          <label for="dpto">Departamento</label>
          <input type="text" class="form-control" id="dpto">

          <label for="cantidad">Cantidad</label>
          <input type="number" class="form-control" id="cantidad">

          <input type="hidden" id="codigo2">

          <button type="button" id="guardar"></button>
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

      $('#producto').change(function(){
        producto_id = $('#producto').val();
        token = $('meta[name="_token"]').attr('content');

        $.ajax({
          type:"GET",
          headers:{'X-CSRF-TOKEN':token},
          url:'select/'+producto_id,
          success:function(json){
            $('#stock').attr("placeholder",json[0]['stock']);
            $('#und').attr("placeholder",json[0]['und']);
            $('#codigo2').attr("value",json[0]['codigo'])
          },
          error: function (xhr, ajaxOptions, thrownError) {
            $('#respuesta').empty();
            $('#respuesta').append(xhr.status+"  "+thrownError);
          }
        });
      });
/*
      $('#guardar').click(function(){
        codigo = $('#codigo2').val();
        receptor = $('#receptor').val();
        dpto = $('#dpto').val();
        cantidad = $('#cantidad').val();
        $.ajax({
          type:'POST',
          url:'entrada',
          headers:{'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
          dataType:'json',
          data:{codigo:codigo,receptor:receptor,dpto:dpto,cantidad:cantidad},
          success:function(){
            $('#respuesta').empty();
            $('#respuesta').append('Datos Enviados');
          },
          error: function (xhr, ajaxOptions, thrownError) {
            $('#respuesta').empty();
            $('#respuesta').append(xhr.status+"  "+thrownError);
          }
        });
      });
*/
      $('#buscar').click(function(e){
        e.preventDefault();
        route = "entrada";
        codigo = $("#codigo").val();

        $.ajax({
          type:"POST",
          url:route,
          headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
          dataType:'json',
          data:{codigo:codigo},
          success:function(json){
            $('#stock').attr("placeholder",json[0]['stock']);
            $('#und').attr("placeholder",json[0]['und']);
            $('#codigo2').attr("value",json[0]['codigo'])
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
