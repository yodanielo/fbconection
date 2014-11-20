<div id="cuadrocontact">
    <div id="ctcol1">
        <strong>FB Conexion</strong><br/>
        1584 Oak Ave. Apt 2<br/>
        Evanston, IL 60201<br/>
        USA<br/>
        Phone (773) 441 3116<br/>
        Email: <a href="mailto:info@fbconexion.com">info@fbconexion.com</a><br/>
        Hours:<br/>
        Monday – Friday from 9:00am to 5:00pm Central Standard Time
        <a target="_blank" title="FB Conexion on Google Maps" id="ctmap" href="http://maps.google.com/maps?q=fb+conexion&hl=es&sll=42.04691,-87.685822&sspn=0.006175,0.009645&vpsrc=0&hq=fb+conexion&t=m&z=17">
            <img src="http://maps.google.com/maps/api/staticmap?center=42.04675,-87.68690&zoom=15&size=200x200&sensor=false&markers=42.04675,-87.68690&visible=Fb%20Conexion" alt="FB Conexion on Google Maps" />
        </a>
        <a id="linkscontact" href="<?=$this->getURL(LANG."linksDirectory")?>"><?=__("Links Directory")?></a>
    </div>
    <div id="ctcol2">
        <form id="frmcontact" action="" method="post">
            <div class="ctrow" id="cttitle">
                Contact
            </div>
            <?php if($_POST["txt1"]){ ?>
            <div class="ctrow">
                <span>Message Sent</span>
            </div>
            <?php } ?>
            <div class="ctrow">
                <span>If you have any questions or comments regarding our platform please feel free to complete the form below to contact us
                </span>
            </div>
            <div class="ctrow">
                <label>Issue</label>
                <select class="ctinput" type="text" name="txt1" id="txt1">
                    <option value="Sales">Sales</option>
                    <option value="Support">Support</option>
                    <option value="Report error">Report error</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="ctrow">
                <label>Subject</label>
                <input class="ctinput" type="text" name="txt2" id="txt2" />
            </div>
            <div class="ctrow">
                <label>Name</label>
                <input class="ctinput" type="text" name="txt3" id="txt3" />
            </div>
            <div class="ctrow">
                <label>E-mail</label>
                <input class="ctinput" type="text" name="txt4" id="txt4" />
            </div>
            <div class="ctrow">
                <label>Message</label>
                <textarea class="ctinput ctarea" type="text" name="txt5" id="txt5"></textarea>
            </div>
            <div class="ctrow">
                <input type="submit" value="send" id="ctsubmit" />
            </div>
        </form>
    </div>
</div>
<div style="display:none">
    <div id="alertbox"></div>
</div>
<script type="text/javascript">
    $("#frmcontact").formValidator({
        onValidated:function(msg){
            if(msg){
                $("#alertbox").html(msg);
                $("#alertbox").dialog({
                    "title":"Alert",
                    "modal":true,
                    buttons: { }
                })
            }
        }
    });
</script>