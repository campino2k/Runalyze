<?php
/**
 * This file contains class::Object
 * @package Runalyze\Model\Activity
 */

namespace Runalyze\Model\Activity;

use Runalyze\Model;
use Runalyze\Model\Activity\Partner;
use Runalyze\Model\Activity\Splits;
use Runalyze\Model\Activity\Clothes;

use Runalyze\Data\Weather;

/**
 * Activity object
 *
 * @author Hannes Christiansen
 * @package Runalyze\Model\Activity
 */
class Object extends Model\ObjectWithID {
	/**
	 * Key: timestamp
	 * @var string
	 */
	const TIMESTAMP = 'time';

	/**
	 * Key: timestamp created
	 * @var string
	 */
	const TIMESTAMP_CREATED = 'created';

	/**
	 * Key: timestamp last edit
	 * @var string
	 */
	const TIMESTAMP_EDITED = 'edited';

	/**
	 * Key: sportid
	 * @var string
	 */
	const SPORTID = 'sportid';

	/**
	 * Key: typeid
	 * @var string
	 */
	const TYPEID = 'typeid';

	/**
	 * Key: is public
	 * @var string
	 */
	const IS_PUBLIC = 'is_public';

	/**
	 * Key: is track
	 * @var string
	 */
	const IS_TRACK = 'is_track';

	/**
	 * Key: distance
	 * @var string
	 */
	const DISTANCE = 'distance';

	/**
	 * Key: time in seconds
	 * @var string
	 */
	const TIME_IN_SECONDS = 's';

	/**
	 * Key: elapsed time
	 * @var string
	 */
	const ELAPSED_TIME = 'elapsed_time';

	/**
	 * Key: elevation
	 * @var string
	 */
	const ELEVATION = 'elevation';

	/**
	 * Key: calories
	 * @var string
	 */
	const CALORIES = 'kcal';

	/**
	 * Key: average heart rate
	 * @var string
	 */
	const HR_AVG = 'pulse_avg';

	/**
	 * Key: maximal heart rate
	 * @var string
	 */
	const HR_MAX = 'pulse_max';

	/**
	 * Key: vdot
	 * @var string
	 */
	const VDOT = 'vdot';

	/**
	 * Key: vdot by time
	 * @var string
	 */
	const VDOT_BY_TIME = 'vdot_by_time';

	/**
	 * Key: vdot with elevation
	 * @var string
	 */
	const VDOT_WITH_ELEVATION = 'vdot_with_elevation';

	/**
	 * Key: use vdot
	 * @var string
	 */
	const USE_VDOT = 'use_vdot';

	/**
	 * Key: jd intensity
	 * @var string
	 */
	const JD_INTENSITY = 'jd_intensity';

	/**
	 * Key: trimp
	 * @var string
	 */
	const TRIMP = 'trimp';

	/**
	 * Key: cadence
	 * @var string
	 */
	const CADENCE = 'cadence';

	/**
	 * Key: power
	 * @var string
	 */
	const POWER = 'power';

	/**
	 * Key: ground contact time
	 * @var string
	 */
	const GROUNDCONTACT = 'groundcontact';

	/**
	 * Key: vertical oscillation
	 * @var string
	 */
	const VERTICAL_OSCILLATION = 'vertical_oscillation';

	/**
	 * Key: temperature
	 * @var string
	 */
	const TEMPERATURE = 'temperature';

	/**
	 * Key: weather id
	 * @var string
	 */
	const WEATHERID = 'weatherid';

	/**
	 * Key: route id
	 * @var string
	 */
	const ROUTEID = 'routeid';

	/**
	 * Key: route
	 * @var string
	 * @deprecated
	 */
	const ROUTE = 'route';

	/**
	 * Key: clothes
	 * @var string
	 */
	const CLOTHES = 'clothes';

	/**
	 * Key: splits
	 * @var string
	 */
	const SPLITS = 'splits';

	/**
	 * Key: comment
	 * @var string
	 */
	const COMMENT = 'comment';

	/**
	 * Key: partner
	 * @var string
	 */
	const PARTNER = 'partner';

	/**
	 * Key: running drills
	 * @var string
	 */
	const RUNNING_DRILLS = 'abc';

	/**
	 * Key: shoe id
	 * @var string
	 */
	const SHOEID = 'shoeid';

	/**
	 * Key: notes
	 * @var string
	 */
	const NOTES = 'notes';

	/**
	 * Key: creator
	 * @var string
	 */
	const CREATOR = 'creator';

