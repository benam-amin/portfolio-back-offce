<?php 
function inputUpload($label, $name, $path, $error_msg) { ?>
    <div>
        <!-- Label du champ -->
        <label class="block text-lg font-medium text-gray-700"><?= $label ?></label>

        <!-- Zone de dépôt de fichier -->
        <div id="dropZone" class="drop-zone mt-1 block w-full rounded-md border-2 border-dashed border-gray-300 p-8 text-center cursor-pointer">
            Glissez-déposez un fichier ici ou cliquez pour sélectionner

            <!-- Input caché, déclenché par un clic sur la zone -->
            <input 
                type="file" 
                id="fileInput" 
                name="<?= $name ?>" 
                accept="image/*,application/pdf" 
                class="hidden"
            >
        </div>

        <!-- Conteneur de prévisualisation -->
        <div id="previewContainer" class="mt-3">
            <!-- Image si le fichier est une image -->
            <img 
                id="previewImage" 
                class="hidden rounded-md w-24 h-24 object-cover" 
                src=""
            >

            <!-- Message PDF sélectionné, masqué par défaut -->
            <p id="pdfMessage" class="hidden text-sm text-gray-700 font-medium">
                Fichier PDF sélectionné.
            </p>
        </div>

        <!-- Message d'erreur -->
        <?php if (!empty($error_msg)) : ?>
            <p class="mt-2 text-red-500 text-sm font-semibold"><?= $error_msg ?></p>
        <?php endif; ?>
    </div>
<?php } ?>
