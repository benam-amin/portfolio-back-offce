<?php 
    function inputUpload($label, $name, $path, $error_msg) { ?>
        <div>
        <label class="block text-lg font-medium text-gray-700"><? echo $label?></label>
        <div id="dropZone" class="drop-zone mt-1 block w-full rounded-md border-2 border-dashed border-gray-300 p-6 text-center cursor-pointer">
            Glissez-déposez un fichier ici ou cliquez pour sélectionner
            <input type="file" id="fileInput" name="<?php echo $name; ?>" class="hidden">
        </div>
        <img id="preview" class="mt-3 hidden rounded-md w-24 h-24 object-cover" src="<? echo $path ?: '';?>"> <?
        if (!empty($error_msg)) { ?>
            <p class="mt-2 text-red-500 text-sm font-semibold"><?php echo $error_msg; ?></p>
        <?}?>   
        </div>
    <?}
?>