	/**
	 * Key: creator details
	 * @var string
	 */
	const CREATOR_DETAILS = 'creator_details';

	/**
	 * Key: garmin activity id
	 * @var string
	 */
	const GARMIN_ACTIVITY_ID = 'activity_id';

	/**
	 * Weather
	 * @var \Runalyze\Data\Weather
	 */
	protected $Weather = null;

	/**
	 * Splits
	 * @var \Runalyze\Model\Activity\Clothes\Object
	 */
	protected $Clothes = null;

	/**
	 * Splits
	 * @var \Runalyze\Model\Activity\Splits\Object
	 */
	protected $Splits = null;

	/**
	 * Partner
	 * @var \Runalyze\Model\Activity\Partner
	 */
	protected $Partner = null;

	/**
	 * All properties
	 * @return array
	 */
	static public function allProperties() {
		return array(
			self::TIMESTAMP,
			self::TIMESTAMP_CREATED,
			self::TIMESTAMP_EDITED,
			self::SPORTID,
			self::TYPEID,
			self::IS_PUBLIC,
			self::IS_TRACK,
			self::DISTANCE,
			self::TIME_IN_SECONDS,
			self::ELAPSED_TIME,
			self::ELEVATION,
			self::CALORIES,
			self::HR_AVG,
			self::HR_MAX,
			self::VDOT,
			self::VDOT_BY_TIME,
			self::VDOT_WITH_ELEVATION,
			self::USE_VDOT,
			self::JD_INTENSITY,
			self::TRIMP,
			self::CADENCE,
			self::POWER,
			self::GROUNDCONTACT,
			self::VERTICAL_OSCILLATION,
			self::TEMPERATURE,
			self::WEATHERID,
			self::ROUTEID,
			self::ROUTE,
			self::CLOTHES,
			self::SPLITS,
			self::COMMENT,
			self::PARTNER,
			self::RUNNING_DRILLS,
			self::SHOEID,
			self::NOTES,
			self::CREATOR,
			self::CREATOR_DETAILS,
			self::GARMIN_ACTIVITY_ID
		);
	}

	/**
	 * Properties
	 * @return array
	 */
	public function properties() {
		return static::allProperties();
	}

	/**
	 * Can set key?
	 * @param string $key
	 * @return boolean
	 */
	protected function canSet($key) {
		switch ($key) {
			case self::TEMPERATURE:
			case self::WEATHERID:
			case self::PARTNER:
			case self::CLOTHES:
			case self::SPLITS:
				return false;
		}

		return true;
	}

	/**
	 * Can be null?
	 * @param string $key
	 * @return boolean
	 */
	protected function canBeNull($key) {
		if ($key == self::TEMPERATURE) {
			return true;
		}

		return false;
	}

	/**
	 * Get value for this key
	 * @param string $key
	 * @return mixed
	 */
	public function get($key) {
		if ($key == self::TEMPERATURE) {
			return $this->Data[self::TEMPERATURE];
		}

		return parent::get($key);
	}

	/**
	 * Synchronize
	 */
	public function synchronize() {
		parent::synchronize();

		$this->Data[self::TEMPERATURE] = $this->weather()->temperature()->value();
		$this->Data[self::WEATHERID] = $this->weather()->condition()->id();
		$this->Data[self::CLOTHES] = $this->clothes()->asString();
		$this->Data[self::SPLITS] = $this->splits()->asString();
		$this->Data[self::PARTNER] = $this->partner()->asString();
	}

	/**
	 * Timestamp
	 * @return int
	 */
	public function timestamp() {
		return $this->Data[self::TIMESTAMP];
	}

	/**
	 * Sportid
	 * @return int
	 */
	public function sportid() {
		return $this->Data[self::SPORTID];
	}

	/**
	 * Typeid
	 * @return int
	 */
	public function typeid() {
		return $this->Data[self::TYPEID];
	}

	/**
	 * Type
	 * @return \Type
	 */
	public function type() {
		return new \Type($this->Data[self::TYPEID]);
	}

	/**
	 * Is public?
	 * @return boolean
	 */
	public function isPublic() {
		return ($this->Data[self::IS_PUBLIC] == 1);
	}

	/**
	 * On track?
	 * @return boolean
	 */
	public function isTrack() {
		return ($this->Data[self::IS_TRACK] == 1);
	}

	/**
	 * Distance
	 * @return float [km]
	 */
	public function distance() {
		return $this->Data[self::DISTANCE];
	}

	/**
	 * Time in seconds
	 * @return int [s]
	 */
	public function duration() {
		return $this->Data[self::TIME_IN_SECONDS];
	}

