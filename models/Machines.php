<?php

namespace app\models;

use yii\db\ActiveRecord;

class Machines extends ActiveRecord
{
    public function getOptions()
    {
        return $this->hasOne(MachinesOptions::className(), ['machine_id' => 'id']);
    }

    public function getOptionsSet()
    {
        return $this->hasMany(MachinesOptionsSet::className(), ['machine_id' => 'id']);
    }
}
