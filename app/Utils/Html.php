<?php

namespace App\Utils;

class Html
{
    /**
     * Generate an HTML link.
     *
     * @param  string  $url
     * @param  string|null  $title
     * @param  array  $attributes
     * @param  bool|null  $secure
     * @param  bool  $escape
     * @return string
     */
    public static function link($url, $title = null, $attributes = [], $secure = null, $escape = true)
    {
        $a = html()->a($url, $title);
        if (!empty($attributes)) {
            $a = $a->attributes($attributes);
        }
        return $a;
    }

    /**
     * Generate an HTML image element.
     *
     * @param  string  $url
     * @param  string|null  $alt
     * @param  array  $attributes
     * @param  bool|null  $secure
     * @return string
     */
    public static function image($url, $alt = null, $attributes = [], $secure = null)
    {
        $img = html()->img($url, $alt);
        if (!empty($attributes)) {
            $img = $img->attributes($attributes);
        }
        return $img;
    }

    /**
     * Generate a link to a JavaScript file.
     *
     * @param  string  $url
     * @param  array  $attributes
     * @param  bool|null  $secure
     * @return string
     */
    public static function script($url, $attributes = [], $secure = null)
    {
        return '<script src="' . asset($url, $secure) . '"' . self::attributes($attributes) . '></script>';
    }

    /**
     * Generate a link to a CSS file.
     *
     * @param  string  $url
     * @param  array  $attributes
     * @param  bool|null  $secure
     * @return string
     */
    public static function style($url, $attributes = [], $secure = null)
    {
        $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];
        $attributes = array_merge($defaults, $attributes);
        return '<link href="' . asset($url, $secure) . '"' . self::attributes($attributes) . '>';
    }

    /**
     * Build an HTML attribute string from an array.
     *
     * @param  array  $attributes
     * @return string
     */
    public static function attributes($attributes)
    {
        $html = [];
        foreach ((array) $attributes as $key => $value) {
            $element = self::attributeElement($key, $value);
            if (!is_null($element)) {
                $html[] = $element;
            }
        }
        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }

    /**
     * Build a single attribute element.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return string|null
     */
    protected static function attributeElement($key, $value)
    {
        if (is_numeric($key)) {
            return $value;
        }
        if (is_bool($value) && $key !== 'value') {
            return $value ? $key : null;
        }
        if (!is_null($value)) {
            return $key . '="' . e($value, false) . '"';
        }
        return null;
    }
}
