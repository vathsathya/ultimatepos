<?php
$count = 0;
$directoryMap = [
    './Modules',
    './resources/views'
];

foreach ($directoryMap as $dirPath) {
    if (!is_dir($dirPath)) {
        echo "Not a dir: $dirPath\n";
        continue;
    }
    $dir = new RecursiveDirectoryIterator($dirPath);
    $iter = new RecursiveIteratorIterator($dir);
    $files = new RegexIterator($iter, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

    foreach ($files as $file) {
        $path = $file[0];
        if (strpos($path, '/vendor/') !== false || strpos($path, '/storage/') !== false)
            continue;

        $content = file_get_contents($path);

        // Remove trailing semicolons in {!! !!} where the semicolon is followed only by whitespace before !!}
        $updated = preg_replace_callback('/(\{!!\s*)(.*?)(\s*!!\})/s', function ($m) {
            $inner = $m[2];
            // If the inner string ends with a semicolon and optional whitespace, remove the semicolon
            $inner_clean = preg_replace('/;\s*$/s', '', $inner);
            return $m[1] . $inner_clean . $m[3];
        }, $content);

        // Remove trailing semicolons in {{ }} where the semicolon is followed only by whitespace before }}
        $updated = preg_replace_callback('/(\{\{\s*)(.*?)(\s*\}\})/s', function ($m) {
            $inner = $m[2];
            if (substr($inner, 0, 2) === '--')
                return $m[0]; // skip comments
            $inner_clean = preg_replace('/;\s*$/s', '', $inner);
            return $m[1] . $inner_clean . $m[3];
        }, $updated);

        if ($content !== $updated) {
            file_put_contents($path, $updated);
            $count++;
        }
    }
}
echo "Fixed $count files.\n";
