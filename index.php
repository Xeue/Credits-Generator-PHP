<!DOCTYPE html>

<?php
  $saves = array_flip(array_diff(scandir("saves"), array('..', '.')));
  $fonts = array_flip(array_diff(scandir("assets/fonts"), array('..', '.')));
  $savesJson = $saves;
  $savesText = implode(str_replace(".js","",array_diff(scandir("saves"), array('..', '.'))),',');
  function stripLogo($string) {
    return strpos($string, 'logo') === false;
  }

  foreach ($saves as $key => $save) {
    $versions = array_diff(scandir("saves/$key"), array('..', '.'));
    $filteredVersions = str_replace(".js","",array_filter($versions, 'stripLogo'));
    asort($filteredVersions);
    $savesJson[$key] = implode($filteredVersions,',');
    $saves[$key] = $filteredVersions;

    $images = array_diff(scandir("saves/$key/logo"), array('..', '.'));
    asort($images);
    $imagesArray[$key] = $images;
  }

  $versions = str_replace(".js","",array_reverse(array_values($saves)[0]));
  arsort($versions);
?>

<html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>StagTV - Credits Generator</title>
    <link rel="icon" href="https://i1.wp.com/stagtv.co.uk/wp-content/uploads/2018/08/cropped-stagtv-favicon-1.png?fit=32%2C32" sizes="32x32">
    <link rel="icon" href="https://i1.wp.com/stagtv.co.uk/wp-content/uploads/2018/08/cropped-stagtv-favicon-1.png?fit=192%2C192" sizes="192x192">
    <link rel="stylesheet" href="credits.css">
    <link rel="stylesheet" href="builder.css">
    <style>
      <?php
        foreach ($fonts as $key => $font) {
          $fontName = strtok(str_replace("-", " ", $key), '.');
          ?>
          @font-face {
            font-family: "<?=$fontName?>";
            src: url("assets/fonts/<?=$key?>");
          }
        <?php }
      ?>
    </style>
    <script src="webcg-framework.umd.js"></script>
    <script src="jquery-3.6.0.js"></script>
    <script src="cookie.js"></script>
    <script>
      images = <?=json_encode($imagesArray)?>
    </script>
    <script src="builder.js"></script>
    <script src="editor.js"></script>
    <script src="credits.js"></script>
  </head>

  <body id="mainBody">
    <main id="creditsBody" class="background">
      <header>
        <select id="loadFile" data-projects="<?=$savesText?>">
          <?php
            foreach ($saves as $key => $save) {
              echo "<option id='proj_$key' value='$key' data-versions=".$savesJson[$key].">$key</option>";
            }
          ?>
        </select>
        <select id="loadVersion">
          <?php
            foreach ($versions as $key => $version) {
              echo "<option value='$version'>$version</option>";
            }
          ?>
        </select>
        <button id="newButton">
          New
        </button><button id="saveButton">
          Save
        </button><button id="loadButton">
          Load
        </button><button id="uploadButton">
          Upload
        </button><button id="uploadImgButton">
          Upload Files
        </button><button id="downloadButton">
          Download
        </button><button id="downloadImgButton">
          Download Images
        </button>
        <button id="help" class="right">Help</button>
        <button id="run" class="right">Run in Browser</button>
        <button id="editButton" class="right">Edit</button>
        <button id="settings" class="right">Settings</button>
      </header>

      <div id="creditsScroller">
        <div id="creditsCont">
        </div>
      </div>

      <div id="creditsLogos" class="hidden">

      </div>

      <div id="newSave" class="hidden popup">
        <form id="saveForm" action="/" method="POST">
          <header id="saveHead">Upload</header>
          <section id="saveBody">
            <div id="saveFile" class="hidden">
              <input type="file" id="saveUpload" name="uploadJSON">
            </div>
            <div id="saveExisting" class="selected">
              <div class="label">Add to existing</div>
              <div>
                <select id="loadFileBut">
                  <?php
                    foreach ($saves as $key => $save) {
                      echo "<option value='$key' data-versions=".$savesJson[$key].">$key</option>";
                    }
                  ?>
                </select>
                <select id="loadVersionBut">
                  <?php
                    foreach (array_reverse(array_values($saves)[0]) as $key => $version) {
                      echo "<option value=".str_replace(".js","",$version).">".str_replace(".js","",$version)."</option>";
                    }
                  ?>
                  <option value='new'>New Version</option>
                </select>
              </div>
            </div>
            <div id="saveNew" class="flexCol">
              <div class="label">Create new</div>
              <input id="saveNewProject" type="text" placeholder="Project">
            </div>
          </section>
          <footer id="saveFoot">
            <button id="saveButSave" type="button">Upload</button>
            <button id="saveButCancel" type="button">Cancel</button>
          </footer>
        </form>
      </div>

      <div id="uploadImg" class="hidden popup">
        <form id="uploadForm" action="/" method="POST">
          <header id="uploadHead">Upload Files</header>
          <section id="uploadBody">
            <div id="uploadFile">
              <input type="file" id="uploadImageInput" name="images[]" multiple>
            </div>
            <div id="uploadExisting" class="selected">
              <div class="label">Add to existing</div>
              <select id="uploadFileBut">
                <?php
                  foreach ($saves as $key => $save) {
                    echo "<option value='$key' data-versions=".$savesJson[$key].">$key</option>";
                  }
                ?>
              </select>
            </div>
            <div id="uploadNew" class="flexCol">
              <div class="label">Create new</div>
              <input id="uploadNewProject" type="text" placeholder="Project">
            </div>
          </section>
          <footer id="uploadFoot">
            <button id="uploadButSave" type="button">Upload</button>
            <button id="uploadButCancel" type="button">Cancel</button>
          </footer>
        </form>
      </div>

      <div id="toutorial" class="hidden popup">
        <div>
          <header id="tutHead">Help/Info</header>
          <section id="tutBody">
            This page is designed to be used with the CasparCG credits template avaiable via the download template button (Not added yet...).<br>
            When the credits are complete you can load them into caspar by downloading them as a file, or by using the URL in the following format:<br>
            <?=$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]?>saves/PROJECT/VERSION.js<br>
            <br>
            These credits can also be run from in borwser, simply click the "Run in Browser" button. This will create a pupup window with some controls.<br>
            <br>
            Settings for the credits can be changed in the settings menu, these are in the form of CSS rules:
            <a href="https://www.w3schools.com/cssref/">https://www.w3schools.com/cssref/</a><br>
            <br>
            To make changes to the credits, click on the edit button, then click on the "block" you want to edit,
            from there properties of the block can be turned on and off and their values edited.<br>
            For names a roles, if you paste in a comma seperated list, it will automatically split them into seperate entries.<br>
            Click and drag to re-order the properties.<br>
            <br>
            You can right click on various things to move them or delete them.<br>
            <br>
            If that doesn't make any sense, you find any bugs or generally want to ask questions you can get in contact via: <a href="mailto:sam@chilton.tv">sam@chilton.tv</a>
          </section>
          <footer id="tutFoot">
            <button id="tutClose" type="button">Got it!</button>
          </footer>
        </div>
      </div>

      <footer id="creditsFooter">
        <button id="creditsButton" class="tabButton active">Main</button>
        <button id='newFade'>+</button>
      </footer>
    </main>
    <aside id="editorCont">
    </aside>
    <nav>
      <button id="navMoveUp">Move Up</button><button id="navMoveDown">Move Down</button><button id="navDelete">Delete</button>
    </nav>
  </body>

</html>
