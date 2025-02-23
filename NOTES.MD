# Notes diverses de trucs que j'ai appris

## Logger - Utiliser le logger de symfony 
1. Installer composant Monolog: `php bin/console debug:container monolog.logger`
2. Utiliser ainsi :
```php
$logger->critical('Ceci est un log critic'); // rouge vif
$logger->info('Uploading avatar file', ['file' => $avatarFile]); // Recommandé
// Différentes valeurs
debug/info/notice/warning/error/critical/alert/emergency/
```
3. Lancer le server de log
`symfony server:log`



## Upload d'un fichier
- Utiliser le bundle Vich, bien configurer l'entité correctement
- Attention le format de la data est un FormData et pas un JSON donc les méthodes du controller change
- IL faut créer un dossier en back pour mettre les images
- Vichupload va gérer le fichier et la taille en tant que propriété de la propriété file cf exp ms on a besoin de updatedAt
- La propriété qui contient le fichier est stockée temporairement et pas en BB, elle ne dt dc pas avoir de mapping (    // #[ORM\Column(length: 255, nullable: true)] => ne pas mapper cette propriété
)
- C'est celle qui ctient le nom qui est stockée en BDD

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L]
</IfModule>

<img src={`http://127.0.0.1:8000/${character.image}`} alt="Avatar" />


## Created at - Lifecycle callbacks
- Bien mettre `#[ORM\HasLifecycleCallbacks] ` avant `class Maclasse`pour préciser l'utilisation des cycles de vie Doctrine