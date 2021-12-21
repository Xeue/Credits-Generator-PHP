
<html>
  <head>
    <title>Remote Run</title>
    <style>
      .but {
        width: 190px;
        height: 90px;
        font-size: 20pt
      }
      .cont {
        display: flex;
      }
    </style>
  </head>
  <body>
    <div class="cont">
      <button class="but" onclick="triggerStart()" type="button">Run</button>
      <div style="width: 10px;"></div>
      <button class="but" onclick="toggleUI()" type="button">Toggle UI</button>
    </div>
    <div style="height: 10px;"></div>
    <div class="cont">
      <input class="but" id="time" type="text"/>
      <div style="width: 10px;"></div>
      <button class="but" onclick="setTime()" type="button">Set Time</button>
    </div>
    <script type="text/javascript">
      function triggerStart() {
        if (window.opener) {
          window.opener.postMessage('{"command":"run"}', "*");
        }
      }
      function toggleUI() {
        if (window.opener) {
          window.opener.postMessage('{"command":"toggleUI"}', "*");
        }
      }
      function setTime() {
        if (window.opener) {
          let time = document.getElementById("time").value;
          window.opener.postMessage('{"command":"setTime","time":'+time+'}', "*");
        }
      }
    </script>
  </body>
</html>
