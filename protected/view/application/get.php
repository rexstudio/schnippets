<div id="code">

<?php

$updated = date('m/d/Y',$schnippet['time']);
?>

<div id='controls'>
    <a class='right action print' title='Print' href='javascript:window.print();'></a>
    <a class='right action download' title='Download' href='?route=/application/schnippets&m=download&id=<?php echo $schnippet['id']; ?>'></a>
    <a class='right action edit' title='Edit' href='?route=/application/schnippets&m=edit&id=<?php echo $schnippet['id']; ?>'></a>
</div>

<div class='right big-red'><?php echo $schnippet['lang']; ?></div>

<h5 class='author'><?php echo $updated; ?> by 
    <?php 
        $usr = $user->get_user($schnippet['user']); 
        echo "{$usr['fname']} {$usr['lname']}";
    ?></h5>

<?php 


$geshi =& new GeSHi($schnippet['code'], $schnippet['lang']);
$geshi->set_header_type(GESHI_HEADER_DIV);
$geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS);
echo $geshi->parse_code();
?>

</div>
