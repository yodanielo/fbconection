<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mfacebook
 *
 * @author daniel
 */
include("facebook2.php");

class MfbSDK extends object {

    var $settings; //settings
    var $fbc; //credencials
    var $fb; //facebook object

    function login($appId=null,$secret=null) {
        
        $cfg=$this->loadConfig("fb");
        $this->settings = array(
            'appId' => ($appId?$appId:$cfg["id"]),
            'secret' => ($secret?$secret:$cfg["appsecret"]),
            //'oauth'=>true,
            'cookie'=>true
            /*'fbconnect' => 1,
            'domain' => 'fbconexion.com',
            'canvas' => 0,*/
        );
        $this->fb = new Facebook($this->settings);
    }

    function fqlQuery($fql,$appId=null,$secret=null) {
        $this->login($appId,$secret);
        //----------------------------------------------------
        if (isset($this->fb) && $this->fb) {
            $params = array(
                'method' => 'fql.query',
                'query' => $fql,
            );
            $result = $this->fb->api($params);
            return $result;
        } else {
            echo "aaaaaaaaaaaaaaaa";
        }
    }

    function permisionsLink($appId=null,$secret=null) {
        $this->login($appId,$secret);
        $cfg=$this->loadConfig("fb");
        return 'https://www.facebook.com/dialog/oauth?client_id='.$cfg["id"].'&redirect_uri='.urlencode('https://apps.facebook.com/appfbconexion/')."&scope=manage_pages,user_likes,offline_access,publish_stream,email";
        /*return $this->fb->getLoginUrl(array(
            'next' => $this->getURL("fbconexion/"),
            'req_perms' => 'manage_pages,user_likes,offline_access,publish_stream,email',
            'domain' => 'fbconexion.com'
        ));*/
    }

    function getLogout($appId=null,$secret=null) {
        $this->login($appId,$secret);
        return $this->fb->getLogoutUrl(array(
            'next' => $this->getURL(""),
        ));
    }
    
    function publicarpag($appId=null,$secret=null) {
        $this->login($appId,$secret);
        $fbSession = $this->fb->getSession();
        if (substr(strtolower($_SERVER['HTTP_REFERER']), 0, 24) == 'http://apps.facebook.com') {
            // aplicación dentro de facebook
        } else {
            // aplicación cargada directamente
        }
    }
    function getSession($appId=null, $secret=null, $uid=null) {
        $this->login($appId, $secret);
        if ($this->fb->getUser()!=0) {
            $user_profile = $this->fb->api('/'.$this->fb->getUser());
            $user_profile["uid"]=$user_profile["id"];
            //print_r($user_profile);
            return $user_profile;
        }
        else
            return false;
    }
    function getUsers($pagId){
        $uids=$this->fqlQuery("select uid from page_fan where page_id=$pagId");
        //recogiendo ID
        $uids2=array();
        if(count($uids)>0){
            foreach ($uids as $u) {
                $uids[]=$u["uid"];
            }
            $fql="select first_name, middle_name, last_name, pic_small from user where uid in(".  implode($uids, ",").")";
            $users=$this->fqlQuery($fql);
        }else
            return false;
    }
    function publishWall($mensaje,$attachment,$actions,$nose,$pageid){
        $this->login();
        $this->fb->api_client->stream_publish($mensaje,$attachment,$actions,$nose,$pageid);
    }
}

?>
