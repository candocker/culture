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
        $path = "{$base}{$book['path']}/{$book['code']}/";
        return $path;
    }

    /*public function getChapterFile($chapter, $returnContent = true)
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
    }*/

    protected function getAppcode()
    {
        return 'culture';
    }

    public function wrapWiki($name = null)
    {
        $name = is_null($name) ? $this->name : $name;
        $name = $this->baidu_url ? "<a href='{$this->baidu_url}' target='_blank'>{$name}</a>" : $name;
        $name = $this->wiki_url ? "{$name} <a href='{$this->wiki_url}' target='_blank'>WIKI</a>" : $name;
        return $name;
    }
}
