<?php
/**
 * Manage images
 */

/**
 * Holds the logic for image manipulation
 */
class ImageManagement 
{
	/**
	 * Creates a Thumbnail of an image
	 *
 	 * @param string $file The path to the file
	 * @param string $save The targetpath
	 * @param string $width The with of the image
	 * @param string $height The height of the image
	 * 
	 * @return true when success
	 */
	public function thumb($file, $save, $width, $height)
	{
		//GD-Lib > 2.0 only!
		@unlink($save);

		//get sizes else stop
		if (!$infos = @getimagesize($file)) 
		{
			return false;
		}

		// keep proportions
		$iWidth = $infos[0];
		$iHeight = $infos[1];
		$iRatioW = $width / $iWidth;
		$iRatioH = $height / $iHeight;

		if ($iRatioW < $iRatioH) 
		{
			$iNewW = $iWidth * $iRatioW;
			$iNewH = $iHeight * $iRatioW;
		} 
		else {
			$iNewW = $iWidth * $iRatioH;
			$iNewH = $iHeight * $iRatioH;
		}

		//Don't resize images which are smaller than thumbs
		if ($infos[0] < $width && $infos[1] < $height) 
		{
			$iNewW = $infos[0];
			$iNewH = $infos[1];
		}

		if($infos[2] == 1) 
		{
			/*
			* Image is typ gif
			*/
			$imgA = imagecreatefromgif($file);
			$imgB = imagecreate($iNewW,$iNewH);
			
       		//keep gif transparent color if possible
          	if(function_exists('imagecolorsforindex') && function_exists('imagecolortransparent')) 
          	{
            	$transcolorindex = imagecolortransparent($imgA);
        		//transparent color exists
        		if($transcolorindex >= 0 ) 
        		{
         			$transcolor = imagecolorsforindex($imgA, $transcolorindex);
          			$transcolorindex = imagecolorallocate($imgB, $transcolor['red'], $transcolor['green'], $transcolor['blue']);
          			imagefill($imgB, 0, 0, $transcolorindex);
          			imagecolortransparent($imgB, $transcolorindex);
          		} //fill white
        		else {
          			$whitecolorindex = @imagecolorallocate($imgB, 255, 255, 255);
          			imagefill($imgB, 0, 0, $whitecolorindex);
        		}
            } //fill white
            else {
            	$whitecolorindex = imagecolorallocate($imgB, 255, 255, 255);
            	imagefill($imgB, 0, 0, $whitecolorindex);
          	}
          	imagecopyresampled($imgB, $imgA, 0, 0, 0, 0, $iNewW, $iNewH, $infos[0], $infos[1]);
			imagegif($imgB, $save);

		} 
		elseif($infos[2] == 2) 
		{
			/*
			* Image is typ jpg
			*/
			$imgA = imagecreatefromjpeg($file);
			$imgB = imagecreatetruecolor($iNewW,$iNewH);
			imagecopyresampled($imgB, $imgA, 0, 0, 0, 0, $iNewW, $iNewH, $infos[0], $infos[1]);
			imagejpeg($imgB, $save);

		} 
		elseif($infos[2] == 3) 
		{
			/*
			* Image is typ png
			*/
			$imgA = imagecreatefrompng($file);
			$imgB = imagecreatetruecolor($iNewW, $iNewH);
			imagealphablending($imgB, false);
			imagecopyresampled($imgB, $imgA, 0, 0, 0, 0, $iNewW, $iNewH, $infos[0], $infos[1]);
			imagesavealpha($imgB, true);
			imagepng($imgB, $save);
		} 
		else {
			return false;
		}
		return true;
	}

