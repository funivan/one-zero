<?php

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 2/17/14
   */
  class ScriptInlineGenerator {

    protected function prepareScript($filePath) {
      $script = file_get_contents($filePath);
      do {
        $oldScriptContent = $script;
        $script = trim($script);
        $script = preg_replace("!\n!", "", $script);
        $script = preg_replace("!\/\*.*\*\/!Uus", "", $script);
        $script = preg_replace("!\s{2,}!Uu", " ", $script);
        $script = preg_replace("!\s*(,|\|\{|\}|=|\))\s*!", "$1", $script);
      } while ($script != $oldScriptContent);
      return $script;
    }

    public function get() {
      $js = $this->prepareScript("oneZero.js");
      $js .= $this->prepareScript("runOnLoad.js");
      return $js;
    }
  }

  $jsGenerator = new ScriptInlineGenerator();
  $script = $jsGenerator->get();
?>

<script type="text/javascript" src="oneZero.js"></script>

<div style="text-align: center;margin-top: 40px;">
  Перетягніть кнопку на панель закладок <br>
  або просто поклікайте декілька раз на посилання, що б зрозуміти що він мутить<br/>
  <br>
  <a href="javascript:<?= $script ?>">OneZero</a>


  <br/>
  <br/>
  <div id="current-text">
    Якщо ви натиснете на кнопку нижче, зміниться тільки цей текст
  </div>

  <div>
    <a href="#" onclick="changeNodeText()" id="one-zero-apply">клік</a>
  </div>
</div>


<script type="text/javascript">
  var node = document.getElementById('current-text');
  changeNodeText = function () {
    var oz = new oneZero();
    oz.run(node);
  }
</script>
