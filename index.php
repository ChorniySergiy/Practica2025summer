<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require __DIR__ . '/bootstrap.php';

//$emailId = 131;
/*
$emailId = $_GET['email_id'];
$stmt = $conn->prepare("SELECT * FROM `emails` WHERE `id` = ?");
$stmt->execute([$emailId]);
$array = $stmt->fetch(PDO::FETCH_ASSOC);
*/

$array = json_decode(file_get_contents('data.json'), true);

?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'form-modul.php'; ?>

    <!--Code-input is on GitHub ==> https://github.com/WebCoder49/code-input-->
    <script src="/../media/code-input-2.4.0/code-input.min.js"></script>
    <link rel="stylesheet" href="/../media/code-input-2.4.0/code-input.min.css">

    <!--Prism-->
    <link id="import-theme" rel="stylesheet" href="/../media/code-input-2.4.0/theme-prism.css">
    <!-- <script src="/../media/code-input-2.4.0/prism-core.min.js"></script> -->
    <script src="/../media/code-input-2.4.0/prism.min.js"></script>
    <script src="/../media/code-input-2.4.0/prism-autoloader.min.js"></script>
    <script src="/../media/code-input-2.4.0/prism-line-numbers.min.js"></script>
    <link rel="stylesheet" href="/../media/code-input-2.4.0/line-numbers-prism-line-numbers.min.css">
    <link rel="stylesheet" href="/../media/code-input-2.4.0/plugins-prism-line-numbers.min.css">

    <script src="/../media/code-input-2.4.0/indent.min.js"></script>
    <script src="/../media/code-input-2.4.0/find-and-replace.min.js"></script>
    <link rel="stylesheet" href="/../media/code-input-2.4.0/find-and-replace.min.css">
    <script src="/../media/code-input-2.4.0/go-to-line.min.js"></script>
    <link rel="stylesheet" href="/../media/code-input-2.4.0/go-to-line.min.css">
    <script src="/../media/code-input-2.4.0/select-token-callbacks.min.js"></script>
    <!-- <script src="/../media/code-input-2.4.0/auto-close-brackets.min.js"></script> -->
</head>
<body>
<script>
   codeInput.registerTemplate("html-code", codeInput.templates.prism(Prism, [
     new codeInput.plugins.Indent(true, 2),
     new codeInput.plugins.FindAndReplace(),
     new codeInput.plugins.GoToLine(),
     /*new codeInput.plugins.Autocomplete(function(popupElem, textarea, selectionEnd) {
        //const jsData = `<?php //echo $array['custom_html']; ?>`;
        //textarea.value = jsData;
        //textarea.addEventListener("input", () => {textarea.value = jsData});
     }),*/
     //new codeInput.plugins.AutoCloseBrackets(),
     //new codeInput.plugins.SelectTokenCallbacks(new codeInput.plugins.SelectTokenCallbacks.TokenSelectorCallbacks(selectBrace, deselectAllBraces), true),
   ]));
</script>
<div class="container">
    <div class="left">
        <div class="box">
           <!-- <label for=""><i class="fa-brands fa-html5"></i> HTML</label>-->
            <!-- <textarea id="html-code"></textarea> -->
            <code-input id="html-code" oninput="" template="html-code" lang="HTML" name="html_code" placeholder="Type code here" class="line-numbers code-input_registered code-input_pre-element-styled code-input_loaded" tabindex="-1" style="background-color: rgb(245, 242, 240);"></code-input>
            <div>
                <select id="select-theme" onchange="document.querySelector('#import-theme').setAttribute('href', this.value);">
                   <option value="/../media/code-input-2.4.0/theme-prism.css">Default Theme</option>
                   <option value="/../media/code-input-2.4.0/theme-monokai.css">Monokai Theme</option>
                   <option value="/../media/code-input-2.4.0/theme-prism-tomorrow.css">Tomorrow Night (Rosey) Theme</option>
                   <option value="/../media/code-input-2.4.0/theme-prism-dark.css">Dark Theme</option>
                </select>
                <button id="file-m" onClick="javascript:window.open('m5-file-m.php', '_blank');">File Manager</button>
                <button id="save-text">Save</button>
            </div>
             <!-- <p><button id="save-text">Save</button></p> -->
        </div>
    </div>
    <div class="right">
      <!--  <label for=""><i class="fa-solid fa-play"></i> Output</label>-->
        <iframe id="output"></iframe>
    </div>