	/**
	 * Creates image information of an image
	 *
	 * @param string $image The path to image
	 * @param int $width The width to resize image
	 *
	 * @return imagedata if available
	 */
	public function flyercreator($image, $width)
	{
		if (!$image)
		{
			return false;
		}
		$parts = explode(DIRECTORY_SEPARATOR, $image);
			
		if (count($parts) > 0) 
		{
			$image_name = array_pop($parts);
			
			//Create thumbnail if it does not exist already
			if ( !file_exists(Yii::app()->basePath . '/../upload/_thumb/images/'.$image_name) ) 
			{
				$filepath 	= Yii::app()->basePath . '/..'.$image;
				$save 		= Yii::app()->basePath . '/../upload/_thumb/images/'.$image_name;

				self::thumb($filepath, $save, $width, $settings->imageheight);
			}

			//set paths
			$dimage['original'] = 'images/eventlist/'.$folder.'/'.$image;
			$dimage['thumb'] 	= 'images/eventlist/'.$folder.'/small/'.$image;

			//get imagesize of the original
			$iminfo = @getimagesize('images/eventlist/'.$folder.'/'.$image);

			//if the width or height is too large this formula will resize them accordingly
			if (($iminfo[0] > $settings->imagewidth) || ($iminfo[1] > $settings->imageheight)) {

				$iRatioW = $settings->imagewidth / $iminfo[0];
				$iRatioH = $settings->imageheight / $iminfo[1];

				if ($iRatioW < $iRatioH) {
					$dimage['width'] 	= round($iminfo[0] * $iRatioW);
					$dimage['height'] 	= round($iminfo[1] * $iRatioW);
				} else {
					$dimage['width'] 	= round($iminfo[0] * $iRatioH);
					$dimage['height'] 	= round($iminfo[1] * $iRatioH);
				}

			} else {

				$dimage['width'] 	= $iminfo[0];
				$dimage['height'] 	= $iminfo[1];

			}

			if (JFile::exists(JPATH_SITE.'/images/eventlist/'.$folder.'/small/'.$image)) {

				//get imagesize of the thumbnail
				$thumbiminfo = @getimagesize('images/eventlist/'.$folder.'/small/'.$image);
				$dimage['thumbwidth'] 	= $thumbiminfo[0];
				$dimage['thumbheight'] 	= $thumbiminfo[1];

			}
			return $dimage;
		}
		return false;
	}

	/**
	 * Creates image information of an images in attention
	 *
	 * @param string $image The image name
	 * @param string $event_id
	 *
	 * @return imagedata if available
	 */
	public function galleryFlyercreator($image, $event_id)
	{
		$settings = & ELHelper::config();
		$params = JComponentHelper::getParams('com_eventlist');
		
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');

		//define the environment based on the type
		$type = 'gallery';
		$folder 	= 'event'.$event_id;
		
		if ( $image ) 
		{
			//Create thumbnail if enabled and it does not exist already
			$thumb_path = JPATH_SITE.'/images/'.$type.'/'.$folder.'/small/';
			if ($settings->gddisabled == 1 && !file_exists($thumb_path.$image)) 
			{
				if ( !JFolder::exists($thumb_path) )
				{
					JFolder::create($thumb_path);
				}
				
				$filepath 	= JPATH_SITE.'/'.$params->get('attachments_path', 'media/com_eventlist/attachments').'/'.$folder.'/'.$image;
				$save 		= JPATH_SITE.'/images/'.$type.'/'.$folder.'/small/'.$image;

				$result = ELImage::thumb($filepath, $save, $settings->imagewidth, $settings->imageheight);
			}
			
			$dimage['info'] = $image;

			//set paths
			$dimage['original'] = $params->get('attachments_path', 'media/com_eventlist/attachments').'/'.$folder.'/'.$image;
			$dimage['thumb'] 	= 'images/'.$type.'/'.$folder.'/small/'.$image;

			//get imagesize of the original
			$iminfo = @getimagesize( $dimage['original'] );

			//if the width or height is too large this formula will resize them accordingly
			if (($iminfo[0] > $settings->imagewidth) || ($iminfo[1] > $settings->imageheight)) {

				$iRatioW = $settings->imagewidth / $iminfo[0];
				$iRatioH = $settings->imageheight / $iminfo[1];

				if ($iRatioW < $iRatioH) {
					$dimage['width'] 	= round($iminfo[0] * $iRatioW);
					$dimage['height'] 	= round($iminfo[1] * $iRatioW);
				} else {
					$dimage['width'] 	= round($iminfo[0] * $iRatioH);
					$dimage['height'] 	= round($iminfo[1] * $iRatioH);
				}

			} else {

				$dimage['width'] 	= $iminfo[0];
				$dimage['height'] 	= $iminfo[1];

			}

			if (JFile::exists(JPATH_SITE.'/images/'.$type.'/'.$folder.'/small/'.$image)) {

				//get imagesize of the thumbnail
				$thumbiminfo = @getimagesize('images/'.$type.'/'.$folder.'/small/'.$image);
				$dimage['thumbwidth'] 	= $thumbiminfo[0];
				$dimage['thumbheight'] 	= $thumbiminfo[1];

			}
			return $dimage;
		}
		return false;
	}

}
