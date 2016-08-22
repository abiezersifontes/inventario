@extends('layout.menu')
@section('sidebar')
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8">
        <h1><strong>Entradas</strong></h1>
      </div>
      <div class="col-lg-4 col-md-4">
      </br>
        <a class="btn btn-success" href="regentrada" role="button">Registrar Entrada</a>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-md-12 ">
        </br></br>

          <table class="table table-striped">
            <thead>
              <th>Id</th>
              <th>Fecha</th>
              <th>Codigo</th>
              <th>Cantidad</th>
              <th>Opciones</th>
            </thead>
            <tbody id="datos">

            </tbody>
          </table>
          <form>
            <input type="hidden" id="token" value="{!! csrf_token() !!}">
          </form>

        </br></br>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script>
    function Eliminar(btn){
      var route = "entrada/"+btn.value+"";
      var token = $("#token").val();
      var tr = $('#'+btn.id).closest('tr');

      $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'DELETE',
        dataType: 'json',
        success: function(json){

          $("#msj-success").fadeIn();
          tr.remove();
        }
      });
    }

    $(document).ready(function(){
      Carga();
    });

    function Carga{
      route = route = "entradapu";
      $.get(route,function(res){
      $('#datos').append(res);
      });
    }

  </script>
@endsection
