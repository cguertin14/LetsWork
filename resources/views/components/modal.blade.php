<style>
    .modal-title {
        color: #ffffff;
        font-size: 1.5em;
        display: inline-block;
        font-family: Montserrat,sans-serif;
    }
    .modal-body {
        font-family: Ubuntu,sans-serif;
        font-size: 1.2em;
    }
    .close {
        float: right;
        font-size: 35px;
        font-weight: 700;
        line-height: 1;
        color: white;
        text-shadow: 0 1px 0 #fff;
        filter: alpha(opacity=20);
        opacity: .2;
    }

    .close:hover {
        color: rgba(160, 221, 255, 0.39);
    }
</style>

<div class="vertical-alignment-helper">
    <div class="modal-dialog vertical-align-center" role="document">
        <div class="modal-content" style="background-color: #5d5d5d">
            <div class="modal-header">
                <!-- Titre du modal -->
                <h2 class="modal-title" id="exampleModalLabel">{{$title}}</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenu du modal -->
                {{$body}}
            </div>
            <div class="modal-footer">
                <!-- Bouton submit pour confirmer le modal -->
                {{$submitbtn}}
                <button id="cancel" type="button" class="btn btn-secondary closeout" data-dismiss="modal" style="font-size: 17px !important;">Fermer</button>
            </div>
        </div>
    </div>
</div>

{{$events}}