@extends('layout.menu')
@section('sidebar')


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Producto</h4>
    </div>
    <div class="modal-body">
      <label for="codigo">Codigo</label>
      <input type="text" id="codigo" name="codigo" class="form-control">
      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre" class="form-control">
      <label for="und">Unidad</label>
      <input type="text" id="und" name="und" class="form-control">
      <label for="stock">Existencia</label>
      <input type="number" id="stock" name="stock" class="form-control">
      <input type="hidden" id="id" name="id">
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" id="actualizar" class="btn btn-primary">Guardar cambios</button>
    </div>
  </div>
</div>
</div>

  <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
  		<strong> Datos Actualizados.</strong>
	</div>
  <div id="msj-delete" class="alert alert-success alert-dismissible" role="alert" style="display:none">
      <strong> Datos Eliminados.</strong>
  </div>
  <form >
    <input type="hidden" id="token" value="{!! csrf_token() !!}">
  </form>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8">
        <h1><strong>Productos</strong></h1>
      </div>
      <div class="col-lg-4 col-md-4">
      </br>
        <a class="btn btn-info" href="regproducto" role="button">Nuevo Producto</a>
      </div>
    </div>
    <div class="row">
      <div id="capa" class="col-lg-12 col-md-12 ">
      </div>
      <div class="col-lg-12 col-md-12 ">
        </br></br>

          <form>
            <div class="col-lg-3 col-md-3">

              <select id="tipo" class="form-control">
                <option value="1">Codigo</option>
                <option value="2">Nombre</option>
              </select>

            </div>
            <div class="col-lg-6 col-md-6 ">
              <input type="text" id="buscar" name="search" class="form-control">
            </div>
            <div class="col-lg-3 col-md-3 ">
              <button id="search" class="btn">Buscar</button>
            </div>
          </form>
        </br>
        </br>
        </br>
          <table id="table" class="table table-striped">
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Und</th>
            <th>Stock</th>
            <th>Opciones</th>
            <tbody id="datos">
              @foreach ($productos as $producto)
              <tr>
                <td id="codigo">{{ $producto->codigo }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->und }}</td>
                <td>{{ $producto->stock }}</td>
                <td>
                  <button id="{{$producto->id}}"  class="btn btn-danger" value="{{$producto->id}}" OnClick="Eliminar(this);">Eliminar</button>
                  <button id="{{$producto->id}}" class="btn btn-warning" value="{{$producto->id}}" OnClick="Mostrar(this);" data-toggle="modal" data-target="#myModal">Modificar</button>
                </td>
              </tr>
              @endforeach
          </tbody >
          </table>
          {!!$productos->render()!!}
        </br></br>
      </div>
    </div>
    <meta name="_token" content="{!! csrf_token() !!}"/>
  </div>
@endsection
@section('scripts')
<script>


    $('#search').click(function(e){

      e.preventDefault();
      tipo = $('#tipo').val();
      dato = $('#buscar').val();
      token = $('#token').val();
      if(dato==''){
        $('#table').empty();
        $('#table').append("<p class='bg-warning text-center'></br><strong>Debe ingresar un valor</strong></br></br></p>");
      }else{
        $.ajax({
          url:'search/'+dato+'/'+tipo,
          success:function(json){
            if(json[0]==0){
              $('#table').empty();
              $('#table').append("<p class='bg-warning text-center'></br><strong>Valor no encontrado</strong></br></br></p>");
            }else{
            $('#table').empty();
            $('#table').append("<table id='table' class='table table-striped'><th>Id</th><th>Codigo</th><th>Nombre</th><th>Und</th><th>Stock</th><th>Opciones</th><tbody id='datos'><tr id='tr'><td id='id'>"+json[0]['id']+"</td><td id='codigo'>"+json[0]['codigo']+"</td><td>"+json[0]['nombre']+"</td><td>"+json[0]['und']+"</td><td>"+json[0]['stock']+"</td><td><button id='"+json[0]['id']+"'  class='btn btn-warning' value='{{$producto->id}}' OnClick='Eliminar(this);'>Eliminar</button><button id='"+json[0]['id']+"' class='btn btn-danger' value='"+json[0]['id']+"' OnClick='Mostrar(this);' data-toggle='modal' data-target='#myModal'>Modificar</button></td></tr></tbody>");
            }
          },
          error:function(){
            alert('ha ocurrido un error');
          }
        });
      }
    });

    function Mostrar(btn){

      route = "producto/"+btn.value+"/edit";

      $.get(route, function(res){
          $("#codigo").val(res.codigo);
          $("#nombre").val(res.nombre);
          $("#und").val(res.und);
          $("#stock").val(res.stock);
          $("#id").val(res.id)
          console.log(res.stock);
		    });
    }

    $("#actualizar").click(function(){
      codigo = $("#codigo").val();
      nombre = $("#nombre").val();
      und = $("#und").val();
      stock = $("#stock").val();
      id = $("#id").val();

    	var route = "producto/"+id;
    	token = $('#token').val();

  	$.ajax({
  		url: route,
  		headers: {'X-CSRF-TOKEN': token},
  		type: 'PUT',
  		dataType: 'json',
  		data: {codigo:codigo,
            nombre:nombre,
            und:und,
            stock:stock,
            id:id},
  		success: function(){
  			//Carga();
  			$("#myModal").modal('toggle');
        window.location="producto";
  			$("#msj-success").fadeIn();
        $("#msj-delete").fadeOut('slow');
      },
      error:function() {
        alert("ha ocurrido un error")
      }

  	});
  });

  function Eliminar(btn){
  	var route = "producto/"+btn.value+"";
  	var token = $("#token").val();
    var tr = $('#'+btn.id).closest('tr');

  	$.ajax({
  		url: route,
  		headers: {'X-CSRF-TOKEN': token},
  		type: 'DELETE',
  		dataType: 'json',
  		success: function(json){
        tr.remove();
  			$("#msj-delete").fadeIn();
        $("#msj-delete").fadeOut('slow');
  		}
  	});
  }


function Carga(){
  route = "producto";
  $.get(route, function(res){
			$('#datos').append(res);
	});
}
/*  $(document).on('click','.pagination a',function(e){
  e.preventDefault();
  var page = $(this).attr('href').split('page=')[1];
  var route = "producto";
  $.ajax({
      url: route,
      data: {page: page},
      type: 'GET',
      dataType: 'json',
      success: function(data){
          $(".users").html(data);
      }
  });
  alert(page+", "+route)
});*/

</script>
@endsection
