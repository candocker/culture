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
        //$path = '/data/htmlwww/filesys/booksold/';
        //$files = CommonTool::getPathFiles($path);
        //$bCode = CommonTool::getSpellStr($info['name'], '');
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
        $path = '/data/database/books/';
        $filePath = '/data/htmlwww/filesys/books/';
        $files = CommonTool::getPathFiles($path);
        $command = '';
        /*foreach ($files as $file) {
            $subPath = $path . $file;
            $subFiles = CommonTool::getPathFiles($subPath);
            foreach ($subFiles as $subFile) {
                $book = $this->getModelObj('book')->where(['code' => $subFile])->first();
                if (empty($book)) {
                    $fileNew = str_replace(['.epub', '—', '——', '-', '·', '：'], ['', '', '', '', '', ''], $subFile);
                    //echo $subFile . '=' . $subFile . '==<br />';
                    $command .= "mv {$subPath}/{$subFile} {$subPath}/{$fileNew};\n";
                }
            }
        }*/
        $infos = $this->getModelObj('book')->where(['type' => 'epub'])->limit(2000)->get();
        foreach ($infos as $info) {
            $bookPath = $path . $info['path'] . '/' . $info['code'];
            $epubPath = $filePath . $info['path'] . '/' . $info['code'] . '.epub';
            if (!file_exists($bookPath)) {
                echo 'bbb-' . $info['name'] . '==' . $bookPath . '<br />';
            }
            if (!file_exists($epubPath)) {
                echo 'fff-' . $info['name'] . '==' . $epubPath . '<br />';
            }
        }
        echo $command;
        exit();

        //$bookFigures = $this->getModelObj('bookFigure')->where(['figure_code' => 'luxun'])->limit(2000)->get();
        $infos = $this->getModelObj('book')->where(['type' => 'epub'])->limit(2000)->get();
        $str = '';
        foreach ($infos as $info) {
            $count = $this->getModelObj('book')->where(['code' => $info['book_code']])->count();
            if (empty($count) || $count > 1) {
                echo $count . '-' . $info->book_code . '-' . $info->name . '<br />';// . '==' . "<a href='{$info->book['baidu_url']}' target='_blank'>{$info->book['name']}</a>" . '<br />';
                $str .= "'{$info->book_code}',";
            }
        }
        echo $str;
        exit();
    }

    public function _test()
    {
        //exit();
    }
}
