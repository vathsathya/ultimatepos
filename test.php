<?php
$str = "{!! Form::hidden('account_type', null, ['id' => 'account_type']); !!}";
$updated = preg_replace_callback('/(\{!!\s*)(.*?)(\s*!!\})/s', function ($m) {
    var_dump($m);
    $inner = $m[2];
    $inner_clean = preg_replace('/;\s*$/s', '', $inner);
    return $m[1] . $inner_clean . $m[3];
}, $str);
var_dump($updated);
