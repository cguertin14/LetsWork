@extends('layouts.master')

@section('styles')
    <style>
        .ele {
            height: 15em;
        }
        [v-cloak] {
            display: none;
        }
        body {
            background-color: #5d5d5d;
        }

        .form-control {
            border-top-left-radius: 4px !important;
            border-bottom-left-radius: 4px !important;
        }
    </style>
@endsection

@section('content')
    <div  style="width:85%;margin-left: auto;margin-right: auto">
        <h1 class="page-title">
            Toutes les compagnies
        </h1>
        <hr class="separator">
    </div>

    <div id="list" v-cloak style="width: auto;">
        <div class="centre custom-container">
            <table class="table custom-table" style="margin: 0">
                <thead>
                    <tr class="section-title">
                        <th>Rechercher</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">
                            <br>
                            <div class="form-group col-md-6" style="width: 100%;">
                                <div class="input-group input-group-lg">
                                    <input style="width: 100% !important;" placeholder="Rechercher une entreprise..." autofocus required id="schbox" class="form-control input-lg" type="text" v-model="text">
                                    <span class="input-group-btn">
                                        <input type="button" id="rechercher" class="btn purplebtn" v-on:click="rechercher" style="margin-bottom: 5px" value="Rechercher">
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td v-if="text != ''">
                            <br>
                            <div class="form-group pull-right">
                                <button id="reset" class="btn btn-danger" v-on:click="reset()">Réinitialiser</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div v-if="company.length == 0">
            @component('components.nothing')
                @slot('message')
                    Aucune entreprise trouvée
                @endslot
            @endcomponent
        </div>
        <div v-else class="centre custom-container">
            <table class="table custom-table" style="margin: 0">
                <thead>
                <tr class="section-title">
                    <th>Nom <span id="nameSort" v-on:click="sortName()" class="sort"></span></th>
                    <th>Description <span id="descriptionSort" v-on:click="sortDescription()" class="sort"></span></th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="section">
                <tr v-for="(c,position) in company" class="clickable-section" v-bind:class="(position % 2 == 0 ? 'section-index-2' : 'section-index')" v-bind:data-href="'company/'+c.slug">
                    <td>@{{ c.name }}</td>
                    <td>@{{  (c.description.length > 10) ? c.description.substr(0,c.description.length / 4) + '...': c.description }}</td>
                    <td><a v-bind:href="'company/'+c.slug" class="btn purplebtn pull-right" role="button" style="overflow:hidden;margin-right: 1em">Voir la compagnie</a></td>
                </tr>
                </tbody>
            </table>
            <button class="btn purplebtn col-md-offset-5" v-on:click="load" v-if="canloadmore" style="margin-top: 2em;margin-bottom: 2em">Plus de résultats...</button>
            <button class="btn btn-danger col-md-offset-5" disabled v-if="!canloadmore" style="margin-top: 2em;margin-bottom: 2em">Il n'y a plus de résultat.</button>
        </div>
        <br>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#list',
            data: {
                text: '',
                number: 0,
                company: [],
                canloadmore:true,
                sortNormal:  'url("{{env('APP_URL')}}/image/sort.png")',
                sortUp:      'url("{{env('APP_URL')}}/image/sortup.png")',
                sortDown:    'url("{{env('APP_URL')}}/image/sortdown.png")'
            },
            methods: {
                setTypeAhead: function () {
                    var substringMatcher = function(strs) {
                        return function findMatches(q, cb) {
                            var matches, substringRegex;

                            // an array that will be populated with substring matches
                            matches = [];

                            // regex used to determine if a string contains the substring `q`
                            substrRegex = new RegExp(q, 'i');

                            // iterate through the pool of strings and for any string that
                            // contains the substring `q`, add it to the `matches` array
                            $.each(strs, function(i, str) {
                                if (substrRegex.test(str)) {
                                    matches.push(str);
                                }
                            });

                            cb(matches);
                        };
                    };
                    // AutoComplete for search input
                    String.prototype.replaceAll = function(search, replacement) {
                        var target = this;
                        return target.split(search).join(replacement);
                    };

                    var autocompletes = [];
                    let self = this;
                    $.ajax({
                        url: '{{route('company.names')}}',
                        method: 'GET',
                        success: function (data) {
                            autocompletes = data;
                            $('#schbox').typeahead({
                                hint: true,
                                highlight: true,
                                minLength: 1
                            }, {
                                name: 'companies',
                                source: substringMatcher(autocompletes),
                            }).on('typeahead:selected', function (obj, datum) {
                                self.text = datum;
                            });
                            $('#schbox').focus();
                        }
                    });
                },
                init: function () {
                    this.setTypeAhead();
                    // Place correct images for sorting in header columns
                    @if (array_key_exists('order',$sesh))
                        @if (count($sesh) > 0)
                            let order = '{{$sesh['order']}}';
                            @if (strpos($sesh['column'],'name') !== false)
                                $('#nameSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                            @elseif (strpos($sesh['column'],'description') !== false)
                                $('#descriptionSort').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                            @endif
                        @endif
                    @endif
                },
                sortName: function () {
                    const order = $('#nameSort').css('background-image') === this.sortNormal ? 'ASC' :
                                 ($('#nameSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('company.sortCompanies')}}',
                        data: { column: 'name', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortDescription: function () {
                    const order = $('#descriptionSort').css('background-image') === this.sortNormal ? 'ASC' :
                                 ($('#descriptionSort').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('company.sortCompanies')}}',
                        data: { column: 'description', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                reset: function () {
                    this.text = "";
                    this.company = [];
                    this.number = 0;
                    this.canloadmore = true;
                    this.load();

                    $('#schbox').focus();
                },
                rechercher: function () {
                    this.company = [];
                    this.number = 0;
                    this.load();
                },
                load: function () {
                    this.number++;
                    this.getpage();
                },
                appendtogrid: function (data) {
                    this.company.push.apply(this.company, data);
                },
                getpage: function () {
                    let app=  this;
                    $.getJSON("/cpage", {page: this.number, name: this.text}, function (data) {
                        app.canloadmore = data.canloadmore;
                        if (app.canloadmore) {
                            app.appendtogrid(data.data);
                        }
                    });
                }
            },
            watch:{
                text: function () {
                    if (this.text === '') {
                        this.reset();
                    } else {
                        this.rechercher();
                    }
                }
            },
            updated: function () {},
            mounted: function () {
                this.init();
                this.load();
                load = this.load;
            }
        });
    </script>
@endsection