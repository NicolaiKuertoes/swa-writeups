# SWA - Praktikum 6

### Analyse
Es existiert keine Input-Validierung beim <i>file-upload</i>. Es lassen sich beliebige Dateien hochladen. Diese landen dann im Verzeichnis <b><i>uploads</i></b>.<br>
Navigiert man über die URL "https://example.com/uploads" in dieses Verzeichnis, so wird dessen Inhalt sichtbar aufgelistet. Dies ist bekannt als <i>Directory Listing</i>. (Angreifer können so auch hochgeladene Inhalte von anderen Usern ausspähen.) Lädt ein angreifer ein böswilliges PHP-Skript hoch, wird es automatisch ausgeführt. Er kann es auch manuell ausführen, indem er es einfach über die URL "https://example.com/uploads/evil.php" aufruft. Angreifer haben so die volle Kontrolle über den Server.<br>

### Exploit
Ein symbolischer exploit sähe wie folgt aus:
```PHP
<?php
  exec("cat /etc/passwd > reconnaissance.txt");
```

### Fix
