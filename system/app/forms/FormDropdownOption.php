<?php

/*
 * The MIT License
 *
 * Copyright 2020 cjacobsen.
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

namespace system\app\forms;

/**
 * Description of FormDropdownOption
 *
 * @author cjacobsen
 */
class FormDropdownOption extends FormElement {

    //put your code here
    private $value;
    private $selected = '';

    function __construct($label = null, $value = null) {
        $this->setLabel($label);
        $this->value = $value;
    }

    function getName() {
        return $this->name;
    }

    function getValue() {
        return $this->value;
    }

    function setName($name): void {
        $this->name = $name;
    }

    function setValue($value): void {
        $this->value = $value;
    }

    public function selected() {
        $this->selected = 'selected';
    }

    public function getSelected() {
        return $this->selected;
    }

}
