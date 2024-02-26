<div class="modal fade" id="updateModal{{ $panneau->idpanneau }}" tabindex="-1"
     aria-labelledby="updateModalLabel{{ $panneau->idpanneau }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel{{ $panneau->idpanneau }}">Fiche panneau</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/panneau/{{ $panneau->idpanneau }}/update" method="POST">
                    @csrf
                    @method('PUT')
                    <p>Puissance : <input class="form-control" type="text" name="puissance" value="{{ $panneau->puissance }}" placeholder="{{$panneau->puissance}}"></p>
                    <p>Tarif : <input class="form-control" type="text" name="tarif" value="{{ $panneau->tarif }}" placeholder="{{$panneau->tarif}}"></p>
                    @foreach($listeTaux as $taux)
                        <p>{{$taux->deb}} - {{$taux->fin}} : <input class="form-control" type="text" name="taux[{{$taux->idtaux}}]" value="{{$taux->taux}}" placeholder="{{$taux->taux}}"></p>
                   @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
                <button type="submit" class="btn btn-danger">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>
