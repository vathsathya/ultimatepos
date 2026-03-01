<?php

namespace App\Utils;

class Form
{
    /**
     * Create a new model based form builder.
     *
     * @param  mixed  $model
     * @param  array  $options
     * @return string
     */
    public static function model($model, array $options = [])
    {
        $method = strtoupper($options['method'] ?? 'POST');
        $url = $options['url'] ?? '';

        $form = html()->model($model)->form($method, $url);

        if (isset($options['id'])) {
            $form = $form->id($options['id']);
        }

        if (isset($options['class'])) {
            $form = $form->class($options['class']);
        }

        if (isset($options['files']) && $options['files']) {
            $form = $form->acceptsFiles();
        }

        // Handle other attributes
        $exclude = ['method', 'url', 'id', 'class', 'files', 'route', 'action'];
        $attributes = array_diff_key($options, array_flip($exclude));
        if (!empty($attributes)) {
            $form = $form->attributes($attributes);
        }

        return $form->open();
    }

    /**
     * Open a new HTML form.
     *
     * @param  array  $options
     * @return string
     */
    public static function open(array $options = [])
    {
        $method = strtoupper($options['method'] ?? 'POST');
        $url = $options['url'] ?? '';

        $form = html()->form($method, $url);

        if (isset($options['id'])) {
            $form = $form->id($options['id']);
        }

        if (isset($options['class'])) {
            $form = $form->class($options['class']);
        }

        if (isset($options['files']) && $options['files']) {
            $form = $form->acceptsFiles();
        }

        // Handle other attributes
        $exclude = ['method', 'url', 'id', 'class', 'files', 'route', 'action'];
        $attributes = array_diff_key($options, array_flip($exclude));
        if (!empty($attributes)) {
            $form = $form->attributes($attributes);
        }

        return $form->open();
    }

    /**
     * Close the current form.
     *
     * @return string
     */
    public static function close()
    {
        return html()->form()->close();
    }

    /**
     * Create a form label element.
     *
     * @param  string  $name
     * @param  string|null  $value
     * @param  array  $options
     * @param  bool  $escape_html
     * @return string
     */
    public static function label($name, $value = null, $options = [], $escape_html = true)
    {
        $label = html()->label($value, $name);
        if (!empty($options)) {
            $label = $label->attributes($options);
        }
        return $label;
    }

    /**
     * Create a text input field.
     *
     * @param  string  $name
     * @param  string|null  $value
     * @param  array  $options
     * @return string
     */
    public static function text($name, $value = null, $options = [])
    {
        $text = html()->text($name, $value);
        if (!empty($options)) {
            $text = $text->attributes($options);
        }
        return $text;
    }

    /**
     * Create a hidden input field.
     *
     * @param  string  $name
     * @param  string|null  $value
     * @param  array  $options
     * @return string
     */
    public static function hidden($name, $value = null, $options = [])
    {
        $hidden = html()->hidden($name, $value);
        if (!empty($options)) {
            $hidden = $hidden->attributes($options);
        }
        return $hidden;
    }

    /**
     * Create a select box field.
     *
     * @param  string  $name
     * @param  array  $list
     * @param  string|bool|null  $selected
     * @param  array  $options
     * @return string
     */
    public static function select($name, $list = [], $selected = null, $options = [])
    {
        $select = html()->select($name, $list, $selected);
        if (!empty($options)) {
            $select = $select->attributes($options);
        }
        return $select;
    }

    /**
     * Create a checkbox input field.
     *
     * @param  string  $name
     * @param  mixed  $value
     * @param  bool|null  $checked
     * @param  array  $options
     * @return string
     */
    public static function checkbox($name, $value = 1, $checked = null, $options = [])
    {
        $checkbox = html()->checkbox($name, $checked, $value);
        if (!empty($options)) {
            $checkbox = $checkbox->attributes($options);
        }
        return $checkbox;
    }

    /**
     * Create a radio button input field.
     *
     * @param  string  $name
     * @param  mixed  $value
     * @param  bool|null  $checked
     * @param  array  $options
     * @return string
     */
    public static function radio($name, $value = null, $checked = null, $options = [])
    {
        $radio = html()->radio($name, $checked, $value);
        if (!empty($options)) {
            $radio = $radio->attributes($options);
        }
        return $radio;
    }

    /**
     * Create a password input field.
     *
     * @param  string  $name
     * @param  array  $options
     * @return string
     */
    public static function password($name, $options = [])
    {
        $password = html()->password($name);
        if (!empty($options)) {
            $password = $password->attributes($options);
        }
        return $password;
    }

    /**
     * Create an email input field.
     *
     * @param  string  $name
     * @param  string|null  $value
     * @param  array  $options
     * @return string
     */
    public static function email($name, $value = null, $options = [])
    {
        $email = html()->email($name, $value);
        if (!empty($options)) {
            $email = $email->attributes($options);
        }
        return $email;
    }

    /**
     * Create a number input field.
     *
     * @param  string  $name
     * @param  string|null  $value
     * @param  array  $options
     * @return string
     */
    public static function number($name, $value = null, $options = [])
    {
        $number = html()->input('number', $name, $value);
        if (!empty($options)) {
            $number = $number->attributes($options);
        }
        return $number;
    }

    /**
     * Create a date input field.
     *
     * @param  string  $name
     * @param  string|null  $value
     * @param  array  $options
     * @return string
     */
    public static function date($name, $value = null, $options = [])
    {
        $date = html()->date($name, $value);
        if (!empty($options)) {
            $date = $date->attributes($options);
        }
        return $date;
    }

    /**
     * Create a URL input field.
     *
     * @param  string  $name
     * @param  string|null  $value
     * @param  array  $options
     * @return string
     */
    public static function url($name, $value = null, $options = [])
    {
        $url = html()->input('url', $name, $value);
        if (!empty($options)) {
            $url = $url->attributes($options);
        }
        return $url;
    }

    /**
     * Create a textarea input field.
     *
     * @param  string  $name
     * @param  string|null  $value
     * @param  array  $options
     * @return string
     */
    public static function textarea($name, $value = null, $options = [])
    {
        $textarea = html()->textarea($name, $value);
        if (!empty($options)) {
            $textarea = $textarea->attributes($options);
        }
        return $textarea;
    }

    /**
     * Create a file input field.
     *
     * @param  string  $name
     * @param  array  $options
     * @return string
     */
    public static function file($name, $options = [])
    {
        $file = html()->file($name);
        if (!empty($options)) {
            $file = $file->attributes($options);
        }
        return $file;
    }

    /**
     * Create a submit button element.
     *
     * @param  string|null  $value
     * @param  array  $options
     * @return string
     */
    public static function submit($value = null, $options = [])
    {
        $submit = html()->submit($value);
        if (!empty($options)) {
            $submit = $submit->attributes($options);
        }
        return $submit;
    }
}
