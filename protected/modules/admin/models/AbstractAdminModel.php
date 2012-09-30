<?php
/**
 * Contains abstract model for admin module
 */
/**
 * Abstract Admin Model class
 */
abstract class AbstractAdminModel extends CActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function __construct($scenario = 'insert')
    {
        parent::__construct($scenario);

        // TODO : read more about that
        //$this->attachEventHandler( 'beforeSave', '' );
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        // TODO : do something with it
        return array(
            array('title, description', 'required'),
            array('title, alias, description, parent_id, state, section, params, metakey, metadesc, metadata', 'safe'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        // TODO : do something with it
        return array(
            'title' => Yii::t('main', 'TITLE'),
            'alias' => Yii::t('main', 'ALIAS'),
            'body' => Yii::t('main', 'TEXT'),
            'publish' => Yii::t('main', 'PUBLISH'),
            'frontpage' => Yii::t('main', 'FEATURED'),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function beforeSave()
    {
        $allowedActions = array('insert', 'update');
        if (in_array($this->getScenario(), $allowedActions))
        {
            $this->modified_at = date('Y-m-d H:i:s');
            $this->modified_by = Yii::app()->user->id;

            if ($this->isNewRecord || empty($this->created_at))
            {
                $this->created_at = $this->modified_at;
            }
            if ($this->isNewRecord || empty($this->created_by))
            {
                $this->created_by = $this->modified_by;
            }

            // TODO : always need to use this class
            if (!$this->alias)
            {
                $this->alias = TranslitHelper::perform($this->title);
            }
            else
            {
                $this->alias = TranslitHelper::perform($this->alias);
            }
        }

        return parent::beforeSave();
    }

}
