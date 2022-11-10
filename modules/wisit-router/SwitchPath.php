<?php
return function (...$Route) {
    foreach ($Route as $value) {
        if ($value) {
            $content = $value();
            if ($content) return $content;
        }
    }
};
