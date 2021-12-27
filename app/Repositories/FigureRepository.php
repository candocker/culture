<?php
declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class FigureRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'code', 'name', 'photo', 'name_card', 'nationality', 'dynasty', 'birthday', 'deathday', 'ftitle', 'description', 'created_at', 'status', 'point_operation'],
            'listSearch' => ['id', 'name', 'keyword'],
            'keyvalueExtSearch' => ['id', 'name', 'keyword'],
            'add' => ['code', 'name', 'photo', 'name_card', 'nationality', 'dynasty', 'birthday', 'deathday', 'ftitle', 'baidu_url', 'wiki_url', 'description', 'status'],
            'update' => ['code', 'name', 'photo', 'name_card', 'nationality', 'dynasty', 'birthday', 'deathday', 'ftitle', 'baidu_url', 'wiki_url', 'description', 'status'],
        ];
    }

    public function getShowFields()
    {
        return [
            'birthday' => ['valueType' => 'extinfo', 'extType' => 'dateinfo'],
            'deathday' => ['valueType' => 'extinfo', 'extType' => 'dateinfo'],
            'ftitle' => ['valueType' => 'extinfo', 'extType' => 'ftitle'],
        ];
    }

    public function getFormFields()
    {
        return [
            'birthday' => ['type' => 'dateinfo', 'accurateInfos' => $this->getKeyValues('accurate'), 'eraInfos' => $this->getKeyValues('eraType')],
            'deathday' => ['type' => 'dateinfo', 'accurateInfos' => $this->getKeyValues('accurate'), 'eraInfos' => $this->getKeyValues('eraType')],
            'ftitle' => ['type' => 'complexSelect', 'infos' => $this->getKeyValues('ftitle')],
        ];
    }

    public function getSearchFields()
    {
        return [
        ];
    }

    public function getSearchDealFields()
    {
        return [
        ];
    }

    public function _getFieldOptions()
    {
        return [
        ];
    }

    protected function _pointOperations($model, $field)
    {
        $add = [
            'name' => '添加履历',
            'type' => 'popForm',
            'resource' => 'figureResume',
            'app' => $this->getAppcode(),
            'params' => ['figure_code' => $model->code],
        ];

        $list = [
            'name' => '履历列表',
            'type' => 'popTable',
            'resource' => 'figureResume',
            'app' => $this->getAppcode(),
            'params' => ['figure_code' => $model->code],
        ];
        return [$add, $list];
    }
}
