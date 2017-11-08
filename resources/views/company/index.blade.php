@extends('layouts.master')

@section('styles')
    <style>
        .ele {
            height: 20em;
        }
        [v-cloak] {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div id="list" v-cloak>
        <div class="row">
            <div class="form-group col-md-6">
                <div class="input-group input-group-lg">
                    <input placeholder="..." name="" id="schbox" class="form-control input-lg" v-model="text">
                    <span class="input-group-btn">
                    <button id="rechercher" class="btn btn-primary purplebtn"
                            v-on:click="rechercher">Rechercher</button>
                </span>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="ele col-md-4" v-for="c in company" style="background-color: #e6e6e6">
                <a v-bind:href="'company/'+c.name" class="btn btn-primary purplebtn" role="button" style="width: 100%">@{{
                    c.name }}</a>
                <description :desc="c.description"></description>
            </div>
        </div>
        <br>
        <button class="btn btn-primary purplebtn col-md-offset-5" v-on:click="load" v-if="canloadmore">Plus de résultats...</button>
        <button class="btn btn-primary purplebtn col-md-offset-5" v-if="!canloadmore">Il n'y a plus de résultats...</button>
        <br><br>
    </div>
@endsection

@section('scripts')
    <script>
        Vue.component("description", {
            props: ["desc"],
            template: "<p v-html='desc'></p>"
        });

        new Vue({
            el: '#list',
            data: {
                text: '',
                number: 0,
                company: [],
                canloadmore:true
            },
            methods: {
                rechercher: function () {
                    this.company = [];
                    this.number = 0;
                    this.load();
                    this.canloadmore=true;
                },
                load: function () {
                    if(this.canloadmore) {
                        this.number++;
                        this.getpage();
                    }
                },
                appendtogrid: function (data) {
                    this.company.push.apply(this.company, data);
                },
                getpage: function () {
                    let app=this;
                    $.getJSON("api/cpage", {page: this.number, name: this.text}, function (data) {
                        if(data.length==0) {
                            app.canloadmore = false;
                        }
                        else {
                            app.appendtogrid(data);
                        }
                    });
                }
            },
            watch:{
                text:function () {
                    this.rechercher();
                }
            },
            mounted: function () {
                this.load();
                load=this.load;
            }
        });
    </script>
@endsection