<?php

namespace ModuleCulture\Controllers;

use Overtrue\Pinyin\Pinyin;

trait DealBookTrait
{
	public function dealBook()
	{
		$model = $this->getPointModel('book');
		$infos = $model->getInfos();
		foreach ($infos as $info) {
			$data = ['tag_code' => $info['author'], 'info_id' => $info['id'], 'info_type' => 'book'];
			$this->getPointModel('tag-info-culture')->createRecord($data, false);
		}
		echo count($infos);exit();
	}

	public function dealChapter()
	{
		$model = $this->getPointModel('book');
		$infos = $model->getInfos(['limit' => 50, 'orderBy' => ['id' => SORT_ASC], 'where' => ['status' => '92']]);
		$basePath = '/data/database/books';
        $datas = \common\helpers\DirectoryHelper::pathFiles($basePath);
		foreach ($infos as $info) {
			$path = "/{$info['author']}/{$info['code']}";
			$this->_chapter($basePath . $path, $datas[$path], $info);
			$info->status = 91;
			$info->update(false, ['status']);
		}
		echo 'sss';
		exit();
	}

	public function _chapter($path, $datas, $book)
	{
		foreach ($datas as $fileBase) {
			$file = "{$path}/{$fileBase}";
			if (in_array($fileBase, ['center.txt', 'fm.txt', 'qy000.txt', 'index.txt', 'cover.txt']) && file_exists($file)) {
				unlink($file);
				continue;
			}
			$lines = file($file);
    		$code = str_replace('.txt', '', $fileBase);
			$serial = intval($code);
			$serial = $serial > 1000 ? $serial - 1000 : $serial;
    		$data = [
    			'book_code' => $book['code'],
				'serial' => $serial,
    			'name' => trim($lines[0]),
    			'code' => $code,
    			'author' => $book['author'],
    		];
			print_r($data);
    		$this->getPointModel('chapter')->addInfo($data);
			//var_dump($last);
			//var_dump($lines[0]);
			continue;
			//$content = file_get_contents($file);
			//$content = str_replace([$last, $lines[0]], ['', ''], $content);
			//$content = trim($content);
			//$content = mb_convert_encoding ($content, 'UTF-8','gbk');
			//file_put_contents($file, $content);
		}
	}

