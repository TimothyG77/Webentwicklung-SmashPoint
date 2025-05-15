<?php
session_start();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Richtlinien - SmashPoint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../res/css/style.css">

</head>
<body>
<?php include('header.php'); ?>

<div class="container my-5">
    <h2 class="text-center mb-5 fw-bold">Rechtliches bei SmashPoint</h2>

    <!-- AGB -->
    <section class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title mb-3 text-primary fw-semibold">Allgemeine Geschäftsbedingungen (AGB)</h4>
            <ul class="list-unstyled lh-lg">
                <li><strong>§ 1 Geltungsbereich:</strong> Diese AGB gelten für alle Bestellungen über unseren Webshop.</li>
                <li><strong>§ 2 Vertragspartner:</strong> SmashPoint Webshop, Inhaber: Philip Zeisler, Badmintonstraße 77, 12345 Badmintontown.</li>
                <li><strong>§ 3 Vertragsabschluss:</strong> Der Vertrag kommt durch Klick auf den Bestellbutton zustande.</li>
                <li><strong>§ 4 Preise:</strong> Alle Preise inkl. MwSt., ggf. zuzüglich Versandkosten.</li>
                <li><strong>§ 5 Lieferung:</strong> Versand via DHL innerhalb Deutschlands (2–5 Werktage).</li>
                <li><strong>§ 6 Zahlung:</strong> PayPal, Kreditkarte oder Überweisung.</li>
                <li><strong>§ 7 Widerruf:</strong> Sie haben ein Widerrufsrecht. Siehe separate Belehrung.</li>
                <li><strong>§ 8 Eigentum:</strong> Ware bleibt bis zur Zahlung Eigentum von SmashPoint.</li>
            </ul>
        </div>
    </section>

    <!-- Datenschutz -->
    <section class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title mb-3 text-primary fw-semibold">Datenschutzerklärung</h4>
            <ul class="list-unstyled lh-lg">
                <li><strong>Allgemeines:</strong> Wir behandeln Ihre Daten vertraulich & DSGVO-konform.</li>
                <li><strong>Verantwortlicher:</strong> SmashPoint Webshop, Badmintonstraße 77, info@smashpoint.de</li>
                <li><strong>Erhebung:</strong> Daten bei Bestellung & Registrierung: Name, Adresse, E-Mail, Zahlungsinfos.</li>
                <li><strong>Verwendung:</strong> Nur zur Vertragserfüllung – keine unberechtigte Weitergabe.</li>
                <li><strong>Cookies:</strong> Nutzung für Benutzerfreundlichkeit – Steuerung über Browser möglich.</li>
                <li><strong>Rechte:</strong> Auskunft, Löschung, Berichtigung, Übertragbarkeit etc.</li>
            </ul>
        </div>
    </section>

    <!-- Nutzungsbedingungen -->
    <section class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title mb-3 text-primary fw-semibold">Nutzungsbedingungen</h4>
            <ul class="list-unstyled lh-lg">
                <li><strong>Geltung:</strong> Mit der Nutzung akzeptieren Sie diese Bedingungen.</li>
                <li><strong>Urheberrecht:</strong> Inhalte sind geschützt – nur private Nutzung erlaubt.</li>
                <li><strong>Benutzerkonto:</strong> Zugangsdaten sind geheim zu halten – keine Haftung bei Missbrauch.</li>
                <li><strong>Verfügbarkeit:</strong> Keine permanente Verfügbarkeit garantiert.</li>
                <li><strong>Haftung:</strong> Nur bei Vorsatz oder grober Fahrlässigkeit.</li>
                <li><strong>Änderungen:</strong> Änderungen vorbehalten – gültig ist stets die aktuelle Version.</li>
            </ul>
        </div>
    </section>
</div>



<?php include('footer.php'); ?>
</body>
</html>
