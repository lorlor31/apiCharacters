# Entites

## Characters

|Propriété |Type| Descr|Autre |
|---|:-:|:-:| :-:|
|**id** | int| |unique|
|**nickname** |string | nom en un ou plusieurs termes|short unique|
|**abstract** | string|résumé du personnage |long|
|**birthDate** |date | date de naissance|--a voir--|
|**deathDate** |date | date de mort|--a voir--NULL |

## Users
En fait on va utiliser le User du SecurityBundle (cf Memento)

|Propriété |Type| Descr|Autre |
|---|:-:|:-:| :-:|
|**id** | int| |unique|
|**nickname** |string | nom en un ou plusieurs termes|short unique|
|**password** |string | nom en un ou plusieurs termes|short unique|
|**is_admin** | bool|droits admin|default false|
|**birthDate** |date | date de naissance|--a voir-- NULL|

## Stories (many-to-one) un personnage petu avoir pkusieurs histoire
|Propriété |Type| Descr|Autre |
|---|:-:|:-:| :-:|
|**id** | int| |unique|
|**character_id** | int|histoire du personnage |unique??|
|**era_id** | int|époque de l'histoire ||


## Parts (many-to-one) un histoire pkusieurs Parts
|Propriété |Type| Descr|Autre |
|---|:-:|:-:| :-:|
|**id** | int| |unique|
|**type** | int| |enum : intro title paragraph outro|
|**content** | string|contenu|long|
|**story_id** | int| ||

## Traits (many-to-one) plusieurs personnage pkusieurs Traits
- gentil
- méchant
- drôle
- différent
- malchanceux
- courageux
- ambitieux
- dur
|Propriété |Type| Descr|Autre |
|---|:-:|:-:| :-:|
|**id** | int| ||
|**value** | int| ||

## Tags (many-to-many)
- action
- voyage
- amour
- suspense
- historique
- fantastique
- sf
- poésie
- peur
- philo
- magie

|Propriété |Type| Descr|Autre |
|---|:-:|:-:| :-:|
|**id** | int| ||
|**value** | int| ||

## Tags_stories (many-to-many)
|Propriété |Type| Descr|Autre |
|---|:-:|:-:| :-:|
|**tag_id** | int| ||
|**story_id** | int| ||

## Traits_characters (many-to-many)
|Propriété |Type| Descr|Autre |
|---|:-:|:-:| :-:|
|**trait_id** | int| ||
|**character_id** | int| ||

## Eras (many-to-one) une époque a pkusieurs hisoitres
- préhistoire
- antiquité
- Moyen-Âge
- renaissance
- guerre
- contemporain
- futur
|Propriété |Type| Descr|Autre |
|---|:-:|:-:| :-:|
|**id** | int| ||
|**value** | int| ||
|**begin** | int| ||
|**end** | int| ||

## Friends (many-to-many)?????????
>quelle relation pour pas de doublon et pas ami à soi meme ?
|Propriété |Type| Descr|Autre |
|---|:-:|:-:| :-:|
|**character_id** | int| ||
|**character_id** | int| ||

## Comments
|Propriété |Type| Descr|Autre |
|---|:-:|:-:| :-:|
|**id** | int| |unique|
|**user_id** | int| id d'un user||
|**content** | string|contenu|long|
|**story_id** | int| ||

## Marks
|Propriété |Type| Descr|Autre |
|---|:-:|:-:| :-:|
|**id** | int| |unique|
|**user_id** | int| id d'un user||
|**value** | int|note sur 5||
|**story_id** | int| ||

## Friends
|Propriété |Type| Descr|Autre |
|---|:-:|:-:| :-:|
|**first_character_id** | int|id d'un character ||
|**second_character_id** | int| id d'un character||

> Fastbook ??
> Lors du choix de l'ère de l'histoire, prévenir de l'anachronisme si le personnage n'est pas né ou est mort
> Permettre à l'utilisateur de rajouter des tags traits eras ?
> Commentaire ( à voir après pour pouvoir y répondre)