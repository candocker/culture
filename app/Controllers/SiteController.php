<?php

namespace ModuleCulture\Controllers;

use bench\models\Wage;

class SiteController extends AbstractController
{
	public function actionBook()
	{

		$provider = $this->_getProviderObj('website');
    	$myParams = [
    		'where' => ['user_id' => $this->userInfo['id']],
    	];
    	$websiteIds = $this->getPointModel('business-base')->getInfosKeys($myParams, 'website_id');

		if ($this->checkAjax()) {
			$return = $this->formatListDatas($provider);
			$return['datas']['relateWebsites'] = $websiteIds;
			return $return;
		}

        return $this->render('/site/book', ['provider' => $provider, 'relateScenes' => $relaetScenes]);
	}
}
