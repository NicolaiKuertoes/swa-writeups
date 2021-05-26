# SWA - Praktikum 6
### Table of Contents
<a href="./bWAPP">:page_facing_up: bWAPP - write-up</a><br>
<a href="./xss-game">:page_facing_up: XSS-Game - write-up</a><br>

### Analyse (most obvious)
<a href="https://p6.swa-toaster.de/">:link: zum OTC Server</a><br>
Es existiert keine Input-Validierung beim <b>File-Upload</b>. Es lassen sich beliebige Dateien hochladen. Diese landen dann im Verzeichnis <b><i>uploads</i></b>.<br>
Navigiert man über die URL "https://p6.swa-toaster.de/uploads" in dieses Verzeichnis, so wird dessen Inhalt sichtbar aufgelistet. Dies ist bekannt als <i>Directory Listing</i>. (Angreifer können so auch hochgeladene Inhalte von anderen Usern ausspähen.) Lädt ein angreifer ein böswilliges PHP-Skript hoch, wird es automatisch ausgeführt. Er kann es auch manuell ausführen, indem er es einfach über die URL "https://p6.swa-toaster.de/uploads/evil.php" aufruft. Angreifer haben so die volle Kontrolle über den Server.<br>

### Exploit (simple)
Ein symbolischer exploit sähe wie folgt aus:
```php
<?php
  # evil.php
  exec("cat /etc/passwd > reconnaissance.txt");
```
Ein angreifer lädt das Obige Skript über den File-Upload hoch. Dieses wird automatisch ausgeführt.
Der Angreifer navigiert nun einfach über die URL in das <b><i>uploads</i></b> Verzeichnis und öffnet die erzeugte Datei, mit dem inhalt des "cat" commands.

### Fixes
#### (1) Prevent Directory Listing
Hier möchten wir zunächst das <i>Directory Listing</i> verhindern. Dies lässt sich ganz einfach mit einer leeren index.html oder index.php Datei im gewünschten Verzeichnis umsetzen. Der Server hält nach besagten index-Dateien ausschau und zeigt diese automatisch an. Um den Zugang zum <b>uploads</b> Ordner garnicht erst zu ermöglichen, kann man auch eine automatische Weiterleitung programmieren.
Dazu schreibe ich folgenden Code in die <i>/uploads/<b>index.php</b></i>:
```php
<?php
  # /uploads/index.php
  header("Location: https://p6.swa-toaster.de/");
```
Navigiert man über die URL in das <b>uploads</b> Verzeichnis, so wird man automatisch zurück zur Startseite geleitet.<br>
><i><b>Great success!</b></i>
#### (2) Prevent Arbitrary File-Upload
Nun möchten wir dafür Sorge tragen, dass nur Dateien mit der Endung .jpg oder .png hochgeladen werden dürfen.
Dazu benötigen wir die File-Extension hochzuladenden datei. Diese erhalten wir mit:
```php
$info = new SplFileInfo($_FILES["dispic"]["name"]);
$ext = $info->getExtension();
```
Jetzt müssen wir prüfen, ob es sich um ein zulässiges Datei-Format (.jpg oder .png) handelt.
Hierzu erzeugen wir ein array mit den erlaubten extensions:
```php
$allowed_ext = array("jpg", "jpeg", "png");
```
Anschließend prüfen wir, ob wir unsere extension im array wiederfinden:
```php
if (!in_array($ext, $allowed_ext)) {
  echo 'File not allowed.';
} else {
  # Speichere Datei auf Server
}
```
><i><b>Great success!</b></i>
#### (3) Generate Unique Filenames On Server
Um zu verhindern, das mehrere Benutzer eine valide Datei mit gleichem Namen hochladen und so die gleichnamige Datei eines anderen Benutzers auf dem Server überschreiben, müssen wir einzigartige Dateinamen erzeugen:
```php
$dest_dir = "uploads/";
$dest = $dest_dir . bin2hex(uniqid(rand(), true)) . '.' . $ext;
# bsp. "38323939333436343636306164393031346534386335332e3533303034393337.png"
```
><i><b>Great success!</b></i>
#### (4) Bonus (Limit Filesize)
Um ein "zumüllen" des Servers durch zuviele Uploads zu großer Dateien zu verhindern, können wir die Dateigröße der hochzuladenen Datei auf ein gewünschtes Maximum beschränken. Für ein Profilbild genügen 200kB.
```php
# 200kB
$maxSize = 200000;
```
Jetzt prüfen wir einfach zusätzlich zur File-Extension, ob die Datei eine zulässige größe nicht überschreitet.<br>
Alle Fixes zusammen:
```php
# restrict filesize to max 200kB
$maxSize = 200000;
# restrict file-upload to .jpg and .png files
$allowed_ext = array("jpg", "jpeg", "png");
# getting extension of file to upload
$info = new SplFileInfo($_FILES["dispic"]["name"]);
$ext = $info->getExtension();
# check if file exists for uploading
if ($ext != "") {
  # check if file is allowed and max-filesize is not exceeded
  if (!in_array($ext, $allowed_ext) || $_FILES["dispic"]["size"] > $maxSize) {
    echo 'File not allowed or too big.';
  } else {
    $dest_dir = "uploads/";
    # generate unique filename
    $dest = $dest_dir . bin2hex(uniqid(rand(), true)) . '.' . $ext;
    $src = $_FILES["dispic"]["tmp_name"];
    # upload file to server
    if (move_uploaded_file($src, $dest)) {
      # save path to just ubloaded file to session variable
      $_SESSION["dispic_url"] = $dest;
      chmod($dest, 0644);
      echo 'Success. File uploaded.';
    }
}
```
><i><b>Major success!</b></i>
### Fazit
Mit diesen 15 Zeilen Code haben wir eine schwerwiegende Sicherheitslücke geschlossen.<br>
Bei diesen Fixes handelt es sich um sehr einfache lösungen, mit welchen man sicher keinen Preis gewinnt. Dennoch haben wir es Angreifern erheblich schwerer gemacht, den Server über dieses File-Upload zu übernehmen.
<p>&copy Nicolai Kuertoes :space_invader:</p>
