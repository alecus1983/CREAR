<title>Claves para una Educación Respetuosa</title>


<?php
include_once "./assets/templates/header.php";
?>

<br>
<br>
<br>
<br>
<br>
<br>

<div class="container mt-4">

	<div class="row">
		<div class="col-md-8">
			<h1>COMO DESCARGAR Y TRADUCIR MEDIANTE SUBTÍTULOS AUTOMÁTICOS DE INGLÉS A ESPAÑOL DESDE <b>YOUTUBE</b> CON LINUX</h1>

			<br>
			<br>
			<!-- -<img src="./img-blog/1.jpg" class="img-fluid mb-4 mt-3" alt="img"> -->
			<p style="font-we" class="fw-normal">En diversas ocaciones se hace necesario contar con un vídeo alojando en internet con distintos fines, recreativos educativos, etc. En caso de que no se disponga de una conexión permante o por otras razones, se requiere tenerlo en un archivo en formato de video con audio.</p>

			<p style="font-we" class="fw-normal">En primer lugar emplearemos los siguientes programas, que se pueden ejecutar desde el terminal de Linux:</p>
			<br><br>

			<div class="container">
				<div class="row">
					<div class="col-md-3"><a href="https://github.com/yt-dlp/yt-dlp">yt-dlp</a></div>
					<div class="col-md-9"><i>Este programa se encarga de descargar el archivo desde la página de youtube</i></div>
				</div>
				<div class="row">
					<div class="col-md-3"><a href="https://www.ffmpeg.org/documentation.html">ffmpeg</a></div>
					<div class="col-md-9"><i>Este programa puede convertir audio o video entre distintos formatos, editar subtítulos, entre otras funciones.</i>
					</div>
				</div>
			</div>

			<p>Por ejemplo para descargar un video inice copiando la url del video y ejecute el siguiente comando:</p>
			<br>
			<pre style="background-color:#111111; color:#aaa">  yt-dlp  --write-auto-sub --sub-lang es  -f mp4 <i>url   </i></pre>

			<p>
				Si la url es <a href="https://www.youtube.com/watch?v=Nr_A0HcvSOI">https://www.youtube.com/watch?v=Nr_A0HcvSOI</a>, el comando quedaría
			</p>

			<pre style="background-color:#111111; color:#aaa">
yt-dlp  --write-auto-sub --sub-lang es -f mp4 -o Amazing_Grace https://www.youtube.com/watch?v=Nr_A0HcvSOI
			</pre>
			<p>la opciones del comando son las siguientes:</p>

			<div class="container">
				<div class="row">
					<div class="col-md-3">–write -auto-sub</div>
					<div class="col-md-9">indica que se descarguen los subtitulos automaticamente</div>
				</div>
				<div class="row">
					<div class="col-md-3">–sub-lang es</div>
					<div class="col-md-9">indica que los subtítulos sean en español (en para inglés)</div>
				</div>
				<div class="row">
					<div class="col-md-3">–f</div>
					<div class="col-md-9">indica el formato de salida del vídeo en este caso MP4</div>
				</div>

				<div class="row">
					<div class="col-md-3">–o</div>
					<div class="col-md-9">indica el nombre del archivo obtenido</div>
				</div>
			</div>
			<p>Con lo cual recibimos dos archivos uno .mp4 (Amazing Grace.mp4) con el vídeo y otro .vtt (Amazing_Grace.es.vtt)con los subtítulos. Para poder tratar estos últimos cambiamos el formato (y opcionalmente el nombre ) de .vtt a .ass, mediante el programa ffmpeg en línea de comandos así:
			</p>

			<pre style="background-color:#111111; color:#aaa">ffmpeg -i Amazing_Grace.es.vtt subtitulos.ass
			</pre>
			<p>y finalmente fusiones estos subtítulos en formato .ass con el video obtenido en formato .mp4, para obtener un archivo final.</p>

			<pre style="background-color:#111111; color:#aaa">ffmpeg -i Amazing_Grace -vf ass=subtitulos.ass Amazin_grace_sub_es.mp4</pre>
			<p>Nota: Se puede editar el archivo .ass para mejorar la traducción.</p>

			<br>
			<br>
			<p>Enlaces de interés</p>
			<p>
			<ul>Sitio oficial de yt-dlp : <a href="https://github.com/yt-dlp/yt-dlp">https://github.com/yt-dlp/yt-dlp</a></ul>
			</p>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
					<button type="button" class="btn btn-light"> <a href="blog.php">Inicio</a></button>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Psicología</h5>

					<ul class="list-group">
						<li class="list-group-item"><a href="blog.php">Disciplina Positiva: Claves para una Educación Respetuosa</a></li>

					</ul>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Informática</h5>
					<ul class="list-group">
						<li class="list-group-item"><a href="descargardeinternet.php">Como descargar video de youtube</a></li>

					</ul>
				</div>
			</div><!-- fin de card -->
		</div><!-- fin de col -->
	</div><!-- fin de row -->
</div><!-- fin de container -->
<br>
<br>
<br>
