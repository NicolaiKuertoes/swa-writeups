# SWA - Praktikum 6

### Analyse (most obvious)
Es existiert keine Input-Validierung beim <b>File-Upload</b>. Es lassen sich beliebige Dateien hochladen. Diese landen dann im Verzeichnis <b><i>uploads</i></b>.<br>
Navigiert man über die URL "https://example.com/uploads" in dieses Verzeichnis, so wird dessen Inhalt sichtbar aufgelistet. Dies ist bekannt als <i>Directory Listing</i>. (Angreifer können so auch hochgeladene Inhalte von anderen Usern ausspähen.) Lädt ein angreifer ein böswilliges PHP-Skript hoch, wird es automatisch ausgeführt. Er kann es auch manuell ausführen, indem er es einfach über die URL "https://example.com/uploads/evil.php" aufruft. Angreifer haben so die volle Kontrolle über den Server.<br>

### Exploit (sehr einfach)
Ein symbolischer exploit sähe wie folgt aus:
```PHP
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
```PHP
<?php
  # /uploads/index.php
  header("Location: https://example.com/");
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
if (!in_array($ext, $allowed_ext) || $_FILES["dispic"]["size"] > $maxSize) {
        echo 'Error';
      } else {
        $dest_dir = "uploads/";
        $dest = $dest_dir . bin2hex(uniqid(rand(), true)) . '.' . $ext;
        $src = $_FILES["dispic"]["tmp_name"];
        if (move_uploaded_file($src, $dest)) {
          $_SESSION["dispic_url"] = $dest;
          chmod($dest, 0644);
          echo 'Success';
        }
      }
}
```
