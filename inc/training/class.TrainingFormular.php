<?php
/**
 * This file contains class::TrainingFormular
 * @package Runalyze\DataObjects\Training
 */

use Runalyze\Configuration;

/**
 * Formular for trainings
 *
 * This training formular extends StandardFormular and can be used for creating
 * a new training as well as for editing an existing training.
 *
 * Nearly all fields are set directly through the given DatabaseScheme for a training.
 * This class only extends the standard formular with some additional values
 * (e.g. created-timestamp) and additional fieldsets for adding gps-data etc.
 *
 * @author Hannes Christiansen
 * @package Runalyze\DataObjects\Training
 */
class TrainingFormular extends StandardFormular {
	/**
	 * CSS class for inputs only for running
	 * @var string
	 */
	static public $ONLY_RUNNING_CLASS = "only-running";

	/**
	 * CSS class for inputs only for not running
	 * @var string
	 */
	static public $ONLY_NOT_RUNNING_CLASS = "only-not-running";

	/**
	 * CSS class for inputs only for sports outside
	 * @var string
	 */
	static public $ONLY_OUTSIDE_CLASS = "only-outside";

	/**
	 * CSS class for inputs only for sports with types
	 * @var string
	 */
	static public $ONLY_TYPES_CLASS = "only-types";

	/**
	 * CSS class for inputs only for sports with distance
	 * @var string
	 */
	static public $ONLY_DISTANCES_CLASS = "only-distances";

	/**
	 * CSS class for inputs only for sports with power
	 * @var string
	 */
	static public $ONLY_POWER_CLASS = "only-power";

	/**
	 * Prepare for display
	 */
	protected function prepareForDisplayInSublcass() {
		parent::prepareForDisplayInSublcass();

		if ($this->submitMode == StandardFormular::$SUBMIT_MODE_EDIT) {
			$this->addOldObjectData();
			$this->initElevationCorrectionFieldset();
			$this->initDeleteFieldset();

			if (Request::param('mode') == 'multi') {
				$this->addHiddenValue('mode', 'multi');
				$this->submitButtons['submit'] = __('Edit and continue');
			}
		}

		$this->appendJavaScript();
	}

	/**
	 * Display after submit
	 */
	protected function displayAfterSubmit() {
		if ($this->submitMode == StandardFormular::$SUBMIT_MODE_CREATE) {
			$this->displayHeader();
			echo HTML::okay( __('The activity has been successfully created.') );
			echo Ajax::closeOverlay();

			if (Configuration::ActivityForm()->showActivity())
				echo Ajax::wrapJS('Runalyze.Training.load('.$this->dataObject->id().');');
		} else {
			if (Request::param('mode') == 'multi') {
				echo Ajax::wrapJS('Runalyze.goToNextMultiEditor();');
			} else {
				parent::displayAfterSubmit();
			}
		}
	}

	/**
	 * Add old object
	 */
	protected function addOldObjectData() {
		$this->addHiddenValue('old-data', base64_encode(serialize($this->dataObject->getArray())));
	}

	/**
	 * Display fieldset: Delete training
	 */
	protected function initDeleteFieldset() {
		$DeleteText = '<strong>'.__('Permanently delete this activity').' &raquo;</strong>';
		$DeleteUrl  = $_SERVER['SCRIPT_NAME'].'?delete='.$this->dataObject->id();
		$DeleteLink = Ajax::link($DeleteText, 'ajax', $DeleteUrl);

		$Fieldset = new FormularFieldset( __('Delete activity') );
		$Fieldset->addWarning($DeleteLink);
		$Fieldset->setCollapsed();

		$this->addFieldset($Fieldset);
	}

	/**
	 * Init fieldset for correct elevation
	 */
	protected function initElevationCorrectionFieldset() {
		// TODO: Elevation correction is currently only available with a route object, not for the activity object
		return;

		if ($this->dataObject->get('elevation_corrected') == 1)
			return;

		$Fieldset = new FormularFieldset( __('Use elevation correction') );
		$Fieldset->setConfValueToSaveStatus('ELEVATION');

		$Fieldset->addInfo('
			<a class="ajax" target="gps-results" href="call/call.Training.elevationCorrection.php?id='.$this->dataObject->id().'"><strong>'.__('Correct elevation data').'</strong></a><br>
			<br>
			<small id="gps-results" class="block">
				'.__('Elevation data via GPS is very inaccurate. Therefore you can correct it via some satellite data.').'
			</small>');

		$this->addFieldset($Fieldset);
	}

	/**
	 * Append JavaScript
	 */
	protected function appendJavaScript() {
		echo '<script type="text/javascript">';
		include FRONTEND_PATH . '../lib/jquery.form.include.php';
		echo '</script>';
	}
}
