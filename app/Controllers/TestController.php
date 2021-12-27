<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

use Swoolecan\Foundation\Helpers\CommonTool;

class TestController extends AbstractController
{
    public function test()
    {
        $request = $this->request;
        $inTest = config('app.inTest');
        if (empty($inTest)) {
            return $this->error(400, '非法请求');
        }
        $method = ucfirst($request->input('method', ''));
        $method = "_test{$method}";
        $this->$method($request);
        exit();
    }

    protected function _testDealFigure()
    {
        $model = $this->getModelObj('emperor');
        $infos = $model->where('id', '>', 3)->where('id', '<', 50)->get();
        foreach ($infos as $info) {
            print_r($info->toArray());exit();
        }
    }

    protected function _testFigure()
    {
        $results = require('/tmp/text/dealed/hddonghan.php');
        print_R($results);exit();
        $datas = require('/tmp/text/cd.php');
        $codes = array_keys($results);


        foreach ($datas[4] as $index => $data) {
            if ($index > 43) {
                break;
            }
            if ($index >= 36) {
                $index++;
            }
            if ($index >= 37) {
                $index++;
            }
            $code = $codes[$index - 30];
            $results[$code]['birth_death'] = $data[2];
            $results[$code]['brief1'] = $data[4];
            $results[$code] = array_merge($results[$code], $data);
        }
        var_export($results);
        exit();

        //print_r($datas);exit();

        foreach ($datas[1] as $index => $data) {
            if ($index < 1) {
                continue;
            }
            $name = $data[3];
            $code = CommonTool::getSpellStr($data[3], '');
            if (!in_array($code, $codes)) {
                //print_R($data);
            }
            //$results[$code]['description'] = $data[4];
            $results[$code] = [
                'name' => trim($data[3]),
                'dynastic_title' => trim($data[1]),
                'office_term' => trim($data[4]),
                'posthumous_title' => trim($data[2]),
                //'brief' => trim($data[8]),
                'on_office' => trim($data[5]),
                'eraname' => trim($data[7]),
                'mausoleum' => trim($data[6]),
                //'birth_death' => $data[],
                //'photo' => $data[],
                //'photo1' => $data[],
                //'description' => $data[],
                //'brief1' => $data[],
            ];

            //$code = $codes[$index - 290];
            //$results[$code]['brief1'] = $data[4];
        }
        //print_r($datas[0]);exit();
        var_export($results);exit();
    }

    public function _testRecord()
    {
        //$results = require('/tmp/text/dealed/dealcd.php');
        $results = require('/tmp/text/dealed/hdqing.php');
        //$fields = ['code', 'parent_code', 'capital', 'first_emperor', 'category', 'country', 'nationality', 'name', 'brief', 'description', 'baidu_url', 'wiki_url', 'created_at', 'updated_at', 'status', 'extfield', 'begin_end'];
        $fields = ['code', 'name', 'spell', 'name_card', 'nationality', 'party', 'dynasty', 'period', 'term', 'dynastic_title', 'posthumous_title', 'eraname', 'office_term', 'office_pre', 'on_office', 'birth_death', 'age', 'photo', 'photo1', 'photo2', 'brief', 'brief1', 'brief2', 'description', 'mausoleum', 'baidu_url', 'wiki_url', 'extfield'];
        $model = $this->getModelObj('emperor');
        //$model = $this->getModelObj('dynasty');
        foreach ($results as $code => $result) {
            $nData = ['code' => $code, 'dynasty' => 'qing'];
            //$nData = ['code' => $code, 'country' => 'china'];
            foreach ($result as $key => $value) {
                if (!in_array($key, $fields)) {
                    echo $key . '==';print_r($value);exit();
                }
                $nData[$key] = $value;
            }
            print_r($nData);
            //$model->create($nData);
        }
        exit();
        print_R($results);exit();
    }

    public function _test()
    {
        //exit();
    }
}
/*
                'name' => $data[],
                'dynastic_title' => $data[],
                'office_term' => $data[],
                'posthumous_title' => $data[],
                'brief' => $data[],
                'eraname' => $data[],
                'mausoleum' => $data[],
                'office_term' => $data[],
                'birth_death' => $data[],
                'photo' => $data[],
                'photo1' => $data[],
                'description' => $data[],
                'brief1' => $data[],
*/
