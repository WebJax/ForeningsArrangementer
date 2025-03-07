# Forening Arrangementer Klasse

Denne klasse giver foreninger mulighed for at oprette og administrere deres egne arrangementer direkte fra frontenden af deres WordPress-side. Klassen tilbyder funktionalitet til at tilføje, redigere og slette arrangementer samt opdatere baggrundsbilledet på en specifik side.

## Funktioner

- **Tilføj Arrangementer**: Brugere kan tilføje nye arrangementer med navn, beskrivelse, startdato og slutdato.
- **Rediger og Slet Arrangementer**: Brugere kan redigere eksisterende arrangementer eller slette dem.
- **Opdater Baggrundsbillede**: Brugere kan opdatere baggrundsbilledet på siden, der viser arrangementerne.
- **Custom Endpoint**: Viser arrangementer på en dedikeret URL baseret på foreningens navn.
- **Separate Templates**: Adskilt visning og redigering af arrangementer for bedre overskuelighed.

## Installation

1. **Upload Plugin**: Upload pluginets mappe til `/wp-content/plugins/` mappen på din WordPress installation.
2. **Aktiver Plugin**: Gå til WordPress administrationspanelen, navigér til "Plugins" og aktiver "Forening Arrangementer".
3. **Genindlæs Permalinks**: Gå til "Indstillinger" > "Permalinks" og klik på "Gem ændringer" for at genindlæse permalinks.

## Brug

### Shortcode

Brug shortcoden `[vis_arrangementer]` på en side eller et indlæg for at vise og administrere arrangementer.

### Endpoint

For at vise arrangementer for en specifik forening, kan du bruge følgende URL-struktur:

http://ditdomæne.dk/forening/FORENINGSNAVN-screen


Erstat `FORENINGSNAVN` med det faktiske navn på foreningen.

### Templates

- **Visning af Arrangementer**: Brug `templates/visarrangementer.php` til at vise arrangementerne.
- **Redigering af Arrangementer**: Brug `templates/redigerarrangementer.php` til at tilføje og redigere arrangementer.

## Filstruktur

- `foreningarrangementer.php`: Hovedfilen med klassen `ForeningArrangementer`.
- `assets/forening-arrangementer.js`: JavaScript-fil til at håndtere AJAX-anmodninger.
- `templates/visarrangementer.php`: Template til visning af arrangementer.
- `templates/redigerarrangementer.php`: Template til redigering af arrangementer.

## Udvikling

### Krav

- PHP version 7.4 eller nyere.
- WordPress version 5.0 eller nyere.

### Bidrag

1. Fork dette repository.
2. Opret en ny branch (`git checkout -b ny-funktion`).
3. Lav dine ændringer og commit dem (`git commit -am 'Add ny funktion'`).
4. Push din branch (`git push origin ny-funktion`).
5. Opret en Pull Request.

## Licens

Dette projekt er licenseret under MIT License - se `LICENSE` filen for detaljer.

## Kontakt

For spørgsmål eller support, kontakt Jacob Thygesen, JaxWeb, info@jaxweb.dk.

