<?php

declare(strict_types = 1);

namespace ModuleCulture\Controllers;

use Swoolecan\Foundation\Helpers\CommonTool;
use Carbon\Carbon;

class TestController extends AbstractController
{
    public function test()
    {
    $date1 = Carbon::parse('2021-4-6 01:00');//:00:01');//->startOfDay();
    print_r($date1);exit();
$date2 = Carbon::parse('2021-04-07 00:00:00');//->startOfDay();
print_r($date2);
$d = $date1->diffInDays($date2);//相差天数的绝对值（正数）
var_dump($d);exit();
        $request = $this->request;
        $inTest = config('app.inTest');
        if (empty($inTest)) {
            return $this->error(400, '非法请求');
        }
        $method = ucfirst($request->input('method', ''));
        //$method = "_test{$method}";
        //$this->$method($request);

        foreach ($r as $sCode => $info) {
            foreach ($info as $vCode => $brief) {
                //$this->getModelObj('seriesVolume')->where(['series_code' => $sCode, 'extfield' => $vCode])->update(['brief' => $brief]);
            }
        }
        exit();
        //$path = '/data/htmlwww/filesys/booksold/';
        //$files = CommonTool::getPathFiles($path);
        //$bCode = CommonTool::getSpellStr($info['name'], '');
    }

