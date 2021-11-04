<?php
declare(strict_types = 1);

namespace ModuleCulture\Repositories;

class FigureRepository extends AbstractRepository
{
    protected function _sceneFields()
    {
        return [
            'list' => ['id', 'code', 'name', 'photo', 'name_card', 'nationality', 'dynasty', 'birthday', 'deathday', 'othername', 'description', 'created_at', 'status'],
            'listSearch' => ['id', 'name'],
            'add' => ['code', 'name', 'photo', 'name_card', 'nationality', 'dynasty', 'birthday', 'deathday', 'othername', 'description', 'status'],
            'update' => ['code', 'name', 'photo', 'name_card', 'nationality', 'dynasty', 'birthday', 'deathday', 'othername', 'description', 'status'],
        ];
    }

    public function getFormFields()
    {
        return [
            'birthday' => ['type' => 'dateinfo', 'accurateInfos' => $this->getKeyValues('accurate'), 'eraInfos' => $this->getKeyValues('eraType'), 'customValue' => 3],
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
