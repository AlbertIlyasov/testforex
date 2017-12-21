<?php

namespace app\models;

use yii\base\Exception;
use yii\base\Model;
use app\models\Machines;
use app\models\MachinesOptions;
use app\models\MachinesOptionsSet;

class Machine extends Model
{
    public $machine;
    public $serial;
    public $time;
    public $connect_freq;
    public $firmware;
    public $set_connect_freq;
    public $task;

    public function response()
    {
        $result = [
            'time' => $this->time,
        ];

        if ($this->getTask()) {
            $this->runTask();
            $result['set_connect_freq'] = $this->machine->options->connect_freq;
            $this->deleteTask();
        }
            
        $result['status'] = 'ok';

        print_r($result);
    }

    public function receive(array $data): Machine
    {
        try {
            $this->load($data, '');
            $this->validate();
            $this->machine = Machines::findOne(['serial' => $this->serial]);
            
            if ($this->set_connect_freq) {
                $this->setTask(['connect_freq' => $this->set_connect_freq]);
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $this;
    }

    public function getTask()
    {
        return $this->task instanceof MachinesOptionsSet ? $this->task : null;
    }

    public function setTask($data)
    {
        $this->task = new MachinesOptionsSet();
        $this->task->machine_id = $this->machine->id;

        foreach ($data as $attribute => $value) {
            $this->task->$attribute = $value;
        }

        $this->task->save();
    }

    public function runTask()
    {
        $this->machine->options->connect_freq = $this->getTask()->connect_freq;
        $this->machine->options->save();
    }

    public function deleteTask()
    {   
        $this->task->delete();
    }

    public function rules()
    {
        return [
            [['serial', 'time'], 'required'],
            [['serial'], 'integer', 'max' => pow(2, 8*8)],
            [['serial'], 'validateSerial'],
            [['time'], 'validateTime'],
            [['connect_freq'], 'integer', 'max' => pow(2, 4*8)],
            [['firmware'], 'string', 'max' => 32],
            [['set_connect_freq'], 'integer', 'max' => pow(2, 4*8)],
        ];
    }

    public function validate($attributeNames = NULL, $clearErrors = true)
    {
        $result = parent::validate($attributeNames, $clearErrors);
        if ($this->hasErrors()) {
            throw new Exception('InvalidFieldsMachineException: '.print_r($this->getErrors(), true));
        }

        return $result;
    }

    public function validateTime($attribute, $params, $validator)
    {
        $dateFormat = 'Y-m-d H:i:s';
        $date = \DateTime::createFromFormat($dateFormat, $this->$attribute);
        if (!($date && $date->format($dateFormat) == $this->$attribute)) {
            $this->addError($attribute, 'Invalid time format, must be "Y-m-d H:i:s".');
        }
    }

    public function validateSerial($attribute, $params, $validator)
    {
        $machine = Machines::findOne(['serial' => $this->$attribute]);
        if (is_null($machine)) {
            $this->addError($attribute, 'Machine doesn\'t exists.');
        }
    }
}
