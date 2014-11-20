<?php
/*
 * GalleryFromPicasa get datas of galleries, pictures from Picasaweb
 *
 * @license GNU General Public License (GPL)
 * @author Pal Buczko <buczekpaya@gmail.com>
 *
 */

class GalleryFromPicasa {

    private $url=null;          //Google AtomFeed URL
    private $parsed=array();    //an unprocessed array from AtomFeed XML
    private $result=array();    //an associative array from parsed array
    private $userid=null;       //Picasaweb username
    private $albumid=null;      //album id
    private $thumbsize=null;    //thumbnail size for album lists or photo lists

    /*
     * Function parse parsing Google API AtomFeed XML
     */
    private function parse() {

        $a=xml_parser_create();
        xml_parse_into_struct($a, $this->getUrlContent(), $values);
        xml_parser_free($a);

        $this->parsed=$values;
        
    }

    /*
     * Function makeArrayFull makes an array,
     * that contain all data comes from Google API AtomFeed XML
     */
    private function makeArrayFull() {
        
        $rsstomb=$this->parsed;

        $result=array();

        $level1=1;
        $level2=2;
        $level3=3;
        $level4=4;

        $level2i=1;
        $level3i=1;

        $i=0;

        $level1name=$rsstomb[$i]['tag'];
        $i++;
        
        while ($rsstomb[$i]['level']!=$level1 or $rsstomb[$i]['type']!='close') {
            $level2name=$rsstomb[$i]['tag'];
            if ($level2name==$rsstomb[$i-1]['tag']) {
                $level2name=$level2name.$level2i++;
            }
            else {
                $level2i=1;
            }
            if ($rsstomb[$i]['level']==$level2 and $rsstomb[$i]['type']=='complete') {
                if (isset($rsstomb[$i]['attributes'])) {
                    $result[$level1name][$level2name]['attributes']=$rsstomb[$i]['attributes'];
                }
                if (isset($rsstomb[$i]['value'])) {
                    $result[$level1name][$level2name]['value']=$rsstomb[$i]['value'];
                }
            }
            elseif ($rsstomb[$i]['level']==$level2 and $rsstomb[$i]['type']=='open') {
                if (isset($rsstomb[$i]['attributes'])) {
                    $result[$level1name][$level2name]['attributes']=$rsstomb[$i]['attributes'];
                }
                if (isset($rsstomb[$i]['value'])) {
                    $result[$level1name][$level2name]['value']=$rsstomb[$i]['value'];
                }
                $i++;
                while ($rsstomb[$i]['level']!=$level2 or $rsstomb[$i]['type']!='close') {
                    $level3name=$rsstomb[$i]['tag'];
                    if ($level3name==$rsstomb[$i-1]['tag']) {
                        $level3name=$level3name.$level3i++;
                    }
                    else {
                        $level3i=1;
                    }
                    if ($rsstomb[$i]['level']==$level3 and $rsstomb[$i]['type']=='complete') {
                        if (isset($rsstomb[$i]['attributes'])) {
                            $result[$level1name][$level2name][$level3name]['attributes']=$rsstomb[$i]['attributes'];
                        }
                        if (isset($rsstomb[$i]['value'])) {
                            $result[$level1name][$level2name][$level3name]['value']=$rsstomb[$i]['value'];
                        }
                    }
                    elseif ($rsstomb[$i]['level']==$level3 and $rsstomb[$i]['type']=='open') {
                        if (isset($rsstomb[$i]['attributes'])) {
                            $result[$level1name][$level2name][$level3name]['attributes']=$rsstomb[$i]['attributes'];
                        }
                        if (isset($rsstomb[$i]['value'])) {
                            $result[$level1name][$level2name][$level3name]['value']=$rsstomb[$i]['value'];
                        }
                        $i++;
                        while ($rsstomb[$i]['level']!=$level3 or $rsstomb[$i]['type']!='close') {
                            $level4name=$rsstomb[$i]['tag'];
                            if ($rsstomb[$i]['level']==$level4 and $rsstomb[$i]['type']=='complete') {
                                if (isset($rsstomb[$i]['attributes'])) {
                                    $result[$level1name][$level2name][$level3name][$level4name]['attributes']=$rsstomb[$i]['attributes'];
                                }
                                if (isset($rsstomb[$i]['value'])) {
                                    $result[$level1name][$level2name][$level3name][$level4name]['value']=$rsstomb[$i]['value'];
                                }
                            }
                            $i++;
                        }
                    }
                    $i++;
                }
            }
            $i++;
        }

        $this->result=$result;

    }

