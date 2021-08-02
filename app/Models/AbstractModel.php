<?php

declare(strict_types = 1);

namespace ModuleCulture\Models;

use Framework\Baseapp\Models\AbstractModel as AbstractModelBase;

class AbstractModel extends AbstractModelBase
{
    protected $connection = 'culture';

	public function getBookPath($book)
	{
		$base = $this->config->get('culture.book_path');
		$path = "{$base}{$book['author']}/{$book['code']}/";
		return $path;
	}

	public function getChapterFile($chapter, $returnContent = true)
	{
		$path = $this->getBookPath($chapter->book);
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

    public function formatTagDatas($tagInfos)
    {
        $datas = [];
        foreach ($tagInfos as $tagInfo) {
            $tag = $tagInfo->tag;
            if (empty($tag)) {
                continue;
            }
            $datas[$tag['code']] = $tag['name'];
        }
        return $datas;
    }

    protected function getAppcode()
    {
        return 'culture';
    }
}