	/**
	 * Elapsed time
	 * @return int [s]
	 */
	public function elapsedTime() {
		return $this->Data[self::ELAPSED_TIME];
	}

	/**
	 * Elevation
	 * @return int [m]
	 */
	public function elevation() {
		return $this->Data[self::ELEVATION];
	}

	/**
	 * Calories
	 * @return int [kcal]
	 */
	public function calories() {
		return $this->Data[self::CALORIES];
	}

	/**
	 * Average heart rate
	 * @return int [bpm]
	 */
	public function hrAvg() {
		return $this->Data[self::HR_AVG];
	}

	/**
	 * Maximal heart rate
	 * @return int [bpm]
	 */
	public function hrMax() {
		return $this->Data[self::HR_MAX];
	}

	/**
	 * VDOT by heart rate
	 * @return float
	 */
	public function vdotByHeartRate() {
		return $this->Data[self::VDOT];
	}

	/**
	 * VDOT by time
	 * @return float
	 */
	public function vdotByTime() {
		return $this->Data[self::VDOT_BY_TIME];
	}

	/**
	 * VDOT with elevation
	 * @return float
	 */
	public function vdotWithElevation() {
		return $this->Data[self::VDOT_WITH_ELEVATION];
	}

	/**
	 * Uses VDOT for shape
	 * @return boolean
	 */
	public function usesVDOT() {
		return ($this->Data[self::USE_VDOT] == 1);
	}

	/**
	 * JD intensity
	 * @return int
	 */
	public function jdIntensity() {
		return $this->Data[self::JD_INTENSITY];
	}

	/**
	 * TRIMP
	 * @return int
	 */
	public function trimp() {
		return $this->Data[self::TRIMP];
	}

	/**
	 * Cadence
	 * @return int [rpm]
	 */
	public function cadence() {
		return $this->Data[self::CADENCE];
	}

	/**
	 * Power
	 * @return int [W]
	 */
	public function power() {
		return $this->Data[self::POWER];
	}

	/**
	 * Ground contact
	 * @return int [ms]
	 */
	public function groundcontact() {
		return $this->Data[self::GROUNDCONTACT];
	}

	/**
	 * Vertical oscillation
	 * @return int [mm]
	 */
	public function verticalOscillation() {
		return $this->Data[self::VERTICAL_OSCILLATION];
	}

	/**
	 * Clothes
	 * @return \Runalyze\Data\Weather
	 */
	public function weather() {
		if (is_null($this->Weather)) {
			$this->Weather = new Weather(
				new Weather\Temperature($this->Data[self::TEMPERATURE]),
				new Weather\Condition($this->Data[self::WEATHERID])
			);
		}

		return $this->Weather;
	}

	/**
	 * Clothes
	 * @return \Runalyze\Model\Activity\Clothes\Object
	 */
	public function clothes() {
		if (is_null($this->Clothes)) {
			$this->Clothes = new Clothes\Object($this->Data[self::CLOTHES]);
		}

		return $this->Clothes;
	}

	/**
	 * Splits
	 * @return \Runalyze\Model\Activity\Splits\Object
	 */
	public function splits() {
		if (is_null($this->Splits)) {
			$this->Splits = new Splits\Object($this->Data[self::SPLITS]);
		}

		return $this->Splits;
	}

	/**
	 * Comment
	 * @return string
	 */
	public function comment() {
		return $this->Data[self::COMMENT];
	}

	/**
	 * Partner
	 * @return \Runalyze\Model\Activity\Partner
	 */
	public function partner() {
		if (is_null($this->Partner)) {
			$this->Partner = new Partner($this->Data[self::PARTNER]);
		}

		return $this->Partner;
	}

	/**
	 * Is with running drills?
	 * @return boolean
	 */
	public function isWithRunningDrills() {
		return ($this->Data[self::RUNNING_DRILLS] == 1);
	}

	/**
	 * Shoe ID
	 * @return int
	 */
	public function shoeID() {
		return $this->Data[self::SHOEID];
	}

	/**
	 * Notes
	 * @return string
	 */
	public function notes() {
		return $this->Data[self::NOTES];
	}

	/**
	 * Unset running values
	 */
	public function unsetRunningValues() {
		$this->set(Object::VDOT_BY_TIME, 0);
		$this->set(Object::VDOT, 0);
		$this->set(Object::VDOT_WITH_ELEVATION, 0);
		$this->set(Object::JD_INTENSITY, 0);
	}
}
