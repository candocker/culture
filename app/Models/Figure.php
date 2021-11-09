<?php

namespace ModuleCulture\Models;

class Figure extends AbstractModel
{
    protected $table = 'figure';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    protected $guarded = ['id'];

    public function afterSave()
    {
        $request = request();
        $ftitle = $request->input('ftitle');
        if (!is_null($ftitle)) {
            $this->getModelObj('figureTitle')->recordTitle($ftitle, $this->code);
        }
        foreach (['birthday', 'deathday'] as $elem) {
            $value = $request->input($elem);
            if (!is_null($value)) {
                $this->getModelObj('dateinfo')->recordDateinfo($elem, $value, 'figure', $this->id);
            }
        }

        return true;
    }

    public function getFtitle($type = 'all')
    {
        $titles = $this->getFtitleDatas();
        $str = '';
        $repository = $this->getRepositoryObj('figure');
        $ftitleDatas = $repository->getKeyValues('ftitle');
        $result = [];
        foreach ($titles as $key => $value) {
            $kName = $ftitleDatas[$key] ?? $key;
            foreach ($value as $cTitle) {
                $result["{$key}:{$cTitle}"] = "{$kName}:{$cTitle}";
            }
        }
        return ['source' => $result, 'show' => implode('||', $result)];
    }

    public function getFtitleDatas($type = null)
    {
        $where = ['figure_code' => $this->code];
        $infos = $this->getModelObj('figureTitle')->where($where)->orderBy('type')->get();
        $results = [];
        foreach ($infos as $info) {
            $results[$info['type']][] = $info['title'];
        }
        if (!is_null($type)) {
            return $results[$type] ?? [];
        }
        return $results;
    }
}
