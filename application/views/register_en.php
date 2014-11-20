<div id="regcol1"></div>
<div id="contregister">
    <div id="regcol2">
        <form name="frmregister" id="frmregister">
            <div class="regtitle">Register</div>
            <label>Email</label>
            <input type="text" id="txt1" name="txt1" value="" class="required" alt="Email" />
            <label>Password</label>
            <input type="text" id="txt2" name="txt2" value="" class="required" alt="Password" />
            <label>Repeat Password</label>
            <input type="text" id="txt3" name="txt3" value="" class="required" alt="Repeat Password" />
            <label>First Name</label>
            <input type="text" id="txt4" name="txt4" value="" class="required" alt="First Name" />
            <label>Last Name</label>
            <input type="text" id="txt5" name="txt5" value="" class="required" alt="Last Name" />
            <label>Company</label>
            <input type="text" id="txt6" name="txt6" value="" class="required" alt="Company" />
            <label>Phone</label>
            <input type="text" id="txt7" name="txt7" value="" class="required" alt="Phone" />
            <label>Country</label>
            <input type="text" id="txt8" name="txt8" value="" class="required" alt="Country" />
            <label>State</label>
            <input type="text" id="txt9" name="txt9" value="" class="required" alt="State" />
            <label>City</label>
            <input type="text" id="txt10" name="txt10" value="" class="required" alt="City" />
            <label>Address</label>
            <input type="text" id="txt11" name="txt11" value="" class="required" alt="Address" />
            <label>ZIP</label>
            <input type="text" id="txt12" name="txt12" value="" class="required" alt="ZIP" />
            <input type="submit" id="btnsubreg" value="Send" />
        </form>
    </div>
    <div id="regcol3">
        <form name="frmreglogin" id="frmreglogin">
            <label>Username</label>
            <input type="text" id="reglog1" value="" />
            <label>Password</label>
            <input type="password" id="reglog2" value="" />
            <input type="submit" id="btnsubreg" value="Register" />
        </form>
    </div>
</div>
<div id="registerbox"></div>
<script type="text/javascript">
    $("#frmregister").formValidator({
        
        onValidated:function(msg){
            if(msg!=""){
                $("#registerbox").html(msg);
                $("#registerbox").dialog({
                    modal:true,
                    title:"<?=__("titalert")?>",
                    buttons:{
                        "OK":function(){
                            $("#registerbox").dialog("close");
                        }
                    }
                })
            }
        }
    });
    
</script>