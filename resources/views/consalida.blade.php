@extends('layout.menu')
@section('sidebar')

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Salida</h4>
    </div>
    <div class="modal-body">
      <label for="codigo">Dpto</label>
      <input type="text" id="dpto" name="dpto" class="form-control">
      <label for="nombre">Receptor</label>
      <input type="text" id="receptor" name="receptor" class="form-control">
      <label for="und">Cantidad</label>
      <input type="text" id="cantidad" name="cantidad" class="form-control">
      <input type="hidden" id="id" name="id">
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" id="actualizar" class="btn btn-primary">Guardar cambios</button>
    </div>
  </div>
</div>
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
        <h1><strong>Salidas</strong></h1>
      </div>
      <div class="col-lg-4 col-md-4">
      </br>
        <a class="btn btn-primary" href="regsalida" role="button">Registrar Salida</a>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-md-12 ">
        </br></br>

          <table class="table table-striped">

            <th>fecha</th>
            <th>Codigo</th>
            <th>Dpto</th>
            <th>Receptor</th>
            <th>Cantidad</th>
            <th>Opciones</th>
            @foreach ($salidas as $salida)
            <tr>
              <td>{{ $salida->created_at }}</td>
              <td>{{ $salida->codigo }}</td>
              <td>{{ $salida->dpto }}</td>
              <td>{{ $salida->receptor }}</td>
              <td>{{ $salida->cantidad }}</td>
              <td>
                <button id="{{$salida->id}}"  class="btn btn-danger" value="{{$salida->id}}" OnClick="Eliminar(this);">Eliminar</button>
              </td>
            </tr>
            @endforeach
          </table>
          {!! $salidas->render() !!}
        </br></br>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script>


  function Eliminar(btn){
  	var route = "salida/"+btn.value+"";
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

</script>
@endsection
