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

namespace system\app\auth;

/**
 * Description of Local
 *
 * @author cjacobsen
 */
use system\app\auth\AuthException;
use app\config\MasterConfig;
use app\models\user\User;

abstract class Local {
//put your code here

    /** @var MasterConfig|null The app logger */
    public static function authenticate($username = null, $password = null) {
        $config = \app\config\MasterConfig::get();
        if (strtolower($username) == "admin") {
            if (isset($config->admin->adminPasswordHash) and $this->config->admin->adminPasswordHash != '') {
                if ($password == $config->admin->adminPasswordHash) {
                    return new User(CoreUser::ADMINISTRATOR);
                    return true;
                }
                throw new AuthException(AuthException::BAD_PASSWORD);
            } else {
                if ($password == "test") {
                    return new User(CoreUser::ADMINISTRATOR);
                    return true;
                }
                throw new AuthException(AuthException::BAD_PASSWORD);
            }
        }
        throw new AuthException(AuthException::BAD_USER);
    }

}