<?php
header("content-type: text/xml");
echo file_get_contents("http://api.groupon.com/v2/deals/shoebuy-charlotte.xml?client_id=817eca6ffcac06bf6943cb2b39048cfd0cb8f6ee")
?>