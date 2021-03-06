<?php

class GroupController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('index','view','create','update','admin','delete', 'policy', 'plugin','device','deletepolicy','deleteplugin','deletedevice'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Group;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Group']))
		{
			$model->attributes=$_POST['Group'];
                        
                        
                                                
                        if($model->save())
				$this->redirect(array('view','id'=>$model->idGroup));
		}


		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Group']))
		{
			$model->attributes=$_POST['Group'];
			
                                                
                        if($model->save())
				$this->redirect(array('view','id'=>$model->idGroup));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
               
            
            $model = $this->loadModel($id);
            
            $model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

        /**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeletePolicy($id)
	{
                GroupPolicy::model()->findByPk($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
         /**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeletePlugin($id)
	{
                GroupPlugin::model()->findByPk($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
         /**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeleteDevice($id)
	{
                GroupDevice::model()->findByPk($id)->delete();

                
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Group');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Group('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Group']))
			$model->attributes=$_GET['Group'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

        
	/**
	 * Displays the Policy Manager
	 * @param integer $group the ID of the model to be deleted
	 */
	public function actionPolicy($group)
	{
                $groupmodel = $this->loadModel($group);
                
                $model=new GroupPolicy('search');
		$model->unsetAttributes();  // clear any default values
                $model->GroupID = $groupmodel->primaryKey;
                
		if(isset($_GET['GroupPolicy'])) 
                $model->attributes=$_GET['GroupPolicy'];
                
                if(isset($_POST['todelete']))
                {
                    //delete the seelcted items and refresh
                    $transaction = Yii::app()->db->beginTransaction();
                    try
                    {
                        foreach ($_POST['todelete'] as $id)
                        {
                            GroupPolicy::model()->findByPk($id)->delete();
                        }
                        
                        $transaction->commit();
                        Yii::app()->user->setFlash('success','The selected policies were removed from the group.');
                        $this->refresh();
                    } 
                    catch (Exception $e)
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error','The selected policies could not be removed from group!');
                        $this->refresh();
                    }
                }
                        
                        
		$this->render('policy',array(
			'model'=>$model,'group'=>$groupmodel,
		));
	}
        
        /**
	 * Displays the Plugin Manager
	 * @param integer $group the ID of the model to be deleted
	 */
	public function actionPlugin($group)
	{
                $groupmodel = $this->loadModel($group);
                
                $model=new GroupPlugin('search');
		$model->unsetAttributes();  // clear any default values
                $model->GroupID = $groupmodel->primaryKey;
                
		if(isset($_GET['GroupPlugin'])) 
                $model->attributes=$_GET['GroupPlugin'];
                
                if(isset($_POST['todelete']))
                {
                    //delete the seelcted items and refresh
                    $transaction = Yii::app()->db->beginTransaction();
                    try
                    {
                        foreach ($_POST['todelete'] as $id)
                        {
                            GroupPlugin::model()->findByPk($id)->delete();
                        }
                        
                        $transaction->commit();
                        Yii::app()->user->setFlash('success','The selected plugins were removed from the group.');
                        $this->refresh();
                    } 
                    catch (Exception $e)
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error','The selected plugins could not be removed from group!');
                        $this->refresh();
                    }
                }
                        
                        
		$this->render('plugin',array(
			'model'=>$model,'group'=>$groupmodel,
		));
	}
        
         /**
	 * Displays the Device Manager
	 * @param integer $group the ID of the model to be deleted
	 */
	public function actionDevice($group)
	{
		$groupmodel = $this->loadModel($group);
                
                $model=new GroupDevice('search');
		$model->unsetAttributes();  // clear any default values
                $model->GroupID = $groupmodel->primaryKey;
                
		if(isset($_GET['GroupDevice'])) 
                $model->attributes=$_GET['GroupDevice'];
                
                if(isset($_POST['todelete']))
                {
                    //delete the seelcted items and refresh
                    $transaction = Yii::app()->db->beginTransaction();
                    try
                    {
                        foreach ($_POST['todelete'] as $id)
                        {
                            GroupDevice::model()->findByPk($id)->delete();
                        }
                        
                        $transaction->commit();
                        Yii::app()->user->setFlash('success','The selected devices were removed from the group.');
                        $this->refresh();
                    } 
                    catch (Exception $e)
                    {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error','The selected devices could not be removed from group!');
                        $this->refresh();
                    }
                }
                        
                        
		$this->render('device',array(
			'model'=>$model,'group'=>$groupmodel,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Group::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='group-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
