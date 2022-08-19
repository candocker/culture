<?php

declare(strict_types = 1);

namespace ModuleCulture\Resources;

class Series extends AbstractResource
{
    protected function _frontBaseArray()
    {
        return [              
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'brief' => $this->brief,
            'publish_at' => $this->publish_at,
            'description' => $this->description,
            'press' => $this->getRepository()->getKeyValues('press', $this->press),
        ];
    }

    protected function _frontInfoArray()
    {
        $volumes = $this->volumes;
        $vDatas = $this->getCollectionObj('seriesVolume', ['resource' => $volumes, 'scene' => 'frontInfo', 'repository' => $this->getRepositoryObj('seriesVolume'), 'simpleResult' => true]);
        $data = $this->_frontBaseArray();
        $data['volumes'] = $vDatas;
        return $data;
    }
}
