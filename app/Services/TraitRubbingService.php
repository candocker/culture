<?php
declare(strict_types = 1);

namespace ModuleInfocms\Services;

use Swoolecan\Foundation\Helpers\CommonTool;

trait TraitRubbingService
{
    public function downWord()
    {
        $repository = $this->getRepositoryObj('rubbing');
        //$basePath = '/data/htmlwww/filesys/rubbings';
        $basePath = '/data/wwwroot/happy-writing/public/docs/d/sql1';
        $rId = 999;
        $words = $this->getModelObj('rubbingWord')->where('extfield5', 1)->orderBy('extfield2')->orderBy('extfield3')->limit(60000)->update(['rubbing_id' => $rId]);
        $words = $this->getModelObj('rubbingWord')->where('rubbing_id', $rId)->get();
        $command = $down = '';
        $paths = [];
        foreach ($words as $word) {
            $info = $this->getRubbing($word['extfield2']);
            $path = $basePath . "/{$info['calligrapher_code']}/{$info['code']}/word/{$word['extfield3']}";
            if (!in_array($path, $paths)) {
                $paths[] = $path;
                $command .= "mkdir {$path} -p \n";
            }
            $remoteUrl = $repository->tmpThumb($word, 'url');
            $ext = pathinfo($remoteUrl, PATHINFO_EXTENSION);
            $file = $path . "/{$word['orderlist']}-{$word['id']}.{$ext}";
            $down .= "wget -O {$file} {$remoteUrl} \n";
        }
        file_put_contents('/tmp/command', $command);
        file_put_contents('/tmp/remote', $down);
        exit();
    }

    public function downRubbing()
    {
        $infos = $this->getModelObj('rubbingDetail')->where('rubbing_id', 0)->get();
        $repository = $this->getRepositoryObj('rubbing');
        //$basePath = '/data/htmlwww/filesys/rubbings';
        $basePath = '/data/wwwroot/happy-writing/public/docs/d/sql1';
        $command = $down = '';
        foreach ($infos as $detail) {
            $path = $basePath . "/weizhi/{$detail['extfield2']}";
            $command .= "mkdir {$path} -p \n";
            $remoteUrl = $repository->tmpThumb($detail, 'url');
            $ext = pathinfo($remoteUrl, PATHINFO_EXTENSION);
            $file = $path . "/{$detail['orderlist']}-{$detail['id']}.{$ext}";
            $down .= "wget -O {$file} {$remoteUrl} \n";
        }
        echo $command;
        echo $down;
        file_put_contents('/tmp/command', $command);
        file_put_contents('/tmp/remote', $down);
        exit();


        $infos = $this->getModelObj('rubbing')->get();
        $repository = $this->getRepositoryObj('rubbing');
        //$basePath = '/data/htmlwww/filesys/rubbings';
        $basePath = '/data/wwwroot/happy-writing/public/docs/d/sql1';
        $command = $down = '';
        foreach ($infos as $info) {
            $path = $basePath . "/{$info['calligrapher_code']}/{$info['code']}";
            $command .= "mkdir {$path} -p \n";
            $details = $this->getModelObj('rubbingDetail')->where('rubbing_id', $info['id'])->get();
            $thumbRemoteUrl = $repository->tmpThumb($info, 'url');
            $thumbExt = pathinfo($thumbRemoteUrl, PATHINFO_EXTENSION);
            $thumbFile = $path . "/thumb-{$info['id']}.{$thumbExt}";
            $down .= "wget -O {$thumbFile} {$thumbRemoteUrl} \n";
            foreach ($details as $detail) {
                $remoteUrl = $repository->tmpThumb($detail, 'url');
                $ext = pathinfo($remoteUrl, PATHINFO_EXTENSION);
                $file = $path . "/{$detail['orderlist']}-{$detail['id']}.{$ext}";
                $down .= "wget -O {$file} {$remoteUrl} \n";
            }
        }
        file_put_contents('/tmp/command', $command);
        file_put_contents('/tmp/remote', $down);
    }

    public function checkDetail($rubbingId)
    {
        $rubbing = $this->getModelObj('rubbing')->where('id', $rubbingId)->first();
        if (empty($rubbing)) {
            echo 'no exist';
            exit();
        }
        $repository = $this->getRepositoryObj('rubbing');
        $details = $this->getModelObj('rubbingDetail')->where('rubbing_id', $rubbingId)->get();
        $str = "<h1>{$rubbing['name']}</h1>";
        $str .= $repository->tmpThumb($rubbing, '');
        foreach ($details as $detail) {
            $str .= $repository->tmpThumb($detail, '');
        }
        echo $str;
        exit();
    }

    public function dealCalligrapher()
    {
        $model = $this->getModelObj('calligrapher');
        $infos = $model->get();
        foreach ($infos as $info) {
            $code = CommonTool::getSpellStr($info['name'], '');
            $info->code = $code;
            $info->dynasty = $this->getPointAttrCode('dynasty', $info->dynasty, 'value');
            $info->save();
        }
    }

