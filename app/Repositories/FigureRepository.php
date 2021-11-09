<?php
declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class FigureRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'code', 'name', 'photo', 'name_card', 'nationality', 'dynasty', 'birthday', 'deathday', 'ftitle', 'description', 'created_at', 'status'],
            'listSearch' => ['id', 'name', 'keyword'],
            'keyvalueExtSearch' => ['id', 'name', 'keyword'],
            'add' => ['code', 'name', 'photo', 'name_card', 'nationality', 'dynasty', 'birthday', 'deathday', 'ftitle', 'description', 'status'],
            'update' => ['code', 'name', 'photo', 'name_card', 'nationality', 'dynasty', 'birthday', 'deathday', 'ftitle', 'description', 'status'],
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
}
