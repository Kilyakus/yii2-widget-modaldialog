<?php
namespace kilyakus\widget\modal;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class Modal extends \kilyakus\widgets\Widget
{
    const SIZE_LARGE = "modal-lg";
    const SIZE_SMALL = "modal-sm";
    const SIZE_DEFAULT = "";

    public $header;

    public $headerOptions;

    public $bodyOptions = ['class' => 'modal-body'];

    public $footer;

    public $footerOptions;

    public $size;

    public $closeButton = [];

    public $toggleButton = false;

    public function init()
    {
        parent::init();

        $this->initOptions();

        echo $this->renderToggleButton();
        echo Html::beginTag('div', $this->options);
        echo Html::beginTag('div', ['class' => 'modal-dialog ' . $this->size]);
        echo Html::beginTag('div', ['class' => 'modal-content']);
        echo $this->renderHeader();
        echo $this->renderBodyBegin();
    }

    public function run()
    {
        echo $this->renderBodyEnd();
        echo $this->renderFooter();
        echo Html::endTag('div'); // modal-content
        echo Html::endTag('div'); // modal-dialog
        echo Html::endTag('div');

        $this->registerPlugin('modal');
    }

    protected function renderHeader()
    {
        $button = $this->renderCloseButton();
        if ($button !== null) {
            $this->header = $button . $this->header;
        }
        if ($this->header !== null) {
            Html::addCssClass($this->headerOptions, ['widget' => 'modal-header']);
            return Html::tag('div', $this->header, $this->headerOptions);
        } else {
            return null;
        }
    }

    protected function renderBodyBegin()
    {
        return Html::beginTag('div', $this->bodyOptions);
    }

    protected function renderBodyEnd()
    {
        return Html::endTag('div');
    }

    protected function renderFooter()
    {
        if ($this->footer !== null) {
            Html::addCssClass($this->footerOptions, ['widget' => 'modal-footer']);
            return Html::tag('div', $this->footer, $this->footerOptions);
        } else {
            return null;
        }
    }

    protected function renderToggleButton()
    {
        if (($toggleButton = $this->toggleButton) !== false) {
            $tag = ArrayHelper::remove($toggleButton, 'tag', 'button');
            $label = ArrayHelper::remove($toggleButton, 'label', 'Show');
            if ($tag === 'button' && !isset($toggleButton['type'])) {
                $toggleButton['type'] = 'button';
            }

            return Html::tag($tag, $label, $toggleButton);
        } else {
            return null;
        }
    }

    protected function renderCloseButton()
    {
        if (($closeButton = $this->closeButton) !== false) {
            $tag = ArrayHelper::remove($closeButton, 'tag', 'button');
            $label = ArrayHelper::remove($closeButton, 'label', '&times;');
            if ($tag === 'button' && !isset($closeButton['type'])) {
                $closeButton['type'] = 'button';
            }

            return Html::tag($tag, $label, $closeButton);
        } else {
            return null;
        }
    }

    protected function initOptions()
    {
        $this->options = array_merge([
            'class' => 'fade',
            'role' => 'dialog',
            'tabindex' => -1,
        ], $this->options);
        Html::addCssClass($this->options, ['widget' => 'modal']);

        if ($this->clientOptions !== false) {
            $this->clientOptions = array_merge(['show' => false], $this->clientOptions);
        }

        if ($this->closeButton !== false) {
            $this->closeButton = array_merge([
                'data-dismiss' => 'modal',
                'aria-hidden' => 'true',
                'class' => 'close',
            ], $this->closeButton);
        }

        if ($this->toggleButton !== false) {
            $this->toggleButton = array_merge([
                'data-toggle' => 'modal',
            ], $this->toggleButton);
            if (!isset($this->toggleButton['data-target']) && !isset($this->toggleButton['href'])) {
                $this->toggleButton['data-target'] = '#' . $this->options['id'];
            }
        }
    }
}