</div>
</body>
</html>
<script>
    let codeInputElem = document.querySelector("code-input");
    let textarea;
    let interval = window.setInterval(() => {
        textarea = codeInputElem.querySelector("textarea");
        if (textarea != null) window.clearInterval(interval);

        const jsData = `<?php echo $array['custom_html']; ?>`;
        try {
          textarea.parentElement.value = jsData;
          document.getElementById("output").contentDocument.body.innerHTML = jsData;
        } catch (error) {
          //console.error(error);
        }

        var htmlCode = document.getElementById("html-code");
        var outputIframesHeight = document.getElementById("output");
        //htmlCode.style.height = "865px";
        htmlCode.style.height = outputIframesHeight.contentWindow.document.body.scrollHeight + "px";

       //console.log(textarea.parentElement.value);
    }, 10);
    /* doctype, html not loading */
    //const jsData = `<?php /*echo $array['custom_html'];*/ ?>`;
    /*var htmlCode = document.getElementById("html-code");
    htmlCode.innerHTML = jsData;
    htmlCode.style.height = (htmlCode.scrollHeight) + "px";
    document.getElementById("output").contentDocument.body.innerHTML = jsData;*/
    /* doctype, html not loading */

    document.getElementById("save-text").addEventListener("click", function () {
        //console.log(textarea.parentElement.value);

        var request = new XMLHttpRequest();
        request.open('POST', '/liveEditor/save.php', true);
        var data = new FormData();
        data.append('email_id', '<?php echo $emailId ?? ''; ?>');
        data.append('ma5_content', textarea.parentElement.value);
        request.send(data);
        request.onload = function() {
        if (this.status >= 200 && this.status < 400) {
                console.log ('Code successfully saved.');
            } else {
                var err = this.response;
                console.log ('Code save  problem: ' + JSON.stringify(err));
            }
        };

        alert('Saved');
    });
    document.getElementById("html-code").addEventListener("input", () => {
      document.getElementById("output").contentDocument.body.innerHTML = event.target.value;
    });
    document.getElementById("html-code").addEventListener("change", (event) => {
      document.getElementById("output").contentDocument.body.innerHTML = event.target.value;
    });
</script>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'poppins', sans-serif;
    }
    body{
        background-color: #454545;
        color: #fff;
    }
    .container{
        width: 100%;
        height: 95vh;
        padding: 20px;
        display: flex;
        gap: 20px;
    }
    .left, .right{
        width: 40%;
        flex-basis: 50%;
        padding: 10px;
    }
    .left{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .left .box{
        height: 25vh;
    }
    iframe{
        width: 100%;
        height: 100%;
        background-color: #fff;
        border: none;
        outline: none;
    }
    label i{
        margin: 0 10px;
    }
    label{
        display: flex;
        align-items: center;
        background-color: #000;
        height: 30px;
    }
    .fr-wrapper div.fr-element.fr-view {
        height: 75vh;
    }
    /*textarea {
        width: 100%;
        height: 865px;
        max-height: 865px;
    }*/
    #html-code{
        width: 100%;
        /*height: 865px;*/
        max-height: 865px;
    }
    #save-text { 
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        border-radius: 0.25rem;
        border-color: #0098f7;
        background: #0098f7;
        color: #ffffff;
        margin-left: 0.75rem;
        margin-top: 1.75rem;
        margin-bottom: 0.75rem;
    }
    #file-m { 
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        border-radius: 0.25rem;
        margin-left: 0.75rem;
    }
</style>
