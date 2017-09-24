<template>
    <div class="container">
        <div id="grid" class="grid">
            <template v-for="c in listcompany">
                <div class="grid-item col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="" alt="Logo">
                        <div class="caption">
                            <h3>{{c.name}}</h3>
                            <p>a</p>
                            <p><a href="" class="btn btn-primary purplebtn" role="button"></a></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    <script>
    var vue = new Vue({
        el: '#index',
        data:{
            listcompany: [{name: "a"}, {name: "a"}],
        },
        template:thetemplate
    });

    function appendtogrid(data) {
        console.log(data);
    }

    function getpage(num) {
        $.getJSON("api/cpage/" + num, function (data) {
            appendtogrid(data);
        });
    }

    function load() {
        $("#grid").append(getpage(1));
    }

    $(load());
</script>
</script>