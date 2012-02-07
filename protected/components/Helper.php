<?php
/**
 * File for helper class
 */

/**
 * Helper class, provides the methods for site
 */
class Helper 
{
	/**
	 * Function convert cyrillic letters to latin
	 * 
	 * @static
	 * @access public
	 * @param sting input data
	 * 
	 * @return string result of converting
	 */
	public static function translit( $string ) 
	{
		$table = array(
			'А' => 'A',
			'Б' => 'B',
			'В' => 'V',
			'Г' => 'G',
			'Ґ' => 'G',
			'Д' => 'D',
			'Е' => 'E',
			'Є' => 'E',
			'Ж' => 'ZH',
			'З' => 'Z',
			'И' => 'Y',
			'І' => 'I',
			'Ї' => 'I',
			'Й' => 'J',
			'К' => 'K',
			'Л' => 'L',
			'М' => 'M',
			'Н' => 'N',
			'О' => 'O',
			'П' => 'P',
			'Р' => 'R',
			'С' => 'S',
			'Т' => 'T',
			'У' => 'U',
			'Ф' => 'F',
			'Х' => 'H',
			'Ц' => 'C',
			'Ч' => 'CH',
			'Ш' => 'SH',
			'Щ' => 'CSH',
			'Ь' => '',
			'Ю' => 'YU',
			'Я' => 'YA',
			'а' => 'a',
			'б' => 'b',
			'в' => 'v',
			'г' => 'g',
			'ґ' => 'g',
			'д' => 'd',
			'е' => 'e',
			'є' => 'e',
			'ж' => 'zh',
			'з' => 'z',
			'и' => 'y',
			'і' => 'i',
			'ї' => 'i',
			'й' => 'j',
			'к' => 'k',
			'л' => 'l',
			'м' => 'm',
			'н' => 'n',
			'о' => 'o',
			'п' => 'p',
			'р' => 'r',
			'с' => 's',
			'т' => 't',
			'у' => 'u',
			'ф' => 'f',
			'х' => 'h',
			'ц' => 'c',
			'ч' => 'ch',
			'ш' => 'sh',
			'щ' => 'csh',
			'ь' => '',
			'ю' => 'yu',
			'я' => 'ya'
		);

		$output = str_replace( array_keys( $table ), array_values( $table ), $string );

		$output = preg_replace( '/\s+/ms', '-', $output );
		$output = preg_replace( '/[^a-z0-9\_\-.]+/mi', '', $output );
		$output = preg_replace( '#[\-]+#i', '-', $output );
		$output = strtolower( $output );

		if ( strlen( $output ) > 128 ) 
		{
			$output = substr( $output, 0, 128 );
			if ( ( $temp_max = strrpos( $output, '-' ) ) )
			{
				$output = substr($output, 0, $temp_max);
			}
		}
		elseif ( strrpos( $output, '-' ) == ( strlen( $output ) - 1 ) )
		{
			$output = substr( $output, 0, strlen( $output ) - 1 );
		}

		return $output;
	}

	/**
	 * Get main image of news
	 * 
	 * @static
	 * @access public
	 * @param sting $text of the item
	 * 
	 * @return string
	 */
	public static function getThumbImage( $text )
	{
		// Get main image of news
		$image = '';
		$pattern = '/(img|src)=("|\')[^"\'>]+/i'; 
		preg_match( $pattern, $text, $media );

		$pattern = '/(img|src)("|\'|="|=\')(.*)/i'; 
		$url = preg_replace( $pattern, "$3", $media[0] );

		$info = pathinfo( $url );
		if ( isset( $info['extension'] ) ) 
		{
			if ( ( $info['extension'] == 'jpg' ) ||
				( $info['extension'] == 'jpeg' ) ||
				( $info['extension'] == 'gif' ) ||
				( $info['extension'] == 'png' ) ) 
			{
				// Check for thumb variant of image
				$smal_image = str_replace( '/upload/image/', '/upload/_thumb/image/', $url );
				$dir = Yii::app( )->basePath . '/..';
				if ( file_exists( $dir . $smal_image ) )
				{
					$image = $smal_image;
				}
				else {
					$image = $url;
				}
			}
		}
		return $image;
	}
	
