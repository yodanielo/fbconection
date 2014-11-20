<div class="wrappersup wrapperex">
    <?php
    $clase='';
    if (count($params["samples"]) > 0){
        foreach ($params["samples"] as $k=>$s) {
            echo '<a rel="example" class="exbig '.$clase.'" title="" href="'.$this->getURL("images/examples/".$s->eximagen).'"><img src="'.$this->getURL("images/examples/".str_replace("_0.jpg","_1.jpg",$s->eximagen)).'" alt=""/></a>';
            if($k+1%3==0)
                $clase='salto3';
            else
                $clase='';
        }
    }
    ?>
</div>
<script type="text/javascript">
    $(".exbig").fancybox({
        
    })
</script>