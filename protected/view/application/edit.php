<div id="insert">
<form method="post">
    <div class="field-item right">
        <label style="display: inline-block;" for="protected">Protected:</label>
        <input type="checkbox" <?php if ($schnippet['protected'] == 'on') echo 'checked'; ?> name="protected" />
    </div>
        <label for="lang">Lang:</label>
        <select name="lang">
            <option value="php" <?php if ($schnippet['lang'] == 'php') echo 'selected'; ?> >PHP</option>
            <option value="javascript" <?php if ($schnippet['lang'] == 'javascript') echo 'selected'; ?> >Javascript</option>
            <option value="css" <?php if ($schnippet['lang'] == 'css') echo 'selected'; ?> >CSS</option>
            <option value="sql" <?php if ($schnippet['lang'] == 'sql') echo 'selected'; ?> >SQL</option>
            <option value="bash" <?php if ($schnippet['lang'] == 'bash') echo 'selected'; ?> >Bash</option>
            <option value="text" <?php if ($schnippet['lang'] == 'text') echo 'selected'; ?> >Text</option>
        </select> 
    <label for="Title">Title:</label>
    <input type="text" name="title" value="<?php echo $schnippet['title']; ?>" />
    <label for="code">Snippet:</label>
    <textarea name="code" class="code" cols="100" rows="25"><?php echo htmlentities($schnippet['code']); ?></textarea>
    <a class="button right" href="?route=/application/schnippets&m=get&id=<?php echo $schnippet['id']; ?>">Cancel</a>
    <input type="submit" name="save" value="Save" class="button" />
</form>
</div>
