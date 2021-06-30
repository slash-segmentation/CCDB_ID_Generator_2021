<center>
<table>
    <tr >
        <td>
            <h3><u>Select an experiment:</u></h3>
        </td>
            
    </tr>
</table>
</center>

<form action="/Ccdb_id_gen/create_microscopy" method="post" onsubmit="return validateUser()">
<?php
   // var_dump($userArray);

?>
<br/>
<center>
<select id="experiment_list" name="experiment_list" size="20">
    <?php
    
        foreach($eArray as $exp)
        {
            $purpose = "";
            if(strlen($exp->Experiment_purpose)> 30)
                $purpose = substr($exp->Experiment_purpose, 0, 30);
    ?> 
            <option value="<?php echo $exp->Experiment_id; ?>"><?php echo $exp->Experiment_id."-----".$exp->Experiment_title."------".$purpose; ?></option>
        
    <?php
        }
    
    ?>

    
</select>
</center>

<br/>

<center>
<table>
    <tr>
        <td style="width: 50%">
            &nbsp;
        </td>
        <td style="width: 50%">
            <input type="submit" value="Next"> 
        </td>
    </tr>
</table>
</center>
</form>


<script> 
    function validateUser()
    {
        var sel = document.getElementById('experiment_list');
        //alert(sel.selectedIndex);
        var index = sel.selectedIndex;
        if(index < 0)
        {
            alert("You have to select an experiment to continue");
            return false;
        }
        
        return true;
    }
    
</script>
    