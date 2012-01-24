<?php

class PollController extends AdminController {
    
    public function actionIndex() {
        $this->model = 'Poll';
        
        $rows = Poll::model()->findAll();
        $this->render('index', array('rows' => $rows));
    }

    public function actionEdit() {
        $this->model = 'Poll';
        
        $model = $this->loadModel();
        $form = new CForm('admin.views.poll.form', $model);

        if (is_null($model->id)) {
            $title = 'Нове голосування';
        } else {
            $title = $model->name;
        }
        $this->breadcrumbs = array(
            'Голосування' => '/admin/poll',
            $title
        );
        
        if (isset($_POST['Poll'])) {
            $model->attributes = $_POST['Poll'];
            
            if ($model->validate() && $model->save()) {
                if (isset($_POST['id']) && $_POST['id'] != 0) {
                    $msg = 'Голосування успішно оновлене.';
                } else {
                    $msg = 'Голосування успішно додане.';
                }
                Yii::app()->user->setFlash('info', $msg);
                Yii::app()->getRequest()->redirect('/admin/poll');
            }
        }

        $this->renderText($form);
    }
    
    public function actionPublish() {
        $this->model = 'Poll';
        
        if (isset($_POST['publish']) && $this->validateID($_POST['id']) ) {
            Poll::model()->updateByPk(
                $_POST['id'], array(
                    'publish' => abs($_POST['publish'] - 1),
                )
            );
        }

        Yii::app()->getRequest()->redirect('/admin/poll');
    }

    public function actionDelete() {
        $this->model = 'Poll';
        
        if (isset($_POST['delete']) && sizeof($_POST['delete']) > 0) {
            foreach ($_POST['delete'] as $id)
                Poll::model()->deleteByPk($id);

            Yii::app()->user->setFlash('info', 'Голосування видалені.');
        }

        Yii::app()->getRequest()->redirect('/admin/poll');
    }
    
    public function actionItems() {
        $poll_id = $_GET['poll-id'];
        $this->validateID($poll_id);
        
        $poll = Poll::model()->findByPk($poll_id);
        $rows = PollItems::model()->ordering()->findAllByAttributes(array('poll_id' => $poll_id));
        
        $this->render('items', array('rows' => $rows, 'poll' => $poll));
    }
    
    public function actionItemsEdit() {
        $poll_id = $_GET['poll-id'];
        $this->validateID($poll_id);
        $poll = Poll::model()->findByPk($poll_id);
                
        $this->model = 'PollItems';
        $model = $this->loadModel();
        $form = new CForm('admin.views.poll.item_form', $model);

        if (is_null($model->id)) {
            $title = 'Новий варіант';
        } else {
            $title = $model->name;
        }
        $this->breadcrumbs = array(
            'Голосування' => '/admin/poll',
            'Варіанти голосування: '.$poll->name => '/admin/poll/items/poll-id/'.$poll->id,
            $title
        );
        
        if (isset($_POST['PollItems'])) {
            $model->attributes = $_POST['PollItems'];
            
            if ($model->validate() && $model->save()) {
                if (isset($_POST['id']) && $_POST['id'] != 0) {
                    $msg = 'Варіант голосування успішно оновлений.';
                } else {
                    $msg = 'Варіант голосування успішно доданий.';
                }
                Yii::app()->user->setFlash('info', $msg);
                Yii::app()->getRequest()->redirect('/admin/poll/items/poll-id/'.$poll->id);
            }
        }

        $this->renderText($form);
    }
    
    public function actionItemsDelete() {
        $poll_id = $_GET['poll-id'];
        $this->validateID($poll_id);
        
        if (isset($_POST['delete']) && sizeof($_POST['delete']) > 0) {
            foreach ($_POST['delete'] as $id)
                PollItems::model()->deleteByPk($id);

            Yii::app()->user->setFlash('info', 'Варіанти голосування видалені.');
        }

        Yii::app()->getRequest()->redirect('/admin/poll/items/poll-id/'.$poll_id);
    }
    
    public function actionSaveOrder() {
        $order = $_POST['order'];
        $model = $_POST['model'];
        $poll_id = $_POST['poll_id'];

        if (!empty($order) && is_array($order)) {
            foreach ($order as $k => $value) {
                $record = $model::model()->findByPk($k);
                
                if ($record->ordering != $value) {
                    $record->ordering = $value;
                    $record->save();
                }
            }
        }

        if (!empty($poll_id) && $this->validateID($poll_id)) {
            $this->reorder($model, $poll_id);
            
            Yii::app()->user->setFlash('info', 'Новий порядок збережений.');
            Yii::app()->getRequest()->redirect('/admin/poll/items/poll-id/' . $poll_id);
        } else {
            $this->reorder($model);
            
            Yii::app()->user->setFlash('info', 'Новый порядок сохранен.');
            Yii::app()->getRequest()->redirect('/admin/poll');
        }
    }

    public function actionChangeOrder() {
        $id = $_POST['id'];
        $type = $_POST['type'];
        $model = $_POST['model'];
        $poll_id = $_POST['poll_id'];

        if (!empty($type) && $this->validateID($id)) {
            $record = $model::model()->findByPk($id);
            
            if ($type == 'up' && $record->ordering > 1) {
                $record->ordering -= 2;
                $record->save();
            } elseif ($type == 'down') {
                $record->ordering += 2;
                $record->save();
            }
        }

        if (!empty($poll_id) && $this->validateID($poll_id)) {
            $this->reorder($model, $poll_id);
            
            Yii::app()->getRequest()->redirect('/admin/poll/items/poll-id/' . $poll_id);
        } else {
            $this->reorder($model);
            
            Yii::app()->getRequest()->redirect('/admin/poll');
        }
    }

    private function reorder($model, $poll_id = null) {
        if (!empty($poll_id) && $this->validateID($poll_id)) {
            $rows = $model::model()->ordering()->findAll('poll_id=:poll_id', array('poll_id' => $poll_id));
        } else {
            $rows = $model::model()->ordering()->findAll();
        }

        if (!empty($rows)) {
            for ($i = 0, $n = count($rows); $i < $n; $i++) {
                if ($rows[$i]->ordering != $i + 1) {
                    $rows[$i]->ordering = $i + 1;
                    $rows[$i]->save();
                }
            }
        }

        return true;
    }
    
}