<?php
/**
 * File for TranslitHelper class
 */

/**
 * TranslitHelper is class which provides the methods for site
 * @static
 */
abstract class TranslitHelper 
{
	/**
	 * Function convert cyrillic letters to latin
	 * 
	 * @param sting input data
	 * @return string result of converting
	 */
	public static function perform( $string ) 
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

}
