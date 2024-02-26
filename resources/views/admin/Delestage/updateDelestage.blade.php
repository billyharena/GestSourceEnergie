<div class="modal fade" id="updateModal{{ $delestage->iddelestage }}" tabindex="-1"
     aria-labelledby="updateModalLabel{{ $delestage->iddelestage }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel{{ $delestage->iddelestage }}">Fiche délestage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/delestage/{{ $delestage->iddelestage }}/update" method="POST">
                    @csrf
                    @method('PUT')
                    <p>Début : <input class="form-control" type="number" name="deb" value="{{ $delestage->deb }}" placeholder="{{$delestage->deb}}"></p>
                    <p>Fin : <input class="form-control" type="number" name="fin" value="{{ $delestage->fin }}" placeholder="{{$delestage->fin}}"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
                <button type="submit" class="btn btn-danger">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>
