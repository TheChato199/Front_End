@extends('template')
@section('cuerpo')
<div class = "container">
	<div class = "card">
		<h5 class = "card-header">Actualizar Noticias</h5>
		<div class = "card-body">
			<form method="post" action="{{$base_url}}index.php/admin/noticias/update">
			<input value = "{{$noticia -> external}}" type="hidden" name = "external"/>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" name="titulo" class="form-control" placeholder="Titulo" required value = "{{$noticia -> 	titulo}}">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<textarea name="cuerpo" class="form-control" placeholder="Cuerpo" required>{{$noticia -> cuerpo}}</textarea>
					</div>
					<div class="row align-items-center remember">		
					</div>
					<div class="form-group">
						<input type="submit" value="guardar" class="btn btn-succes float-rigth">
					</div>
			</form>
		</div>
	</div>
</div>
@endsection