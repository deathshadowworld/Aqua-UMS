<?php

namespace app\models;
use app\models\DBHandler;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class ParamForm extends Model
{
    public $tank_id;
    public $ph_min;
    public $ph_max;
    public $do_min;
    public $do_max;
    public $salinity_min;
    public $salinity_max;
    public $ammonia_min;
    public $ammonia_max;
    public $nitrate_min;
    public $nitrate_max;
    public $turbidity_min;
    public $turbidity_max;
    public $temp_min;
    public $temp_max;
    public $depth_min;
    public $depth_max;
    private $_sensor = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['tank_id','ph_min','ph_max','do_min','do_max','salinity_min','salinity_max',
            'ammonia_min','ammonia_max','nitrate_min', 'nitrate_max','turbidity_min',
            'turbidity_max','temp_min', 'temp_max','depth_min','depth_max'], 'required'],
        ];
    }

    public function updateParams()
    {
        if ($this->validate()) {
            $new = [
                'tank_id' => $this->tank_id,
                'ph_min' => $this->ph_min,
                'ph_max' => $this->ph_max,
                'do_min' => $this->do_min,
                'do_max' => $this->do_max,
                'salinity_min' => $this->salinity_min,
                'salinity_max' => $this->salinity_max,
                'ammonia_min' => $this->ammonia_min,
                'ammonia_max' => $this->ammonia_max,
                'nitrate_min' => $this->nitrate_min,
                'nitrate_max' => $this->nitrate_max,
                'turbidity_min' => $this->turbidity_min,
                'turbidity_max' => $this->turbidity_max,
                'temp_min' => $this->temp_min,
                'temp_max' => $this->temp_max,
                'depth_min' => $this->depth_min,
                'depth_max' => $this->depth_max,
                'cycle_length' => 60,
            ];
            return DBHandler::updateParam($new);
        }
        return false;
    }

}
