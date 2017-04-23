<?php 
	function resizeImage($file, $w, $h, $crop=FALSE) {
	    list($width, $height) = getimagesize($file);
	    $r = $width / $height;
	    if ($crop) {
	        if ($width > $height) {
	            $width = ceil($width-($width*abs($r-$w/$h)));
	        } else {
	            $height = ceil($height-($height*abs($r-$w/$h)));
	        }
	        $newwidth = $w;
	        $newheight = $h;
	    } else {
	        if ($w/$h > $r) {
	            $newwidth = $h*$r;
	            $newheight = $h;
	        } else {
	            $newheight = $w/$r;
	            $newwidth = $w;
	        }
	    }
	    $src = imagecreatefromjpeg($file);
	    $dst = imagecreatetruecolor($newwidth, $newheight);
	    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	    return $dst;
	}

	function getLastRowId($table, $connection){
		$query = "SELECT MAX(id) as id FROM ".$table;
		$result = $connection->query($query);
		if($result){
			while($row = $result->fetch_object()){
				return ($row->id + 1);
			}
		}
	}

	function uploadFile($file){
		if ($file["error"] > 0){
            return false;
        } else {
            $filename = $file['name'];
			$filesize = $file['size'];	
			$filetype = $file['type'];
			$filetmp_name = $file['tmp_name'];
            $kb_limit = 40000;

            if ($filesize <= $kb_limit * 1024){
				$url = "../imgs/animes/". $filename;
                if (!file_exists($url)){
                    if (is_dir('../imgs/animes/')) {

					}else {
					    mkdir('../imgs/animes/', 0777, true);
					}
                    $result = @move_uploaded_file($filetmp_name, $url);
                    //devuelve un booleano con true o false: si es falso ocurrio un error, sino se subio correctamente
                    if ($result){
                    	return $filename;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
	
?>