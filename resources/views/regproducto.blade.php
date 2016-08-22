@extends('layout.menu')
@section('sidebar')
  <div class="container">
    <div class="row">
      <div id="respuesta" class="col-lg-12 col-md-12">

      </div>
    </div>
    <div class="row">
      <div class="col-lg-9 col-md-9 ">
        </br></br>

        {!!Form::open(['id'=>'form'])!!}
          <div class="form-group">
            {!!Form::label('Codigo')!!}
            {!!Form::text('Codigo', null,['class'=>'form-control', 'placeholder'=>'Por ejemplo ´A-001´', 'id' => 'codigo'])!!}
          </div>
          <div class="form-group">
            {!!Form::label('Nombre')!!}
            {!!Form::text('Nombre', null,['class'=>'form-control', 'placeholder'=>'Por ejemplo ´BOLIGRAFO´', 'id' => 'nombre'])!!}
          </div>
          <div class="form-group">
            {!!Form::label('Existencia')!!}
            {!!Form::number('Existencia', null,['class'=>'form-control', 'placeholder'=>'Por ejemplo ´52´', 'id' => 'stock'])!!}
          </div>
          <div class="form-group">
            {!!Form::label('Unidad')!!}
            {!!Form::text('Unidad', null,['id' => 'und', 'class'=>'form-control', 'placeholder'=>'Por ejemplo ´UND´ ´LTS´ ´MTS´ '])!!}
          </div>

          <button id="guardar" class="btn btn-default">Guardar</button>
        {!! Form::close() !!}
        </br></br>
      </div>
    </div>
  </div>
  <meta name="_token" content="{!! csrf_token() !!}"/>
@endsection
@section('scripts')
<script>
$(document).ready(function(){
  $('#form').submit(function(e){
    e.preventDefault();
    codigo = $('#codigo').val();
    nombre = $('#nombre').val();
    stock = $('#stock').val();
    und = $('#und').val();
    route = "producto";

    html1 = "<p class='bg-warning text-center'></br><strong>";
    html2 = "</strong></br></br></p>";

    $.ajax({
      type:"POST",
      headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
      url:route,
      dataType:'json',
      data:{codigo:codigo,nombre:nombre,stock:stock,und:und},
      success:function(json){
        if(json[0]['codigo']=='Se requiere un codigo' || json[0]['codigo']=='El codigo debe ser unico'){

          $('#respuesta').html(html1+json[0]['codigo']+html2);

        }else if(json[0]['nombre']=='Se requiere un nombre' || json[0]['nombre']=='El nombre debe ser unico'){

          $('#respuesta').html(html1+json[0]['nombre']+html2);

        }else if(json[0]['stock']=='Debe tener una existencia'){

          $('#respuesta').html(html1+json[0]['stock']+html2);

        }else if(json[0]['und']=='Debe tener una unidad'){

          $('#respuesta').html(html1+json[0]['und']+html2);

        }else {
          $('#respuesta').html("<p class='bg-success text-center'></br><strong>Datos Registrados Exitosamente</strong></br></br></p>");
          $("#form")[0].reset();
          $('#respuesta').fadeOut('slow');
        }
      },
      error: function() {
        $('#respuesta').html("<p class='bg-warning text-center'></br><strong>ha Ocurrido Un error</strong></br></br></p>");
      }
    });
  });
});
</script>
@endsection
