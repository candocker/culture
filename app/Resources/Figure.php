<?php

namespace ModuleCulture\Resources;

class Figure extends AbstractResource
{
    protected function _frontDetailArray()
    {
        $data = $this->_frontInfoArray();
        return $data;
    }

    protected function _frontInfoArray()
    {
        return [];
    }

    protected function _frontBaseArray()
    {
        $suffix = '?x-oss-process=image/resize,m_pad,h_250,w_150';
        $photoUrl = $this->photoUrl ? $this->photoUrl . $suffix : '';
        $photoUrl = $photoUrl ? "<img src='{$photoUrl}' />" : '';
        $name = $this->wrapWiki($this->name);
        $name .= "<br />{$this->name_card}";
        $titleDatas = $this->getFtitleDatas();
        foreach ($titleDatas as $titles) {
            foreach ($titles as $title) {
                $name .= "<br />{$title}";
            }
        }
        $ageInfo = $this->getBirthDeath();
        $ageStr = "{$ageInfo['ageStr']}<br />{$ageInfo['birthStr']}<br />{$ageInfo['deathStr']}";

        return [              
            'id' => $this->id,
            'code' => $this->code,
            'name' => $name,
            'ageStr' => $ageStr,
            'description' => $this->textMore($this->code, $this->description),
            'photoUrl' => $photoUrl,
            'colspan' => '1',
            'style' => '',
        ];
    }
}
