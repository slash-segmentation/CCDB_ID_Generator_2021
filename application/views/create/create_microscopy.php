<center>
<table>
    <tr >
        <td>
            <h3><u>Create a New Microscopy ID:</u></h3>
        </td>
            
    </tr>
</table>
</center>


<form action="/Ccdb_id_gen/submit_microscopy" method="post" onsubmit="return validateMP()">
<br/>
<center>
    <table style="width:40%;" >
        <tr>
            <td style="width:30%;">Image basename:</td>
            <td style="width:70%;"><input type="text" id="image_basename" name="image_basename"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="width:30%;">Description:</td>
            <td style="width:70%;"><input type="text" id="description" name="description"  size="100"></td>
        </tr>
        
    </table>
    
    
</center>   
<br/>

<center>
<table>
    <tr>
        <td style="width: 20%">
            &nbsp;
        </td>
        <td style="width: 80%">
            <input type="submit" value="Create a new Microscopy ID"> 
        </td>
    </tr>
</table>
</center>
</form>    
<script>
    function validateMP()
    {
        var image_basename = document.getElementById('image_basename').value;
        if(image_basename.length == 0)
        {
            alert('You have to enter a basename');
            return false;
        }
        
        return true;
    }
    
</script>