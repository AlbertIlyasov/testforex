<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Machine;
use app\models\Machines;

class MachineController extends Controller
{
    public function actionAnswer()
    {
        $data = Yii::$app->request->post('Machine');

        if ($data) {
            $response = (new Machine())
                ->receive($data)
                ->response(); 
        }

        die;
    }

    public function actionTest()
    {
        $model = new Machine();

        return $this->render('test', [
            'model' => $model,
        ]);
    }


    public function actionTables()
    {
        $model = Machines::findOne(1);

        return $this->render('tables', [
            'model' => $model,
        ]);
    }
}
