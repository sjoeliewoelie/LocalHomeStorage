<?php
  require('scandir.php');
  $LocalBox = new Files();
  $LocalBox->init();
  $LBfiles = $LocalBox->OutFiles();
  session_start();
  require('vkauth.php');
  require('vkapi.php');
  $vkapi = new vkapi();
  $userinfo = $vkapi->getinfo();
  $count = 0;
  if($userinfo != false){
    $username = $userinfo->response[0]->first_name.' '.$userinfo->response[0]->last_name;
    $photo_50 = $userinfo->response[0]->photo_50;
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Local Home Storage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <style>
    body{
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="/assets/css/bootstrap.css?<?=time()?>" rel="stylesheet">
    <link href="/assets/css/bootstrap-glyphicons.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="/assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="/assets/ico/favicon.png">
  </head>

  <body>
      <div class="navbar navbar-fixed-top">
        <div class="chevron"></div>
        <div class="navbar-inner">
          <div  class="container">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">LocalBox</a>
            <div class="nav-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
              </ul>
              <ul class="nav navbar-nav pull-right">
                <?php
                  if($userinfo != false){
                    echo '<li class="usergroup"><a href="http://vk.com/id'.$_SESSION['user_id'].'">'.$username.'</a></li>
                    <li class="divider-vertical usergroup"></li>
                    <li class="dropdown usergroup">
                      <a href="#" class="dropdown-toggle photo_50drop" data-toggle="dropdown">
                        <img class="photo_50" src="'.$photo_50.'">
                      </a>
                      <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="/signout.php">Sign out</a></li>
                      </ul>

                    </li>';
                  }else{
                    echo '<li><a class="btn btn-default" style="height: 50px" href="https://oauth.vk.com/authorize?client_id=3791305&scope=audio,video&redirect_uri=http://'.$_SERVER['HTTP_HOST'].'/&display=popup&v=4.104&response_type=code">Sign in</a></li>';
                  }
                ?>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </div>
      </div>
    <!-- MAIN CONTAINER -->
    <div class="container">
      <ul class="breadcrumb">
        <?php
          $furl = '';
          if(isset($_GET['f'])){
            $url = urldecode($_GET['f']);
            preg_match_all("/[^\\\]*/", $url, $uri);
            echo '<li><a href="http://'.$_SERVER['HTTP_HOST'].'">LocalBox</a></li>';
            for ($i = 0; $i < count($uri[0]); $i++) {
              if($i % 2 != 0){
                if($i + 1 == (count($uri[0]) - 1)){
                  echo '<li class="active">'.$uri[0][$i].'</li>';
                }else{
                  $buff = $uri[0][$i];
                  $furl = $furl.'\\'.$buff;
                  echo '<li><a href="http://'.$_SERVER['HTTP_HOST'].'?f='.urlencode($furl).'">'.$uri[0][$i].'</a></li>';
                }
              }
            }
          }else{
            echo '<li class="active">LocalBox</li>';
          }
        ?>
      </ul>
      <!-- Example row of columns -->
      <div class="row">
        <?php
          foreach($LBfiles as $file){ 
            $count++;
        ?>
        
        <div <?php
              if($file['type'] != 'folder'){ 
                echo  'data-folder="'.$file['infolder'].'" data-mime="'.$file['mime'].'" data-name="'.$file['name'].'" data-file="'.$file['directlink'].'" data-type="'.$file['type'].'"';
              }
            ?> class="col-lg-4 fileitem">
           <?php
              if($file['type'] != 'folder'){  
                echo '<img class="img" src="/assets/icons/'.$file['ico'].'">';
              }else{
                echo '<a href="?f='.$file['folder'].'"><img class="img" src="/assets/icons/'.$file['ico'].'"></a>';
              }
            ?>
          <?php 
            if(strlen($file['name'])>10){
              echo '<h5 title="'.$file['name'].'" class="title">'.strtolower(substr($file['name'],0,9)).'...</h5>';
            }else{
              echo '<h5 class="title">'.$file['name'].'</h5>';
            }
          ?>
          <!--<h5 class="title"><?php //echo $name;?></h5> -->
          <div class="btn-group btn-group-file">
            <a class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" href="#">
              Action
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <!-- dropdown menu links -->
              <?php
              switch($file['type']){
              case 'audio':
              case 'video':
              case 'image':
              case 'text':
                echo '<li><a tabindex="-1" href="'.$file['link'].'" target="_blank"><span class="glyphicon glyphicon-eye-open"></span> Open in new tab</a></li>';
              break;
              case 'folder':
                echo '<li><a tabindex="-1" href="?f='.$file['folder'].'"><span class="glyphicon glyphicon-folder-open"></span> Open</a></li>';
              break;
              };
              ?>
              <?php
                if($file['type'] != 'folder'){
                  echo '<li><a tabindex="-1" class="btnrename" href="#"><span class="glyphicon glyphicon-pencil"></span> Rename</a></li>';
                }
              ?>
              <?php
                if($file['type'] == 'zip'){
                  echo '<li><a tabindex="-1" href="#"><span class="glyphicon glyphicon-share-alt"></span> Unzip</a></li>';
                };
                if($file['type'] == 'x-rar'){
                  echo '<li><a tabindex="-1" href="#"><span class="glyphicon glyphicon-share-alt"></span> Extract</a></li>';
                };
              ?>
              <?php
                if($file['type'] != 'folder'){
                  echo '<li><a tabindex="-1" href="'.$file['link'].'" download><span class="glyphicon glyphicon-download-alt"></span> Download</a></li>';
                }
              ?>
                  <?php
                    if($file['type'] != 'folder'){
                      echo '<li class="divider"></li>
                            <li>
                              <a tabindex="-1" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                            </li>';
                    }
                  ?>
                </li>
            </ul>
          </div>
          </div>
        <?php
          }
        ?>
        </div>
      </div>
        <div class="modal fade" id="ModalFile">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <span id="btns"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></span>
                <h5 id="ModalFileLabel" class="modal-title">Modal title</h5>
              </div>
              <div class="modal-body">
                ...
              </div>
              <div class="modal-footer fedit">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save">Save changes</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <!-- FOOTER -->
    <hr>

    <footer>
      &copy; <a href="http://vk.com/k0mat0znik">Евгений Кирсанов</a> 2013
    </footer>
    <!-- remake bootstrap and styles -->
    <style>
      .row{
        margin:0px auto;
      }
      .col-lg-4{
        -moz-transition:all 0.3s ease;
        -o-transition:all 0.3s ease;
        -webkit-transition:all 0.3s ease;
        transition:all 0.3s ease;
        background-color: #EEEEEE;
        margin:0px 0px 5px 5px;
        max-width:165px;
        float:left;
      }
      .col-lg-4 h5{
        font-size: 12px !important;
        margin-top:15px !important;
        margin-left:0px !important;
      }
      .title{
        margin:10px 0px 10px 5px;
        float:left;
        color:gray;
      }
      .btn-group-file{
        margin: 10px 0px 10px 0px !important;
      }
      .col-lg-4 .btn-group{
        float:right;
        margin:10px 5px 10px 0px;
      }
      .col-lg-4 img{
        cursor: pointer;
        margin-top: 10px;
        -moz-transition:all 0.3s ease;
        -o-transition:all 0.3s ease;
        -webkit-transition:all 0.3s ease;
        transition:all 0.3s ease;
        height:115px;
        width:135px;
        opacity:0.69;
      }
      .col-lg-4:hover{
        -moz-box-shadow: 0px 0px 16px 3px #888;
        -webkit-box-shadow: 0px 0px 16px 3px #888;
        box-shadow: 0px 0px 16px 3px #888;
        z-index: 999;
        background-color: #F7F7F7;
      }
      .col-lg-4:hover img{
        opacity:1;
      }
      .vk{
        width:30px;
      }
      .photo_50{
        width:40px;
        margin-top: 4px;
      }
      .row{
        margin: 0px auto;
      }
      .photo_50drop{
        padding: 0px 0px 0px 0px !important;
      }
      .chevron{
        z-index: 1;
        width:100%;
        height:0;
        opacity: 0.93;
        -moz-transition:all 0.7s ease;
        -o-transition:all 0.7s ease;
        -webkit-transition:all 0.7s ease;
        transition:all 0.7s ease;
      }
      .usergroup{
        float:left !important;
      }
      .dropdown.usergroup.open{
        
      }
      .fedit{
        display:none;
      }
      .inputrename{
        width:510px;
      }
      .video-js{
        width:100% !important;
        height:350px !important;
      }
      .edit_file{
        padding: 0;
        cursor: pointer;
        background: transparent;
        border: 0;
        -webkit-appearance: none;
        opacity: 0.2;
        float:right;
        margin:2px 4px 0px 0px;
      }
      #ModalFile .close{
        font-size: 26px;
      }
      .edit_file:hover{
        opacity:0.5;
      }
      .modal-body textarea{
        resize:none;
        width:535px !important;
        height: 360px !important; 
      }
      .modal-body img{
        width:100%;
      }
      .container{
        max-width: none !important;
      }
      .form-rename{
        width:100%;
      }
      .LocalPlayer{
        -moz-transition:all 0.7s ease;
        -o-transition:all 0.7s ease;
        -webkit-transition:all 0.7s ease;
        transition:all 0.7s ease;
        height:40px;
        width:100%;
      }
      .stop{
        background-color:#F9F9F9;
      }
      .stop:hover{
        background-color:#EFEFEF;
      }
      .pause{
        background-color:#999999;
      }
      .AudioName{
        padding:10px 0px 0px 10px;
      }
      .play{
        color:gray;
        background-color:#DADADA;
      }
      .play:hover{
        background-color:#999999;
        color:#fff;
      }
    </style>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/assets/video-js/video.js"></script>
    <link href="/assets/video-js/video-js.css" rel="stylesheet" type="text/css">
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/bootstrap.js"></script>
    <script src="/assets/soundmanager/script/soundmanager2.js"></script>
    <script type="text/javascript">
      function LBUI(){return this;}
      LBUI.prototype = {
        sound:null,
        init: function(){
          soundManager.setup({
          url: '/assets/soundmanager/swf',
          flashVersion: 9, // optional: shiny features (default = 8)
          // optional: ignore Flash where possible, use 100% HTML5 mode
          // preferFlash: false,
          onready: function() {
            // Ready to use; soundManager.createSound() etc. can now be called.
            console.log('LocalSound initialized');
          }
        });
          $('.opennav').css({'height': $(window).height()/2 + 'px'});
          $('.navbar-brand').click(function(){
            if($('.chevron').hasClass('opennav')){
              $('.opennav').css({'height': 0, 'background-color': '#EEEEEE'});
              $('.chevron').removeClass('opennav');
            }else{
              $('.chevron').addClass('opennav');
              $('.opennav').css({'height': $(window).height()/2 + 'px'});
            }
          });
          var $this = this;
          $('#ModalFile').on('hidden.bs.modal', function () {
            $('.modal-body').html('');
            $('#ModalFileLabel').html('');
            $('.modal-footer').addClass('fedit');
            $('#btns').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
            if($this.sound != null){
              $this.sound.unload();
              $this.sound = null;
              soundManager.destroySound('LocalSound');
            }
          })
          $('.delete').click(function(event){$this.FDelete(event.currentTarget)});
          $('.btnrename').click(function(event){$this.ModalFileRename(event.currentTarget)});
          $('.img').click(function(event){$this.ModalFileOpen(event.currentTarget)});
        },
        FDelete: function(FButton){
          jQuery.ajax({
          url: 'delete.php',
          type: 'POST',
          dataType: 'json',
          data: {delete: $(FButton).closest('.fileitem').data('file')},
          complete: function(xhr, textStatus) {
            //called when complete
          },
          success: function(data, textStatus, xhr) {
            //called when successful
            if(data.status == 'OK'){
              $(FButton).closest('.fileitem').remove();
            }
          },
          error: function(xhr, textStatus, errorThrown) {
            //called when there is an error
          }
        });
        },
        ModalFileOpen: function(FModal){
          $('#ModalFileLabel').html($(FModal).closest('.fileitem').data('name'));
          switch($(FModal).closest('.fileitem').data('type')){
            case 'image':
              $('.modal-body').html('<img src="' + $(FModal).closest('.fileitem').data('file') + '"/>');
              $('#ModalFile').modal('toggle');
            
            break;
            case 'video':
              var $vid = Math.floor(Math.random()*9999 + 1);
              $('.modal-body').html('<video id="V'+$vid+'" class="video-js vjs-default-skin" controls preload="none"data-setup="{}"><source src="'+$(FModal).closest('.fileitem').data('file')+'"type="'+$(FModal).closest('.fileitem').data('mime')+'"/></video>');
              videojs('V'+$vid, { "controls": true, "autoplay": false, "preload": "auto" });
              $('#ModalFile').modal('toggle');
            break;
              case 'text':
                var $this = this;
                jQuery.ajax({
                  url: 'readfile.php',
                  type: 'POST',
                  dataType: 'json',
                  data: {readf: $(FModal).closest('.fileitem').data('file')},
                  complete: function(xhr, textStatus) {
                    //called when complete
                  },
                  success: function(data, textStatus, xhr) {
                    //called when successful
                    if(data.status == 'OK'){
                      $('#btns').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><button class="edit_file"><span class="glyphicon glyphicon-pencil"></span></button>');
                      $('.edit_file').click(function(event){$this.FileEdit(FModal)});
                      $('.modal-body').html('<pre class="filetext" style="word-wrap: break-word; white-space: pre-wrap;">'+data.file+'</pre>');
                      $('#ModalFile').modal('toggle');
                    }
                  },
                  error: function(xhr, textStatus, errorThrown) {
                    //called when there is an error
                  }
                });
                
              break;
              case 'audio':
                $('.modal-body').html('<div class="LocalPlayer stop"><h4 class="tittle AudioName">'+$(FModal).closest('.fileitem').data('name')+'</h4></div>');
                var $this = this;
                $('.LocalPlayer').click(function(){
                  if($this.sound != null){
                    if($('.LocalPlayer').hasClass('play')){
                      $('.LocalPlayer').removeClass('play');
                      $('.LocalPlayer').addClass('pause');
                      $this.sound.pause();
                    }else if($('.LocalPlayer').hasClass('pause')){
                      $('.LocalPlayer').removeClass('pause');
                      $('.LocalPlayer').addClass('play');
                      $this.sound.resume();
                    }else{
                      $this.sound.unload();
                    }
                  }else{
                    $this.sound = soundManager.createSound({
                      id : 'LocalSound',
                      url : $(FModal).closest('.fileitem').data('file')
                    }).play();
                    $('.LocalPlayer').removeClass('stop');
                    $('.LocalPlayer').addClass('play');
                  }
                });
                $('#ModalFile').modal('toggle');
              break;
          }
        },
        ModalFileRename: function(FModal){
          $('#ModalFileLabel').html('Rename');
          $('.modal-footer').removeClass('fedit');
          $('.save').click(function(event){document.forms['rename'].submit()});
          $('.modal-body').html('<form class="input-group form-rename" name="rename" action="rename.php" method="POST"><input class="inputrename form-control" name="newname" type="text" value="' + $(FModal).closest('.fileitem').data('name') + '" /></input><input type="hidden" name="oldname" value="'+$(FModal).closest('.fileitem').data('name')+'"></input><input type="hidden" name="folder" value="'+$(FModal).closest('.fileitem').data('folder')+'"></input></form>');
          $('#ModalFile').modal('toggle');
      },
      FileEdit: function(FEModal){
        $('.modal-footer').removeClass('fedit');
        $text = $('.filetext').html();
        $('#btns').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>');
        $('.save').click(function(event){document.forms['editfile'].submit()});
        $('.modal-body').html('<form class="input-group" style="margin:0px;" name="editfile" action="editfile.php" method="POST"><textarea  class="form-control" type="text" name="newtext">'+$text+'</textarea></input><input type="hidden" name="filefolder" value="'+$(FEModal).closest('.fileitem').data('file')+'"></form>');
      }
      }
      jQuery(document).ready(function($) {
        var  UI = new LBUI();
        UI.init();
      });
    </script>
  </body>
</html>