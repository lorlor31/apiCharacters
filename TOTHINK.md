#TO THINK

## Pour le create du Character
Plusieurs steps à suivre :
- essayer déjà de persister les données avec un JSON test sans modifier dans l'entité les images 
- faire l'essai avec le formulaire et les champs simples
- rajoute un champ checkbox pour Personalities
- remplacer avec le type File upload ds l'entité et le formulaire

JSON tests :

```json

{
    "nickname": "A",
    "abstract": "A est le plus laid de son village.",
    "birthDate": "1980-01-23T00:00:00+01:00",
    "deathDate": null,
    "long_description": "A Commodo dolore ipsum consequat labore non tempor voluptate Lorem enim ullamco et nostrud id eiusmod. Lorem minim et sint sint. Labore veniam magna non id Lorem excepteur Lorem nulla ullamco. Nulla sint labore ex quis deserunt cupidatat cillum reprehenderit laborum deserunt velit ex. Voluptate consectetur labore tempor consequat dolore eiusmod enim adipisicing incididunt adipisicing. Ex duis ullamco labore pariatur consectetur eu culpa exercitation.?",

}
```

    "backgroundImage": "blue-sky-country-road.jpg",
    "avatarImage": "young-mason.jpg",
    "personalities": [
        {
            "id": 1,
            "value": "gentil"
        },
        {
            "id": 2,
            "value": "méchant"
        },
        {
            "id": 3,
            "value": "courageux"
        },
        {
            "id": 6,
            "value": "dynamique"
        }
    ]