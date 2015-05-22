<?php

class ImageController extends \BaseController{

	public function uploadEvento($id){
		set_time_limit(3600);
		$up = Input::hasFile('file');
		$status = array();
		if($up){

			//guardamos la imágen en una variable
			$image = Input::file('file');

			//obtenemos el md5
			$md5 = md5_file($image);

			//traemos la extensión
			$ext = $image->getClientOriginalExtension();

			//generamos el nombre de la imagen
			$filename = $md5.'.'.$ext;

			//se mueve la imágen a la carpeta pictures
			$image->move('pictures', $filename);
			$fileUrl = URL::asset('pictures/show/'.$filename);

			$file = public_path('pictures/'.$filename);

			//asignamos las carpetas a variables
			$pathShow = public_path('pictures/show/'.$filename);

			//redimensiones, a todos tamaños  de carpetascuidando el upsize
			Image::make($file)->resize(null, 640, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			})->save($pathShow, 60);

			//insertamos la imagen en la bd
			DB::table('eventos')
			->where('id', $id)
			->update(array('picture' => $fileUrl));

			//guardamos el status
			$status = array(
				'status' => 'success',
				'time'=> array(
					'time' => time()
				),
				'description' => 'Se guardó la imagen',
				'picabs' => $fileUrl,
				'pic' => $filename,
				'id' => $id
			);
		}else{
			//si la imagen no sube guardamos el error
			$status = array(
				'status' => 'error',
				'time'=> array(
					'time' => time()
				),
				'error' => 'error',
				'pic' => 'error'
			);
		}

		//$status = json_encode($status);
		return Response::json($status);

	}

	public function uploadTaller($id){
		set_time_limit(3600);
		$up = Input::hasFile('file');
		$status = array();
		if($up){

			//guardamos la imágen en una variable
			$image = Input::file('file');

			//obtenemos el md5
			$md5 = md5_file($image);

			//traemos la extensión
			$ext = $image->getClientOriginalExtension();

			//generamos el nombre de la imagen
			$filename = $md5.'.'.$ext;

			//se mueve la imágen a la carpeta talleres
			$image->move('talleres', $filename);
			$fileUrl = URL::asset('talleres/show/'.$filename);
			$fileUrlWB = URL::asset('talleres/blur/'.$filename);

			$file = public_path('talleres/'.$filename);

			//asignamos las carpetas a variables
			$pathShow = public_path('talleres/show/'.$filename);
			$pathBlur = public_path('talleres/blur/'.$filename);

			//redimensiones, a todos tamaños  de carpetascuidando el upsize
			Image::make($file)->resize(null, 640, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			})->save($pathShow, 60);
			Image::make($file)->resize(null, 640, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			})->blur(60)->save($pathBlur, 60);

			//insertamos la imagen en la bd
			DB::table('talleres')
			->where('id', $id)
			->update(array(
				'imgsrc' => $fileUrl,
				'imgsrc_blur' => $fileUrlWB,
			));

			//guardamos el status
			$status = array(
				'status' => 'success',
				'time'=> array(
					'time' => time()
				),
				'description' => 'Se guardó la imagen',
				'picabs' => $fileUrl,
				'pic' => $filename,
				'id' => $id
			);
		}else{
			//si la imagen no sube guardamos el error
			$status = array(
				'status' => 'error',
				'time'=> array(
					'time' => time()
				),
				'error' => 'error',
				'pic' => 'error'
			);
		}

		//$status = json_encode($status);
		return Response::json($status);

	}

}