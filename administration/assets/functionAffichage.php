<?php 
   function visibiliteAffichage($entite, $table) {
    // Vérifier si la clé 'visibilite' existe dans le tableau avant de l'utiliser
    $isVisible = isset($entite['visibilite']) && $entite['visibilite'] ? 'fa-eye' : 'fa-eye-slash';
    $id = $entite['id'];

    echo "<td class='px-6 py-3'>";
    echo "<button class='visibility-toggle' data-id='{$id}' onclick='toggleVisibility(this, \"{$table}\")'>";
    echo "<i class='fa-solid {$isVisible}' id='icon-{$id}'></i>";
    echo "</button>";
    echo "</td>";
}

    

    function visibiliteInput($check ='') { ?>
        <div>
            <label class="block text-lg font-medium text-gray-700">Visibilité</label>
            <div class="mt-2 flex gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="visibilite" value="1" <?php echo ($check == 1) ? 'checked' : ''; ?> class="form-radio text-blue-600" checked>
                    <span class="ml-2">Visible</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="visibilite" value="0" <?php echo ($check == 0) ? 'checked' : ''; ?> class="form-radio text-blue-600">
                    <span class="ml-2">Masqué</span>
                </label>
            </div>
        </div>
    <? }
?>