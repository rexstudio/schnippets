<div id="add">
    <div id="big-button">
        <strong>Add a</strong><br /> 
        <a class="button schnippet" href="?route=/application/schnippets&m=insert">Schnippet</a>
    </div>
</div>
<div id="search">
    <strong>Find a <span class="schnippet" style="font-size: 24px;">Schnippet</span></strong>
<form id="search-form">
    
    <div class="field-item left short">
        <label for="lang">Lang:</label>
        <select name="lang">
            <option value="all">All</option>
            <option value="php" <?php if ($_GET['lang']=='php') echo 'selected'; ?> >PHP</option>
            <option value="javascript" <?php if ($_GET['lang']=='javascript') echo 'selected'; ?> >Javascript</option>
            <option value="css" <?php if ($_GET['lang']=='css') echo 'selected'; ?> >CSS</option>
            <option value="sql" <?php if ($_GET['lang']=='sql') echo 'selected'; ?> >SQL</option>
            <option value="bash" <?php if ($_GET['lang']=='bash') echo 'selected'; ?> >Bash</option>
            <option value="text" <?php if ($_GET['lang']=='text') echo 'selected'; ?> >Text</option>
        </select> 
    </div>
    
    <div class="field-item right short">
        <label for="user">User:</label>
        <select name="user">
            <option value="all">All</option>
            <?php
            foreach ($users as $user) {
                $selected = ($_GET['user'] == $user['id']) ? 'selected' : '';
                echo "<option value='{$user['id']}' {$selected} >{$user['fname']} {$user['lname']}</option>";
            }
            ?>
        </select> 
    </div>
    
    <div class="field-item clear left normal">
        <label for="title">Title Search:</label>
        <input type="text" name="title" value="<?php echo (isset($_GET['title'])) ? $_GET['title'] : '' ?>" />
    </div>
    
    <div class="field-item clear left normal">
        <label for="code">Code Search:</label>
        <input type="text" name="code" value="<?php echo (isset($_GET['code'])) ? $_GET['code'] : '' ?>" />
    </div>
    
    <div class="field-item field-date clear left short">
        <label for="start_date">Start Date:</label>
        <input type="text" name="start_date" id="start_date" value="<?php echo (isset($_GET['start_date'])) ? $_GET['start_date'] : '' ?>" /> 
    </div>
    
    <div class="field-item field-date right short">
        <label for="end_date">End Date:</label>
        <input type="text" name="end_date" id="end_date" value="<?php echo (isset($_GET['end_date'])) ? $_GET['end_date'] : '' ?>" />
    </div>
    
    <div class="field-item clear left">
        <input type="button" name="search" value="Search" id="search-button" />
    </div>
    <div class="clear"></div>
</form>  
</div>