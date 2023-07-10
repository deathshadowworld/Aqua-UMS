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
class SensorForm extends Model
{
    public $name;
    public $type;
    public $tank;
    private $_sensor = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'type','tank'], 'required'],
        ];
    }

    public function registerSensor()
    {
        if ($this->validate()) {
            $new = [
                'name' => $this->name,
                'type' => $this->type,
                'tank' => $this->tank
            ];
            return DBHandler::addSensor($new);
        }
        return false;
    }

}
