
<!DOCTYPE html>
<html>
<head>
    <title>Form Page 1</title>
</head>
<body>
    <form action="page2.php" method="post">
        <label for="level">Select Level:</label>
        <select name="level" id="level">
            <option value="level1">Level 1</option>
            <option value="level2">Level 2</option>
            <option value="level3">Level 3</option>
            <option value="level4">Level 4</option>
        </select><br>
        
        <label for="type">Select Type:</label>
        <select name="type" id="type">
            <option value="proper">Proper</option>
            <option value="repeat">Repeat</option>
        </select><br>
        
        <label for="subject">Select Subject:</label>
        <select name="subject" id="subject" >
        <option value="('CSC - Direct Intake')">(CSC - Direct Intake)</option>
        <option value="('BOT, ZOO, FSC')">(BOT, ZOO, FSC)</option>
        <option value="('CHE, BOT, FSC')">(CHE, BOT, FSC)</option>
        <option value="('CHE, BOT, ZOO')">(CHE, BOT, ZOO)</option>
        <option value="('CHE, ZOO, FSC')">(CHE, ZOO, FSC)</option>
        <option value="('CHE, PMM, AMM')">(CHE, PMM, AMM)</option>
        <option value="('CSC, AMM, CHE')">(CSC, AMM, CHE)</option>
        <option value="('CSC, AMM, PHY')">(CSC, AMM, PHY)</option>
        <option value="('CSC, AMM, STA')">(CSC, AMM, STA)</option>
        <option value="('CSC, PMM, AMM')">(CSC, PMM, AMM)</option>
        <option value="('CSC, PMM, CHE')">(CSC, PMM, CHE)</option>
        <option value="('CSC, STA, PMM')">(CSC, STA, PMM)</option>

</select><br>
        
        <input type="submit" value="Next">
    </form>
</body>
</html>
