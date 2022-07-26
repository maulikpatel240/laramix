<?php

namespace App\Helper;

use Illuminate\Support\Facades\URL;

class Html
{
    /**
     * @var string Regular expression used for attribute name validation.
     * @since 2.0.12
     */
    public static $attributeRegex = '/(^|.*\])([\w\.\+]+)(\[.*|$)/u';
    /**
     * @var array list of void elements (element name => 1)
     * @see http://www.w3.org/TR/html-markup/syntax.html#void-element
     */
    public static $voidElements = [
        'area' => 1,
        'base' => 1,
        'br' => 1,
        'col' => 1,
        'command' => 1,
        'embed' => 1,
        'hr' => 1,
        'img' => 1,
        'input' => 1,
        'keygen' => 1,
        'link' => 1,
        'meta' => 1,
        'param' => 1,
        'source' => 1,
        'track' => 1,
        'wbr' => 1,
    ];
    /**
     * @var array the preferred order of attributes in a tag. This mainly affects the order of the attributes
     * that are rendered by [[renderTagAttributes()]].
     */
    public static $attributeOrder = [
        'type',
        'id',
        'class',
        'name',
        'value',

        'href',
        'src',
        'srcset',
        'form',
        'action',
        'method',

        'selected',
        'checked',
        'readonly',
        'disabled',
        'multiple',

        'size',
        'maxlength',
        'width',
        'height',
        'rows',
        'cols',

        'alt',
        'title',
        'rel',
        'media',
    ];
    /**
     * @var array list of tag attributes that should be specially handled when their values are of array type.
     * In particular, if the value of the `data` attribute is `['name' => 'xyz', 'age' => 13]`, two attributes
     * will be generated instead of one: `data-name="xyz" data-age="13"`.
     * @since 2.0.3
     */
    public static $dataAttributes = ['aria', 'data', 'data-ng', 'ng'];

    /**
     * Encodes special characters into HTML entities.
     * The [[\yii\base\Application::charset|application charset]] will be used for encoding.
     * @param string $content the content to be encoded
     * @param bool $doubleEncode whether to encode HTML entities in `$content`. If false,
     * HTML entities in `$content` will not be further encoded.
     * @return string the encoded content
     * @see decode()
     * @see https://secure.php.net/manual/en/function.htmlspecialchars.php
     */
    public static function encode($content, $doubleEncode = true)
    {
        // return htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, Yii::$app ? Yii::$app->charset : 'UTF-8', $doubleEncode);
    }

    /**
     * Decodes special HTML entities back to the corresponding characters.
     * This is the opposite of [[encode()]].
     * @param string $content the content to be decoded
     * @return string the decoded content
     * @see encode()
     * @see https://secure.php.net/manual/en/function.htmlspecialchars-decode.php
     */
    public static function decode($content)
    {
        return htmlspecialchars_decode($content, ENT_QUOTES);
    }
    /**
     * Generates a hyperlink tag.
     * @param string $text link body. It will NOT be HTML-encoded. Therefore you can pass in HTML code
     * such as an image tag. If this is coming from end users, you should consider [[encode()]]
     * it to prevent XSS attacks.
     * @param array|string|null $url the URL for the hyperlink tag. This parameter will be processed by [[Url::to()]]
     * and will be used for the "href" attribute of the tag. If this parameter is null, the "href" attribute
     * will not be generated.
     *
     * If you want to use an absolute url you can call [[Url::to()]] yourself, before passing the URL to this method,
     * like this:
     *
     * ```php
     * Html::a('link text', Url::to($url, true))
     * ```
     *
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * @return string the generated hyperlink
     * @see \yii\helpers\Url::to()
     */
    public function a($text, $url = null, $options = [])
    {
        if ($url !== null) {
            $options['href'] = Url::to($url);
        }

        return static::tag('a', $text, $options);
    }

    /**
     * Generates a complete HTML tag.
     * @param string|bool|null $name the tag name. If $name is `null` or `false`, the corresponding content will be rendered without any tag.
     * @param string $content the content to be enclosed between the start and end tags. It will not be HTML-encoded.
     * If this is coming from end users, you should consider [[encode()]] it to prevent XSS attacks.
     * @param array $options the HTML tag attributes (HTML options) in terms of name-value pairs.
     * These will be rendered as the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     *
     * For example when using `['class' => 'my-class', 'target' => '_blank', 'value' => null]` it will result in the
     * html attributes rendered like this: `class="my-class" target="_blank"`.
     *
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated HTML tag
     * @see beginTag()
     * @see endTag()
     */
    public static function tag($name, $content = '', $options = [])
    {
        if ($name === null || $name === false) {
            return $content;
        }
        $html = "<$name" . static::renderTagAttributes($options) . '>';
        return isset(static::$voidElements[strtolower($name)]) ? $html : "$html$content</$name>";
    }

    public static function renderTagAttributes($attributes)
    {

        $html = "";
        // if (count($attributes) > 1) {
        //     $sorted = [];
        //     foreach (static::$attributeOrder as $name) {
        //         if (isset($attributes[$name])) {
        //             $sorted[$name] = $attributes[$name];
        //         }
        //     }
        //     $attributes = array_merge($sorted, $attributes);
        // }

        // $html = '';
        // foreach ($attributes as $name => $value) {
        //     if (is_bool($value)) {
        //         if ($value) {
        //             $html .= " $name";
        //         }
        //     } elseif (is_array($value)) {
        //         if (in_array($name, static::$dataAttributes)) {
        //             foreach ($value as $n => $v) {
        //                 if (is_array($v)) {
        //                     $html .= " $name-$n='" . Json::htmlEncode($v) . "'";
        //                 } elseif (is_bool($v)) {
        //                     if ($v) {
        //                         $html .= " $name-$n";
        //                     }
        //                 } elseif ($v !== null) {
        //                     $html .= " $name-$n=\"" . static::encode($v) . '"';
        //                 }
        //             }
        //         } elseif ($name === 'class') {
        //             if (empty($value)) {
        //                 continue;
        //             }
        //             $html .= " $name=\"" . static::encode(implode(' ', $value)) . '"';
        //         } elseif ($name === 'style') {
        //             if (empty($value)) {
        //                 continue;
        //             }
        //             $html .= " $name=\"" . static::encode(static::cssStyleFromArray($value)) . '"';
        //         } else {
        //             $html .= " $name='" . Json::htmlEncode($value) . "'";
        //         }
        //     } elseif ($value !== null) {
        //         $html .= " $name=\"" . static::encode($value) . '"';
        //     }
        // }

        return $html;
    }
}