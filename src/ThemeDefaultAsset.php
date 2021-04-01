<?php
namespace kilyakus\portlet;

class ThemeDefaultAsset extends \kilyakus\widgets\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/widget-modal_default'],'widget-modal-theme-default');
        parent::init();
    }
}