    /*
     * Function getUrlContent gets content of Google API AtomFeed URL
     */
    private function getUrlContent()
	{
        if(empty($this->url))
            {
            throw new Exception("URL to parse is empty!.");
            return false;
            }

        if($content = @file_get_contents($this->url))
            {
            return $content;
            }
        else
            {
            $ch=curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $content=curl_exec($ch);
            $error=curl_error($ch);

            curl_close($ch);

            if(empty($error))
                {
                return $content;
                }
            else
                {
                throw new Exception("Erroe occured while loading url by cURL. <br />\n" . $error) ;
                return false;
                }
            }

        }

        /*
         * Function makeURL makes Google AtomFeed URL
         * from username, albumid, and optional thumbnail size
         */
        private function makeURL() {

            if ($this->thumbsize!="") {
                $thumbsize="&thumbsize=" . $this->thumbsize;
            }
            else {
                $thumbsize="";
            }
            $ret="http://picasaweb.google.com/data/feed/api";
            if ($this->userid!="") {
                $ret.="/user/" . $this->userid;
            }
            if ($this->albumid!="") {
                $ret.="/albumid/" . $this->albumid . "?kind=photo&access=public" . $thumbsize;
            }
            else {
                $ret.="?kind=album&access=public" . $thumbsize;
            }
        return $ret;
        }

        /*
         * Function fromURLtoArray calls 3 different function
         */
        private function fromURLtoArray() {
            $this->url=$this->makeURL();
            $this->parse();
            $this->makeArrayFull();
        }

        /*
         * Function getKeys gets similar keys of $key from full array
         */
        private function getKeys($key) {
            $keys=array_keys($this->result["FEED"]);
            $entry=array();
            $entry_key=0;
            for ($i=0;$i<count($keys);$i++) {
                if (preg_match("/" . $key . "/", $keys[$i])) {
                    $entry[$entry_key++]=$keys[$i];
                }
            }
            return $entry;
        }

        /*
         * Function getAlbums gets some data from Picasaweb.
         *
         * getAlbums(userid,thumbsize,albumname)
         *
         * parameters:
         * userid (your picasaweb userid)
         * thumbsize (size of thumbnail images) optional, default is 160px
         * * * you can use this sizes: 32, 48, 64, 72, 104, 144, 150, 160
         * * * this pictures available full and crop format
         * * * for example:
         * * * * you want to use 32px crop thumbnail: thumbsize value is "32c"
         * * * * full size: "32u"
         * albumname (optional, it comes from picasa url,
         * * * for example: http://picasaweb.google.com/userid/albumname#
         * * * if this parameter not null, method returns only datas of this album
         * * * if this album not present, method returns datas of all album)
         *
         * Return in this data format:
         *
         * "albumid"=>"name"="albumname (type: string)",
         * "albumid"=>"numphotos"="number of photos (type: string)",
         * "albumid"=>"published"="publication time (type: unix timestamp)",
         * "albumid"=>"thumbnail"="URL of thumbnail image (type: string)",
         * "albumid"=>"title"="title of album (type: string)")
         *
         */
        public function getAlbums($userid,$thumbsize="",$albumname="") {

            $albums=array();

            $this->userid=$userid;
            $this->thumbsize=$thumbsize;
            $this->fromURLtoArray();

            foreach ($this->getKeys("ENTRY") AS $key=>$value) {
                foreach ($this->result["FEED"][$value] AS $gphotokey=>$gphotovalue) {
                    switch ($gphotokey) {
                        case "GPHOTO:ID":
                            $id=$gphotovalue["value"];
                            $albums[$gphotovalue["value"]]="";
                            break;
                        case "GPHOTO:NAME":
                            $albums[$id]['name']=$gphotovalue["value"];
                            break;
                        case "GPHOTO:NUMPHOTOS":
                            $albums[$id]['numphotos']=$gphotovalue["value"];
                            break;
                        case "GPHOTO:TIMESTAMP":
                            $albums[$id]['published']=substr($gphotovalue["value"],0,10);
                            break;
                        case "MEDIA:GROUP":
                            foreach ($gphotovalue AS $mediakey=>$mediavalue) {
                                if ($mediakey=="MEDIA:THUMBNAIL") {
                                    $albums[$id]['thumbnail']=$mediavalue["attributes"]["URL"];
                                }
                                if ($mediakey=="MEDIA:TITLE") {
                                    $albums[$id]['title']=$mediavalue["value"];
                                }
                            }
                            break;
                        default:
                            break;
                    }
                }
            }
            /*
             * if set $albumname and it present, returns only datas of this album
             */
            if ($albumname!="") {
                $album=array();
                foreach ($albums as $key=>$value) {
                    if ($albumname==$value['name']){
                        $album=array($key=>$value);
                    }
                }
                if (count($album)>0){
                    return $album;
                }
                else {
                    return $albums;
                }
            }
            else {
                return $albums;
            }
        }

