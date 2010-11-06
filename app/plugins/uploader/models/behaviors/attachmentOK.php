<?php
/** 
 * Attachment Behavior
 *
 * A CakePHP Behavior that attaches a file to a model, and uploads automatically, then stores a value in the database.
 *
 * @author 		Miles Johnson - www.milesj.me
 * @copyright	Copyright 2006-2009, Miles Johnson, Inc.
 * @license 	http://www.opensource.org/licenses/mit-license.php - Licensed under The MIT License
 * @link		www.milesj.me/resources/script/uploader-plugin
 */
 
App::import('Component', array('Uploader.Uploader', 'Uploader.S3Transfer'));

class AttachmentBehavior extends ModelBehavior { 

	/**
	 * Files that have been uploaded / attached; used for fallback functions.
	 *
	 * @access private
	 * @var array
	 */
	private $__attached = array();
	
	/**
	 * All user defined attachments; images => model.
	 *
	 * @access private
	 * @var array
	 */
	private $__attachments = array();
	
	/**
	 * The default settings for attachments.
	 *
	 * @access private
	 * @var array
	 */
	private $__defaults = array(
		'uploadDir' 	=> null,
		'dbColumn'		=> 'uploadPath',
		'maxNameLength' => null,
		'overwrite'		=> true,
		'name'			=> null,
		'transforms'	=> array(),
		's3'			=> array()
	);

	/**
	 * Initialize uploader and save attachments.
	 *
	 * @access public
	 * @uses UploaderComponent
	 * @param object $Model
	 * @param array $settings
	 * @return boolean
	 */
	public function setup(&$Model, $settings = array()) {
		$this->Uploader = new UploaderComponent();
		$this->S3Transfer = new S3TransferComponent();
		
		if (!empty($settings) && is_array($settings)) {
			foreach ($settings as $field => $attachment) {
				$this->__attachments[$Model->alias][$field] = array_merge($this->__defaults, $attachment);
			}
		}
	}
	
	/**
	 * Deletes any files that have been attached to this model.
	 *
	 * @access public
	 * @param object $Model
	 * @return boolean
	 */
	public function beforeDelete(&$Model) {
		$data = $Model->read(null, $Model->id);
		
		if (!empty($data[$Model->alias])) {
			foreach ($data[$Model->alias] as $field => $value) {
				if (strpos($value, 's3.amazonaws.com') !== false) {
					$this->S3Transfer->delete($value);
					
				} else if (is_file(WWW_ROOT . $value)) {
					$this->Uploader->delete($value);
				}
			}
		}
		
		return true;
	}
	
	/**
	 * Before saving the data, try uploading the image, if successful save to database.
	 *
	 * @access public
	 * @param object $Model
	 * @return boolean
	 */
	public function beforeSave(&$Model) {
		$this->Uploader->initialize($Model);
		$this->Uploader->startup($Model);
		
		if (!empty($Model->data[$Model->alias])) {
			foreach ($Model->data[$Model->alias] as $file => $data) {
				if (isset($this->__attachments[$Model->alias][$file])) {
					$attachment = $this->__attachments[$Model->alias][$file];
					$options = array();
					$s3 = false;

					// S3
					if (!empty($attachment['s3'])) {
						if (!empty($attachment['s3']['bucket']) && !empty($attachment['s3']['accessKey']) && !empty($attachment['s3']['secretKey'])) {
							$this->S3Transfer->bucket = $attachment['s3']['bucket'];
							$this->S3Transfer->accessKey = $attachment['s3']['accessKey'];
							$this->S3Transfer->secretKey = $attachment['s3']['secretKey'];

							if (isset($attachment['s3']['useSsl']) && is_bool($attachment['s3']['useSsl'])) {
								$this->S3Transfer->useSsl = $attachment['s3']['useSsl'];
							}

							$this->S3Transfer->startup($Model);
							$s3 = true;
						} else {
							trigger_error('Uploader.Attachment::beforeSave(): To use the S3 transfer, you must supply an accessKey, secretKey and bucket.', E_USER_WARNING);
						}
					}

					// Uploader
					if (!empty($attachment['uploadDir'])) {
						$this->Uploader->uploadDir = $attachment['uploadDir'];
					}
					
					if (is_numeric($attachment['maxNameLength'])) {
						$this->Uploader->maxNameLength = $attachment['maxNameLength'];
					}
					
					if (is_bool($attachment['overwrite'])) {
						$options['overwrite'] = $attachment['overwrite'];
					}
					
					if (!empty($attachment['name'])) {
						$options['name'] = $attachment['name'];
					}

					if ($data['error'] == UPLOAD_ERR_NO_FILE) {
						continue;
					}

					// Upload file and attache to model data
					if ($data = $this->Uploader->upload($file, $options)) {
						$basePath = $data['path'];

						if ($s3 === true) {
							$basePath = $this->S3Transfer->transfer($basePath);
						}

						$Model->data[$Model->alias][$attachment['dbColumn']] = $basePath;
						$this->__attached[$file][$attachment['dbColumn']] = $basePath;
						
						// Apply transformations
						if (!empty($attachment['transforms'])) {
							foreach ($attachment['transforms'] as $method => $options) {
								if (is_array($options) && isset($options['dbColumn'])) {
									if (isset($options['method'])) {
										$method = $options['method'];
										unset($options['method']);
									}

									if (!method_exists($this->Uploader, $method)) {
										trigger_error('Uploader.Attachment::beforeSave(): "'. $method .'" is not a defined transformation method.', E_USER_WARNING);
										return false;
									}
									
									if ($path = $this->Uploader->$method($options)) {
										if ($s3 === true) {
											$path = $this->S3Transfer->transfer($path);
										}

										$Model->data[$Model->alias][$options['dbColumn']] = $path;
										$this->__attached[$file][$options['dbColumn']] = $path;
									
										// Delete original if same column name
										if ($options['dbColumn'] == $attachment['dbColumn']) {
											if ($s3 === true) {
												$this->S3Transfer->delete($basePath);
											} else {
												$this->Uploader->delete($basePath);
											}
										}
										
									} else {
										$this->__deleteAttached($file);
										$Model->validationErrors[$file] = sprintf(__('An error occured during "%s" transformation!', true), $method);
										return false;
									}
								}
							}
						}
						
					} else {
						$Model->validationErrors[$file] = __('There was an error attaching this file!', true);
						return false;
					}
				}
			}
		}
		
		return true;
	}
	
	/**
	 * Applies dynamic settings to an attachment.
	 *
	 * @access public
	 * @param string $model
	 * @param string $file
	 * @param array $settings
	 * @return void
	 */
	public function update($model, $file, $settings) {
		if (isset($this->__attachments[$model][$file])) {
			$this->__attachments[$model][$file] = array_merge($this->__attachments[$model][$file], $settings);
		}
	}
	
	/**
	 * Delete all attached images if attaching fails midway.
	 * 
	 * @access private
	 * @param string $file
	 * @return void
	 */
	private function __deleteAttached($file) {
		if (!empty($this->__attached[$file])) {
			foreach ($this->__attached[$file] as $column => $path) {
				if (strpos($path, 's3.amazonaws.com') !== false) {
					$this->S3Transfer->delete($path);

				} else {
					$this->Uploader->delete($path);
				}
			}
		}
	}
	
}
