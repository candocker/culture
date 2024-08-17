<?php

namespace ModuleCulture\Controllers;

use Symfony\Component\DomCrawler\Crawler;
use Overtrue\Pinyin\Pinyin;

trait DealBookTrait
{
    public function dealBookpass()
    {
        $infos = \DB::SELECT('SELECT `id`, `name`, LEFT(`name`, 3) AS `key` FROM `data_culture`.`wp_book` WHERE 1 ');
        $results = [];
        foreach ($infos as $info) {
            $results[$info->key][$info->id] = $info->name;
        }
        $tmps = [];
        foreach ($results as $key => $kData) {
            if (count($kData) > 1) {
                var_dump($key);
                foreach ($kData as $id => & $name) {
                    $info = $this->getModelObj('book')->where(['id' => $id])->first();
                    $author = $info->formatAuthorData();
                    $tmps[$author][] = $name;
                    $name .= '==' . $author;
                }
                print_r($kData);
            }
        }
        foreach ($tmps as $author => $aTmp) {
            if (count($aTmp) > 1) {
                var_dump($author);
                print_r($aTmp);
            }
        }
        //print_r($tmps);
        exit();
        print_R($results);exit();

        print_r($infos);
        exit();
        $book = $this->getModelObj('book')->where('code', 'guwenguanzhi')->first();
        $chapters = $book->chapters;
        $a = $b = [];
        foreach ($chapters as $chapter) {
            $n = $chapter['name'];
            if (strpos($n, ' ')) {
                $tmp = explode(' ', $n);
                $n = array_pop($tmp);
            }
            $a[$n] = $chapter['name'];
        }
        $gwgz = require('/data/database/material/booklist/guwenguanzhi_catalogue.php');
        foreach ($gwgz as $gw) {
            $b[] = $gw['name'];
        }
        foreach ($a as $key => $suba) {
            if (!in_array($key, $b)) {
                var_dump($suba);
            }
        }
        //print_r($a);
        //print_r($b);
        exit();

        /*$driver = \Storage::disk('local');
        $datas = $driver->allFiles('bookold');
        $tmps = [];
        $command = '';
        exit();*/
        $oldPath = '/data/database/books/';
        $basePath = '/data/htmlwww/resource/books/';

        $infos = $this->getModelObj('book')->where('type', 'epub')->limit(500)->get();
        foreach ($infos as $info) {
        }
        echo $command;
    }

    public function _formatContent($contents)
    {
        $str = "<?php\nreturn [\n'chapters' => [\n";
        foreach ($contents as $content) {
            $content = str_replace(['　'], [''], $content);
            $content = trim($content);
            if (empty($content)) {
                continue;
            }
            $str .= "[\n    'content' => [\n        '{$content}',\n    ],\n],\n";
        }
        $str .= "],\n];";
        return $str;
    }

    public function dealBook()
    {
        $model = $this->getModelObj('book');
        $infos = $model->getInfos();
        foreach ($infos as $info) {
            $data = ['tag_code' => $info['author'], 'info_id' => $info['id'], 'info_type' => 'book'];
            $this->getPointModel('tag-info-culture')->createRecord($data, false);
        }
        echo count($infos);exit();
    }

    protected function formatContent($file)
    {
        $content = file_get_contents($file);
        $content = str_replace(['　', ' '], ['', ''], $content);
        $content = str_replace("\r\n", "\n", $content);
        $content = trim($content, "\n");
        //var_dump($content);exit();
        file_put_contents($file, $content);
    }

    public function dealLongContent()
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
            //file_put_contents($file, $content);
            $i++;
        }
        exit();
        print_r(array_keys($result));
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

    public function getCrawlerObj($file)
    {
        $crawler = new Crawler();
        $content = file_get_contents($file);
        if (empty($content)) {
            var_dump($file);exit();
        }
        $crawler->addContent($content);
        return $crawler;
    }

    public function getBaseBookDatas()
    {
        $pathBase = '/data/backup/database/books/booksource/jd/';
        $bases = [
            '汉译世界学术名著丛书（中国卷）' => '中国',
            '汉译世界学术名著丛书（其它卷）' => '其它',
            '汉译世界学术名著丛书（德国卷）' => '德国',
            '汉译世界学术名著丛书（法国卷）' => '法国',
            '汉译世界学术名著丛书（英国卷）' => '英国',
            '汉译世界学术名著丛书（美国卷）' => '美国',
            '汉译世界学术名著丛书（美国卷）ext' => '美国ext',
        ];
        $results = [];
        foreach ($bases as $path => $bName) {
            $indexFile = $pathBase . $path . '/index.htm';
            if (!file_exists($indexFile)) {
                var_dump($indexFile);
            }
            $crawler = $this->getCrawlerObj($indexFile);
            $bDatas = [];
            $crawler->filter('a')->each(function ($node) use (& $bDatas) {
                $url = $node->attr('href');
                $img = $node->filter('img');
                $imgUrl = '';
                if (count($img) > 0) {
                    $imgUrl = $img->attr('src');
                }
                $bDatas[] = ['url' => $url, 'img' => $imgUrl];
            });
            $results[$bName] = $bDatas;
        }
        var_export($results);exit();
    }
}
