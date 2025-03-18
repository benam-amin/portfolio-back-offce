<?php 
    function genererColonnesTableau($tableau) {
        ?>
        <thead>
            <tr class="bg-gray-800 text-white">
            <?php
            foreach ($tableau as $value) { ?>
                <th class="px-6 py-3 border"><?php echo $value ?></th>
            <?php } ?>
                <th class="px-6 py-3 border">Actions</th>
            </tr>
        </thead>
    <?php } 
?>