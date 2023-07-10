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

    public function _testUpdateMaterial()
    {
        /*$figures = $this->getModelObj('culture-figure')->where(['id' => '754'])->get();
        foreach ($figures as $figure) {
            $this->updateSource($figure);
        }*/
        //$where = ['series_code' => 'philosophy'];
        //$where = ['series_code' => 'politics'];
        //$where = ['series_code' => 'history'];
        //$where = ['series_code' => 'economics'];
        //$where = ['series_code' => 'language'];
        $where = ['series_code' => 'otheracademic'];
        //$where = ['series_code' => 'classical'];
        $datas = $this->getModelObj('culture-bookPublish')->where($where)->orderBy('serial', 'asc')->get();
        $i = 0;
        foreach ($datas as $data) {
            $book = $data->book;
            if (!empty($book->baidu_url)) {
                //print_r($book->toArray());
                $this->updateSource($book, ['category_code' => 'hanyixueshu']);
            } else {
                if (empty($book)) {
                    print_r($data->toArray());
                    continue;
                }
                echo 'noooooooooo-baiduurl =' . $book['code'] . '=' . $book['name'] . "\n";
                //print_r($book->toArray());
            }
            //continue;
            $bFigures = $book->authorInfos();
            foreach ($bFigures as $bFigure) {
                $figure = $bFigure->figure;
                if (empty($figure) || empty($figure['baidu_url'])) {
                    echo 'noooooooooooo-figure' . "\n";
                    //print_r($book->toArray());
                    continue;
                }
                //print_r($figure->toArray());
                $this->updateSource($figure);
            }
        }
        echo $i;
        exit();
    }

    protected function updateSource($info, $data = [])
    {
        $className = get_class($info);
        $nData = array_merge([
            'name' => $info['name'],
            'url' => $info['baidu_url'],
            'category_code' => 'author',
            'domain' => 'baike.baidu.com',
            'description' => $info['description']
        ], $data);
        if ($className == 'ModuleCulture\Models\Figure') {
            $nData['figure'] = $info['code'];
            $nData['file_path'] = '/source/figures/academic4/' . $info['code'];
            $exist = $this->getModelObj('infocms-materialSource')->where(['figure' => $info['code']])->first();
        }
        if ($className == 'ModuleCulture\Models\Book') {
            $nData['book'] = $info['code'];
            $nData['file_path'] = '/source/books/academic4/' . $info['code'];
            $exist = $this->getModelObj('infocms-materialSource')->where(['book' => $info['code']])->first();
        }
        if ($exist) {
            //print_r($info->toArray());
            return true;
        }

        $file = '/data/database/material' . $nData['file_path'] . '.php';
        if (!file_exists($file)) {
            echo $file . "<br />\n";
            file_put_contents($file, "<?php\nreturn [\n'brief' => [\n],\n];");
        }
        print_r($nData); 
        $this->getModelObj('infocms-materialSource')->create($nData);
        return true;
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

    public function _testBookContent()
    {
        $rs = file('/data/database/books/zhaopuchu/fjwd/9.txt');
        $lines = [];
        foreach ($rs as $k => $r) {
            if ($k === 0) {
                continue;
            }
            $r = trim($r);
            if (empty($r)) {
                continue;
            }
            if (strpos($r, '问：') !== false || strpos($r, '答：') !== false) {
                $lines[] = $r;
            } else {
                $index = count($lines);
                $lines[$index - 1] .= $r;
            }
        }
        //print_r($rs);
        //print_r($lines);exit();
        $str = "<?php\nreturn [\n'chapters' => [\n";
        foreach ($lines as $index => $line) {
            $line = trim($line);
            if ($index % 2 == 0) {
                $str .= "[\n    'content' => [\n        '{$line}',\n    ],\n";
            } else {
                $str .= "    'vernacular' => [\n        '{$line}',\n    ],\n],\n";
            }
        }
        $str .= "],\n];";
        //file_put_contents('/data/database/material/references/fojiaowenda/9.php', $str);
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

    public function _testSourceFile()
    {
        $infos = $this->getModelObj('infocms-materialSource')->get();
        $basePath = '/data/database/material/source/';
        $this->checkSourceFile($basePath);exit();
        //$basePath = '/data/database/material/source/guji/';
        $files = CommonTool::getPathFiles($basePath);
        foreach ($files as $file) {
            $code = str_replace('.php', '', $file);
            if (in_array($code, ['ancient_cn', 'academic1'])) {
                continue;
            }
            $path = str_replace('/data/database/material', '', $basePath) . $code;
            $exist = $this->getModelObj('infocms-materialSource')->where(['book' => $code])->first();
            if (empty($exist)) {
                echo $path . '<br />';
            } else {
                if (empty($exist->file_path)) {
                    $exist->file_path = $path;
                    $exist->save();
                }
            }
        }
        print_r($files);
        exit();
    }

    public function checkSourceFile($path)
    {
        $files = CommonTool::getPathFiles($path);
        foreach ($files as $file) {
            $fullPath = $path . $file;
            if (is_dir($fullPath)) {
                $this->checkSourceFile($fullPath . '/');
            } else {
                $file = str_replace(['/data/database/material', '.php'], '', $fullPath);
                $exist = $this->getModelObj('infocms-materialSource')->where(['file_path' => $file])->first();
                if (empty($exist)) {
                    var_dump($file);
                }
            }
        }
        //print_r($files);
        //exit();
    }
}
