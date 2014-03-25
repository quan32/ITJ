<?php
class Source extends AppModel{
	public $belongsTo = array(
		'Lecture' => array(
			'className' => 'Lecture',
			'foreignKey' => 'lecture_id'
			)
		);

	public $validate = array(
		'filename' => array(
			// http://book.cakephp.org/2.0/en/models/data-validation.html#Validation::uploadError
			'uploadError' => array(
				'rule' => 'uploadError',
				'message' => 'アップロードするとき、エラーが起きてしまった。',
				'required' => FALSE,
				'allowEmpty' => TRUE,
			),
			// http://book.cakephp.org/2.0/en/models/data-validation.html#Validation::mimeType
			'mimeType' => array(
				'rule' => array('mimeType', array('image/gif','image/png','image/jpg','image/jpeg',
					'text/tab-separated-values','video/x-flv','audio/mp4', 'audio/mpeg3','audio/mp3','audio/mpeg', 'audio/x-mpeg-3', 'video/mpeg', 'video/x-mpeg')),
				'message' => '不当なファイル',
				'required' => FALSE,
				'allowEmpty' => TRUE,
			),
			// custom callback to deal with the file upload
				'rule' => 'processUpload',
				'message' => 'プロセスするとき、エラーが起きてしまった。',
				'required' => FALSE,
				'allowEmpty' => TRUE,
				'last' => TRUE,
			)
		);

	/**
	 * Upload Directory relative to WWW_ROOT
	 * @param string
	 */
	public $uploadDir = 'uploads';

	/**
	 * Before Validation Callback
	 * @param array $options
	 * @return boolean
	 */
	public function beforeValidate($options = array()) {
		// ignore empty file - causes issues with form validation when file is empty and optional
		if (!empty($this->data[$this->alias]['filename']['error']) && $this->data[$this->alias]['filename']['error']==4 && $this->data[$this->alias]['filename']['size']==0) {
			unset($this->data[$this->alias]['filename']);
		}

		return parent::beforeValidate($options);
	}

	/**
	 * Before Save Callback
	 * @param array $options
	 * @return boolean
	 */
	public function beforeSave($options = array()) {
		// a file has been uploaded so grab the filepath
		if (!empty($this->data[$this->alias]['filepath'])) {
			$this->data[$this->alias]['filename'] = $this->data[$this->alias]['filepath'];
		}

		return parent::beforeSave($options);
	}

	/**
	 * Process the Upload
	 * @param array $check
	 * @return boolean
	 */
	public function processUpload($check=array()) {
		$rdnumber=rand(1,1000000).'_';
		// deal with uploaded file
		if (!empty($check['filename']['tmp_name'])) {

			// check file is uploaded
			if (!is_uploaded_file($check['filename']['tmp_name'])) {
				return FALSE;
			}

			// build full filename
			// $filename = WWW_ROOT . $this->uploadDir . DS . Inflector::slug(pathinfo($check['filename']['name'], PATHINFO_FILENAME)).'.'.pathinfo($check['filename']['name'], PATHINFO_EXTENSION);
			$filename =$rdnumber.Inflector::slug(pathinfo($check['filename']['name'], PATHINFO_FILENAME)).'.'.pathinfo($check['filename']['name'], PATHINFO_EXTENSION);
			$fullpath = WWW_ROOT . $this->uploadDir . DS .$rdnumber. Inflector::slug(pathinfo($check['filename']['name'], PATHINFO_FILENAME)).'.'.pathinfo($check['filename']['name'], PATHINFO_EXTENSION);
			// @todo check for duplicate filename

			// try moving file
			if (!move_uploaded_file($check['filename']['tmp_name'], $fullpath)) {
				return FALSE;

			// file successfully uploaded
			} else {
				// save the file path relative from WWW_ROOT e.g. uploads/example_filename.jpg
				$this->data[$this->alias]['filepath'] = $filename;
			}
		}

		return TRUE;
	}
}

?>