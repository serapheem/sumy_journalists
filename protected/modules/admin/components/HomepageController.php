<?php
/**
 * 
 */

/**
 * Home page Controller Class
 */
class HomepageController extends AdminAbstractController
{
    /**
     * Displays edit form and save changes
     * 
     * @access public
     * 
     * @return void
     */
    public function actionEdit()
    {
        $model_name = strtolower($this->model);

        $model = $this->loadModel();
        $form = new CForm("admin.views.{$model_name}.form", $model);

        if (is_null($model->id))
        {
            $title = Yii::t($model_name, 'NEW_ITEM');
        }
        else
        {
            $title = $model->title;
        }
        $this->breadcrumbs = array(
            Yii::t($model_name, 'SECTION_NAME') => '/admin/' . $model_name,
            $title
        );

        $frontpage = null;
        if ($model->id)
        {
            $frontpage = Frontpage::model()
                ->findByAttributes(array(
                'section' => $this->model,
                'item_id' => $model->id
                ));
            if ($frontpage)
            {
                $model->frontpage = 1;
            }
        }
        if (!isset($model->frontpage))
        {
            $model->frontpage = 0;
        }

        if (isset($_POST[$this->model]))
        {
            $model->attributes = $_POST[$this->model];

            if ($model->validate() && $model->save())
            {
                // Add or delete news from front page
                if ($model->frontpage && is_null($frontpage))
                {
                    $frontpage_model = new Frontpage( );
                    $frontpage_model->section = $this->model;
                    $frontpage_model->item_id = $model->id;
                    if ($frontpage_model->validate())
                    {
                        $frontpage_model->save();
                    }
                }
                elseif (!$model->frontpage)
                {
                    Frontpage::model()
                        ->deleteAllByAttributes(array(
                            'section' => $this->model,
                            'item_id' => $model->id
                        ));
                }

                if (isset($_REQUEST['id']) && $_REQUEST['id'])
                {
                    $msg = Yii::t($model_name, 'ITEM_UPDATED');
                }
                else
                {
                    $msg = Yii::t($model_name, 'ITEM_ADDED');
                }
                Yii::app()->user->setFlash('info', $msg);

                if (!empty($_POST['save']) || ( empty($_POST['save']) && empty($_POST['apply']) ))
                {
                    Yii::app()
                        ->getRequest()
                        ->redirect('/admin/' . $model_name);
                }
                else
                {
                    Yii::app()
                        ->getRequest()
                        ->redirect("/admin/{$model_name}/edit?id=" . $model->id);
                }
            }
        }

        $this->renderText($form);
        return true;
    }

}
