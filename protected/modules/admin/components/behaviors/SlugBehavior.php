<?php
/**
 * Contains SlugBehavior class
 *
 * @author      Serhiy Hlushko <serhiy.hlushko@gmail.com>
 * @copyright   Copyright 2013 Hlushko inc.
 * @company     Hlushko inc.
 */

/**
 * SlugBehavior will automatically fill slug attribute based on title attribute
 */
class SlugBehavior extends CActiveRecordBehavior
{
    /**
     * @var string The name of the attribute to store the slug value. 
     * Defaults to 'slug'
     */
    public $slugAttribute = 'slug';

    /**
     * @var string The name of the attribute to get data for slug attribute. 
     * Defaults to 'title'
     */
    public $titleAttribute = 'title';

    /**
     * @var int The max possible length of the slug attribute. 
     * Defaults to 255
     */
    public $maxLength = 255;

    /**
     * Responds to {@link CActiveRecord::onBeforeSave} event.
     * Sets the values of the slug attribute
     *
     * @param CModelEvent $event event parameter
     */
    public function beforeSave(CModelEvent $event)
    {
        if ($this->getOwner()->{$this->slugAttribute}) {
            $this->getOwner()->{$this->slugAttribute} = $this->translit($this->getOwner()->{$this->slugAttribute});
        } else {
            $this->getOwner()->{$this->slugAttribute} = $this->translit($this->getOwner()->{$this->titleAttribute});
        }
    }

    /**
     * Function convert cyrillic letters to latin
     * @param string $input data
     *
     * @return string result of converting
     */
    public function translit($input)
    {
        $table = array(
//            'А' => 'A',
//            'Б' => 'B',
//            'В' => 'V',
//            'Г' => 'G',
//            'Ґ' => 'G',
//            'Д' => 'D',
//            'Е' => 'E',
//            'Є' => 'E',
//            'Ж' => 'ZH',
//            'З' => 'Z',
//            'И' => 'Y',
//            'І' => 'I',
//            'Ї' => 'I',
//            'Й' => 'J',
//            'К' => 'K',
//            'Л' => 'L',
//            'М' => 'M',
//            'Н' => 'N',
//            'О' => 'O',
//            'П' => 'P',
//            'Р' => 'R',
//            'С' => 'S',
//            'Т' => 'T',
//            'У' => 'U',
//            'Ф' => 'F',
//            'Х' => 'H',
//            'Ц' => 'C',
//            'Ч' => 'CH',
//            'Ш' => 'SH',
//            'Щ' => 'CSH',
//            'Ь' => '',
//            'Ю' => 'YU',
//            'Я' => 'YA',
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

        $output = str_replace(array_keys($table), array_values($table), mb_strtolower($input, 'utf-8'));

        $output = preg_replace('/\s+/ms', '-', $output);
        $output = preg_replace('/[^a-z0-9\_\-.]+/mi', '', $output);
        $output = preg_replace('#[\-]+#i', '-', $output);

        if (strlen($output) > $this->maxLength) {
            $output = substr($output, 0, $this->maxLength);
            if ($tempMax = strrpos($output, '-')) {
                $output = substr($output, 0, $tempMax);
            }
        } elseif (strrpos($output, '-') == (strlen($output) - 1)) {
            $output = substr($output, 0, strlen($output) - 1);
        }

        return $output;
    }

}