<?php

class ImageController extends \BaseController {

	public function upload () {
		set_time_limit(3600);
		$up = Input::hasFile('file');
		$status = array();

		$group = Input::get('group');
		$group = isset($group) ? $group : "General";
		if ($up) {
			// guardamos la imágen en una variabñe
			$image = Input::file('file');

			// obtenemos el md5
			$md5 = md5_file($image);

			// consultamos el md5 en la bd
			$imagen = Picture::whereMd5($md5)->get();

			// si no encontramos coincidencias subimos
			if ($imagen->isEmpty()) {
				//traemos la extensión
				$ext = $image->getClientOriginalExtension();

				//generamos un uid
				$uid = uniqid();

				// generamos el nombre de la imagen
				$filename = $md5 . '.' . $ext;

				// se mueve la imágen a la carpeta pictures
				$image->move('pictures', $filename);
				$fileUrl = URL::asset('pictures/' . $filename);
				$fileUrlMiddle = URL::asset('pictures/medium/' . $filename);

				if ($group == 'UserProfile') {
					$fileUrlMiddle = URL::asset('pictures/sqm/' . $imagen[0]->url);
				}

				// asignamos las carpetas a variables
				$file = public_path('pictures/' . $filename);
				$pathLarge = public_path('pictures/large/' . $filename);
				$pathNormal = public_path('pictures/normal/' . $filename);
				$pathMedium = public_path('pictures/medium/' . $filename);
				$pathSmall = public_path('pictures/small/' . $filename);
				$pathSq = public_path('pictures/sq/' . $filename);
				$pathSqm = public_path('pictures/sqm/' . $filename);
				$pathThumb = public_path('pictures/thumb/' . $filename);

				// almacenamos la imagen original
				$opicture = Image::make($file);

				// redimensiones, a todos tamaños  de carpetascuidando el upsize
				Image::make($file)->resize(1280, null, function ($constraint) {
					$constraint->aspectRatio();
					$constraint->upsize();
				})->save($pathLarge);
				Image::make($file)->resize(960, null, function ($constraint) {
					$constraint->aspectRatio();
					$constraint->upsize();
				})->save($pathNormal);
				Image::make($file)->resize(640, null, function ($constraint) {
					$constraint->aspectRatio();
					$constraint->upsize();
				})->save($pathMedium);
				Image::make($file)->resize(320, null, function ($constraint) {
					$constraint->aspectRatio();
					$constraint->upsize();
				})->save($pathSmall);
				Image::make($file)->resize(160, null, function ($constraint) {
					$constraint->aspectRatio();
					$constraint->upsize();
				})->save($pathThumb);
				Image::make($file)->resize(256, 256)->save($pathSq);
				Image::make($file)->resize(64, 64)->save($pathSqm);

				//insertamos la imagen en la bd
				$picture = new Picture;
				$picture->uid = $uid;
				$picture->md5 = $md5;
				$picture->url = $filename;
				$picture->group = $group;

				$picture->content_type = $opicture->mime();
				$picture->width = $opicture->width();
				$picture->height = $opicture->height();
				$picture->exif = json_encode($opicture->exif());
				$picture->save();

				//guardamos el status
				$status = array(
					'status' => 'success',
					'time'=> array(
						'time' => time()
					),
					'description' => 'Se guardó la imagen',
					'pic' => $fileUrlMiddle,
					'filelink' => $fileUrlMiddle,
					'id' => $uid
				);
			} else {
				// si la imágen ya existe obtenemos la url
				$fileUrlMiddle = URL::asset('pictures/medium/' . $imagen[0]->url);
				if ($group == 'UserProfile') {
					$fileUrlMiddle = URL::asset('pictures/sqm/' . $imagen[0]->url);
				}
				// guardamos el status en json
				$status = array(
					'status' => 'repeat',
					'time'=> array(
						'time' => time()
					),
					'description' => 'La imágen ya existe',
					'pic' => $fileUrlMiddle,
					'filelink' => $fileUrlMiddle,
					'id' => $imagen[0]->uid
				);
			}
		} else {
			$status = array(
				'status' => 'error',
				'time'=> array(
					'time' => time()
				),
				'error' => 'error',
				'pic' => 'error'
			);
		}
		return Response::json($status);

	}
	public function list_json ($group = 'all') {
		$pictures = Picture::all();
		if ($group != "all") {
			$pictures = Picture::where('group', '=', $group)->get();
		}
		$res = array();
		foreach ($pictures as $p) {
			$res[] = Array(
				'url' => URL::to('/').'/pictures/sq/' . $p->url,
				'folder' => $p->group,
				'image' => URL::to('/').'/pictures/medium/' . $p->url,
				'thumb' => URL::to('/').'/pictures/sq/' . $p->url
			);
		}
		return Response::json($res);
	}
}