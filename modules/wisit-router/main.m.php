<?php
/*  * Copyright (c) 2022 ณวสันต์ วิศิษฏ์ศิงขร
    *
    * This source code is licensed under the MIT license found in the
    * LICENSE file in the root directory of this source tree.
*/
return [
    new class
    {
        function getPath()
        {
            $func = require('./modules/wisit-router/getPath.php');
            return $func();
        }

        function Route($path, $callBackFunc)
        {
            $func = require('./modules/wisit-router/Route.php');
            return $func($path, $callBackFunc);
        }

        function SwitchPath(...$Route)
        {
            $func = require('./modules/wisit-router/SwitchPath.php');
            return $func(...$Route);
        }

        function getParams($position = -1)
        {
            $func = require('./modules/wisit-router/getParams.php');
            return $func($position);
        }

        function title($title)
        {
            $func = require('./modules/wisit-router/title.php');
            return $func($title);
        }
    },
    'getPath' => require('./modules/wisit-router/getPath.php'),
    'Route' => require('./modules/wisit-router/Route.php'),
    'SwitchPath' => require('./modules/wisit-router/SwitchPath.php'),
    'getParams' => require('./modules/wisit-router/getParams.php'),
    'title' => require('./modules/wisit-router/title.php'),
];
