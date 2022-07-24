<?php
namespace App\BsModal;

class Modal
{
    /**
     * The additional css class of extra large modal
     * @since 2.0.3
     */
    const SIZE_EXTRA_LARGE = 'modal-xl';
    /**
     * The additional css class of large modal
     */
    const SIZE_LARGE = 'modal-lg';
    /**
     * The additional css class of small modal
     */
    const SIZE_SMALL = 'modal-sm';
    /**
     * The additional css class of default modal
     */
    const SIZE_DEFAULT = '';

    /**
     * @var string the tile content in the modal window.
     */
    public $title;
    public $header;
    /**
     * @var array additional title options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $titleOptions = [];
    /**
     * @var array additional header options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $headerOptions = [];
    /**
     * @var array body options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $bodyOptions = [];
    /**
     * @var string the footer content in the modal window.
     */
    public $footer;
    /**
     * @var array additional footer options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $footerOptions = [];
    /**
     * @var string the modal size. Can be [[SIZE_LARGE]] or [[SIZE_SMALL]], or empty for default.
     */
    public $size;
    /**
     * @var array|false the options for rendering the close button tag.
     * The close button is displayed in the header of the modal window. Clicking
     * on the button will hide the modal window. If this is false, no close button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](http://getbootstrap.com/javascript/#modals)
     * for the supported HTML attributes.
     */
    public $closeButton = [];
    public $closeButtonFooter = [];
    public $submitButton = [];
    /**
     * @var array|false the options for rendering the toggle button tag.
     * The toggle button is used to toggle the visibility of the modal window.
     * If this property is false, no toggle button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to 'Show'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](http://getbootstrap.com/javascript/#modals)
     * for the supported HTML attributes.
     */
    public $toggleButton = false;
    /**
     * @var boolean whether to center the modal vertically
     *
     * When true the modal-dialog-centered class will be added to the modal-dialog
     * @since 2.0.9
     */
    public $centerVertical = false;
    /**
     * @var boolean whether to make the modal body scrollable
     *
     * When true the modal-dialog-scrollable class will be added to the modal-dialog
     * @since 2.0.9
     */
    public $scrollable = false;
    /**
     * @var array modal dialog options
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @since 2.0.9
     */
    public $dialogOptions = [];

    public $data = [];

    public function __construct()
    {

    }
    /**
    * Render the modal opening section
    *
    * @param $data
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */
    public function start($data)
    {
        $this->data = $data;
        return view('grid_view::modal.modal-partial-start', ['modal' => $data]);
    }

    /**
    * Render the modal closing section
    *
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */
    public function end()
    {
        $data = $this->data;
        return view('grid_view::modal.modal-partial-end', ['modal' => $data]);
    }
}
