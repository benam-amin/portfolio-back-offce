<?php 
    if (isset($modifier)) { ?>
        <!-- Visualisation de l'image actuelle -->
        <?php if (!empty($entite['lienMedia'])) { ?>
            <div class="mb-4">
                <label class="block text-lg font-medium text-gray-700">Média actuel</label>
                <img src="../../<?php echo htmlspecialchars($entite['lienMedia']); ?>" alt="Media actuel du projet" class="w-full h-auto rounded-md mb-4">
            </div>
        <?php } } ?>
        <div class="mb-4">
            <label id="mediaExistantLabel" class="block text-lg font-medium text-gray-700">Média existant</label>
            <button id="toggleMediaBtn" class="mb-4 text-blue-600 underline">
                    Afficher les médias existants
                </button>
                <div id="mediaSection" class="hidden mt-4">
                    <label id="mediaExistantLabel" class="block font-medium mb-2"></label>
                    <div id="mediaExistant" class="grid grid-cols-3 gap-4">
                         <!-- Médias chargés par JS -->
                    </div>                                          
                </div>
        </div>

        <!-- Upload de l'image -->
        <div class="mb-4">
            <?php
                inputUpload("Image du projet", "medias", $mediasPath, $error_msg_medias); 
                if (!empty($error_msg_medias)) { ?>
                <p class='text-red-500 text-sm mt-2'><?php echo $error_msg_medias; ?></p>
            <?php } ?>
        </div>
<?php ?>