    public function dealRubbing()
    {
        //$infos = $this->getModelObj('rubbing')->where('extfield2', '<', 1003)->get();
        $model = $this->getModelObj('rubbing');
        //$infos = $model->where('extfield2', '>', 1002)->get();
        $infos = $model->get();
        $calligrapherModel = $this->getModelObj('calligrapher');
        foreach ($infos as $info) {
            $id = $info['id'];
            $code = CommonTool::getFirstSpell($info['name'], '');
            $exist = $model->where('code', $code)->first();
            $info->code = $exist ? $code . $info['id'] :$code;
            $info->save();
            continue;
            /*$info->code = CommonTool::getFirstSpell($info['name'], '');
            //$info->dynasty = $this->getPointAttrCode('dynasty', $info->dynasty);
            //$info->calligraphy_style = $this->getPointAttrCode('calligraphyStyle', $info->calligraphy_style);
            //$calligrapher = $calligrapherModel->where('extfield2', $info['calligrapher'])->first();
            $info->dynasty = $this->getPointAttrCode('dynasty', $info->dynasty, 'value');
            $info->calligraphy_style = $this->getPointAttrCode('calligraphyStyle', $info->calligraphy_style, 'value');
            $calligrapher = $calligrapherModel->where('name', $info['calligrapher'])->first();
            if (empty($calligrapher)) {
                echo $info['id'] . '==' . $info['name'] . '==' . $info['calligrapher'] . "\n";
            }
            $info->calligrapher = $calligrapher['code'];
            $info->created_at = date('Y-m-d H:i:s');
            $info->updated_at = date('Y-m-d H:i:s');*/
            //print_r($info->toArray());exit();
            $info->save();
        }
        echo count($infos);exit();
    }

    public function dealRubbingDetails()
    {
        $relates = [
            1269 => 30221,
            1264 => 30131,
            1259 => 30070,
            1258 => 30046,
            1256 => 29978,
            1255 => 29962,
            1254 => 29954,
            1252 => 29952,
            1239 => 29767,
            1238 => 29748,
            1237 => 29687,
            1234 => 29522,
            1233 => 29488,
            1232 => 29433,
            1231 => 29369,
            1229 => 29029,
            1226 => 28712,
            1225 => 28975,
            1224 => 28392,
            1223 => 28370,
            1222 => 28335,
            1221 => 28328,
            1220 => 28321,
            1219 => 28314,
            1218 => 28307,
            1217 => 28300,
            1216 => 28293,
            1215 => 28286,
            1214 => 28279,
            1213 => 28272,
            1212 => 28265,
            1211 => 28258,
            1210 => 28251,
            1209 => 28244,
            1208 => 28237,
            1207 => 28230,
            1206 => 28228,
            1205 => 28226,
            1204 => 28224,
            1203 => 28223,
            1202 => 28222,
            1201 => 28221,
            1200 => 28220,
            1199 => 28219,
            1198 => 28218,
            1197 => 28217,
            1196 => 28216,
            1195 => 28215,
            1194 => 28214,
            1193 => 28213,
            1192 => 28212,
            1191 => 28211,
            1190 => 28210,
            1189 => 28209,
            1188 => 28208,
            1187 => 28207,
            1186 => 28206,
            1185 => 28205,
            1184 => 28204,
            1183 => 28203,
            1182 => 28202,
            1181 => 28201,
            1180 => 28200,
            1179 => 28199,
            1178 => 28198,
            1177 => 28156,
            1149 => 27387,
            1111 => 27070,
            1107 => 26990,
            1097 => 26544,
            1067 => 25645,
            1066 => 29736,
            1063 => 25543,
            1062 => 25533,
            1061 => 25521,
            1059 => 25489,
            1058 => 25483,
            1057 => 25476,
            1056 => 25466,
            1053 => 25353,
            1052 => 25339,
            1050 => 25326,
            1048 => 25292,
            1047 => 25282,
            1045 => 25280,
            1044 => 25274,
            1043 => 25196,
            1042 => 25232,
            1041 => 25214,
            1040 => 25268,
            1039 => 25197,
            1038 => 25198,
            1037 => 25199,
            1035 => 25202,
            1034 => 25205,
            1033 => 25208,
            1032 => 25209,
            1031 => 25210,
            1030 => 25211,
            1029 => 25212,
            1028 => 25213,
            1026 => 25152,
            1024 => 25105,
            1021 => 24965,
            1006 => 24571,
        ];
        $rModel = $this->getModelObj('rubbing');
        $model = $this->getModelObj('rubbingDetail');
        foreach ($relates as $rId => $dId) {
            $detail = $model->where('browse_num', $dId)->first();
            $rubbing = $rModel->where('extfield2', $rId)->first();
            if (empty($detail)) {
                echo $rId . '===' . $rubbing['name'] . '==' . $dId . "\n";
            }
            $model->where('rubbing_id', $detail['rubbing_id'])->update(['white_pic' => $rId]);
        }
        exit();

        $infos = $model->where('rubbing_id', '>', '10000')->orderBY('browse_num', 'asc')->get();
        $infos = $rModel->where('status', 0)->orderBy('extfield2', 'desc')->get();
        $rubbings = [];
        $sql = $str = '';
        foreach ($infos as $info) {
            echo "            {$info->extfield2} => ,\n";continue;// . '==' . $info->name . '==' . $info->title . "\n"; continue;
            if (in_array($info->rubbing_id, $rubbings)) {
                continue;
            }
            $rubbings[] = $info->rubbing_id;
            $name = preg_replace('/\d+/', '', $info->pic_file_name);
            $exist = $rModel->where('status', 0)->where('name', 'like', "%{$name}%")->first();
            $rName = empty($exist) ? 'nnnnnn' : $exist->name;
            //$str .= "<a href='https://zsbt-1254153797.cos.ap-shanghai.myqcloud.com/{$info['pic']}' target='_blank'>{$name}</a><br />";
            $sql .= "UPDATE `sp_rubbing_detail` SET `rubbing_id` = WHERE `rubbing_id` = {$info->rubbing_id};\n";

            //echo $name . '====' . $rName . "\n";
        }
        //echo $str;
        echo $sql;
        exit();


        $infos = $this->getModelObj('rubbing')->where('status', 0)->get();
        $model = $this->getModelObj('rubbingDetail');
        $datas = [];
        foreach ($infos as $info) {
            $id = $info['extfield2'];
            $name = $info['name'];
            $details = $model->where('pic_file_name', 'like', "{$name}%")->get();
            $datas[$id] = ['name' => $name];
            $rId = 0;
            foreach ($details as $detail) {
                if ($detail['rubbing_id'] < 1000) {
                    continue;
                }
                if (!empty($rId) && $rId != $detail['rubbing_id']) {
                    echo $id . '==' . $name . '==' . $rId . '==' . $detail['rubbing_id'] . "\n";
                }
                $rId = $detail['rubbing_id'];
                $datas[$id]['detail'][] = ['id' => $detail['id'], 'name' => $detail['pic_file_name'], 'rubbing_id' => $detail['rubbing_id']];
                $detail->white_pic = $id;
                //$detail->save();
            }
        }
        print_r($datas);exit();
    }

