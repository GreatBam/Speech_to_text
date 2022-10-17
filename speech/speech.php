<html>
<head>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.4.5/p5.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.4.5/addons/p5.dom.js"></script>
	<script src="../speech/speech/lib/p5.speech.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Speech to text converter</title>
</head>
<body onload="initLang()">
    <div id="navtop">
        <div class="title">Speech to text converter</div>
    </div>
    <div id="main">
        <div id="mainTop">
            <p id="intro">Appuyez sur le bouton rec pour enregistrer</p>
            <button id="rec" class="recButton">Rec</button><br><br>
        </div>
        <form>
            <select id="lang" size="1" onchange="langSelect()">
                <option value="0" selected>Choose</option>
                <option value="1">Français</option>
                <option value="2">Anglais</option>
                <option value="3">Espagnol</option>
            </select>
        </form>
        <textarea name="result" id="result" cols="80" rows="40" readonly></textarea>
    </div>
    <div id="play">
        <p id="outro">Appuyer sur play pour écouter votre message</p>
        <button id="speaker" class="speakerButton">Play</button>
    </div>
    <script>
        
        let intro = document.getElementById("intro");
        let rec = document.getElementById("rec");
        let speaker = document.getElementById("speaker");
        let result = document.getElementById("result");
        let lang = document.getElementById("lang");
        let doc;
        let counter = 0;
        let textLang;
        let speechLang;
        let myVoice = new p5.Speech();
        
        function initLang() {
            let userLangRoot = navigator.userLanguage || navigator.language;
            console.log(navigator)
            let userLang = userLangRoot.match(/^[a-z]{2}/);
            console.log("Language is : " + userLang);
            if(userLang == "fr") {
                lang.value = 1;
                textLang = userLang;
                speechLang = 4;
            } else if(userLang == "en") {
                lang.value = 2;
                textLang = userLang;
                speechLang = 9;
            } else if(userLang == "es") {
                lang.value = 3;
                textLang = userLang;
                speechLang = 13;
            }
        }
        
        function setup() {
            myRec = new p5.SpeechRec(textLang);
        }
            
        function langSelect() {
            let langValue = lang.value;
            if(langValue == 0) {
                myRec = false;
            } else if(langValue == 1) {
                textLang = "fr";
                speechLang = 4;
            } else if(langValue == 2) {
                textLang = "en-US";
                speechLang = 9;
            } else if(langValue == 3) {
                textLang = "es";
                speechLang = 13;
            }
            result.innerHTML = "";
            counter = 0;
            console.log(textLang);
            console.log(speechLang);
            setup();
        }

        rec.onclick = function() {
            myRec.onResult = showResult;
            myRec.start();
        }

        speaker.onclick = function() {
            doc = result.value;
            myVoice.setVoice(speechLang);
            myVoice.speak(doc);
        }

        function showResult() {
            if(myRec.resultValue == true) {
                let convertToString = myRec.resultString;
                console.log(convertToString);
                if(counter < 1) {
                    result.innerHTML += convertToString;
                    counter += 1;
                } else {
                    result.innerHTML += "\r\n" + convertToString;
                }
                if(convertToString == "effacer" || convertToString == "delete" || convertToString == "borrar") {
                    result.innerHTML = "";
                    counter = 0;
                } else if(convertToString == "français" || convertToString == "french" || convertToString == "francés") {
                    result.innerHTML = "";
                    counter = 0;
                    lang.value = 1
                    textLang = "fr";
                    speechLang = 4;
                } else if(convertToString == "anglais" || convertToString == "english" || convertToString == "inglés") {
                    result.innerHTML = "";
                    counter = 0;
                    lang.value = 2
                    textLang = "en-US";
                    speechLang = 9;
                } else if(convertToString == "espagnol" || convertToString == "spanish" || convertToString == "español") {
                    result.innerHTML = "";
                    counter = 0;
                    lang.value = 3
                    textLang = "es";
                    speechLang = 13;
                }
            }
        }

    </script>
</body>
</html>