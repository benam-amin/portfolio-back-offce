<?php 
    function transformerLienYoutube($lien) {
        $pattern = "/^https?:\/\/(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/";
        $replacement = "https://www.youtube.com/embed/$1";
        return preg_replace($pattern, $replacement, $lien);
    }
?>