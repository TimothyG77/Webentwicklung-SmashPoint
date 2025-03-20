# Webentwicklung-Gruppe-27

# 🛒 Webshop-Projekt  

## 📌 Projektbeschreibung  
Dieses Projekt ist ein einfacher **Webshop**, der es Nutzern ermöglicht, Produkte anzusehen, in den Warenkorb zu legen und Bestellungen zu verwalten. Der Webshop enthält eine **Benutzerverwaltung**, ein **Admin-Panel** sowie eine **dynamische Produktdarstellung**.  

---

## 🚀 Funktionen  
### 🔹 **Für Gäste (nicht registrierte Nutzer)**
- Produkte durchsuchen und Kategorien filtern  
- Produktsuche mit Live-Vorschlägen  
- Produkte in den Warenkorb legen und verwalten  
- Registrierung & Login  

### 🔹 **Für registrierte Benutzer**
- Produkte bestellen (Warenkorb wird nach Login gespeichert)  
- Bestellungen und Rechnungen einsehen  
- Persönliche Daten & Zahlungsmethoden verwalten  
- Produkte bewerten  

### 🔹 **Für Administratoren**
- Produkte hinzufügen, bearbeiten & löschen  
- Kundenverwaltung (Deaktivieren/Aktivieren von Accounts)  
- Gutscheine erstellen & verwalten  

---

## 🏗️ Verzeichnisstruktur  

📂 Webshop-Projekt
├── 📂 Backend/
│ ├── 📂 config/ # Konfigurationsdateien (Datenbankzugriff)
│ ├── 📂 models/ # PHP-Klassen für User, Produkte, Bestellungen
│ ├── 📂 logic/ # Business-Logik (Login, Registrierung, Bestellungen)
│ ├── 📂 productpictures/ # Produktbilder
│ | ├── 📂 herren
| | ├── 📂 damen
├── 📂 Frontend/
│ ├── 📂 sites/ # HTML/PHP-Seiten (Login, Produkte, Warenkorb)
│ ├── 📂 res/
│ │ ├── 📂 css/ # Stylesheets
│ │ ├── 📂 js/ # JavaScript & AJAX Funktionen
│ │ ├── 📂 img/ # Statische Bilder
└── README.md # Projektdokumentation

