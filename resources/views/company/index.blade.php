@extends('layouts.master')

@section('styles')
    <style>
        .ele{
            height: 20em;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="form-group col-md-6">
            <div class="input-group input-group-lg">
                <input placeholder="..." name="" id="schbox" class="form-control input-lg">
                <span class="input-group-btn">
                    <button id="rechercher" class="btn btn-primary purplebtn">Rechercher</button>
                </span>
            </div>
        </div>
    </div>
    <br>
    <div id="list" class="row">
        <div class="ele col-md-4" v-for="c in company" style="background-color: #e6e6e6">
                <a v-bind:href="'company/'+c.name" class="btn btn-primary purplebtn" role="button" style="width: 100%">@{{ c.name }}</a>
                <description :desc="c.description"></description>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var pagenb=1;
        $("#rechercher").click(function () {
            //$(list).empty();
            pagenb=1;
            load();
        });
        
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                load();
            }
        });

        Vue.component("description", {
            props:["desc"],
            template:"<p v-html='desc'></p>"
        });

        var app = new Vue({
            el: '#list',
            data: {
                company: [],
            }
        });

        function appendtogrid(data) {
            console.log(data);
            app.$data.company.push.apply(app.$data.company, data);
        }

        function getpage(num) {
            var nom=$("#schbox").val();
            $.getJSON("api/cpage",{page:1, name: ""+nom}, function (data) {
                appendtogrid(data);
            });
        }

        function load() {
            $("#grid").append(getpage(1));
            pagenb++;
        }

        $(load());
    </script>
@endsection