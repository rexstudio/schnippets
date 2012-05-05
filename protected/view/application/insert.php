<div id="insert">
<form method="post">
    <div class="field-item right">
        <label style="display: inline-block;" for="protected">Protected:</label>
        <input type="checkbox" checked="checked" name="protected" />
    </div>
    
    <label for="lang">Lang:</label>
    <select name="lang">
        <option value="php">PHP</option>
        <option value="javascript">Javascript</option>
        <option value="css">CSS</option>
        <option value="sql">SQL</option>
	    <option value="bash">Bash</option>
        <option value="text">Text</option>
    </select>
    <label for="Title">Title:</label>
    <input type="text" name="title" />
    <label for="code">Schnippet:</label>
    <textarea name="code" class="code" cols="100" rows="25"></textarea>
    <a class="button right" href="index.php">Cancel</a>
    <input type="submit" name="save" value="Save" class="button" />
</form>

</div>
