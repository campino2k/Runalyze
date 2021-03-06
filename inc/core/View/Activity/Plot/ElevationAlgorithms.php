<?php
/**
 * This file contains class::ElevationAlgorithms
 * @package Runalyze\View\Activity\Plot
 */

namespace Runalyze\View\Activity\Plot;

use Runalyze\View\Activity;
use Runalyze\View\Plot\Series as PlotSeries;
use Runalyze\Parameter\Application\ElevationMethod;
use Runalyze\Configuration;
use Runalyze\Data;
use Runalyze\Model\Trackdata;

/**
 * Plot for: Elevation algorithms
 * 
 * @author Hannes Christiansen
 * @package Runalyze\View\Activity\Plot
 */
class ElevationAlgorithms extends ActivityPlot {
	/**
	 * @var \Runalyze\View\Activity\Context
	 */
	protected $Context;

	/**
	 * Set key
	 */
	protected function setKey() {
		$this->key   = 'elevation-algorithms';
		$this->WIDTH = 490;
	}

	/**
	 * Init data
	 * @param \Runalyze\View\Activity\Context $context
	 */
	protected function initData(Activity\Context $context) {
		$this->Context = $context;

		$this->addSeries(new Series\Elevation($context), 1, false);

		if ($context->route()->hasCorrectedElevations() && $context->route()->hasOriginalElevations()) {
			$OriginalSeries = new Series\Elevation($context, true);
			$OriginalSeries->setColor('#ccc');
			$OriginalSeries->setLabel( __('Original data') );

			$this->addSeries($OriginalSeries, 1, false);
		}

		$this->addSeries($this->seriesForThreshold(), 1, false);
		$this->addSeries($this->seriesForDouglasPeucker(), 1, false);

		foreach (array_keys($this->Plot->Data) as $key) {
			$this->Plot->Data[$key]['curvedLines'] = array('apply' => false);
		}
	}

	/**
	 * @return \Runalyze\View\Plot\Series
	 */
	protected function seriesForThreshold() {
		$Series = new PlotSeries();
		$Series->setColor('#008');
		$Series->setLabel(__('Threshold'));
		$Series->setData($this->constructPlotDataFor(ElevationMethod::THRESHOLD));

		return $Series;
	}

	/**
	 * @return \Runalyze\View\Plot\Series
	 */
	protected function seriesForDouglasPeucker() {
		$Series = new PlotSeries();
		$Series->setColor('#800');
		$Series->setLabel(__('Douglas-Peucker'));
		$Series->setData($this->constructPlotDataFor(ElevationMethod::DOUGLAS_PEUCKER));

		return $Series;
	}

	/**
	 * Construct plot data
	 * @param enum $algorithm
	 * @param int $treshold
	 * @return array
	 */
	protected function constructPlotDataFor($algorithm, $treshold = false) {
		$Method = new ElevationMethod();
		$Method->set($algorithm);

		if ($treshold === false) {
			$treshold = Configuration::ActivityView()->elevationMinDiff();
		}

		$Calculator = new Data\Elevation\Calculation\Calculator($this->Context->route()->elevations());
		$Calculator->setMethod($Method);
		$Calculator->setThreshold($treshold);
		$Calculator->calculate();

		$i = 0;
		$Points = $Calculator->strategy()->smoothedData();
		$Indices = $Calculator->strategy()->smoothingIndices();
		$hasDistances = $this->Context->trackdata()->get(Trackdata\Object::DISTANCE);
		$Distances = $this->Context->trackdata()->get(Trackdata\Object::DISTANCE);
		$Times = $this->Context->trackdata()->get(Trackdata\Object::TIME);
		$num = $this->Context->trackdata()->num();

		foreach ($Indices as $i => $index) {
			if ($index >= $num) {
				$index = $num - 1;
			}

			if ($hasDistances) {
				$Data[(string)$Distances[$index]] = $Points[$i];
			} else {
				$Data[(string)$Times[$index].'000'] = $Points[$i];
			}
		}

		return $Data;
	}
}