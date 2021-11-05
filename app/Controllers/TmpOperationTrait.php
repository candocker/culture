<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

trait TmpOperationTrait
{
    public function updateFigure()
    {
        $fModel = $this->getModelObj('figure');
        $sModel = $this->getModelObj('scholarism');
        $bModel = $this->getModelObj('book');
        $bDatas = $bModel->where('extfield1', '<>', 'yes')->where('category_third', 'scholarism')->get();
        //$sDatas = $sModel->get();
        //$sDatas = $sDatas->keyBy('name')->toArray();
        foreach ($bDatas as $bData) {
            $name = $bData['name'];
            $figure = $bData->authorInfo;
            /*if (in_array($name, array_keys($sDatas))) {
                echo $name . '==' . $figure['name'] . '--<br />' . $sDatas[$name]['name'] . '==' . $sDatas[$name]['author'] . '--<br />';
                $sModel->where('name', $name)->update(['book_code' => $bData['code']]);
                $bData->extfield1 = 'yes';
                $bData->save();
            }*/
            /*$tmpName = substr($name, 0, 9);
            $sInfo = $sModel->where('name', 'like', "%{$tmpName}%")->first();
            if (!empty($sInfo)) {
                echo $name . '==' . $figure['name'] . '--<br />' . $sInfo['name'] . '==' . $sInfo['author'] . '--<br />';
            }*/
            $author = $figure->name;
            $sInfos = $sModel->where('author', 'like', $author)->get();
            foreach ($sInfos as $sInfo) {
                echo $name . '==' . $figure['name'] . '--' . $sInfo['name'] . '==' . $sInfo['author'] . '--<br />';
            }
            echo "<br />";
        }
        /*$fDatas = $figure->get();
        foreach ($fDatas as $fData) {
        }*/
    }

    public function updateDate()
    {
        $model = $this->getModelObj('figure');
        $infos = $model->where('birthday', '<>', 0)->get();
        $dateinfoModel = $this->getModelObj('dateinfo');
        foreach ($infos as $info) {
            $birthday = strval($info['birthday']);

            $day = substr($birthday, -2);
            $month = substr($birthday, -4, 2); 
            $year = substr($birthday, 0, strlen($birthday) - 4);
            $dData = [
                'type' => 'birthday',
                'info_type' => 'figure',
                'info_key' => $info->code,
                'year' => $year,
                'month' => $month,
                'day' => $day,
            ];
            $dateinfoModel->create($dData);

            $deathday = strval($info['deathday']);
            $day = substr($deathday, -2);
            $month = substr($deathday, -4, 2); 
            $year = substr($deathday, 0, strlen($deathday) - 4);
            $dData = [
                'type' => 'deathday',
                'info_type' => 'figure',
                'info_key' => $info->code,
                'year' => $year,
                'month' => $month,
                'day' => $day,
            ];
            $dateinfoModel->create($dData);
        }
        echo count($infos);exit();
        $str = file_get_contents('/tmp/text/j.json');
        $data = json_decode($str, true);
        return $data;
    }
}