        /*
         * Function getPictures gets some data from Picasaweb.
         *
         * getAlbums(userid,albumid,thumbsize)
         *
         * parameters:
         * userid (your picasaweb userid)
         * albumid (id of album)
         * thumbsize (size of thumbnail images) optional, default is 160px
         * * * you can use this sizes: 32, 48, 64, 72, 104, 144, 150, 160
         * * * this pictures available full and crop format
         * * * for example you want to use 32px crop thumbnail: thumbsize value is "32c"
         * * * full size: "32u"
         *
         * Return in this data format:
         *
         * "albumid"=>"name"="albumname (type: string)",
         * "albumid"=>"numphotos"="number of photos (type: string)",
         * "albumid"=>"published"="publication time (type: unix timestamp)",
         * "albumid"=>"picture"="URL of picture image (type: string)",
         * "albumid"=>"thumbnail"="URL of thumbnail image (type: string)",
         * "albumid"=>"title"="title of album (type: string)")
         *
         */
        public function getPictures($userid,$albumid,$thumbsize="") {

            $pictures=array();

            $this->userid=$userid;
            $this->albumid=$albumid;
            $this->thumbsize=$thumbsize;
            $this->fromURLtoArray();

            foreach ($this->getKeys("ENTRY") AS $key=>$value) {
                foreach ($this->result["FEED"][$value] AS $gphotokey=>$gphotovalue) {
                    switch ($gphotokey) {
                        case "GPHOTO:ID":
                            $id=$gphotovalue["value"];
                            $pictures[$gphotovalue["value"]]="";
                            break;
                        case "GPHOTO:NAME":
                            $pictures[$id]['name']=$gphotovalue["value"];
                            break;
                        case "GPHOTO:TIMESTAMP":
                            $albums[$id]['published']=substr($gphotovalue["value"],0,10);
                            break;
                        case "MEDIA:GROUP":
                            foreach ($gphotovalue AS $mediakey=>$mediavalue) {
                                if ($mediakey=="MEDIA:CONTENT") {
                                    $pictures[$id]['picture']=$mediavalue["attributes"]["URL"];
                                }
                                if ($mediakey=="MEDIA:THUMBNAIL") {
                                    $pictures[$id]['thumbnail']=$mediavalue["attributes"]["URL"];
                                }
                                if ($mediakey=="MEDIA:TITLE") {
                                    $pictures[$id]['title']=$mediavalue["value"];
                                }
                            }
                            break;
                        default:
                            break;
                    }
                }
            }
            return $pictures;

        }

}

?>
