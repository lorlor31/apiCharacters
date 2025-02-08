# Notes diverses de trucs que j'ai appris

## Logger
Utiliser le logger de symfony

## Upload d'un fichier
- Utiliser le bundle Vich, bien configurer l'entité correctement
- Attention le format de la data est un FormData et pas un JSON donc les méthodes du controller change
- IL faut créer un dossier en back pour mettre les images

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L]
</IfModule>

<img src={`http://127.0.0.1:8000/${character.image}`} alt="Avatar" />
