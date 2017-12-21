@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }

        canvas {
            background-color: white;
        }

        [v-cloak] {
            display: none;
        }

        .form-control {
            border-top-left-radius: 4px !important;
            border-bottom-left-radius: 4px !important;
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            height: 400px;
            background-color: #ddd;
            border-radius: 0.4em;
            text-align: center;
            font-family: 'Ubuntu', sans-serif;
        }

        .title {
            color: grey;
            font-size: 18px;
        }

        .card > button {
            border: none;
            outline: 0;
            display: inline-block;
            padding: 8px;
            color: white;
            background-color: #552AD6;
            border-radius: 0.3em;
            text-align: center;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
        }

        img.profile-image {
            height: 150px;
            width: 150px;
        }
    </style>
@endsection

@section('content')
    <div id="app">
        <div class="page-title-header">
            <h1 class="page-title">Heures de mes employés</h1>
            <hr class="separator">
        </div>

        @if (count($punches) > 0)
            <div class="col-md-12">
                <div class="row layout">
                    <div class="centre custom-container">
                        <table class="table custom-table" style="margin: 0 !important;" id="headerTable">
                            <thead>
                                <tr class="section-title">
                                    <th>Rechercher par Employé</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <br>
                                        <div class="form-group col-md-12" style="width: 100%;">
                                            <div class="input-group input-group-lg">
                                                <input style="width: 100% !important;" placeholder="Rechercher un employé..." autofocus required id="schbox" class="form-control input-lg" type="text" v-model="text">
                                                <span class="input-group-btn">
                                                    <input type="button" id="rechercher" class="btn purplebtn" v-on:click="searchEmployees" style="margin-bottom: 5px" value="Rechercher">
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td v-if="text != ''">
                                        <br>
                                        <div class="form-group pull-right">
                                            <button id="reset" class="btn btn-danger" v-on:click="reset">Réinitialiser</button>
                                        </div>
                                    </td>
                                    <td v-else>
                                        <br>
                                        <div class="form-group pull-right">
                                            <button class="btn purplebtn" v-on:click="scrolldown">Voir les heures</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
            </div>
        @endif

        <div class="col-md-12">
            @include('punch.employees_grid')
        </div>

        <div class="col-md-12">
            <div class="row layout">
                @if (count($punches) > 0)
                    <div class="centre custom-container">
                        @include('punch.employees_table')
                    </div>
                @else
                    @component('components.nothing')
                        @slot('message')
                            Il n'y a pas de périodes de travail
                        @endslot
                    @endcomponent
                @endif
                <br>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#employeesTable',
            data: {
                sortNormal:  'url("{{env('APP_URL')}}/image/sort.png")',
                sortUp:      'url("{{env('APP_URL')}}/image/sortup.png")',
                sortDown:    'url("{{env('APP_URL')}}/image/sortdown.png")'
            },
            methods: {
                init: function() {
                    @if (count($sesh) > 0)
                        let order = '{{$sesh['order']}}';
                        @if (strpos($sesh['column'],'datebegin') !== false)
                            $('#sortDateDebut').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @elseif(strpos($sesh['column'],'username') !== false)
                            $('#sortEmployee').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @elseif (strpos($sesh['column'],'dateend') !== false)
                            $('#sortDateFin').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @elseif (strpos($sesh['column'],'duration') !== false)
                            $('#sortDuration').css('background-image',order === 'ASC' ? this.sortUp : this.sortDown);
                        @endif
                    @endif
                },
                sortEmployee: function() {
                    const order = $('#sortEmployee').css('background-image') === this.sortNormal ? 'ASC' :
                        ($('#sortEmployee').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('punches.sortEmployees')}}',
                        data: { column: 'username', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortDateDebut: function () {
                    // TODO
                    const order = $('#sortDateDebut').css('background-image') === this.sortNormal ? 'ASC' :
                        ($('#sortDateDebut').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('punches.sortEmployees')}}',
                        data: { column: 'datebegin', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortDateFin: function () {
                    // TODO
                    const order = $('#sortDateFin').css('background-image') === this.sortNormal ? 'ASC' :
                        ($('#sortDateFin').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('punches.sortEmployees')}}',
                        data: { column: 'dateend', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
                sortDuration: function () {
                    // TODO
                    const order = $('#sortDuration').css('background-image') === this.sortNormal ? 'ASC' :
                        ($('#sortDuration').css('background-image') === this.sortUp ? 'DESC' : 'ASC');
                    $.ajax({
                        method: 'POST',
                        url: '{{route('punches.sortEmployees')}}',
                        data: { column: 'duration', order: order, _token: '{{csrf_token()}}' },
                        success: function () {
                            location.reload();
                        }
                    });
                },
            },
            mounted: function () {
                this.init();
            }
        });

        new Vue({
            el: '#headerTable',
            data: {
                text: ''
            },
            methods: {
                resize: function() {
                    const mq = window.matchMedia( "screen and (min-width: 1100px)" ),
                        mq2 = window.matchMedia( "screen and (min-width: 767px)" ),
                        mq3 = window.matchMedia( "screen and (min-width: 850px)" );
                    if (mq.matches) {
                        $('.profile-image').css({
                            height: '150px',
                            width: '150px'
                        });

                        $('.fullname').css({
                            fontSize: '2em'
                        });

                        $('.col-sm-4:nth-child(2n), .col-sm-4:nth-child(3n)').css({
                            marginTop: '0em'
                        })
                    } else {
                        $('.profile-image').css({
                            height: '100px',
                            width: '100px'
                        });

                        $('.fullname').css({
                            fontSize: '1.5em'
                        });
                    }

                    if (!mq2.matches) {
                        $('.profile-image').css({
                            height: '150px',
                            width: '150px'
                        });

                        $('.fullname').css({
                            fontSize: '2em'
                        });

                        $('.col-sm-4:nth-child(2n), .col-sm-4:nth-child(3n)').css({
                            marginTop: '1em'
                        })
                    } else if (!mq3.matches) {
                        $('.profile-image').css({
                            height: '70px',
                            width: '70px'
                        });

                        $('.fullname').css({
                            fontSize: '1.1em'
                        });
                    }
                },
                scrolldown: function() {
                    $("html, body").animate({ scrollTop: $("#employeesTable").offset().top }, 2000)
                },
                init: function () {
                  // MEDIA QUERIES.
                  this.resize();
                  let self = this;
                  $(window).resize(function() { self.resize(); });
                  this.setTypeAhead();
                },
                setTypeAhead: function() {
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
                        url: '{{route('punches.employees')}}',
                        method: 'GET',
                        success: function (data) {
                            autocompletes = data.employees;
                            $('#schbox').typeahead({
                                hint: true,
                                highlight: true,
                                minLength: 1
                            }, {
                                name: 'employees',
                                source: substringMatcher(autocompletes),
                            }).on('typeahead:selected', function (obj, datum) {
                                self.text = datum;
                            });
                            $('#schbox').focus();
                        }
                    });
                },
                searchEmployees: function () {
                    let self = this;
                    $.ajax({
                        method: 'GET',
                        url: '/punches/sort/employees/' + self.text,
                        success: function (data) {
                            $('#employeesGrid').replaceWith(data);
                            self.resize();
                        }
                    })
                },
                reset: function () {
                    this.text = '';
                    let self = this;
                    $.ajax({
                        method: 'GET',
                        url: '{{route('punches.employeesIndex')}}',
                        success: function (data) {
                            $('#employeesGrid').replaceWith(data);
                            self.resize();
                        }
                    });
                    $('#schbox').focus();
                }
            },
            watch:{
                text: function () {
                    if (this.text === '') {
                        this.reset();
                    } else {
                        this.searchEmployees();
                    }
                }
            },
            mounted: function() {
                this.init();
            }
        });
    </script>
@endsection