    public function _testDealguwen()
    {
        $path = '/data/htmlwww/laravel-system/vendor/candocker/website/migrations/xunzibak/';
        $files = CommonTool::getPathFiles($path);
        $elems = ['content', 'vernacular', 'note'];
        foreach ($files as $file) {
            //echo $file . "\n";
            $old = require($path . $file);
            //print_r($old);
            $name = $old['name'];

            $chapter = $old['chapters'][0];

            //echo $spellFirst;exit();
            $contentFirst = $chapter['content'][0];
            $vernacularFirst = $chapter['vernacular'][0];


            $str = "<?php\nreturn [\n    'name' => '{$name}',\n    'keyword' => '{$vernacularFirst}',\n";
            $str .= "    'chapters' => [\n        [\n";
            /*if (!isset($chapter['note'])) {
                echo $file . "\n";
            }
            continue;*/
            $nCount = count($chapter['note']);
            if ($nCount == 1) {
                $notes = [];
                $noteStr = $chapter['note'][0];
            echo $noteStr;
            $noteTmp = explode('（', $noteStr);
            print_r($noteTmp);
            foreach ($noteTmp as $i =>  $noteStr) {
                if ($i === 0) {
                    continue;
                }
                $notes[] = '（' . $noteStr;
            }
            $chapter['note'] = $notes;
            }
            //$chapter['note'] = empty($notes) ? $chapter['note'] : $notes;
            foreach ($elems as $elem) {
                $eDatas = $chapter[$elem];
                if ($elem == 'vernacular') {
                    unset($eDatas[0]);
                }
                $elemStr = $elem == 'note' ? 'notes' : $elem;
                $str .= "            '{$elemStr}' => [\n";
                foreach ($eDatas as $eData) {
                    $eStr = trim($eData);
                    $eStr = str_replace(' ', '', $eStr);
                    //$eStr = str_replace('，', '， ', $eStr);
                    $str .= "                '{$eStr}',\n";
                }
                $str .= "            ],\n";
            }
            $str .= "        ],\n    ],\n];";
            $newFile = str_replace('bak', '', $path) . $file;
            //echo $newFile;
            file_put_contents($newFile, $str);
            //print_r($old);exit();
        }
        echo 'ssssssss';
        exit();
        $infos = require('/tmp/a.php');
        $files = CommonTool::getPathFiles($path);
        //print_r($infos);exit();
        foreach ($files as $file) {
            $bIndex = str_replace('.php', '', $file);
            $author = $infos[$bIndex - 1];
            echo $file . "\n";
            $old = require($path . $file);
            $chapter = $old['chapters'][0];
            $name = $old['name'];
            $nameShort = trim(substr($name, strpos($name, ' ')));
            $name = str_replace('・', ' ', $name);
            $keyword = trim($chapter['vernacular'][0]);
            $keyword = str_replace('关键词：', '', $keyword);
            //echo $nameShort . '-' . $keyword;

            $vernacular = $chapter['vernacular'];
            //print_r($vernacular);
            $count = count($chapter['content']);
            $count2 = count($chapter['vernacular']);
            $vernacularNew = array_slice($vernacular, 0, $count + 1);
            $notes = array_slice($vernacular, $count + 1);
            //print_r($notes);
            //echo '==' . $count . '==' . $count2 . '==';

            $str = "<?php\nreturn [\n    'name' => '{$name}',\n    'nameShort' => '{$nameShort}',\n    'author' => '{$author}',\n    'keyword' => '{$keyword}',\n";
            $str .= "    'chapters' => [\n        [\n";
            $str .= "            'content' => [\n";
            foreach ($chapter['content'] as $eData) {
                /*if (strpos($eDatas[0], '·') === false && strpos($eDatas[0], '赏析') === false && strpos($eDatas[0], '关键词：') === false) {
                    echo $eDatas[0] . "\n";
                }*/
                $eStr = trim($eData);
                $eStr = str_replace(' ', '', $eStr);
                    echo $eStr . "\n";
                $str .= "                '{$eStr}',\n";
            }
            $str .= "            ],\n";
            $str .= "            'notes' => [\n";
            foreach ($notes as $eData) {
                /*if (strpos($eDatas[0], '·') === false && strpos($eDatas[0], '赏析') === false && strpos($eDatas[0], '关键词：') === false) {
                    echo $eDatas[0] . "\n";
                }*/
                $eStr = trim($eData);
                //echo $eStr . "\n";
                if (strpos($eStr, '》') !== false && strpos($eStr, '《') === false) {
                    echo $eStr . "\n";
                }
                if (strpos($eStr, '〕') !== false && strpos($eStr, '〔') === false) {
                    //echo $eStr . "\n";
                }
                if (strpos($eStr, '】') !== false && strpos($eStr, '【') === false) {
                    //echo $eStr . "\n";
                }
                    //echo $eStr . "\n";
                $eStr = str_replace(' ', '', $eStr);
                $str .= "                '{$eStr}',\n";
            }
            $str .= "            ],\n";
            if (strpos($vernacularNew[0], '关键词：') !== false) {
                unset($vernacularNew[0]);
            }
            $str .= "            'vernacular' => [\n";
            foreach ($vernacularNew as $eData) {
                /*if (strpos($eDatas[0], '·') === false && strpos($eDatas[0], '赏析') === false && strpos($eDatas[0], '关键词：') === false) {
                    echo $eDatas[0] . "\n";
                }*/
                $eStr = trim($eData);
                $eStr = str_replace(' ', '', $eStr);
                $str .= "                '{$eStr}',\n";
            }
            $str .= "            ],\n";

            $str .= "        ],\n    ],\n];";
            $newFile = str_replace('bak', '', $path) . $file;
            //file_put_contents('/tmp/c.php', $str);exit();
            //echo $newFile;
            file_put_contents($newFile, $str);
            //print_r($vernacularNew);exit();
            //print_r($old);exit();
        }


        exit();
        $path = '/data/htmlwww/laravel-system/vendor/candocker/website/migrations/shijingbak/';
        $files = CommonTool::getPathFiles($path);
        $elems = ['spell', 'content', 'vernacular', 'unscramble', 'note'];
        $infos = require('/tmp/a.php');
        foreach ($files as $file) {
            echo $file . "\n";
            $old = require($path . $file);
            //print_r($old);
            $name = $old['name'];
            $nameInfos = explode('·', $name);
            $nameNew = implode('·', array_reverse($nameInfos));
            $nameNew = str_replace('  ', ' ', $nameNew);
            $nameShort = substr($nameNew, 0, strpos($nameNew, '·'));

            $chapter = $old['chapters'][0];
            $spells = $chapter['spell'];

            $spellFirst = $chapter['spell'][0];
            //echo $spellFirst;
            $spellFirst = substr($spellFirst, strrpos($spellFirst, '·') + 2);
            $spellFirst = str_replace('  ', ' ', $spellFirst);
            $spellFirst = str_replace('  ', ' ', $spellFirst);

            //echo $spellFirst;exit();
            $contentFirst = $chapter['content'][0];
            $vernacularFirst = $chapter['vernacular'][0];


            $brief = $infos[$file];
            $str = "<?php\nreturn [\n    'name' => '{$nameNew}',\n    'nameShort' => '{$nameShort}',\n    'nameSpell' => '{$spellFirst}',\n    'brief' => '{$brief}',\n    'keyword' => '{$vernacularFirst}',\n";
            $str .= "    'chapters' => [\n        [\n";
            foreach ($elems as $elem) {
                $eDatas = $chapter[$elem];
                if ($elem != 'note') {
                    if (strpos($eDatas[0], '·') === false && strpos($eDatas[0], '赏析') === false && strpos($eDatas[0], '关键词：') === false) {
                        echo $eDatas[0] . "\n";
                    }
                    unset($eDatas[0]);
                }
                $elemStr = $elem == 'note' ? 'notes' : $elem;
                $str .= "            '{$elemStr}' => [\n";
                foreach ($eDatas as $eData) {
                    $eStr = trim($eData);
                    $eStr = str_replace(' ', '', $eStr);
                    //$eStr = str_replace('，', '， ', $eStr);
                    $str .= "                '{$eStr}',\n";
                }
                $str .= "            ],\n";
            }
            $str .= "        ],\n    ],\n];";
            $newFile = str_replace('bak', '', $path) . $file;
            //echo $newFile;
            file_put_contents($newFile, $str);
            //print_r($old);exit();
        }
        echo 'ssssssss';
        exit();
    }

