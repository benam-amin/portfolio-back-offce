<?php 
function afficherIconesLiens($contact, $contact_liens) {
    $contactList = explode(",", $contact);
    $contact_liensListe = explode(",", $contact_liens);
    for ($i = 0; $i < count($contactList); $i++) {
        if (!empty($contact_liensListe[$i])) {
            $icone = ($contact[$i] == "portfolio") ? "fa-solid fa-globe" : "fa-brands fa-{$contactList[$i]}";
            echo "<a class='text-2xl' href='" . htmlspecialchars($contact_liensListe[$i]) . "' target='_blank'><i class='$icone'></i></a> ";
        }
    }
}


?>