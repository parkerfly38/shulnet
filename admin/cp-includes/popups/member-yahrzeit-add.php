<?php 
    $data = array("English_Name" => "", "id" => "");
?>





<form action="" method="post" id="popupform"
      onsubmit="return json_add('member-yahrzeit-add','','1','popupform');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>
        <input type="hidden" name="user_id" value="<?php echo $_POST['user_id']; ?>" />
        <input type="hidden" name="url" value="<?php //echo $data['url']; ?>" />

    </div>

    <h1>Add Deceased Family Member</h1>


    <div class="pad24t popupbody">


        <fieldset>

            <legend>Deceased and Relationship Details</legend>

            <div class="pad24t">

                <div class="field">

                    <label>Deceased</label>

                    <div class="field_entry">

                        <input type="text" name="yahrzeit_dud" id="fyahrzeit" value="<?php echo $data['English_Name']; ?>"
                               autocomplete="off" onkeyup="return autocom(this.id,'id','English_Name','ppSD_yahrzeits','English_Name','accounts');"
                               style="width:250px;" class="req"/><a href="null.php"
                                                                    onclick="return popup('yahrzeit-add','');"><img
                                src="imgs/icon-quickadd.png" width="16" height="16" border="0" alt="Add" title="Add"
                                class="icon-right"/></a>

                        <input type="hidden" name="yahrzeit" id="fyahrzeit_id" value="<?php echo $data['id']; ?>"/>

                        <p class="field_desc" id="yahrzeit_dud_dets">Select a deceased person to connect.</p>

                    </div>

                </div>

                <div class="field">

                    <label>Relationship</label>

                    <div class="field_entry">
                        
                        <input type="text" id="Relationship" name="Relationship" style="width:250px;" />

                        <p class="field_desc" id="relationship_dets">Enter this member's relationship to the deceased.</p>

                    </div>

                </div>
            </div>
        </fieldset>

    </div>


</form>