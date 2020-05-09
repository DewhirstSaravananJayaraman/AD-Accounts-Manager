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

namespace app\controllers\settings;

/**
 * Description of District
 *
 * @author cjacobsen
 */
use app\controllers\Controller;
use app\models\database\DistrictDatabase;
use app\database\Schema;
use system\Post;
use app\models\database\PermissionMapDatabase;
use app\models\database\PrivilegeLevelDatabase;
use system\app\AppException;

class District extends Controller {

    function __construct(\system\app\App $app) {
        parent::__construct($app);
//$this->layout = 'setup';
    }

//put your code here
    public function index() {

        $this->districts = DistrictDatabase::get();
        $this->district = DistrictDatabase::getDistrict(1);
//var_dump($this->district);

        if ($this->districts == false) {
            return $this->view('settings/district/create');
        } else {
            foreach ($this->districts as $this->district) {
                $this->districID = $this->district[Schema::DISTRICT_ID[Schema::COLUMN]];
                return $this->show();
            }
        }

//return $this->view('settings/district/index');
    }

    public function permissions($districtID = 1) {

        $this->district = DistrictDatabase::getDistrict($districtID);
        return $this->view('settings/district/permissions');
    }

    public function permissionsPost($districtID = 1) {
        $post = Post::getAll();
        $this->preProcessDistrictID($districtID);
        switch (Post::get('action')) {
            case 'updateDistrict':
                $this->updateDistrict(Post::getAll());
                break;
            case 'deletePrivilege':
                $id = Post::get('privilegeID');
                $this->logger->info('Removing Privilege ' . $id);
                PrivilegeLevelDatabase::removePrivilegeLevel($id);
                break;

            case 'addDistrictPermission':
                $this->addDistrictPermission($districtID);

                break;
            case 'addOUPermission':
                $this->addOUPermission();

                break;
            case 'modifyPermission':
                $this->modifyPermission();

                break;
            case 'updatePrivilege':
                $id = Post::get("privilegeID");
                $this->updatePrivilege($id);
                break;
            case 'addPrivilege':
                if (Post::get("ldapGroupName")) {
                    PrivilegeLevelDatabase::addPrivilegeLevel(Post::get("ldapGroupName"), $districtID);
                }
                break;
            case 'removePermission':

                $id = Post::get('id');
                PermissionMapDatabase::removePermissionByID($id);
                break;
            default:
                break;
        }

        $this->redirect('/settings/district/permissions');
    }

    public function edit($districtID = 1) {
        return $this->show($districtID);
    }

    public function show($districtID = 1) {
        $this->districtID = $districtID;
        $this->district = DistrictDatabase::getDistrict($districtID);
        return $this->view('settings/district/show');
    }

    public function createPost() {
        $post = Post::getAll();
        DistrictDatabase::createDistrict($post['name']);
        $this->redirect('/settings/district/edit');
    }

    public function editPost($districtID = 1) {
        $this->district = DistrictDatabase::getDistrict($districtID);
        $post = Post::getAll();
        $this->preProcessDistrictID($districtID);
        switch (Post::get('action')) {
            case 'updateDistrict':
                $this->updateDistrict($post);
                break;
            case 'remove':
                $id = Post::get('privilegeID');
                $this->logger->info('Removing Privilege ' . $id);
                PrivilegeLevelDatabase::removePrivilegeLevel($id);
                break;

            case 'addPermission':
                $this->addDistrictPermission($districtID);

                break;
            case 'updatePrivilege':
                $id = Post::get("privilegeID");
                $this->updatePrivilege($id);
            default:
                if (Post::get("ldapGroupName")) {
                    PrivilegeLevelDatabase::addPrivilegeLevel(Post::get("ldapGroupName"), $districtID);
                }
                break;
        }

        $this->redirect('/settings/district/edit/');
    }

    private function updateDistrict($post) {
        //var_dump($post);
        $this->logger->info("Updating district");
        $this->district->setName($post['name']);
        $this->district->setAbbr($post['abbr']);
        $this->district->setAdFQDN($post['adFQDN']);
        $this->district->setAdNetBIOS($post['adNetBIOS']);
        $this->district->setAdBaseDN($post['adBaseDN']);
        $this->district->setAdPassword($post['adPassword']);
//$this->district->setAdServer($post['adServer']);
        $this->district->setAdStudentGroupName($post['adStudentGroup']);
        $this->district->setAdStaffGroupName($post['adStaffGroup']);
        $this->district->setAdUsername($post['adUsername']);
//$this->district->setGsFQDN($post['gsFQDN']);
//$this->district->setParentEmailGroup($post['parentEmailGroup']);
        //var_dump($this->district);
        $this->district->saveToDB();
//DatabasePost::setPost(Schema::DISTRICT, $districtID, $post);

        return true;
    }

    public function delete($districtID = null) {
        DistrictDatabase::deleteDistrict($districtID);
        $this->redirect('/district/edit');
    }

    public function hasSchools($districtID) {
//$schools = DistrictDatabase::getSchools($districtID);
        return false;
        if ($schools == false or count($schools) < 1) {
            return false;
        }
        return true;
    }

    private function addDistrictPermission($districtID = 1) {
        $district = DistrictDatabase::getDistrict($districtID);
        $this->addOUPermission($district->getAdBaseDN());



//return true;
    }

    private function addOUPermission() {
        $ou = Post::get('ou');
        if ($ou != '' and $ou != null) {
            $permission = new \app\models\user\Permission();
            var_dump(Post::get());
            $permission->setPrivilegeID(Post::get("privilegeID"))
                    ->setOu($ou)
                    ->setUserPermissionLevel(Post::get("userPermissionType"))
                    ->setGroupPermissionLevel(Post::get("groupPermissionType"));
            PermissionMapDatabase::addPermission($permission);
        } else {
            throw new AppException('Permission is missing OU', AppException::PERMISSION_MISSING_OU);
        }

//return true;
    }

    private function modifyPermission() {
        $id = Post::get('id');
        var_dump(Post::get());
        if ($id != '' and $id != null) {
            $permission = new \app\models\user\Permission();
            $permission->importFromDatabase(PermissionMapDatabase::getPermissionById($id));
            //var_dump(Post::get());
            $permission->setPrivilegeID(Post::get("privilegeID"))
                    ->setId($id)
                    ->setUserPermissionLevel(Post::get("userPermissionType"))
                    ->setGroupPermissionLevel(Post::get("groupPermissionType"));
            $permission->updateInDatabase();
        } else {
            throw new AppException('Permission is missing ID', AppException::PERMISSION_MISSING_ID);
        }

//return true;
    }

    public function updatePrivilege($privilegeID) {
        $privilege = new \app\models\user\PrivilegeLevel();
        $privilege->importFromDatabase(PrivilegeLevelDatabase::get($privilegeID));
        $privilege->setAdGroup(Post::get('groupName'));
        $privilege->saveToDatabase();
    }

}
