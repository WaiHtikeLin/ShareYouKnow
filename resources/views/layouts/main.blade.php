<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ThutaWorld') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href='https://mmwebfonts.comquas.com/fonts/?font=myanmar3' />
    <link rel="stylesheet" href='https://mmwebfonts.comquas.com/fonts/?font=zawgyi' />
    <style type="text/css">
        .zawgyi{
            font-family:Zawgyi-One;
        }
        .unicode{
            font-family:Myanmar3,Yunghkio,'Masterpiece Uni Sans';
        }
    </style>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">

        $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

        });


        function listenNotification(id)
        {


            Echo.private('App.User.'+id).notification((notification) => {
            var count="#noticount";
            var id="#notifications";



            if($(id).css('display')=='none')

            {   var num;
                if($(count).text()=='')
                    num=1;
                else
                num=parseInt($(count).text())+1;

                $(count).text(num);

            }
            else readnow();



            });

        }





        function read()
        {

            var id="#notifications";

            if($(id).css('display')=='none')
                readnow();


        }

        function readnow()
        {
            var url="/notifications/read";

            $.ajax({
                type:'PATCH',
                url:url,
                success:function(html) {
                    $("#notifications").html(html);
                    $("#noticount").text('');
                }
                });

        }

        function updateComment(id,postid)
        {   var url="/comments/"+id;
            var comment='#comments_'+postid;
            var stat='#stat_'+postid;
            var words=$('#update_comment_'+id).val();
            var trigger="#updatecommenttrigger"+id;


             $.ajax({
                type:'PATCH',
                url:url,
                data:{words:words},
                success:function(data) {
                    $(trigger).modal("hide");
                    $(stat).html(data.stat);
                    $(comment).html(data.comments);

                },
                error: function(xhr, status, err) {

    var data = JSON.parse(xhr.responseText);

    $("#invalidupdatecommentstatus").text(data.errors.words);

}
                });
        }

        function updateProfile(id)
        {   var url="/profile/"+id;
            var ph_no=$('#update_profile_ph_no'+id).val();
            var address=$('#update_profile_address'+id).val();
            var about=$('#update_profile_about'+id).val();



             $.ajax({
                type:'PATCH',
                url:url,
                data:{ph_no:ph_no,address:address,about:about},
                success:function(data) {
                    $(stat).html(data.stat);
                    $(comment).html(data.comments);

                }
                });
        }

        function deleteComment(id,postid)
        {   var url="/comments/"+id;
            var comment='#comments_'+postid;
            var stat='#stat_'+postid;

            $.ajax({
                type:'DELETE',
                url:url,
                success:function(data) {
                    $(stat).html(data.stat);
                    $(comment).html(data.comments);

                }
                });
        }

        function updateReply(id,commentid)
        {   var url="/replies/"+id;
            var reply='#replies_'+commentid;
            var stat='#commentstat_'+commentid;
            var words=$('#update_reply_'+id).val();


             $.ajax({
                type:'PATCH',
                url:url,
                data:{words:words},
                success:function(data) {
                    $(stat).html(data.stat);
                    $(reply).html(data.replies);

                }
                });
        }

        function deleteReply(id,commentid)
        {   var url="/replies/"+id;
            var reply='#replies_'+commentid;
            var stat='#commentstat_'+commentid;

            $.ajax({
                type:'DELETE',
                url:url,
                success:function(data) {
                    $(stat).html(data.stat);
                    $(reply).html(data.replies);

                }
                });
        }

        function sendComment(id)
        {
            var words=$('#send_to_'+id).val();
            var comment='#comments_'+id;
            var stat='#stat_'+id;
            var url='/'+id+'/store/comment';

            $.ajax({
                type:'POST',
                url:url,
                data:{words:words},
                success:function(data) {
                    $(stat).html(data.stat);
                    $(comment).html(data.comments);
                },
                error: function(xhr, status, err) {

    var data = JSON.parse(xhr.responseText);

    $("#invalidcommentstatus").text(data.errors.words);

}

                });

        }

        function sendReply(id)
        {
            var words=$('#send_reply_to_'+id).val();
            var reply='#replies_'+id;
            var stat='#commentstat_'+id;
            var url='/'+id+'/store/reply';

            $.ajax({
                type:'POST',
                url:url,
                data:{words:words},
                success:function(data) {
                    $(stat).html(data.stat);
                    $(reply).html(data.replies);
                }
                });

        }

        function updateLikesForPost(id,btn) {

                //var btn='#like_'+id;
                var stat='#stat_'+id;
                var msg,url;


            if($(btn).text()=='Like')
            {
                url='/like/to/'+id;
                msg='Liked';
            }
            else
            {   url='/unlike/to/'+id;
                msg='Like';

            }

            updateStats(stat,url);
            $(btn).text(msg);
        }

         function updateLikesForComment(id,btn) {

                //var btn='#like_'+id;
                var stat='#commentstat_'+id;
                var msg,url;


            if($(btn).text()=='Like')
            {
                url='/like/to/comment/'+id;
                msg='Liked';
            }
            else
            {   url='/unlike/to/comment/'+id;
                msg='Like';

            }

            updateStats(stat,url);
            $(btn).text(msg);
        }

        function updateLikesForReply(id,btn) {

                //var btn='#like_'+id;
                var stat='#replylikestat_'+id;
                var msg,url;


            if($(btn).text()=='Like')
            {
                url='/like/to/reply/'+id;
                msg='Liked';
            }
            else
            {   url='/unlike/to/reply/'+id;
                msg='Like';

            }

            updateStats(stat,url);
            $(btn).text(msg);
        }

        function updateStats(stat,url)
        {
            $.ajax({
                type:'POST',
                url:url,
                success:function(data) {
                  $(stat).html(data.stat);
                }
                });
        }

        function updateSaves(id,btn) {
                var stat='#stat_'+id;
                var msg,url;


            if($(btn).text()=='Save')
            {
                url='/save/to/'+id;
                msg='Saved';
            }
            else
            {   url='/unsave/to/'+id;
                msg='Save';

            }

            updateStats(stat,url);
            $(btn).text(msg);
        }

        function getComments(id)
        {
            var comment='#comments_'+id;
            var url='/'+id+'/comments';
            var stat='#stat_'+id;
            var stats='#stats_'+id;
            $(stats).html("");

            if(!$(comment).html())
            { $.ajax({
                type:'POST',
                url:url,
                success:function(data) {
                    $(stat).html(data.stat)
                  $(comment).html(data.comments);
                }
                });
            }
            else
            {
                $(comment).html('');
            }

        }

        function getReplies(id)
        {
            var reply='#replies_'+id;
            var url='/'+id+'/replies';
            var stat='#commentstat_'+id;
            var likestats='#comment_likes_'+id;
            $(likestats).html("");

            if(!$(reply).html())
            { $.ajax({
                type:'POST',
                url:url,
                success:function(data) {
                    $(stat).html(data.stat);
                    $(reply).html(data.replies);
                }
                });

            }
            else
            {
                $(reply).html('');
            }

        }

        function remove(field,label,btn)
        {
            $(field).val('');
            $(field).toggle();

            if($(btn).text()=='remove')
            $(btn).text('Add '+label);
            else
            $(btn).text('remove');
        }

        function displayStats(id)
        {
            var url='/articles/'+id+'/stats';
            var displayform='#stats_'+id;
            var comment='#comments_'+id;
            $(comment).html("");

             if(!$(displayform).html())
                $.ajax({
                type:'GET',
                url:url,
                success:function(data) {
                    $(displayform).html(data);
                }
                });
            else
                $(displayform).html("");

        }

        function displayLikeStats(id,type)
        {
            var url='/'+type+'/'+id+'/stats';
            var displayform='#'+type+'_likes_'+id;

            if(type=='comments')
            {   var reply='#replies_'+id;
                $(reply).html("");
            }

             if(!$(displayform).html())
                $.ajax({
                type:'GET',
                url:url,
                success:function(data) {
                    $(displayform).html(data);
                }
                });
            else
                $(displayform).html("");

        }

        function getUrl()
        {
            var url=$('#searchform').attr('action')+"ghvgv";
            $('#searchform').attr('action',url);
        }

        $(document).ready(function(e)
        {

    //     $(".rate").hover(function(){

    //         var id=$(this).val();
    //         $("#rating"+id).toggle();


    // });

    //update user rating for post
    $(".rate-btn").on('click',function()
    {
        var id=$(this).val();

        if($(this).hasClass("active"))
        {
            var url="/unrate/article/"+id;

            $.ajax({
                type:"POST",
                url:url,
                data:{_method:'DELETE'},
                success:function(data) {

                    $("#avg-rating"+id).text(data);
                    $("#rate"+id).text("Rate");
                }
                });
            $(this).removeClass("active");

        }

            else

        {   var type=$(this).text();
            var url="/rate/article/"+id;

            $.ajax({
                type:"POST",
                url:url,
                data:{type:type,_method:'PATCH'},
                success:function(data) {

                    $("#avg-rating"+id).text(data);
                    $("#rate"+id).text(type);
                }
                });



        $(this).siblings('.active').removeClass("active");
        $(this).addClass("active");

    }

    });


 $("#notifications").on("click",".noti-delete",function()
    {
        var id=$(this).val();

        var url="/notifications/"+id;

        $.ajax({
                type:"DELETE",
                url:url,
                success:function(html) {

                    // $("#notifications").html(html);
                    // $("#noticount").text('');
                }
                });


    });


 $("#profileform").on('submit',function(e)
 {
        e.preventDefault();
        var f=new FormData(this);
        var id=$("#saveprofile").val();
        var url="/profile/"+id;

        $.ajax({
                type:"POST",
                url:url,
                data:f,
                contentType: false,
                cache: false,
                processData:false,
                success:function(data) {
                   $("#profile_form").modal("hide");
                   $("#stable_ph_no").text(data.ph_no);
                   $("#stable_address").text(data.address);
                   $("#stable_about").text(data.about);

                },
                error: function(xhr, status, err) {

    var data = JSON.parse(xhr.responseText);

    var ph_no=data.errors.ph_no ? data.errors.ph_no : "";
    var address=data.errors.address ? data.errors.address : "";
    var about=data.errors.about ? data.errors.about : "";

    $("#ph_no_error").text(ph_no);
    // do stuff with your error messages presumably...
}
                });



 });

        });






    </script>




    <!-- Styles -->

</head>
<body onload="listenNotification({{ auth()->id() }})">


    <!-- <table>
    </table> -->
        <header>


                    <h2>ShareYouKnow</h2>
        </header>

                <nav class="navbar sticky-top navbar-expand-md navbar-expand-sm navbar-dark">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
 <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" id="main-menu" href="/home">Home</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="main-menu" href="/articles">Articles</a>
      </li>
         <li class="nav-item">
        <a class="nav-link" id="main-menu" href="/about">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="read()">
          Notifications<span class="badge badge-danger" id="noticount">{{ auth()->user()->countNoti() }}</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown" id="notifications">

        </div>
      </li>

    </ul>
    <form class="form-inline my-2 my-lg-0" method="get" action="/articles/search/" id="searchform">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="search" required>
        <input class="btn btn-danger my-2 my-sm-0" type="submit" onclick="getUrl()" value="Search">
    </form>
  </div>
</nav>



             <!--    </div>
            </div>
                  -->
      <div class="container-fluid">
        @yield('content')
    </div>

</body>


</html>
