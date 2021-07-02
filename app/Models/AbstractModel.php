<?php

declare(strict_types = 1);

namespace ModulePassport\Models;

use Framework\Baseapp\Models\AbstractModel as AbstractModelBase;

class AbstractModel extends AbstractModelBase
{

	public function getBookPath($book)
	{
		$base = Yii::$app->params['bookPath'];
		$path = "{$base}{$book['author']}/{$book['code']}/";
		return $path;
	}

	public function getChapterFile($chapter, $returnContent = true)
	{
		$path = $this->getBookPath($chapter->bookData);
		$file = "{$path}{$chapter['code']}.txt";
		if (!$returnContent) {
			return $file;
		}
		if (!file_exists($file)) {
			return 'no content';
		}
		$content = file_get_contents($file);
		return $content;
	}
}