	public function dealBookold()
	{
		$path = '/data/database/books/jd/';
		$bases = [
			'汉译世界学术名著丛书（中国卷）' => '中国',
			'汉译世界学术名著丛书（其它卷）' => '其它',
			'汉译世界学术名著丛书（德国卷）' => '德国',
			'汉译世界学术名著丛书（法国卷）' => '法国',
			'汉译世界学术名著丛书（英国卷）' => '英国',
			'汉译世界学术名著丛书（美国卷）' => '美国',
		];
        $datas = \common\helpers\DirectoryHelper::pathFiles($path);
		foreach ($datas as $bCode => $files) {
			if (in_array($bCode, array_keys($bases))) {
				continue;
			}
			list($base, $bName) = explode('/', $bCode);
			$tagStr = '汉译世界学术名著,' . $bases[$base];
			$name = substr($bName, 3, strpos($bName, '》') - 3);
			$figure = substr($bName, strpos($bName, ']') + 1);
			$fCode = Pinyin::trans($figure, ['delimiter' => '', 'accent' => false]);
			$fCode = str_replace(['.', '．', '·'], ['-', '-', '-'], $fCode);
			$fCode = strtolower($fCode);
			$bookCode = Pinyin::trans($name, ['delimiter' => '', 'accent' => false]);
			$bookCode = str_replace(['、', '<', '>', '？'], ['', '', '', ''], $bookCode);
			$fData = [
				'code' => $fCode,
				'name' => $figure,
				'status' => 1,
			];
			$exist = $this->getPointModel('figure')->getInfo(['code' => $fCode, 'name' => $figure]);
			if (empty($exist)) {
			    //$this->getPointModel('figure')->addInfo($fData);
			}
			$tagStr .= '汉译世界学术名著,' . $bases[$base] . ',' . $name . ',' . $figure;
			$bData = [
				'code' => $bookCode,
				'name' => $name,
				'author' => $fCode,
				'note' => $tagStr,
			];
			//$this->getPointModel('book')->addInfo($bData);
			//echo $base . '-' . $bName . '==' . $name . '==' . $figure . '==' . $fCode . '==' . $bCode . "\n";
			$oldPath = "/data/database/books/jd/{$bCode}";
			$newPath = "/data/database/books/{$fCode}/{$bookCode}";
			if (!is_dir(dirname($newPath))) {
			    mkdir(dirname($newPath), 0777, true);
			}
			rename($oldPath, $newPath);
			echo $oldPath . '==' . $newPath . "\n";

			continue;
			//print_r($files);
			continue;
			foreach ($files as $fileBase) {
			    $file = "{$path}{$bCode}/{$fileBase}";
				//$this->formatContent($file);
				//$this->putChapter($file, $bCode, $fileBase);
			}
		}
		exit();
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

	protected function putChapter($file, $bCode, $fileBase)
	{
		echo $bCode . '--';
		$infos = file($file);
		$title = $infos[0];
		$title = str_replace(['〔1〕', '〔１〕', '①'], ['', ''], $title);
		$title = trim($title);
		echo $title . '<br />';
		$data = [
			'book_code' => $bCode,
			'name' => $title,
			'code' => Pinyin::letter($title, ['delimiter' => '', 'accent' => false]),
			'title' => str_replace('.txt', '', $fileBase),
			'author' => 'luxun',
		];
		$this->model->addInfo($data);
	}

	protected function dealLuxun()
	{
		$infos = $this->model->getInfos(['limit' => 2000]);
		foreach ($infos as $info) {
			$serial = $info['write_at'] - $this->baseList($info['book_code']) + 1;
			echo $serial . '==' . $info['name'] . '--' . $info['write_at'] . '--' . $this->baseList($info['book_code']) . '<br />';
			$info->serial = $serial;
			$info->update(false, ['serial']);
		}
		exit();

		$path = '/data/database/books/luxun/';
		$datas = [];
        $datas = \common\helpers\DirectoryHelper::pathFiles($path);
		foreach ($datas as $bCode => $files) {
			foreach ($files as $fileBase) {
			    $file = "{$path}{$bCode}/{$fileBase}";
				//$this->formatContent($file);
				//$this->putChapter($file, $bCode, $fileBase);
			}
		}
    }

	protected function baseList($code)
	{
		static $datas;
		if (isset($datas[$code])) {
			return $datas[$code];
		}
		$first = $this->model->getInfo(['where' => ['book_code' => $code], 'orderBy' => ['write_at' => SORT_ASC]]);
		$datas[$code] = $first['write_at'];
		return $first['write_at'];
	}

	public function dealBookpass()
	{
		$path = '/data/database/books/jd/';
		$bases = [
			'汉译世界学术名著丛书（中国卷）' => '中国',
			'汉译世界学术名著丛书（其它卷）' => '其它',
			'汉译世界学术名著丛书（德国卷）' => '德国',
			'汉译世界学术名著丛书（法国卷）' => '法国',
			'汉译世界学术名著丛书（英国卷）' => '英国',
			'汉译世界学术名著丛书（美国卷）' => '美国',
		];
        $datas = \common\helpers\DirectoryHelper::pathFiles($path);
		foreach ($datas as $bCode => $files) {
			if (in_array($bCode, array_keys($bases))) {
				continue;
			}
			list($base, $bName) = explode('/', $bCode);
			$tagStr = '汉译世界学术名著,' . $bases[$base];
			$name = substr($bName, 3, strpos($bName, '》') - 3);
			$figure = substr($bName, strpos($bName, ']') + 1);
			$fCode = Pinyin::trans($figure, ['delimiter' => '', 'accent' => false]);
			$fCode = str_replace(['.', '．', '·'], ['-', '-', '-'], $fCode);
			$fCode = strtolower($fCode);
			$bookCode = Pinyin::trans($name, ['delimiter' => '', 'accent' => false]);
			$bookCode = str_replace(['、', '<', '>', '？'], ['', '', '', ''], $bookCode);
			$fData = [
				'code' => $fCode,
				'name' => $figure,
				'status' => 1,
			];
			$exist = $this->getPointModel('figure')->getInfo(['code' => $fCode, 'name' => $figure]);
			if (empty($exist)) {
			    //$this->getPointModel('figure')->addInfo($fData);
			}
			$tagStr .= '汉译世界学术名著,' . $bases[$base] . ',' . $name . ',' . $figure;
			$bData = [
				'code' => $bookCode,
				'name' => $name,
				'author' => $fCode,
				'note' => $tagStr,
			];
			//$this->getPointModel('book')->addInfo($bData);
			//echo $base . '-' . $bName . '==' . $name . '==' . $figure . '==' . $fCode . '==' . $bCode . "\n";
			$oldPath = "/data/database/books/jd/{$bCode}";
			$newPath = "/data/database/books/{$fCode}/{$bookCode}";
			if (!is_dir(dirname($newPath))) {
			    mkdir(dirname($newPath), 0777, true);
			}
			rename($oldPath, $newPath);
			echo $oldPath . '==' . $newPath . "\n";

			continue;
			//print_r($files);
			continue;
			foreach ($files as $fileBase) {
			    $file = "{$path}{$bCode}/{$fileBase}";
				//$this->formatContent($file);
				//$this->putChapter($file, $bCode, $fileBase);
			}
		}
		exit();
	}
}
