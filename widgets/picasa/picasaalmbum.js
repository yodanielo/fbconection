$.getPicasa=function(albumurl){
    //obteniendo los componentes que necesito
    a1=albumurl.split("?");
    picasaUrl=a1[0].split("https://picasaweb.google.com/").join("").split("/").join("/album/");
    resultado=null;
    $.ajax({
        url:picasaURL,
        cache: false,
	dataType: ($.browser.msie) ? "text" : "xml",
        success:function(data){
            var xml;
            if (typeof data == 'string') {
                xml = new ActiveXObject("Microsoft.XMLDOM");
                xml.async = false;
                xml.loadXML(data);
            } else {
                xml = data;
            }
            resultado=$(xml).find("entry media:group media:content");
        }
    });
    return resultado;
}