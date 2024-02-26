<div class="modal fade" id="updateModal{{ $groupe->idgroupe }}" tabindex="-1"
     aria-labelledby="updateModalLabel{{ $groupe->idgroupe }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel{{ $groupe->idgroupe }}">Fiche groupe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/groupe/{{ $groupe->idgroupe }}/update" method="POST">
                    @csrf
                    @method('PUT')
                    <p>Capacité max : <input class="form-control" type="number" name="capacitemax" value="{{ $groupe->capacitemax }}" placeholder="{{$groupe->capacitemax}}"></p>
                    <p>Réservoir : <input class="form-control" type="number" name="reservoir" value="{{ $groupe->reservoir }}" placeholder="{{$groupe->reservoir}}"></p>
                    <p>Consommation : <input class="form-control" type="number" name="consommation" value="{{ $groupe->consommation }}" placeholder="{{$groupe->consommation}}"></p>
                    <p>Prix litre : <input class="form-control" type="number" name="prixlitre" value="{{ $groupe->prixlitre }}" placeholder="{{$groupe->prixlitre}}"></p>
                    <p>Début : <input class="form-control" type="number" name="deb" value="{{ $groupe->deb }}" placeholder="{{$groupe->deb}}"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
                <button type="submit" class="btn btn-danger">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>
