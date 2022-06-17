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

    public function getDateinfo($type, $result = 'format')
    {
        $keyField = $this->getKeyField();
        $where = ['type' => $type, 'info_type' => $this->table, 'info_key' => $this->$keyField];
        $info = $this->getModelObj('dateinfo')->where($where)->first();
        if ($result == 'full') {
            if (empty($info)) {
                \Log::info('no-info-' . serialize($this->toArray()));
            }
            return $info ? $info->toArray() : [];
        }
        $result = [
            'source' => $info ? $info->formatDateinfo() : '',
            'show' => $info ? $info->formatDateinfo('show') : '',
            'info' => $info ? $info->toArray() : [],
        ];
        return $result;
    }

    public function getStartEnd()
    {
        $repository = $this->getRepositoryObj('dateinfo');
        $typeDatas = $repository->getKeyValues('accurate');

        $start = $this->getDateinfo('start', 'full');
        $end = $this->getDateinfo('end', 'full');
        if (empty($start) ||empty($end)) {
            print_r($this->toArray());
            return ['ageStr' => '', 'startStr' => '', 'endStr' => ''];
        }
        $age = $end['accurate'] == 'running' ? '-' : '';
        $age = empty($age) ? $start['accurate'] == 'unknown' || $end['accurate'] == 'unknown' ? '未知' : $end['year'] - $start['year'] + 1 : $age;
        $startStr = empty($start['year']) ? '-' : "{$start['year']} / {$start['month']} / {$start['day']}";
        $startStr = ($start['accurate'] ? $typeDatas[$start['accurate']] . ' ' : '') . $startStr;

        $endStr = empty($end['year']) ? '-' : "{$end['year']} / {$end['month']} / {$end['day']}";
        $endStr = ($end['accurate'] ? $typeDatas[$end['accurate']] . ' ' : '') . $endStr;

        return [
            'timeSpan' => intval($age),
            'startStr' => '起始时间:' . $startStr,
            'endStr' => '截止时间:' . $endStr,
        ];
    }
}
