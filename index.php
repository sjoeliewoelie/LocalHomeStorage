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
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">

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
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="brand" href="#">LocalBox</a>
            <div class="nav-collapse collapse">
              <ul class="nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
              </ul>
              <ul class="nav pull-right">
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
                    echo '<li><a href="https://oauth.vk.com/authorize?client_id=3791305&scope=audio,video&redirect_uri=http://'.$_SERVER['HTTP_HOST'].'/&display=popup&v=4.104&response_type=code"><i class="icon-user"></i> Sign in</a></li>';
                  } 
                ?>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </div>
      </div>
    <!-- MAIN CONTAINER -->
    <div class="container">
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
            ?> class="span4 fileitem">
          <img class="img" src="/assets/icons/<?php echo $file['ico'];?>">
          <?php 
            if(strlen($file['name'])>10){
              echo '<h5 title="'.$file['name'].'" class="title">'.substr($file['name'],0,7).'...</h5>';
            }else{
              echo '<h5 class="title">'.$file['name'].'</h5>';
            }
          ?>
          <!--<h5 class="title"><?php //echo $name;?></h5> -->
          <div class="btn-group">
            <a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
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
                echo '<li><a tabindex="-1" href="'.$file['link'].'" target="_blank"><i class="icon-eye-open"></i> Open in new tab</a></li>';
              break;
              case 'folder':
                echo '<li><a tabindex="-1" href="?f='.$file['folder'].'"><i class="icon-folder-open"></i> Open</a></li>';
              break;
              };
              ?>
              <?php
                if($file['type'] != 'folder'){
                  echo '<li><a tabindex="-1" class="btnrename" href="#"><i class="icon-pencil"></i> Rename</a></li>';
                }
              ?>
              <?php
                if($file['type'] == 'zip'){
                  echo '<li><a tabindex="-1" href="#"><i class="icon-share-alt"></i> Unzip</a></li>';
                };
                if($file['type'] == 'x-rar'){
                  echo '<li><a tabindex="-1" href="#"><i class="icon-share-alt"></i> Extract</a></li>';
                };
              ?>
              <?php
                if($file['type'] != 'folder'){
                  echo '<li><a tabindex="-1" href="'.$file['link'].'" download><i class="icon-download-alt"></i> Download</a></li>';
                }
              ?>
                  <?php
                    if($file['type'] != 'folder'){
                      echo '<li class="divider"></li>
                            <li>
                              <a tabindex="-1" class="delete" href="#"><i class="icon-trash"></i> Delete</a>
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
        <div id="ModalFile" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ModalFileLabel" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="ModalFileLabel"></h5>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer rename">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button onclick="document.forms['rename'].submit()" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div> <!-- /container -->

    <!-- FOOTER -->
    <hr>

    <footer>
      &copy; <a href="http://vk.com/k0mat0znik">Евгений Кирсанов</a> 2013
    </footer>
    <!-- remake bootstrap and styles -->
    <style>
      .span4{
        -moz-box-shadow: 1px 6px 12px -6px #888;
        -webkit-box-shadow: 1px 6px 12px -6px #888;
        box-shadow: 1px 6px 12px -6px #888;
        border-radius: 8px 8px 8px 8px;
        margin:0px 0px 20px 20px;
        max-width:151px;
        float:left;
      }
      .title{
        margin:10px 0px 10px 5px;
        float:left;
        color:gray;
      }
      .span4 .btn-group{
        float:right;
        margin:10px 5px 10px 0px;
      }
      .span4 img{
        height:125px;
        width:370px;
        opacity:0.7;
      }
      .span4:hover{
        -moz-box-shadow: 0px 0px 10px 1px #888;
        -webkit-box-shadow: 0px 0px 10px 1px #888;
        box-shadow: 0px 0px 10px 1px #888;
      }
      .span4:hover img{
        opacity:1;
      }
      .span4{
        float: left;
        margin-left: 20px;
      }
      .vk{
        width:30px;
      }
      .photo_50{
        width:34px;
        margin-top: 3px;
      }
      .photo_50drop{
        padding: 0px 0px 0px 0px !important;
      }
      .chevron{
        z-index: 1;
        width:100%;
        background: #fafafa;
        height:0px;
        opacity: 0.93;
        -moz-transition:all 0.7s ease;
        -o-transition:all 0.7s ease;
        -webkit-transition:all 0.7s ease;
        transition:all 0.7s ease;
      }
      .opennav{
        height:300px;
      }
      .usergroup{
        float:left !important;
      }
      .dropdown.usergroup.open{
        width:34px !important;
      }
      .rename{
        display:none;
      }
      .inputrename{
        width:510px;
      }
    </style>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/assets/video-js/video.js"></script>
    <link href="/assets/video-js/video-js.css" rel="stylesheet" type="text/css">
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/bootstrap.js"></script>
    <script type="text/javascript">
      function LBUI(){return this;}
      LBUI.prototype = {
        init: function(){
        videojs.options.flash.swf = "/assets/video-js/video-js.swf";
          $('.brand').click(function(){
            if($('.chevron').hasClass('opennav')){
              $('.chevron').removeClass('opennav');
            }else{
              $('.chevron').addClass('opennav');
            }
          });
          var $this = this;
          $('#ModalFile').on('hidden', function () {
            $('.modal-body').html('');
            $('#ModalFileLabel').html('');
            $('.modal-footer').addClass('rename');
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
              $('.modal-body').html('<video id="V'+$vid+'" class="video-js vjs-default-skin" controls preload="none"data-setup="{}" width="530" height="400" ><source src="'+$(FModal).closest('.fileitem').data('file')+'"type="'+$(FModal).closest('.fileitem').data('mime')+'"/></video>');
              videojs('V'+$vid, { "controls": true, "autoplay": false, "preload": "auto" });
              $('#ModalFile').modal('toggle');
            break;
          }
        },
        ModalFileRename: function(FModal){
          $('#ModalFileLabel').html('Rename');
          $('.modal-footer').removeClass('rename');
          $('.modal-body').html('<form name="rename" action="rename.php" method="POST"><input class="inputrename" name="newname" type="text" value="' + $(FModal).closest('.fileitem').data('name') + '" /></input><input type="hidden" name="oldname" value="'+$(FModal).closest('.fileitem').data('name')+'"></input><input type="hidden" name="folder" value="'+$(FModal).closest('.fileitem').data('folder')+'"></input></form>');
          $('#ModalFile').modal('toggle');
      }
      }
      jQuery(document).ready(function($) {
        var  UI = new LBUI();
        UI.init();
      });
    </script>
  </body>
</html>