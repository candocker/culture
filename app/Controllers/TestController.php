<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

use Swoolecan\Foundation\Helpers\CommonTool;
use Carbon\Carbon;

class TestController extends AbstractController
{
    use DealBookTrait;

    public function test()
    {
        $this->dealBookpass();
        exit();
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

    public function _testDealResource()
    {
        $f1 = '/data/htmlwww/resource/test.jpg';
        $f2 = '/data/htmlwww/resource/t.jpg';
        $f3 = 'https://zsbt-1254153797.cos.ap-shanghai.myqcloud.com/data/upload/beitie/images/page/b4170a692040825baba55f881ebe2e49.jpg';
        var_dump(hash_file('md5', $f1));
        var_dump(hash_file('md5', $f2));
        var_dump(hash_file('md5', $f3));
        exit();


        $basePath = '/data/htmlwww/resource/';
        $infos = $this->getModelObj('infocms-resourceDetail')->where(['tag' => '书籍'])->orderBy('image_model', 'asc')->limit(1000)->get();
$series = array(
'philosophy' => '哲学',
'history' => '历史·地理',
'politics' => '政治·法律·社会',
'economics' => '经济',
'language' => '语言·文艺理论',
);
        $command = '';
        $sNums = $pathCommands = [];
        $grade = 1;
        foreach ($infos as $info) {
            $code = $info['image_model'];
            if (in_array($info['extfield1'], ['', 'no', 'nno'])) {
                continue;
            }
            if (!in_array($code, array_keys($series))) {
                continue;
            }
            if (isset($sNums[$code])) {
                $sNums[$code] += 1;
            } else {
                $sNums[$code] = 1;
            }
            $pathNum = ceil($sNums[$code] / 50);
            $newPath = 'bookcover/' . $series[$code] . '/cover' . $pathNum . '/';
            $mPath = $basePath . $newPath;
            if (!is_dir($mPath) && !in_array($mPath, $pathCommands)) {
                //$command .= "mkdir {$newPath};\n";
            }
            $pathCommands[] = $mPath;
            $old = $basePath . $info['extfield1'];
            if (!file_exists($old)) {
                continue;
            }
            $old = str_replace(['(', ')', ' '], ['\(', '\)', "\ "], $old);
            $newPath .= $info['filename'];
            $new = $basePath . $newPath;
            $new = str_replace(['(', ')', ' '], ['\(', '\)', "\ "], $new);
            $command .= "mv {$old} {$new};\n";
        }
        echo $command;
        exit();
        //$infos = $this->getModelObj('infocms-resourceDetail')->where(['tag' => '人物', 'extfield1' => 'nno'])->limit(500)->get();
        $infos = $this->getModelObj('infocms-resourceDetail')->where(['tag' => '人物', 'extfield1' => 'nno'])->limit(500)->get();
        echo $infos->count();
        foreach ($infos as $info) {
            $path = 'culture/figure2/' . $info['filename'];
            $file = $basePath . $path;
            var_dump($file);
            if (file_exists($file)) {
                var_dump($file);
                $info->extfield1 = $path;
            } else {
                $info->extfield1 = 'nno';
            }
            $info->save();
        }
    }

    public function _testDealData()
    {
        $basePath = '/data/htmlwww/resource';
        /*$driver = \Storage::disk('local');
        $files = $driver->allFiles('rubbing/weizhi/');

        $fFiles = [];
        foreach ($files as $file) {
            list($base, $p1, $p2, $f) = explode('/', $file);
            $bf = str_replace('.jpg', '', $f);
            list($olist, $id) = explode('-', $bf);
            //var_dump($base . '-' . $p1 . '=' . $p2 . '=' . $f . '-' . $olist . '=' . $id);
            $fFiles[$p2][$olist] = $id;
        }
        //print_r($fFiles);
        foreach ($fFiles as $rcode => $rDatas) {
            $rInfo = $this->getModelObj('rubbing')->where(['code' => $rcode, 'calligrapher_code' =>'weizhi'])->first();
            if (empty($rInfo)) {
                var_dump($rcode);var_dump($rDatas);
            }
            $uData = ['rubbing_id' => $rInfo['id']];
            $this->getModelObj('rubbingDetail')->whereIn('id', $rDatas)->update($uData);
        }*/
        /*exit();
        print_r($files);exit();*/

        //$infos = $this->getModelObj('rubbingDetail')->where(['filepath' => '', 'file_num' => 1])->limit(4000)->get();
        $infos = $this->getModelObj('rubbingDetail')->where(['filepath' => '', 'file_num' => -1])->limit(4000)->get();
        foreach ($infos as $info) {
            $rubbing = $info->rubbingInfo;
            if (empty($rubbing)) {
                $info->file_num = -9;
                $info->save();
                continue;
            }
            $path = "rubbing/{$rubbing['calligrapher_code']}/{$rubbing['code']}/{$info['orderlist']}-{$info['id']}.png";
            $full = "{$basePath}/{$path}";
            if (file_exists($full)) {
                $info->filepath = $path;
                $info->file_num = 9;
                $info->save();
            }
        }
        exit();
        $infos = $this->getModelObj('rubbing')->get();
        var_dump($infos->count());
        foreach ($infos as $info) {
            $path = "rubbing/{$info['calligrapher_code']}/{$info['code']}/thumb-{$info['id']}.jpg";
            $path1 = "rubbing/{$info['calligrapher_code']}/{$info['code']}/thumb-{$info['id']}.png";
            $full = "{$basePath}/{$path}";
            $full1 = "{$basePath}/{$path1}";
            if (file_exists($full)) {
                $info->filepath = $path;
                $info->save();
                continue;
            }
            if (file_exists($full1)) {
                $info->filepath = $path1;
                $info->save();
                continue;
            }
        }
        exit();
    }

    public function _testAnnotationMaterial()
    {
        $bookCode = 'lunyu';
        $basePath = '/data/database/material/';
        $cFile = "{$basePath}booklist/{$bookCode}.php";
        $cataFile = "{$basePath}booklist/{$bookCode}_catalogue.php";
        copy($cFile, "{$basePath}annotationlist/{$bookCode}.php");
        copy($cataFile, "{$basePath}annotationlist/{$bookCode}_catalogue.php");

        $bookChapters = require($cataFile);
        $filePath = "{$basePath}annotations/{$bookCode}/";
        $fStr = "<?php\nreturn [\n'chapters' => [\n[\n    'content' => [\n    ],\n    'vernacular' => [\n    ],\n],\n],\n];";
        foreach ($bookChapters as $chapter) {
            file_put_contents($filePath . "{$chapter['code']}.php", $fStr);
        }
        exit();
    }

    public function _testAnnotation()
    {
        $bookCode = 'xifangzhexueshi';
        $bookChapters = $this->getModelObj('culture-chapter')->where(['book_code' => $bookCode])->orderBy('serial', 'asc')->get();
        $str = "<?php\nreturn [\n";
        $basePath = '/data/database/material/';
        $filePath = "{$basePath}annotations/{$bookCode}/";
        $fStr = "<?php\nreturn [\n'chapters' => [\n[\n    'content' => [\n    ],\n    'vernacular' => [\n    ],\n],\n],\n];";
        $infoStr = '';
        foreach ($bookChapters as $chapter) {
            $infoStr .= "{$chapter['code']}, ";
            $str .= "    '{$chapter['code']}' => ['code' => '{$chapter['code']}', 'name' => '{$chapter['name']}', 'brief' => '',],\n";
            //print_r($chapter->toArray());exit();
            file_put_contents($filePath . "{$chapter['code']}.php", $fStr);
        }
        $str .= "];";
        file_put_contents("{$basePath}annotationlist/{$bookCode}_catalogue.php", $str);
        $cStr = "<?php\nreturn [\n'chapters' => [\n[\n    'name' => '',\n    'brief' => '',\n    'infos' => [\n    ],\n],\n],\n];\n{$infoStr}";
        file_put_contents("{$basePath}annotationlist/{$bookCode}.php", $cStr);
        echo $str;
        exit();
    }

    public function _testSearch()
    {
        $info = $this->getModelObj('book')->where('id', 13)->first();
        $infos = $this->getModelObj('book')->limit(35)->get();
        $infos->searchable();exit();
        $content = '文集';//$this->request->input('content');
        $list = $this->getModelObj('book')->search($content)->where('query', ['*user_name*', '*user_email*'])->paginate(20)->toArray();
        //$list = $this->getModelObj('book')->search($content)->where('query', ['*user_name*', '*user_email*'])->orderBy('user_created_at.date.keyword', 'desc')->paginate(20)->toArray();
        print_r($list->toArray());exit();
        //$res = Address::search($content)->where('query', ['*address_home*', '*address_company*'])->orderBy('address_created_at.date.keyword', 'desc')->paginate(20)->toArray();
    }   

    public function _test()
    {
        return true;
    }

    protected function gitDeal()
    {
        $infos = \DB::select("SELECT * FROM `work_bench`.`wp_github`");
        //print_r($infos);
        $strs = [];
        foreach ($infos as $info) {
            $str = '<li class="null"><strong><span style="color: #ba372a;"><a href="' . $info->url . '" target="_blank" rel="noopener">' . $info->name . '</a></span> ( <em>' . $info->code . '</em> )：</strong>' . $info->description . '</li>';
            //$str = '<tr style="height: 48px;"><td style="width: 20%; height: 48px;">1</td><td style="width: 20%; height: 48px;">' . $info->code . '</td><td style="width: 20%; height: 48px;"></td><td style="width: 40%; height: 48px;">' . $info->description . '</td></tr>';
            $strs[$info->sort] = isset($strs[$info->sort]) ? $strs[$info->sort] . $str : $str;
        }
        print_r($strs);
    }
}
