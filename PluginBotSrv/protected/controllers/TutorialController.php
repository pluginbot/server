<?php

class TutorialController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','watch'),
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $model=new Tutorial('search');
               $model->unsetAttributes();  // clear any default values
               if(isset($_GET['Tutorial']))
                   $model->attributes=$_GET['Tutorial'];

               $this->render('index',array(
                   'model'=>$model,
               ));
	}

        /**
         * Watch Tutorials
         */
        public function actionWatch($path)
	{
		$this->layout='fancybox';
		$model = Tutorial::model()->find('Path = :path', array(':path'=>$path));
		
                //if($model===null) throw new CHttpException(404,'The requested page does not exist.');
                if($model===null)
                {
                    $this->render('notfound',array('model'=>$model));
                }
                else
                {
                   $this->render('watch',array('model'=>$model)); 
                }
		
	}
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Tutorial::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
  
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tutorial-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
