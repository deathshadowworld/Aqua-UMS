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
class TankForm extends Model
{
    public $name;
    public $desc;
    public $location;
    private $_tank = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'desc','location'], 'required'],
        ];
    }

    public function registerTank()
    {
        if ($this->validate()) {
            $new = [
                'name' => $this->name,
                'desc' => $this->desc,
                'location' => $this->location
            ];
            return DBHandler::addTank($new);
        }
        return false;
    }

}
