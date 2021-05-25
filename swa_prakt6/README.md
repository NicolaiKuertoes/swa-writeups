# SWA - Praktikum 6

### Analyse
Es existiert keine Input-Validierung beim <b>File-Upload</b>. Es lassen sich beliebige Dateien hochladen. Diese landen dann im Verzeichnis <b><i>uploads</i></b>.<br>
Navigiert man über die URL "https://example.com/uploads" in dieses Verzeichnis, so wird dessen Inhalt sichtbar aufgelistet. Dies ist bekannt als <i>Directory Listing</i>. (Angreifer können so auch hochgeladene Inhalte von anderen Usern ausspähen.) Lädt ein angreifer ein böswilliges PHP-Skript hoch, wird es automatisch ausgeführt. Er kann es auch manuell ausführen, indem er es einfach über die URL "https://example.com/uploads/evil.php" aufruft. Angreifer haben so die volle Kontrolle über den Server.<br>

### Exploit
Ein symbolischer exploit sähe wie folgt aus:
```PHP
<?php
  exec("cat /etc/passwd > reconnaissance.txt");
```
Ein angreifer lädt das obige Skript über den File-Upload hoch. Dieses wird automatisch ausgeführt.
Der Angreifer navigiert nun einfach über die URL in das <b><i>uploads</i></b> Verzeichnis und öffnet die erzeugte Datei, mit dem inhalt des "cat" commands.

### Fix
