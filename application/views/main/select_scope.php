<center>
<table>
    <tr >
        <td>
            <h3><u>Select the current scope:</u></h3>
        </td>
            
    </tr>
</table>
</center>

<form action="/Ccdb_id_gen/select_user" method="post" onsubmit="return validateScope()">
<?php
   // var_dump($userArray);

?>
<br/>
<center>
<select id="scope_list" name="scope_list" size="20" style="width:300px">
    <?php
    
        foreach($scopeArray as $scope)
        {
           
    ?> 
            <!-- <option value="<?php echo $scope->Id; ?>"><?php echo $scope->Scope_name; ?></option> -->
            <option value="<?php echo $scope->Scope_name; ?>"><?php echo $scope->Scope_name; ?></option>
        
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
    
    var cig_scope_idx = "CIG_scope_index";
    
    function validateScope()
    {
        var sel = document.getElementById('scope_list');
        //alert(sel.selectedIndex);
        var index = sel.selectedIndex;
        if(index < 0)
        {
            alert("You have to select a scope to continue");
            return false;
        }
        else
        {
            setCookie(cig_scope_idx,index,365); 
        }
        
        return true;
    }
    
    var scope_index = getCookie(cig_scope_idx);
    if(scope_index)
    {
        document.getElementById('scope_list').selectedIndex  = scope_index;
    }
    else
    {
        document.getElementById('scope_list').selectedIndex  = 0;
    }
    
</script>
    