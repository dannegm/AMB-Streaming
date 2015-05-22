<?php

class IndexController extends BaseController {

	public function song_json (){
		$cSong = file_get_contents("http://circovolador.org/app/csong.php");
			$cSong .= " - ";
			$cSong = str_replace("\n", "", $cSong);
			$cSong = str_replace("\r", "", $cSong);

		$song = explode(" - ", $cSong);
		$json = array (
			"song" => "{$song[0]} - {$song[1]}",
			"artist" => $song[1],
			"title" => $song[0]
		);
		return Response::json($json);
	}
	public function song_txt (){
		$cSong = file_get_contents("http://circovolador.org/app/csong.php");
			$cSong = str_replace("\n", "", $cSong);
			$cSong = str_replace("\r", "", $cSong);

		echo $cSong;
	}

	public function eventos(){
		$eventos = Evento::all();
		return Response::json($eventos);
	}

	public function stream(){
		$video = Video::all();
		$radio = Radio::all();

		$var = array(
			'radio' => $radio[0],
			'video' => $video[0]
		);

		return Response::json($var);
	}

	public function talleres(){
		$taller = Taller::where('imgsrc', '!=', '')->with('horario')->get();

		return Response::json($taller);
	}
}