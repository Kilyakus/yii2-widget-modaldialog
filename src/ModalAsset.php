<?php
namespace kilyakus\widget\modal;

class ModalAsset extends \kilyakus\widgets\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/modal'],'widget-css-modal');
        $this->setupAssets('js', ['js/modal','js/modal.dialogextend'],'widget-js-modal');
        parent::init();
    }
}