    public function getPointAttrCode($type, $index, $indexType = 'key')
    {
        $repository = $this->getRepositoryObj('rubbing');
        $method = "_{$type}KeyDatas";
        $datas = $repository->$method();
        if ($indexType == 'key') {
            $codes = array_keys($datas);
            return $codes[$index - 1];
        }
        $datas = array_flip($datas);
        if (isset($datas[$index])) {
            return $datas[$index];
        }
        $index = str_replace('代', '', $index);
        return $datas[$index] ?? $index;
    }

    public function dealRubbingAddDetails()
    {
        $driver = \Storage::disk('local');
        $files = $driver->files('c');
        $excelService = $this->getServiceObj('passport-excel');
        $fields = ['browse_num', 'pic', 'pic_file_name', 'wide', 'high', 'sort'];
        $detailModel = $this->getModelObj('rubbingDetail');
        $rubbingId = 60000;
        foreach ($files as $file) {
            $fullFile = $driver->getAdapter()->applyPathPrefix($file);
            $datas = $excelService->excelDatas($fullFile);
            foreach ($datas as $data) {
                $newData['rubbing_id'] = $rubbingId;;
                foreach ($fields as $key => $field) {
                    $newData[$field] = $data[$key];
                }
                $detailModel->create($newData);
            }
            $rubbingId += 1;
        }
    }

    public function dealRubbingAddWords()
    {
        $driver = \Storage::disk('local');
        $files = $driver->files('e');
        $excelService = $this->getServiceObj('passport-excel');
        $fields = ['extfield4', 'word', 'orderlist', 'extfield3', 'detail_id', 'extfield'];
        $wordModel = $this->getModelObj('rubbingWord');
        foreach ($files as $file) {
            $fullFile = $driver->getAdapter()->applyPathPrefix($file);
            $datas = $excelService->excelDatas($fullFile);
            foreach ($datas as $data) {
                $newData = [];
                foreach ($fields as $key => $field) {
                    $newData[$field] = $data[$key];
                }
                //print_r($newData);
                $wordModel->create($newData);
            }
        }
    }

    protected function getRubbing($id)
    {
        static $rubbings;
        if (isset($rubbings[$id])) {
            return $rubbings[$id];
        }
        $rubbing = $this->getModelObj('rubbing')->where('extfield2', $id)->first();
        if (empty($rubbing)) {
            $rubbing = ['calligrapher_code' => 'weizhi', 'code' => $id];
        }
        $rubbings[$id] = $rubbing;
        return $rubbing;
    }
}
