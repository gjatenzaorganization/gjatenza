<?php

class MainStoryController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$pages=Page::model()->findAll('story_id=:story_id',array(':story_id'=>$id));	
		$cnt=Page::model()->count('story_id=:story_id',array(':story_id'=>$id));	
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'modelpages'=>$pages,
			'pagecnt'=>$cnt,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$mainstorys=MainStory::model()->findAll('delete_flag=:delete_flag', array(':delete_flag'=>'off'));	
		$this->render('index',array(
			//'model'=>$this->loadModel($id),
			'mainstorys'=>$mainstorys,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MainStory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MainStory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}
