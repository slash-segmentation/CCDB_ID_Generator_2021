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
            <option value="<?php echo $scope->Id; ?>"><?php echo $scope->Scope_name; ?></option>
        
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
        
        return true;
    }
    
</script>
    