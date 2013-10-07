<?php
  require('scandir.php');
  $LocalBox = new Files();
  $LocalBox->init();
  $LBfiles = $LocalBox->OutFiles();
  $count = 0;
  /*session_start();
  require('vkauth.php');
  require('vkapi.php');
  $vkapi = new vkapi();
  $userinfo = $vkapi->getinfo();
  $userdata = $vkapi->getdata();
  if($userinfo != false){
    $username = $userinfo->response[0]->first_name.' '.$userinfo->response[0]->last_name;
    $photo_50 = $userinfo->response[0]->photo_50;
  }*/

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
        <div class="chevron">
        <?php
          /*if($userdata != false){
            for($i = 0;$i<=(($userdata->response->count));$i++){
              if(isset($userdata->response->items[$i])){
                echo '<div class="LocalPlayer"><div data-file="'.($userdata->response->items[$i]->url).'" data-id="'.($userdata->response->items[$i]->id).'" class="LocalPlayer playbtn"></div><div class="LocalPlayer mainbtn"><h5 class="title">'.($userdata->response->items[$i]->artist).' - '.($userdata->response->items[$i]->title).'</h5></div><a href="'.($userdata->response->items[$i]->url).'" download><div class="LocalPlayer downloadbtn"></div></a></div>';
              }
            }
          }*/
        ?>
        </div>
        <div class="navbar-inner">
          <div  class="container">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">LocalBox</a>
            <div class="nav-collapse collapse">
              <ul class="nav navbar-nav pull-right vkinfo">
                 <li><a style="height: 50px" id="login_button" href="#">Sign in</a></li>
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
        <div class="col-lg-4 fileitem createfolder">
           <img class="img" src="/assets/icons/new folder.png">          
           <h5 class="title">Create folder</h5>          <!--<h5 class="title"></h5> -->
        </div>
        <div class="col-lg-4 fileitem uploadfile">
           <img class="img" src="/assets/icons/upload.png">          
           <h5 class="title">Upload file</h5>          <!--<h5 class="title"></h5> -->
        </div>
        <?php
          foreach($LBfiles as $file){ 
            $count++;
        ?>
        
        <div <?php
              if($file['type'] != 'folder'){ 
                echo  'data-folder="'.$file['infolder'].'" data-mime="'.$file['mime'].'" data-name="'.$file['name'].'" data-file="'.$file['directlink'].'" data-type="'.$file['type'].'"';
              }else{
                echo  'data-file="'.$file['directlink'].'"';
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
                  echo '<li><a class="btnextract" tabindex="-1" href="#"><span class="glyphicon glyphicon-share-alt"></span> Unzip</a></li>';
                };
                if($file['type'] == 'x-rar'){
                  echo '<li><a class="btnextract" tabindex="-1" href="#"><span class="glyphicon glyphicon-share-alt"></span> Extract</a></li>';
                };
              ?>
              <?php
                if($file['type'] != 'folder'){
                  echo '<li><a tabindex="-1" href="'.$file['link'].'" download><span class="glyphicon glyphicon-download-alt"></span> Download</a></li>';
                }
              ?>
                  <li class="divider"></li>
                       <li>
                          <a tabindex="-1" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                        </li>
                  </li>
            </ul>
          </div>
          </div>
        <?php
          }
        ?>
        </div>
      </div>

      <div style="display:none; opacity:0.6;" class="dropbox-indicator top">
      </div>
      <div style="display:none; opacity:0.6;" class="dropbox-indicator right">
      </div>
      <div style="display:none; opacity:0.6;" class="dropbox-indicator bottom">
      </div>
      <div style="display:none; opacity:0.6;" class="dropbox-indicator left">
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
        overflow-y: auto;
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
      .AudioName{
        padding:10px 0px 0px 10px;
      }
      .dropbox-indicator{
        position: fixed;
        background-color: #060;
        z-index: 1050;
      }
      .top{
        top: 0px;
        left: 6px;
        width: 100%;
        height: 6px;
      }
      .right{
        top: 6px;
        right: 0px;
        width: 6px;
        height: 100%;
      }
      .bottom{
        bottom: 0px;
        right: 6px;
        width: 100%;
        height: 6px;
      }
      .left{
        bottom: 6px;
        left: 0px;
        width: 6px;
        height: 100%;
      }
      .dragover{
        border:5px solid #66a367;
      }
      .fileitem{
        height:171px;
      }
      .dropbox-modal{
        position: fixed;
        width: 50%;
        bottom: 0px;
        margin: 0px auto;
        left: 25%;
      }
      .dropbox-modal .progress{
        height:30px;
        margin-bottom: 0px;
        text-overflow: ellipsis;
      }
      .dropbox-modal h4{
        margin: 6px;
        float: left;
        text-overflow: ellipsis;
      }
      .playbtn{
        display:inline-block;
        margin:0px 0px 0px 0px;
        width:40px;
        background: url(/assets/icons/play.png) no-repeat;
        background-size: 30px;
        background-position: 5px;
        background-color: #d5d5d5;
        float:left;
        height:40px;
      }
      .downloadbtn{
        display:inline-block;
        margin:0px 0px 0px 0px;
        width:40px;
        background: url(/assets/icons/download_1.png) no-repeat;
        background-size: 30px;
        background-position: 5px;
        background-color: #d5d5d5;
        height:40px;
      }
      .mainbtn{
        display:inline-block;
        margin:0px 1% 0px 1%;
        background-color: #d5d5d5;
        float:left;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        height:40px;
      }
      .mainbtn h5{
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        float:none;
        margin: 10px 0px 0px 1%;;
      }
      .LocalPlayer{
        -moz-transition:all 1s ease;
        -o-transition:all 1s ease;
        -webkit-transition:all 1s ease;
        transition:all 1s ease;
        height:40px;
        width:auto;
        margin:5px 0px 0px 0px;
      }
      .line{
        float:left;
        display: none;
        width: 73%;
        height: 5px;
        background-color: white;
        margin: 5px 1% 0px 1%;
        cursor: pointer;
      }
      .volume{
        display: none;
        width: 22%;
        height: 5px;
        background-color: white;
        margin: 0 0 0 1%;
        float:left;
        cursor: pointer;
      }
      .v_progress{
        background-color: gray;
        height: 5px;
        width: 0%;
        border-radius: 0px;
        position: relative;
        overflow: visible;
      }
      .a_progress{
        background-color: gray;
        height: 5px;
        width: 0%;
        border-radius: 0px;
        margin-top: -5px;
        position: relative;
        overflow: visible;
      }
      .load{
        width: 0%;
        height: 5px;
        background-color: #BEBEBE;
      }
      .time{
        float: right;
        height: 25px;
        width:35px;
        margin: 5px 5px 0px 0px;
      }
      .play{
        background-image: url(/assets/icons/pause.png);
      }
      .LocalPlayer:hover .playbtn{
        background-color: #CFCECE;
      }
      .LocalPlayer:hover .mainbtn{
        background-color: #CFCECE;
      }
      .LocalPlayer:hover .downloadbtn{
        background-color: #CFCECE;
      }
      .dot{
        width: 10px;
        height: 10px;
        background-color: gray;
        position: absolute;
        top: -2.5px;
        display: none;
        margin: 0;
        padding: 0;
        right: -5px;
        z-index: 0;
        cursor: pointer;
      }
      .a_tooltip{
        opacity: 0.7;
        width: 36px;
        height: 20px;
        position: absolute;
        top: -29px;
        right: -16.5px;
        background-color: black;
        display:none;
        z-index: 222;
      }
      .a_triangle{
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 7px solid black;
        position: absolute;
        bottom: -7px;
        left: 14px;
      }
      .a_tooltip-title{
        margin: 3px 0px 0px 0px;
        color: #999999;
        text-align: center;
      }
    </style>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://vk.com/js/api/openapi.js" type="text/javascript"></script>
    <script src="/assets/video-js/video.js"></script>
    <link href="/assets/video-js/video-js.css" rel="stylesheet" type="text/css">
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/bootstrap.js"></script>
    <script src="/assets/soundmanager/script/soundmanager2.js"></script>
    <script type="text/javascript">
      function LBUI(){return this;}
      LBUI.prototype = {
        sound:null,
        volume:100,
        f: <?=(isset($_GET['f']))?"'".urlencode($_GET['f'])."'":'null'?>,
        fdecode: <?=(isset($_GET['f']))?"'".str_replace('\\', '\\\\', $_GET['f'])."'":'null'?>,
        init: function(){
          soundManager.setup({
          url: '/assets/soundmanager/swf',
          flashVersion: 9, // optional: shiny features (default = 8)
          // optional: ignore Flash where possible, use 100% HTML5 mode
          // preferFlash: false,
          onready: function() {
            // Ready to use; soundManager.createSound() etc. can now be called.
          }
        });
          $('.opennav').css({'height': $(window).height()/2 + 'px'});
          VK.init({
            apiId: 3791305
          });
          var $this = this;
          this.bindAll();
          //VK.UI.button('login_button');
          VK.Auth.getLoginStatus(function(event){$this.authInfo(event)});
          VK.Observer.subscribe('auth.login',function(event){$this.authInfo(event)});
          /*if(window.location.hash != ''){
            ans = window.location.hash.split('#')[1].split('&');
            if(ans.length == 3){
              access_token = ans[0].split('=')[1];
              expires_in = ans[1].split('=')[1];
              user_id = ans[2].split('=')[1];
              $.ajax({
                  url: 'vkauth.php',
                  type: 'post',
                  data: {access_token: access_token,expires_in: expires_in,user_id:user_id},
                  success: function (data) {
                    if(data == 'OK'){
                      document.location = 'http://'+document.location.hostname;
                    }
                  }
                });
            }
          }*/
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
                $('.modal-body').html('<div data-id="000" class="LocalPlayer"><h4 class="tittle AudioName">'+$(FModal).closest('.fileitem').data('name')+'</h4></div>');
                var $this = this;
                $this.unbindAll;
                $this.bindAll;
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
          $('.modal-body').html('<form class="input-group" style="margin:0px;" name="editfile" action="editfile.php" method="POST"><textarea  class="form-control" type="text" name="newtext">'+$text+'</textarea><input type="hidden" name="filefolder" value="'+$(FEModal).closest('.fileitem').data('file')+'"></form>');
        },
        ModalFileExtract: function(FModal){
          $('#ModalFileLabel').html($(FModal).closest('.fileitem').data('name'));
          $('.modal-footer').removeClass('fedit');
          $('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary save">Extract</button>');
          $('.save').click(function(event){document.forms['extractfile'].submit()});
          $('.modal-body').html('<form style="margin:0px;" name="extractfile" action="extractfile.php" method="POST"><input type="hidden" name="zipfolder" value="'+$(FModal).closest('.fileitem').data('file')+'"><input type="hidden" name="filename" value="'+$(FModal).closest('.fileitem').data('name')+'">Extract to this folder of the same name?</form>');
          $('#ModalFile').modal('toggle');
        },
        UploadProgress: function(event,name){
          var percent = parseInt(event.loaded / event.total * 100);
          //console.log('загрузка' + percent + '%');
          $('.dropbox-modal').html('<div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="'+ percent +'" aria-valuemin="0" aria-valuemax="100" style="width:'+ percent +'%;"><h4>Uploading '+ name +'</h4></div></div>');
        },
        StateChange: function(event){
          var $this = this;
          if (event.target.readyState == 4) {
            if (event.target.status == 200) {
                if(this.fdecode == null){
                  folder = '';
                }else{
                  folder = this.fdecode;
                }
                var response  = event.target.responseText;
                namet = jQuery.parseJSON(response);
                name = namet['name'];
                type = namet['MIME'];
                icotype = this.GetIco(type,name);
                dropdown = this.GetDropdown(icotype[1],folder+'/'+ name);
                var file = '<div data-folder="'+ folder +'" data-mime="'+ type +'" data-name="'+ name +'" data-file="'+ folder+'/'+ name +'" data-type="' + icotype[1] + '" class="col-lg-4 fileitem"><img class="img" src="/assets/icons/'+ icotype[0] +'">          <h5 title="'+ name +'" class="title">'+ ((name.length > 10)?name.substr(0,9) + '...':name) +'</h5>          <!--<h5 class="title"></h5> --><div class="btn-group btn-group-file"><a class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" href="#">Action<span class="caret"></span></a><ul class="dropdown-menu"><!-- dropdown menu links -->'+dropdown+'<li class="divider"></li><li><a tabindex="-1" class="delete" href="#"><span class="glyphicon glyphicon-trash"></span> Delete</a></li></ul></div></div>'
                $('.row').append(file);
                this.unbindAll();
                this.bindAll();
                $('.dropbox-modal').animate({opacity: 0}, 500, function() {$(this).remove();});
                $('body').append('<div class="dropbox-modal"><div class="progress"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;"><h4>Saved with name  '+ name +'</h4></div></div></div>');
                $('.dropbox-modal').delay(1000).animate({opacity: 0}, 800, function() {$(this).remove();})
            }
          }
        },
        GetIco:function(type,name){
          var $group = type.split('/')
          switch($group[0]){
            case 'audio':
              $ico = 'audio.png';
            break;
            case 'application':
              $ico = 'application.png';
              if(type == 'application/x-bittorrent'){
                $group[0] = 'torrent';
                $ico = 'torrent.png';
              }else if(type == 'application/zip'){
                $group[0] = 'zip';
                $ico = 'zip.png';
              }else if(type == 'application/x-rar'){
                $group[0] = 'x-rar';
                $ico = 'archive.png';
              }else{
                $ico = 'application.png';
              }
            break;
            case 'text':
              $ico = 'document.png';
            break;
            case 'image':
              if(type == 'image/gif'){
                $group[0] = 'image';
                $ico = 'gif.png';
              }else{
                $ico = 'image.png';
              }
            break;
            case 'video':
              $ico = 'video.png';
            break; 
            default:
              $ico = 'application.png';
              $group[0] = 'application';
            break;
          }
          return [$ico,$group[0]];
        },
        GetDropdown:function(type,link){
          var dropdown;
          dropdown = '';
          switch(type){
            case 'audio':
            case 'video':
            case 'image':
            case 'text':
              dropdown+= '<li><a tabindex="-1" href="' + encodeURIComponent(link.replace('/\\/g','/')) + '" target="_blank"><span class="glyphicon glyphicon-eye-open"></span> Open in new tab</a></li><li><a tabindex="-1" class="btnrename" href="#"><span class="glyphicon glyphicon-pencil"></span> Rename</a></li>';
            break;
            case 'x-rar':
              dropdown+= '<li><a tabindex="-1" class="btnrename" href="#"><span class="glyphicon glyphicon-pencil"></span> Rename</a></li><li><a class="btnextract" tabindex="-1" href="#"><span class="glyphicon glyphicon-share-alt"></span> Unzip</a></li>';
            break;
            case 'x-rar':
              dropdown+= '<li><a tabindex="-1" class="btnrename" href="#"><span class="glyphicon glyphicon-pencil"></span> Rename</a></li><li><a class="btnextract" tabindex="-1" href="#"><span class="glyphicon glyphicon-share-alt"></span> Extract</a></li>';
            break;
            default:
              dropdown+= '<li><a tabindex="-1" class="btnrename" href="#"><span class="glyphicon glyphicon-pencil"></span> Rename</a></li><li><a tabindex="-1" href="' + encodeURIComponent(link.replace('/\\/g','/')) + '" download><span class="glyphicon glyphicon-download-alt"></span> Download</a></li>';;
            break; 
            };
          return dropdown;
        },
        bindAll: function(){
          var $this = this;
            $('#ModalFile').on('hidden.bs.modal', function () {
              $('.modal-body').html('');
              $('#ModalFileLabel').html('');
              $('.modal-footer').addClass('fedit');
              $('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary save">Save changes</button>');
              $('#btns').html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
              if($this.sound != null){
                $this.sound.unload();
                $this.sound = null;
                soundManager.destroySound('LocalSound');
              }
            })
          $('.delete').click(function(event){$this.FDelete(event.currentTarget)});
          /*$('.line').click(function(event){
            $this.sound.setPosition(Math.floor($(this).parent().parent().find('.playbtn').data('duration')*event.offsetX/$(this).width()*1000));
          });*/
          $('.line').bind('mousedown',function(event) {
            elem = this;
            $(elem).addClass('down');
            $(elem).find('.dot').addClass('show');
            $(elem).find('.a_tooltip').addClass('show');
            width = event.offsetX;
            $(elem).find('.a_progress').css({'width': (width/$(elem).width()*100)+'%'});
            min = Math.floor(Math.floor($(elem).parent().parent().find('.playbtn').data('duration')*width/$(elem).width())/60);
              sec = Math.round((Math.floor($(elem).parent().parent().find('.playbtn').data('duration')*width/$(elem).width())/60-Math.floor(Math.floor($(elem).parent().parent().find('.playbtn').data('duration')*width/$(elem).width())/60))*60);
              if (sec<10){
                sec = '0'+sec;
              }
              $(elem).find('.a_tooltip-title').html(min + ':' + sec);
            $(document).bind('mousemove', function(event){
              width = event.clientX-elem.offsetLeft;
              if(width >= elem.clientWidth){
                width = elem.clientWidth;
              }else if(width<0){
                width = 0;
              }
              $(elem).find('.a_progress').css({'width': (width/$(elem).width()*100)+'%'});
              min = Math.floor(Math.floor($(elem).parent().parent().find('.playbtn').data('duration')*width/$(elem).width())/60);
              sec = Math.round((Math.floor($(elem).parent().parent().find('.playbtn').data('duration')*width/$(elem).width())/60-Math.floor(Math.floor($(elem).parent().parent().find('.playbtn').data('duration')*width/$(elem).width())/60))*60);
              if (sec<10){
                sec = '0'+sec;
              }
              $(elem).find('.a_tooltip-title').html(min + ':' + sec);
            }).bind('mouseup',function(event){$(elem).removeClass('down');$(elem).find('.dot').removeClass('show');$(document).unbind('mousemove').unbind('mouseup').unbind('selectstart').unbind('dragstart');$(elem).find('.a_tooltip').removeClass('show');$this.sound.setPosition(Math.floor($(elem).parent().parent().find('.playbtn').data('duration')*width/$(elem).width()*1000));}).bind('selectstart',function(event){return false; event.stopPropagation();}).bind('dragstart',function(event){return false; event.stopPropagation();});
          }).bind('mouseover',function(event){$(this).find('.a_tooltip').addClass('show');}).bind('mouseout',function(event){$(this).find('.a_tooltip').removeClass('show');});
          $('.volume').bind('mousedown',function(event) {
            elem = this;
            $(elem).addClass('down');
            $(elem).find('.a_tooltip').addClass('show');
            $(elem).unbind('mouseout');
            if(!$(event.target).hasClass('dot')){
              width = event.offsetX;
              $(elem).find('.v_progress').css({'width': (width/$(elem).width()*100)+'%'});
              $(elem).find('.a_tooltip-title').html(Math.floor(width/$(elem).width()*100)+'%');
              $this.sound.setVolume(Math.floor(width/$(elem).width()*100));
            }
            $(document).bind('mousemove', function(event){
              width = event.clientX-elem.offsetLeft;
              if(width >= elem.clientWidth){
                width = elem.clientWidth;
              }else if(width<0){
                width = 0;
              }
              $(elem).find('.v_progress').css({'width': (width/$(elem).width()*100)+'%'});
              $this.sound.setVolume(Math.floor(width/$(elem).width()*100));
              $(elem).find('.a_tooltip-title').html(Math.floor(width/$(elem).width()*100)+'%');
            }).bind('mouseup',function(event){$(elem).removeClass('down');$(document).unbind('mousemove').unbind('mouseup').unbind('selectstart').unbind('dragstart');$(this).find('.dot').removeClass('show');$(elem).bind('mouseout',function(event){$(this).find('.dot').removeClass('show');});$(elem).find('.a_tooltip').removeClass('show');$this.sound.setVolume(Math.floor(width/$(elem).width()*100));$this.volume = $this.sound['volume']}).bind('selectstart',function(event){return false; event.stopPropagation();}).bind('dragstart',function(event){return false; event.stopPropagation();});
          }).bind('mouseover',function(event){$(this).find('.dot').addClass('show');}).bind('mouseout',function(event){$(this).find('.dot').removeClass('show');});

          $('.btnrename').click(function(event){$this.ModalFileRename(event.currentTarget)});
          $('.btnextract').click(function(event){$this.ModalFileExtract(event.currentTarget)});
          $('.img').click(function(event){$this.ModalFileOpen(event.currentTarget)});
          $(window).resize(function(){
            $('.mainbtn').css({'width': $('.mainbtn').parent().width()*0.98-97 + 'px'});
            //$('.line').css({'width': $('.line').parent().width()-140 + 'px'}); 
            //$('.line').css({'width': $('.line').parent().width()-$('.volume').width()-50 + 'px'});
          });
          $('.chevron').bind('scroll',function(event){
            if($(event.currentTarget).scrollTop() == (event.currentTarget.scrollHeight-$(event.currentTarget).height())){
              VK.Auth.getLoginStatus(function(response) { 
                if (response.session) {
                  $this.getAudio(response);
                }
              }); 
            }
          });
          $('html').bind('dragover', function(event){
            $('.dropbox-indicator').css('display','block'); 
              return false;
            }).bind('dragleave', function(event){
              $('.dropbox-indicator').css('display','none'); 
              return false;
            }).bind('drop', function(){
              event.preventDefault(); 
              $('.dropbox-indicator').css('display','none'); 
              var file = event.dataTransfer.files[0];
              var xhr = new XMLHttpRequest();
              var fname = event.dataTransfer.files[0]['name'];
              xhr.upload.addEventListener('progress', function(event){$this.UploadProgress(event,fname)}, false);
              xhr.onreadystatechange = function(event){$this.StateChange(event)};
              xhr.open('POST', '/upload.php');
              var fd = new FormData;
              fd.append("file", file);
              if($this.f != null){fd.append("folder", $this.f);}
              xhr.send(fd);
              $('body').append('<div class="dropbox-modal"></div>');
            });
            $('.createfolder').click(function(event){$this.CreateFolder(event.currentTarget)});
            $('#login_button').click(function(event){VK.Auth.login(function(){return false;},8)});
            $('#logout_button').click(function(event){VK.Auth.logout($this.outInfo())});
            $('.playbtn').click(function(){
              if($this.sound == null){
                $this.sound = $this.LBSound(this,$this);
              }else{
                if($this.sound['id'] == $(this).attr('id')){
                  if($(this).hasClass('play')){
                    $this.sound.pause(); 
                  }else{
                    $this.sound.resume();
                  }
                }else{
                  $this.sound.unload();
                  $this.sound.destruct();
                  $this.sound=null;
                  $this.sound = $this.LBSound(this,$this);
                }
              }
            });
        },
        unbindAll: function(){
          $('#ModalFile').unbind();
          $('.delete').unbind();
          $('.btnrename').unbind();
          $('.btnextract').unbind();
          $('.img').unbind();
          $('html').unbind();
          $('.createfolder').unbind();
          $('.playbtn').unbind();
          $(window).unbind();
          $('line').unbind();
          $('.volume').unbind();
          $('.chevron').unbind();
          $('#login_button').unbind();
          $('#logout_button').unbind();
        },
        CreateFolder: function(){
          var $this = this;
          $('#ModalFileLabel').html('Create folder');
          $('.modal-footer').removeClass('fedit');
          $('.save').click(function(event){document.forms['CreateFolder'].submit()});
          $('.modal-body').html('<form class="input-group form-rename" name="CreateFolder" action="createfolder.php" method="POST"><input class="form-control inputrename" value="new folder" name="foldername" type="text" /><input type="hidden" name="folder" value="'+ $this.fdecode +'" /></form>');
          $('#ModalFile').modal('toggle');
        },
        authInfo: function(response) {
          var $self = this;
              if (response.session) {
                VK.Observer.unsubscribe('auth.login');
                $('.navbar-brand').click(function(){
                  if($('.chevron').hasClass('opennav')){
                    $('.opennav').css({'height': 0, 'background-color': '#EEEEEE'});
                    $('.chevron').removeClass('opennav');
                  }else{
                    $('.chevron').addClass('opennav');
                    $('.opennav').css({'height': $(window).height()/2 + 'px'});
                  }
                });
                VK.Api.call('users.get', {user_ids: response.session.mid, fields:'photo_50'}, function(r) { 
                  if(r.response) { 
                    $('.vkinfo').html('<li class="usergroup"><a href="http://vk.com/id'+r.response[0].uid+'">'+r.response[0].first_name+' '+r.response[0].last_name+'</a></li><li class="divider-vertical usergroup"></li><li class="dropdown usergroup"><a href="#" class="dropdown-toggle photo_50drop" data-toggle="dropdown"><img class="photo_50" src="'+r.response[0].photo_50+'"></a><ul class="dropdown-menu"><li><a id="logout_button">Sign out</a></li></ul></li>');
                  } 
                });
                $self.unbindAll();
                $self.bindAll();
                $self.getAudio(response); 
              }
        },
        outInfo: function(){
          var $self = this;
          $('.vkinfo').html('<li><a style="height: 50px" id="login_button" href="#">Sign in</a></li>');
          $self.unbindAll();
          $self.bindAll();
          $('.navbar-brand').unbind();
          VK.Observer.subscribe('auth.login',function(event){$self.authInfo(event)});
        },
        getAudio: function(response){
          $self = this;
          if(!$('.chevron').hasClass('loading')){
            if($('.chevron .LocalPlayer:last-child').find('.playbtn').attr('id') == undefined){
              var pref = 0;
            }else{
              var pref = $('.chevron .LocalPlayer:last-child').find('.playbtn').attr('id')*1+1;
            }
            VK.Api.call('audio.get', {owner_id: response.session.mid, access_token:response.session.sig,count:30,offset:pref*1}, function(r) { 
              if(r.response) { 
                for (var i = 1; i <= r.response.length-1; i++) {
                  sec = Math.round((r.response[i].duration/60-Math.floor(r.response[i].duration/60))*60);
                    if(sec<10){
                      sec = '0'+ sec;
                    }
                  $('.chevron').append('<div class="LocalPlayer MainContainer"><div data-duration="'+r.response[i].duration+'" id="'+(i*1+pref*1)+'" data-file="'+r.response[i].url+'" class="playbtn"></div><div class="mainbtn"><h6 class="title time">'+(Math.floor(r.response[i].duration/60))+':'+sec+'</h6><h5 class="title">'+r.response[i].artist+' - '+r.response[i].title+'</h5><div class="line"><div class="load"></div><div class="a_progress"><div class="a_tooltip"><h6 class="a_tooltip-title"></h6><div class="a_triangle"></div></div><div class="dot"></div></div></div><div class="volume"><div class="v_progress"><div class="a_tooltip"><h6 class="a_tooltip-title"></h6><div class="a_triangle"></div></div><div class="dot"></div></div></div></div><a class="downloadbtn" href="'+r.response[i].url+'" download></a></div>');
                  $self.unbindAll();
                  $self.bindAll();
                };
                $('.mainbtn').css({'width': $('.mainbtn').parent().parent().parent().width()*0.97-97 + 'px'});
                //$('.line').css({'width': $('.line').parent().width()-$('.volume').width()-50 + 'px'});
                $self.unbindAll();
                $self.bindAll();
                $('.chevron').removeClass('loading');
              } 
            }); 
          }
        },
        LBSound: function(Sevent,main){
          id = $(Sevent).attr('id');
          url = $(Sevent).data('file');
          duration = $(Sevent).data('duration');
          return soundManager.createSound({
                    id:id,
                    url:url,
                    volume:main.volume,
                    onplay: function(){
                      if($('.playbtn').hasClass('play')){
                        var prev_duration = $('.play').data('duration');
                        sec = Math.round((prev_duration/60-Math.floor(prev_duration/60))*60);
                        if(sec<10){
                          sec = '0'+ sec;
                        } 
                        $('.play').parent().find('.time').html((Math.floor(prev_duration/60))+':'+sec); 
                        $('.playbtn').removeClass('play');
                      }

                      if($('.playbtn').hasClass('pause')){
                        var prev_duration = $('.pause').data('duration');
                        sec = Math.round((prev_duration/60-Math.floor(prev_duration/60))*60);
                        if(sec<10){
                          sec = '0'+ sec;
                        }
                        var prev_duration = $('.pause').data('duration'); 
                        $('.pause').parent().find('.time').html((Math.floor(prev_duration/60))+':'+sec);  
                        $('.playbtn').removeClass('pause');
                      }
                      $('.a_progress').css('width','0%');
                      $('.line').removeClass('show');
                      $('.volume').removeClass('show');
                      $(Sevent).parent().find('.line').addClass('show');
                      $(Sevent).parent().find('.volume').addClass('show');
                      $(Sevent).parent().find('.v_progress').css('width',main.volume+'%')
                      $(Sevent).addClass('play');
                    },
                    whileplaying: function(){
                      if(!$(Sevent).parent().find('.line').hasClass('down')){
                        $(Sevent).parent().find('.a_progress').css('width',(Math.round((this.position/1000)/duration*1000)/10)+'%');
                        sec = Math.round(this.position/1000 - Math.floor(this.position/60000)*60);
                        if (sec<10){
                          sec = '0'+sec;
                        }
                        $(Sevent).parent().find('.line').find('.a_tooltip-title').html(Math.floor(this.position/60000) + ':' + sec);
                      }
                      sec = Math.floor(((duration-(this.position/1000))/60-Math.floor((duration-(this.position/1000))/60))*60);
                      if(sec<10){
                        sec = '0'+ sec;
                      }
                      $(Sevent).parent().find('.time').html('-'+(Math.floor((duration-(this.position/1000))/60))+':'+sec);
                    },
                    whileloading: function(){
                      $(Sevent).parent().find('.load').css('width',(Math.round(this.bytesLoaded/this.bytesTotal*1000)/10)+'%');
                    },
                    onpause: function(){
                      $(Sevent).removeClass('play');
                      $(Sevent).addClass('pause');
                    },
                    onresume: function(){
                      $(Sevent).removeClass('pause');
                      $(Sevent).addClass('play');
                    },
                    onfinish: function(){
                      Next = $('#'+(this.id*1+1));
                      if(Next.length === 0){
                        Next = $('#1');
                      }
                      main.sound.unload();
                      main.sound.destruct();
                      main.sound=null;
                      main.sound = main.LBSound(Next,main);
                    }
                  }).play();
        }
      }
      jQuery(document).ready(function($) {
        var  UI = new LBUI();
        UI.init();
      });
    </script>
  </body>
</html>