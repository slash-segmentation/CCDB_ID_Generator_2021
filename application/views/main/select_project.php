<center>
<table>
    <tr >
        <td>
            <h3><u>Select a project:</u></h3>
        </td>
            
    </tr>
</table>
</center>

<form action="/Ccdb_id_gen/select_project" method="post" onsubmit="return validateUser()">
<?php
   // var_dump($userArray);

?>
<br/>
<center>
<select id="project_list" name="project_list" size="20">
    <?php
    
        foreach($pArray as $project)
        {
            $desc = "";
            if(strlen($project->Project_desc)> 30)
                $desc = substr($project->Project_desc, 0, 30);
    ?> 
            <option value="<?php echo $project->Project_id; ?>"><?php echo $project->Project_id."-----".$project->Project_name."------".$desc; ?></option>
        
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
        var sel = document.getElementById('user_list');
        //alert(sel.selectedIndex);
        var index = sel.selectedIndex;
        if(index < 0)
        {
            alert("You have to select a user to continue");
            return false;
        }
        
        return true;
    }
    
</script>
    