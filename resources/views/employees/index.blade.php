@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
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

    <div id="page">
        <div class="page-title-header">
            <h1 class="page-title">Mes employés <a href="{{route('employees.create')}}" class="btn btn-success pull-right">Ajouter un employé</a></h1>
            <hr class="separator">
        </div>
        @if ($employees->count() > 0)
            <div class="col-md-12">
                <div class="row layout">
                    <div class="centre custom-container">
                        <table class="table custom-table" style="margin: 0 !important;" id="headerTable">
                            <thead>
                            <tr class="section-title">
                                <th>Rechercher un Employé</th>
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
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
            </div>
        @endif
        <div class="col-md-12">
            @include('employees.employees_grid')
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#page',
            data: {
                text: ''
            },
            methods: {
                resize: function () {
                    const mq = window.matchMedia("screen and (min-width: 1100px)"),
                        mq2 = window.matchMedia("screen and (min-width: 767px)"),
                        mq3 = window.matchMedia("screen and (min-width: 850px)");
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
                        url: '{{route('employees.names')}}',
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
                        url: '/employees/sort/' + self.text,
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
                        url: '{{route('employees.employeesAll')}}',
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
            mounted: function() {
                // MEDIA QUERIES.
                this.setTypeAhead();
                this.resize();
                let self = this;
                $(window).resize(function() { self.resize(); });
            }
        });
    </script>
@endsection