	/**
	 * Check if user already view this item
	 * and save view in session
	 * 
	 * @static
	 * @access public
	 * @param string $type name of logical block
	 * @param object $item 
	 * 
	 * @return boolean
	 */
	public static function isNewView( $type, $item )
	{
		$is_new = false;
		
		$session = Yii::app( )->session;
		$views = $session->get( 'views' );
		if ( empty( $views ) )
		{
			$views = array(
				$type => array( )
			);
		} 
		elseif ( empty( $views[$type] ) )
		{
			$views[$type] = array( );
		} 
		
		if ( !in_array( $item->id, $views[$type] ) ) 
		{
			array_push( $views[$type], $item->id );
			$is_new = true;
		}
		$session->add( 'views', $views );
		
		return $is_new;
	}

	/**
	 * Add gallery block to text of item
	 * 
	 * @static
	 * @access public
	 * @param strign $text of item 
	 * 
	 * @return string old text with gallery block
	 */
	public static function addGallery( $text )
	{
		$pattern = '#<img\s([^<>]*|[^</>]*)class=("|\')gallery("|\')([^<>]*|[^</>]*)(>|\/>)#Ui'; 
		preg_match_all( $pattern, $text, $media );
		
		$images = $media[0];
		
		if ( !empty( $images ) )
		{
			$images_url = array( );
			$pattern = '/(img|src)("|\'|="|=\')([^"\']*)/i'; 
			foreach ( $images AS $index => $image )
			{
				preg_match( $pattern, $image, $media );
				
				if ( !empty( $media[3] ) )
				{
					$info = pathinfo( $media[3] );
					if ( isset( $info['extension'] ) &&  
							( ( $info['extension'] == 'jpg' ) ||
							( $info['extension'] == 'jpeg' ) ||
							( $info['extension'] == 'gif' ) ||
							( $info['extension'] == 'png' ) ) )
					{
						$images_url[$index] = $media[3];	
					}
					else {
						unset( $images[$index] );
					}
				}
				else {
					unset( $images[$index] );
				}
			}
		}
		
		if ( !empty( $images ) )
		{
			$text = str_replace( $images, '', $text );
			$text = preg_replace( '#<p>\s*</p>#i', '', $text );
			
			$small_images_url = array( );
			foreach ( $images_url AS $index => $url )
			{
				$smal_image = str_replace( '/upload/image/', '/upload/_thumb/image/', $url );
				$dir = Yii::app( )->basePath . '/..';
				if ( file_exists( $dir . $smal_image ) )
				{
					$small_images_url[$index] = $smal_image;
				}
				else {
					$small_images_url[$index] = $url;
				}
			}
			
			$html = ''; 
			ob_start( );
			include Yii::app( )->theme->viewPath . '/html/gallery.php';
			$html = ob_get_contents( );
			ob_end_clean( );
			
			$text = '<div>'. $text .'</div>'. $html;
		}
		else {
			$text = '<div>'. $text .'</div>';
		}
				
		return $text;
	}

	/**
	 * Return block with social buttons
	 * 
	 * @static
	 * @access public
	 * @param string $section name of the section
	 * @param object $item current display item
	 * 
	 * @return string
	 */
	public static function getSocialButtons( $section, $item )
	{
		$html = ''; 
		
		ob_start( );
		include Yii::app( )->theme->viewPath . '/html/social_buttons.php';
		$html = ob_get_contents( );
		ob_end_clean( );
		
		return $html;
	}

	/**
	 * Return block with change rating buttons
	 * 
	 * @static
	 * @access public
	 * @param string $section name of the section
	 * @param object $item current display item
	 * 
	 * @return string
	 */
	public static function getRatingButtons( $section, $item )
	{
		$html = ''; 
		
		ob_start( );
		include Yii::app( )->theme->viewPath . '/html/rating_buttons.php';
		$html = ob_get_contents( );
		ob_end_clean( );
		
		return $html;
	}
	
	/**
	 * Return block with comments
	 * 
	 * @static
	 * @access public
	 * @param string $section name of the section
	 * @param object $item current display item
	 * 
	 * @return string
	 */
	public static function getCommentsBlock( $section, $item )
	{
		$html = '';		
		
		ob_start( );
		include Yii::app( )->theme->viewPath . '/html/comments.php';
		$html = ob_get_contents( );
		ob_end_clean( );
		
		return $html;
	}

}