<!DOCTYPE html>
<html>
<head>
  <title>Wysihtml5 Size Matters Demo</title>
  <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
  <link rel="stylesheet" href="css/foundation.css"/>
  <link rel="stylesheet" href="css/foundation-icons/foundation-icons.css"/>
  <link rel="stylesheet" href="css/new.css"/>
  <script src="js/vendor/jquery.js"></script> <!--script voor foundation-->
  <script src="js/foundation/foundation.js"></script> <!--script voor foundation-->
  <script src="js/foundation.min.js"></script> <!--script voor foundation-->
  <script src="js/foundation/foundation.dropdown.js"></script> <!--script voor foundation-->
  <script src="js/foundation/foundation.topbar.js"></script> <!--script voor foundation-->
  <script src="js/vendor/modernizr.js"></script>


  <script src="js/jquery.wysihtml5_size_matters.js"></script>
  <script src="js/wysihtml5.js"></script>
  

  <script>
    $(function() {
      var editor = new wysihtml5.Editor("informatieblok_description", {
        toolbar:      "informatieblok_toolbar"
      });

      editor.on('load', function() {
        $(editor.composer.iframe).wysihtml5_size_matters();
      });
    });
  </script>
</head>
<body>

  <!--<div id="toolbar" style="display: none;">
    <a data-wysihtml5-command="bold" title="CTRL+B">bold</a> |
    <a data-wysihtml5-command="italic" title="CTRL+I">italic</a>
  </div>-->

  <div class="row">
  <div class="large-12 small-12 columns" id="ed_info_form" style="border-radius: 3px; background-color: #ffffff; padding: 30px; margin-bottom: 10px; border: 1px solid #d8d8d8; height: auto;">
            <form action="" method="post" style="padding: 10px;" data-abide>
                <div class="large-12 columns" style="padding: 0px;">
                    <div class="large-11 columns left" style="padding: 0px;">
                        <div id="informatieblok_toolbar">
                            <dl class="sub-nav edit_text" style="margin-bottom: 0px; margin: 0px;">
                                <dd style="margin-left: 0px;"><a data-wysihtml5-command="bold" style="font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: inherit; font-weight: 600;">B</a></dd>
                                <dd style="margin-left: 2px;"><a data-wysihtml5-command="italic" style="font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: italic; font-weight: 600;">i</a></dd>
                                <dd style="margin-left: 2px;"><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1" style="font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: inherit; font-weight: 600;">h1</a></dd>
                                <dd style="margin-left: 2px;"><a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2" style="font-family: 'Open Sans', sans-serif; font-size: 16px; font-style: inherit; font-weight: 600;">h2</a></dd>
                                <dd style="margin-left: 2px;"><a data-wysihtml5-command="insertUnorderedList" style="font-family: 'Open Sans', sans-serif; font-size: 14px; font-style: inherit; font-weight: 600;">insertUnorderedList</a></dd>
                                <dd style="margin-left: 2px;"><a data-wysihtml5-command="insertOrderedList" style="font-family: 'Open Sans', sans-serif; font-size: 14px; font-style: inherit; font-weight: 600;">insertOrderedList</a></dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="large-12 columns">
                    <textarea id="informatieblok_description" name="informatieblok_description" placeholder="Geef hier alle informatie in" style="margin-bottom: 10px; border-radius: 3px;">
                        <?php 

                            require ("classes/connection.class.php");

                            $sql = "select * from tbl_informatieblok where informatieblok_id='4'";
                            $result = $db->query($sql); 
                            $row = mysqli_fetch_assoc($result);

                            echo $row['informatieblok_description'];
                         ?>
                    </textarea>
                    <small class="error">Geef de informatie in</small>
                </div>

                </form>
          </div>
  </div>

  <!--<textarea id="wysiwyg"></textarea>-->

  <script>
        var editor = new wysihtml5.Editor("informatieblok_description", { // id of textarea element
          toolbar:      "informatieblok_toolbar", // id of toolbar element
          parserRules:  wysihtml5ParserRules // defined in parser rules set 
        });
    </script>

</body>
</html>