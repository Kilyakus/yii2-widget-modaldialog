<?php
namespace kilyakus\widget\modal;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use kilyakus\button\Button;

class Modal extends \kilyakus\widgets\Widget
{
    public $header;

    public $headerOptions;

    public $bodyOptions = [];

    public $footer;

    public $footerOptions;

    public $toggleButton = false;

    public $pluginOptions = [];

    public $clientOptions = [];

    protected $pluginPreset = [
        'autoOpen' => false,
        'width' => 400,
        'height' => 'auto',
        'modal' => true,
        'resizable' => true,
        'draggable' => true,
        'stack' => true,
    ];

    protected $clientPreset = [
        'show' => [
            'effect' => 'puff',
            'duration' => 100
        ],
        'hide' => [
            'effect' => 'puff',
            'duration' => 200
        ],
    ];

    public function init()
    {
        parent::init();

        $this->initOptions();

        echo $this->renderToggleButton();
        echo Html::beginTag('div', $this->options);
        echo Html::beginTag('div', $this->bodyOptions);
    }

    public function run()
    {
        echo Html::endTag('div');
        echo $this->renderFooter();
        echo Html::endTag('div');

        $this->registerPlugin('dialog');
    }

    protected function renderFooter()
    {
        if ($this->footer !== null) {
            Html::addCssClass($this->footerOptions, ['widget' => 'modal-widget-footer']);
            return Html::tag('div', $this->footer, $this->footerOptions);
        } else {
            return null;
        }
    }

    protected function renderToggleButton()
    {
        if ($this->toggleButton !== false) {
            return Button::widget($this->toggleButton);
        } else {
            return null;
        }
    }

    protected function initOptions()
    {
        $this->options = array_merge([
            'role' => 'dialog',
            'tabindex' => -1,
        ], $this->options);
        Html::addCssStyle($this->options, ['display' => 'none']);
        Html::addCssClass($this->bodyOptions, ['class' => 'modal-widget-body']);

        if ($this->toggleButton !== false) {
            $this->toggleButton['options'] = array_merge([
                'data-toggle' => 'dialog',
            ], $this->toggleButton);
            if (!isset($this->toggleButton['options']['data-target']) && !isset($this->toggleButton['url'])) {
                $this->toggleButton['options']['data-target'] = '#' . $this->options['id'];
            }
        }

        if(!empty($this->clientOptions)){
            $this->clientOptions = array_merge($this->clientPreset, $this->clientOptions);
        }else{
            $this->clientOptions = $this->clientPreset;
        }

        if(!empty($this->pluginOptions)){
            $this->pluginOptions = array_merge($this->pluginPreset, $this->pluginOptions);
        }else{
            $this->pluginOptions = $this->pluginPreset;
        }

        $this->pluginOptions = array_merge_recursive($this->pluginOptions, $this->clientOptions);

        if($this->header){
            $this->pluginOptions = array_merge_recursive($this->pluginOptions, ['title' => $this->header]);
        }

        $this->pluginOptions = Json::encode($this->pluginOptions); 

        $view = $this->getView();

        $view->registerJs("
            $(function(){

                var dialog = $('#" . $this->id . "');

                $(document).ready(function(){
                    dialog.dialog(" . $this->pluginOptions . ");
                });

                $('[data-target=\"#" . $this->id . "\"][data-toggle=\"dialog\"]').click(function(){


                    var dialogExtendOptions = {
                        'closable' : true,
                        'maximizable' : true,
                        'minimizable' : true,
                        'minimizeLocation' : 'left' || false,
                        'collapsable' : false,
                        'dblclick' : 'collapse' || false,
                        'titlebar' : false
                    };

                    dialog.dialogExtend(dialogExtendOptions);

                    dialog.dialog( 'open' );
                });
            });", \yii\web\View::POS_READY);
    }
}
