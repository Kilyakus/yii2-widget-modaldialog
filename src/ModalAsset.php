<?php
namespace kilyakus\widget\modal;

class ModalAsset extends \kilyakus\widgets\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/widget-modal.min'],'widget-css-modal');
        $this->setupAssets('js', ['js/widget-modal.min','js/widget-modal_dialogextend.min'],'widget-js-modal');
        parent::init();
    }
}
