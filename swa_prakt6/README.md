# SWA - Praktikum 6

### Analyse
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
#### Directory Listing
Hier möchte ich zunächst das <i>Directory Listing</i> verhindern. Dies lässt sich ganz einfach mit einer leeren index.html oder index.php Datei im gewünschten Verzeichnis umsetzen. Der Server hält nach besagten index-Dateien ausschau und zeigt diese automatisch an. Um den Zugang zum <b>uploads</b> Ordner garnicht erst zu ermöglichen, kann man auch eine automatische Weiterleitung programmieren.
Dazu schreibe ich folgenden Code in die <i>/uploads/<b>index.php</b></i>:
```PHP
<?php
  # /uploads/index.php
  header("Location: https://example.com/");
```
Navigiert man über die URL in das <b>uploads</b> Verzeichnis, so wird man automatisch zurück zur Startseite geleitet.
