@extends('layouts.master')

@section('styles')
    <style>
        body {
            background-color: #5d5d5d;
        }

        body.modal-open {
            overflow: hidden;
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

        }

        img.profile-image {
            height: 150px;
            width: 150px;
        }

        .modal-backdrop {
            background-color: rgba(255,255,255,0.5);
        }
    </style>
@endsection

@section('content')

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true"></div>

    <div id="page">
        <div class="page-title-header">
            <h1 class="page-title">
                Mes employés
                <a v-if="users > 0" href="#" v-on:click="addEmployee" class="btn btn-success pull-right">Ajouter un employé</a>
            </h1>
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
                text: '',
                users: {{$users->count()}}
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
                    $('#schbox').typeahead('destroy');
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
                        success: function (view) {
                            //$('#employeesGrid').html(view);
                            let newView = Vue.compile(view);
                            new Vue({
                                data: self.$data,
                                render: newView.render,
                                staticRenderFns: newView.staticRenderFns,
                                methods: self.$options.methods
                            }).$mount('#employeesGrid');
                            self.resize();
                        }
                    });
                    $('#schbox').focus();
                },
                reset: function () {
                    this.text = '';
                    let self = this;
                    self.setTypeAhead();
                    $.ajax({
                        method: 'GET',
                        url: '{{route('employees.employeesAll')}}',
                        success: function (data) {
                            self.$data.users = data.users;
                            let newView = Vue.compile(data.view);
                            new Vue({
                                data: self.$data,
                                render: newView.render,
                                staticRenderFns: newView.staticRenderFns,
                                methods: self.$options.methods
                            }).$mount('#employeesGrid');
                            self.resize();
                        }
                    });
                    $('#schbox').focus();
                },
                addEmployee: function() {
                    let self = this;
                    $.ajax({
                        method: 'GET',
                        url: '{{route('employees.create')}}',
                        success: function (view) {
                            let modal = $('#modal');
                            modal.html(view);
                            modal.modal();
                            modal.on('hidden.bs.modal', function () { $(this).empty(); });
                            modal.find('#createBtn').click(function (event) {
                                event.preventDefault();
                                modal.find('#createForm').submit(function (event) {
                                    $.ajax({
                                        type: modal.find('#createForm').attr('method'),
                                        url: modal.find('#createForm').attr('action'),
                                        data: modal.find('#createForm').serialize(),
                                        success: function(data) {
                                            modal.modal('hide');
                                            self.reset();
                                        },
                                        error: function (errors) {
                                            formErrors(errors,modal);
                                        }
                                    });
                                    event.preventDefault();
                                    return false;
                                });
                                modal.find('#createForm').submit();
                            });
                        }
                    })
                },
                editEmployee: function(id) {
                    var self = this;
                    $.ajax({
                        method: 'GET',
                        url: '/employees/'+id+'/edit',
                        success: function (view) {
                            let modal = $('#modal');
                            modal.html(view);
                            modal.modal();
                            modal.on('hidden.bs.modal', function () { $(this).empty(); });
                            modal.find('#editBtn').click(function (event) {
                                event.preventDefault();
                                modal.find('#editForm').submit(function (event) {
                                    $.ajax({
                                        type: modal.find('#editForm').attr('method'),
                                        url: modal.find('#editForm').attr('action'),
                                        data: modal.find('#editForm').serialize(),
                                        success: function(data) {
                                            modal.modal('hide');
                                            self.reset();
                                        },
                                        error: function (errors) {
                                            formErrors(errors,modal);
                                        }
                                    });
                                    event.preventDefault();
                                    return false;
                                });
                                modal.find('#editForm').submit();
                            });
                            modal.find('#deleteBtn').click(function (event) {
                                event.preventDefault();
                                modal.find('#deleteForm').submit(function (event) {
                                    $.ajax({
                                        type: modal.find('#deleteForm').attr('method'),
                                        url: modal.find('#deleteForm').attr('action'),
                                        data: modal.find('#deleteForm').serialize(),
                                        success: function(data) {
                                            modal.modal('hide');
                                            self.reset();
                                        },
                                        error: function (errors) {
                                            formErrors(errors,modal);
                                        }
                                    });
                                    event.preventDefault();
                                    return false;
                                });
                                modal.find('#deleteForm').submit();
                            });
                        }
                    })
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
                this.setTypeAhead();
                // MEDIA QUERIES.
                this.resize();
                let self = this;
                $(window).resize(function() { self.resize(); });
            }
        });
    </script>
@endsection