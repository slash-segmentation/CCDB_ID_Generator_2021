<center>
<table>
    <tr >
        <td>
            <h3><u>Select your user name:</u></h3>
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
<select id="user_list" name="user_list" size="20">
    <?php
    
        foreach($userArray as $user)
        {
    ?> 
            <option value="<?php echo $user->Screen_name ?>"><?php echo $user->Full_name."-----(".$user->Screen_name.")"; ?></option>
        
    <?php
        }
    
    ?>

    
</select>
</center>

<br/>

<center>
<table>
    <tr>
        <td style="width: 25%">
            &nbsp;
        </td>
        <td style="width: 50%"><a href="/Ccdb_id_gen/start_over" target="_self">Start Over</a></td>
        <td style="width: 25%">
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
    