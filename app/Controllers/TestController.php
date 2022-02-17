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

    protected function _testCheckFigure()
    {
        $model = $this->getModelObj('figure');
        $input = $this->request->input('code');

        $bookModel = $this->getModelObj('book');
        $infos = $bookModel->where('name', 'like', "%{$input}%")->get();
        if (count($infos) >= 1) {
            foreach ($infos as $info) {
                print_R($info->toArray());
            }
        }
        exit();

        $infos = $model->where('name', 'like', "%{$input}%")->orWhere('code', $input)->orWhere('name_card', 'like', "{$input}")->get();
        if (count($infos) >= 1) {
            foreach ($infos as $info) {
                //print_R($info->toArray());
            }
        }
        //exit();

        $sModel = $this->getModelObj('scholarism');
        $infos = require('/data/log/dealdata/book.php');
        $sql = '';
        foreach ($infos as $iKey => $info) {
            $scholarism = $sModel->find($info['id']);
            $sql .= "UPDATE `wp_scholarism` SET `book_code` = '{$iKey}' WHERE `id` = {$info['id']};\n";
            $sql .= "INSERT INTO `wp_book` (`code`, `name`, `description`, `baidu_url`, `publish_at`) VALUES ('{$iKey}', '{$scholarism['name']}', '{$info['description']}', '{$info['baidu_url']}', '{$info['publish_at']}');\n";
            if (!isset($info['figure'])) {
                continue;
            }
            if (!is_array($info['figure'])) {
                $sql .= "INSERT INTO `wp_book_figure` (`type`, `book_code`, `figure_code`) VALUES ('author', '{$iKey}', '{$info['figure']}');\n\n";
                continue;
            } else {
                $figure = $info['figure'];
                $sql .= "INSERT INTO `wp_book_figure` (`type`, `book_code`, `figure_code`) VALUES ('author', '{$iKey}', '{$figure['code']}');\n\n";
                $sql .= $this->getFigureSql($figure);
                $sql .= $this->getDateSql('birthday', $info['birthday'], $figure['code']);
                $sql .= $this->getDateSql('deathday', $info['deathday'], $figure['code']);
            }

            if (!isset($info['figure1'])) {
                continue;
            }
            if (!is_array($info['figure1'])) {
                $sql .= "INSERT INTO `wp_book_figure` (`type`, `book_code`, `figure_code`) VALUES ('author', '{$iKey}', '{$info['figure1']}');\n\n";
                continue;
            } else {
                $figure = $info['figure1'];
                $sql .= "INSERT INTO `wp_book_figure` (`type`, `book_code`, `figure_code`) VALUES ('author', '{$iKey}', '{$figure['code']}');\n\n";
                $sql .= $this->getFigureSql($figure);
                $sql .= $this->getDateSql('birthday', $info['birthday1'], $figure['code']);
                $sql .= $this->getDateSql('deathday', $info['deathday1'], $figure['code']);
            }
        }
        echo $sql;exit();

        echo count($infos);
        exit();
    }

    protected function _testDealBook()
    {
        $model = $this->getModelObj('book');
        $bookFigureModel = $this->getModelObj('bookFigure');
        $infos = $model->orderBy('id', 'asc')->get();
        $sql = '';
        $baiduStr = '';
        $i = 1;
        foreach ($infos as $info) {
            $setStr = "`name` = '{$info['name']}', `description` = '' ";
            $setStr .= ", `baidu_url` = ''";
            $baiduStr .= $i . '-' . "<a href='https://baike.baidu.com/item/{$info['name']}' target='_blank'>{$info['name']}</a><br />\n\n";
            $i++;
            $sql .= "UPDATE `wp_figure` SET {$setStr} WHERE `code` = '{$info['code']}';\n";

            $sql .= "INSERT INTO `wp_figure_title` (`figure_code`, `type`, `title`, `description`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES ('{$info['code']}', 'englishfull', '', '', '2021-12-27 17:26:25', '2021-12-27 17:26:25', NULL, '0') ;\n\n";
        }
        echo $baiduStr;
        //echo $sql;
        exit();
    }

    protected function _testDealFigure()
    {
        $model = $this->getModelObj('scholarism');
        //$infos = $model->where('book_code', '')->orderBy('author', 'asc')->orderBy('id', 'asc')->limit(112)->get();
        $infos = $model->where('book_code', '')->orderBy('author', 'asc')->orderBy('id', 'asc')->get();
        //$infos = $model->where('author', 'like', '% %')->get();
        $sql = '';
        $baiduStr = '';
        $i = 1;
        $bookDatas = [];
        foreach ($infos as $info) {
            $baiduStr .= $i . '-' . "<a href='https://baike.baidu.com/item/{$info['name']}' target='_blank'>{$info['name']}</a>";
            $baiduStr .= '-----------------' . "<a href='https://baike.baidu.com/item/{$info['author']}' target='_blank'>{$info['author']}</a>";
            $baiduStr .= '-----------------' . "<a href='http://api.91zuiai.com/culture/test?method=checkFigure&code={$info['author']}' target='_blank'>{$info['author']}</a><br />\n\n";
            $i++;
            continue;

            $bCode = CommonTool::getSpellStr($info['name'], '');
            $sql .= "UPDATE `wp_scholarism` SET `book_code` = '{$bCode}' WHERE `id` = {$info['id']};\n";
            $sql .= "INSERT INTO `wp_book` (`code`, `name`, `description`, `baidu_url`, `publish_at`) VALUES ('{$bCode}', '{$info['name']}', '', '', '');\n";
            $sql .= "INSERT INTO `wp_book_figure` (`type`, `book_code`, `figure_code`) VALUES ('author', '{$bCode}', '');\n\n";


            $sql .= "INSERT INTO `wp_figure` (`code`, `name`, `name_card`, `nationality`, `description`, `baidu_url`) VALUES ('', '{$info['author']}', '', '{$info['nationality']}', '', '');\n";
            $sql .= "INSERT INTO `wp_dateinfo` (`type`, `era_type`, `info_type`, `info_key`, `accurate`, `year`, `month`, `day`) VALUES ('birthday', '', 'figure', '', '', '', '', '') ;\n";
            $sql .= "INSERT INTO `wp_dateinfo` (`type`, `era_type`, `info_type`, `info_key`, `accurate`, `year`, `month`, `day`) VALUES ('deathday', '', 'figure', '{$info['code']}', '', '', '', '') ;\n";
            $sql .= "INSERT INTO `wp_figure_title` (`figure_code`, `type`, `title`) VALUES ('{$info['code']}', 'englishfull', '') ;\n\n";
            $bookDatas[$bCode] = [
                'id' => $info['id'],
                'description' => '',
                'baidu_url' => '',
                'publish_at' => '',
                'figure' => [
                    'code' => '',
                    'englishfull' => '',
                    'name' => $info['author'],
                    'name_card' => '',
                    'nationality' => $info['nationality'],
                    'description' => '',
                    'baidu_url' => '',
                ],
                'birthday' => [
                    'era_type' => '',
                    'accurate' => '',
                    'year' => '',
                    'month' => '',
                    'day' => '',
                ],
                'deathday' => [
                    'era_type' => '',
                    'accurate' => '',
                    'year' => '',
                    'month' => '',
                    'day' => '',
                ],
            ];
        }
        //var_export($bookDatas);exit();
        echo $baiduStr;
        //echo $sql;
        exit();
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

    public function getFigureSql($figure)
    {
        if (empty($figure['code'])) {
            print_r($figure);
        }
        $exist = $this->getModelObj('figure')->where('code', $figure['code'])->first();
        if (!empty($exist)) {
            print_r($exist->toArray());
            print_r($figure);
        }
        $sql = "INSERT INTO `wp_figure` (`code`, `name`, `name_card`, `nationality`, `description`, `baidu_url`) VALUES ('{$figure['code']}', '{$figure['name']}', '{$figure['name_card']}', '{$figure['nationality']}', '{$figure['description']}', '{$figure['baidu_url']}');\n";
        if (!empty($figure['englishfull'])) {
            $sql .= "INSERT INTO `wp_figure_title` (`figure_code`, `type`, `title`) VALUES ('{$figure['code']}', 'englishfull', '{$figure['englishfull']}') ;\n\n";
        } else {
            //print_r($figure);
        }
        return $sql;
    }

    public function getDateSql($type, $data, $figureCode)
    {
        $year = $data['year'] ?: 0;
        $month = $data['month'] ?: 0;
        $day = $data['day'] ?: 0;
        return "INSERT INTO `wp_dateinfo` (`type`, `era_type`, `info_type`, `info_key`, `accurate`, `year`, `month`, `day`) VALUES ('{$type}', '{$data['era_type']}', 'figure', '{$figureCode}', '{$data['accurate']}', '{$year}', '{$month}', '{$day}') ;\n";
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
