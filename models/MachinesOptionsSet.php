<?php

namespace app\models;

use yii\db\ActiveRecord;

class MachinesOptionsSet extends ActiveRecord
{
    public function getMachine()
    {
        return $this->hasOne(Machines::className(), ['id' => 'machine_id']);
    }
}
