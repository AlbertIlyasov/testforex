<?php

namespace app\models;

use yii\db\ActiveRecord;

class MachinesOptions extends ActiveRecord
{
    public function getMachine()
    {
        return $this->hasOne(Machines::className(), ['id' => 'machine_id']);
    }
}