    public function _testDealview()
    {
        $baseData = require('/tmp/text/f.php');
        /*foreach ($baseData as $key => & $infos) {
            foreach ($infos as & $info) {
                if ($key == 'head' && strpos($info, '<title>') !== false) {
                    $info = '';
                } else {
                    $info = trim($info);
                }
            }
        }
        var_export($baseData);exit();*/
        $basePath = '/data/htmlwww/laravel-system/vendor/candocker/website/resources/views/website/';
        $path = $basePath . 'elems/';
        //$files = CommonTool::getPathFiles($path);
        $elems = require('/tmp/nav.php');
        $splits = ['head', 'bottom', 'content', 'footer', 'main', 'nav'];
        $oldStrs = [];
        foreach ($splits as $split) {
            $oldStrs[$split] = implode('', $baseData[$split]);
        }
        foreach ($elems as $elem => $files) {
            $pElems = ['basic', 'contents', 'contents2', 'elements', 'elements2', 'interactions', 'interactions2', 'languages', 'samples'];
            $pElems = ['basic', 'contents', 'contents2', 'elements', 'elements2', 'interactions', 'interactions2', 'languages', 'samples',];//, 'contents', 'contents2', 'elements', 'interactions', 'interactions2', 'languages'];//, 'contents', 'contents2', 'elements', 'elements2', 'interactions', 'interactions2', 'languages', 'samples'];
            //$pElems = ['elements2'];
            if (!in_array($elem, $pElems)) {
                continue;
            }
            foreach ($files as $file) {
                $cSplit = 'content';
                $fullFile = $basePath . 'sources/' . $elem . '/' . $cSplit . '/_' . $file . '.blade.php';
                if (!file_exists($fullFile)) {
                    //echo $fullFile . "\n";
                    continue;
                }
                $lines = file($fullFile);
                $str = '';
                foreach ($lines as $line) {
                    if (strpos($line, '  is-active') !== false) {
                        $str .= str_replace(' is-active', '', $line);
                    } else {
                        $str .= trim($line);
                    }
                }
                if ($oldStrs[$cSplit] != $str) {
                    echo "mv $fullFile  /data/htmlwww/laravel-system/vendor/candocker/website/resources/views/website/modules/content \n";
                    //print_r($lines);
                }
            }
        }
        exit();
        foreach ($elems as $elem => $files) {
            foreach ($files as $file) {
                $fullFile = $path . $file . '.html';
                $lines = file($fullFile);
                $newLines = [];
                $key = 'head';
                foreach ($lines as $line) {
                    $r = trim($line);
                    if (empty($r)) {
                        continue;
                    }
                    $key = strpos($r, '<header class=') !== false ? 'nav' : $key;
                    $key = strpos($r, '<footer class=') !== false ? 'footer' : $key;
                    $key = strpos($r, '<main') !== false ? 'main' : $key;
                    $key = strpos($r, '<!-- Vendor -->') !== false ? 'bottom' : $key;
                    $newLines[$key][] = $line;
                    $key = $r == '</head>' ? 'content' : $key;
                    $key = $r == '</header>' ? 'content' : $key;
                    $key = $r == '</footer>' ? 'content' : $key;
                    $key = $r == '</main>' ? 'content' : $key;
                }
                foreach ($newLines as $page => $pageInfos) {
                    $cStr = '';
                    if ($page == 'main') {
                        $cStr .= "@extends('layouts.website')\n@section('bodyClass')class=\"page\"@endsection\n@section('content')\n";
                        $cStr .= implode('', $pageInfos);
                        $cStr .= "@endsection";
                    } else {
                        $cStr = implode('', $pageInfos);
                    }
                    //$newFile = $basePath . 'elems/' . $elem . '/_' . $page . '-' . $file . '.blade.php';
                    $newFile = $basePath . 'sources/' . $elem . '/' . $page . '/_' . $file . '.blade.php';
                    file_put_contents($newFile, $cStr);
                }
                //var_export($newLines);exit();
                //print_r($newLines);
                echo $fullFile;
            }
        }
        print_r($elems);exit();
    }

    public function _testDealBook()
    {
        $file = '/data/database/books/simaqian/shijizhu/s.txt';
        $r = file($file);
        $result = [];
        $key = 'pre';
        foreach ($r as $info) {
            $info = trim($info);
            if (empty($info)) {
                continue;
            }
            if (strpos($info, '●卷') !== false) {
                $key = $info;
            } else {
                $result[$key][] = $info;
            }
        }
        //print_r($result);exit();
        $pathPre = '/data/database/books/simaqian/shijizhu/';
        $i = 0;
        foreach ($result as $key => $value) {
            $content = $key . "\r\n\r\n";
            $content .= implode("\r\n\r\n", $value);
            $file = "{$pathPre}{$i}.txt";
            echo $file . "<br />";
            file_put_contents($file, $content);
            $i++;
        }
        exit();
        print_r(array_keys($result));
        exit();
    }

    public function _test()
    {
        //exit();
    }
}
