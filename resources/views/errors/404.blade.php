@extends('layouts.top')

@section('styles')
    <style>
        img {
            max-width:100%;
        }
        /*end reset*/
        body{
            background:url(../image/404.png);
            overflow-y: hidden;
        }
        .wrap {
            width:1000px;
            margin:0 auto;
        }
        .main{
            text-align:center;
            background: rgba(255, 255, 255, 0.04);
            color:#FFF;
            font-weight:bold;
            margin-top:160px;
            border:1px solid rgba(102, 102, 102, 0.31);
            -webkit-border-radius:5px;
            -moz-border-radius:5px;
            border-radius:5px;
        }
        .main h3{
            font-size:16px;
            text-align:left;
            padding:10px 30px;
        }
        .main h1{
            font-size:60px;
            margin-top:15px;
            color:#1CD3CB;
            text-transform:uppercase;
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
        }
        .main p{
            font-size:20px;
            margin-top:15px;
            line-height:1.6em;
        }
        .main  span.error {
            color:#48C8D3;
            font-size:18px;
        }
        .main p span{
            font-size:14px;
            color:#24817A;
        }
        .icons{
            padding-bottom:20px;
            text-align:right;
        }
        .icons p{
            padding-right:130px;
            color:#D5CECE;
            font-size:13px;
            cursor:pointer;
        }
        .icons p:hover{
            text-decoration:underline;
        }
        .icons ul{
            padding-right:20px;
        }
        .icons li {
            display:inline-block;
            padding-top:10px;
        }
        .icons li a{
            margin:2px;
        }

        .main > p,h3 {
            font-family: Ubuntu,sans-serif !important;
        }
        .main > p > span {
            font-family: Ubuntu,sans-serif;
        }
        .footer {
            visibility: visible;
            background: rgba(255, 255, 255, 0.04);
        }
    </style>
@endsection

@section('contenu')

    <div class="wrap">
        <div class="main" style="padding-bottom: 1.5em !important;margin-top: 6em">
            <h3>LetsWork</h3>
            <hr>
            <!---728x90--->
            <h1 class="title" style="font-size: 2.7em;">Oups, page introuvable</h1>
            <p>Il y a beaucoup de raison pourquoi cette page est
                <span class="error">404</span>.<br>
                <span>Ne perdez pas trop de temps ici!</span>
            </p>
            <!---728x90--->
            <br>
            <div class="form-group">
                <a href="{{route('homepage.content')}}" class="btn purplebtn">Revenir à l'accueil</a>
            </div>
        </div>
    </div>

@endsection

@section('scriptsm')
    <script>
        // Media queries
        $(document).ready(function () {
            let sizes = function () {
                let matches = false;
                if (window.matchMedia('(max-width: 767px)').matches) {
                    $('.wrap')[0].style.setProperty('width','600px','important');
                    $('.title').css({
                        fontSize: '2.7em'
                    });
                    matches = true;
                } if (window.matchMedia('(max-width: 1060px)').matches) {
                    $('.wrap')[0].style.setProperty('width','800px','important');
                    $('.title').css({
                        fontSize: '2.7em'
                    });
                    matches = true;
                } if (window.matchMedia('(max-width: 820px)').matches) {
                    $('.wrap')[0].style.setProperty('width','600px','important');
                    $('.title').css({
                        fontSize: '2.7em'
                    });
                    matches = true;
                } if (window.matchMedia('(max-width: 750px)').matches) {
                    $('.wrap')[0].style.setProperty('width','500px','important');
                    $('.title').css({
                        fontSize: '2.7em'
                    });
                    matches = true;
                } if (window.matchMedia('(max-width: 667px)').matches) {
                    $('.wrap')[0].style.setProperty('width','350px','important');
                    $('.title').css({
                        fontSize: '2.7em'
                    });
                    matches = true;
                }

                if (!matches) {
                    $('.wrap')[0].style.setProperty('width','1000px','important');
                    $('.title').css({
                        fontSize: '2.7em'
                    });
                }
            };
            sizes();
            $(window).resize(function() {
                sizes();
            });
        });
    </script>
@endsection