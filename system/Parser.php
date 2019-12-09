<?php

/*
 * The MIT License
 *
 * Copyright 2019 cjacobsen.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace system;

/**
 * Description of CoreParser
 *
 * @author cjacobsen
 */
use system\SystemLogger;

class Parser {

    public function view($view) {

        //var_dump($view);
        $view = $this->sanitize($view);

        $path = VIEWPATH . DIRECTORY_SEPARATOR . $view . ".php";
        //echo $path;
        if (file_exists($path)) {


            ob_start();
            if (include $path) {
                return ob_get_clean();
            }
            ob_get_clean();
        }
        return false;
    }

    public function include($file) {

        $file = $this->sanitize($file);

        $path = ROOTPATH . DIRECTORY_SEPARATOR . $file . ".php";
        //echo $path;
        if (file_exists($path)) {
            //ob_start();
            //echo "loaded";
            include $path;
            return true;
            //return ob_get_clean();
        } else {

            return false;
        }
    }

    public function sanitize($path) {
        if ($path[0] == "/" or $path[0] == "\\") {
            $path = substr($path, 1);
        }
        $path = str_replace(array('/', '\\'), strval(DIRECTORY_SEPARATOR), $path);
        return $path;
    }

    public function varDump($object) {
        ob_start();
        var_dump($object);
        return ob_get_clean();
    }

}