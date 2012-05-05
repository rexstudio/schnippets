<?php

/*
 *  * Copyright (C) 2012 Rex Studio Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact Rex Studio Inc at 607 E. Second Ave. Suite 40 Flint, MI 48502 or
 * at email address support@therexstudio.com
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Rex Studio Designed
 *  and Built" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Rex Studio Designed and Built".
 *
 * @author Andy Lawrence (alawrence@therexstudio.com)
 * @author Robert Strutts (rstrutts@therexstudio.com)
 */
?>

<div id="tagcloud-wrapper">
    <div id="tagcloud">
        <?php
            // start looping through the tags
            $maximum = $tags[0];
            $terms = $tags[1];
            foreach ($terms as $term) {
            // determine the popularity of this term as a percentage
            $percent = floor(($term['counter'] / $maximum) * 100);
            
            // determine the class for this term based on the percentage
            if ($percent < 20) {
            $class = 'smallest';
            } elseif ($percent >= 20 and $percent < 40) {
            $class = 'small';
            } elseif ($percent >= 40 and $percent < 60) {
            $class = 'medium';
            } elseif ($percent >= 60 and $percent < 80) {
            $class = 'large';
            } else {
            $class = 'largest';
            }
        ?>
        <span class="<?php echo $class; ?>"> <a class="taglink" title="<?php echo urlencode($term['term']); ?>"><?php echo $term['term']; ?></a> </span>
        <?php } ?>
    </div>
</div>
